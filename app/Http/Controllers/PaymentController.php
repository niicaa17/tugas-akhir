<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Minimal jumlah pcs (qty total) di keranjang/order agar pesanan
     * mendapat gratis ongkir. Di bawah ini, ongkir dibebankan sesuai kurir.
     */
    public const FREE_SHIPPING_MIN_QTY = 5;

    /**
     * Daftar kurir yang tersedia beserta tarif ongkirnya (Rp).
     */
    public const COURIERS = [
        'jnt'         => ['label' => 'J&T Express',  'ongkir' => 15000],
        'jne_reguler' => ['label' => 'JNE Reguler',  'ongkir' => 18000],
        'spx_standar' => ['label' => 'SPX Standar',  'ongkir' => 12000],
    ];

    /**
     * Hitung ongkir berdasarkan kurir & total qty. Gratis jika qty >= minimal.
     */
    public static function hitungOngkir(string $kurir, int $totalQty): int
    {
        if ($totalQty >= self::FREE_SHIPPING_MIN_QTY) {
            return 0;
        }

        return self::COURIERS[$kurir]['ongkir'] ?? 0;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $orderId = $request->query('order');

        if ($orderId) {
            $order = Order::query()->where('id', $orderId)
                ->where('user_id', Auth::id())
                ->with(['orderDetails.product.umkm'])
                ->firstOrFail();

            $existingTotalQty = (int) $order->orderDetails->sum('qty');

            return view('payments.create', [
                'order' => $order,
                'cartItems' => collect(),
                'isDraftCheckout' => false,
                'backUrl' => route('orders.show', $order),
                'totalQty' => $existingTotalQty,
                'couriers' => self::COURIERS,
                'freeShippingMinQty' => self::FREE_SHIPPING_MIN_QTY,
                'freeShipping' => $existingTotalQty >= self::FREE_SHIPPING_MIN_QTY,
            ]);
        }

        $user = Auth::user();
        $cart = $user->cart()->with('cartItems.product.umkm')->first();

        abort_unless($cart && $cart->cartItems->isNotEmpty(), 404, 'Keranjang kosong');

        $cartItems = $cart->cartItems->filter(fn($i) => $i->product && $i->product->stok > 0);

        // Filter sesuai pilihan checkout user (kalau ada)
        $selectedIds = session('checkout_item_ids');
        if (is_array($selectedIds) && !empty($selectedIds)) {
            $cartItems = $cartItems->filter(fn($i) => in_array($i->id, $selectedIds, true));
        }

        abort_if($cartItems->isEmpty(), 404, 'Tidak ada produk untuk di-checkout');

        $totalHarga = $cartItems->sum(function ($item) {
            return $item->product->harga * $item->qty;
        });
        $totalQty = (int) $cartItems->sum('qty');

        // Auto-fill dari profile user. Profil hanya menyimpan satu field
        // alamat bebas, jadi isi itu ke alamat_lengkap apa adanya. Kota & kode
        // pos dibiarkan kosong agar user mengisinya sendiri (keduanya wajib).
        $alamatProfil = trim((string) ($user->alamat ?? ''));

        $draftOrder = (object) [
            'id' => null,
            'total_harga' => $totalHarga,
            'penerima_nama' => $user->name,
            'alamat_lengkap' => $alamatProfil,
            'nomor_telepon' => $user->nomor_telepon ?? '',
            'user' => $user,
        ];

        return view('payments.create', [
            'order' => $draftOrder,
            'cartItems' => $cartItems,
            'isDraftCheckout' => true,
            'backUrl' => route('carts.index'),
            'totalQty' => $totalQty,
            'couriers' => self::COURIERS,
            'freeShippingMinQty' => self::FREE_SHIPPING_MIN_QTY,
            'freeShipping' => $totalQty >= self::FREE_SHIPPING_MIN_QTY,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'nullable|exists:orders,id',
            'metode' => 'required|in:cod,va_dana,va_ovo,va_gopay,bank_bni,bank_bri,bank_bca',
            'kurir' => 'required|in:' . implode(',', array_keys(self::COURIERS)),
            'penerima_nama' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|min:10|max:20',
        ]);

        $user = Auth::user();
        $cart = $user->cart()->with('cartItems.product')->first();
        abort_unless($cart && $cart->cartItems->isNotEmpty(), 404, 'Keranjang kosong');

        // Item yang akan diproses: hormati pilihan dari session (kalau ada)
        $selectedIds = session('checkout_item_ids');
        $itemsToProcess = $cart->cartItems->filter(fn($i) => $i->product && $i->product->stok > 0);
        if (is_array($selectedIds) && !empty($selectedIds)) {
            $itemsToProcess = $itemsToProcess->filter(fn($i) => in_array($i->id, $selectedIds, true));
        }
        abort_if($itemsToProcess->isEmpty(), 404, 'Tidak ada produk valid untuk diproses');

        $totalQty = (int) $itemsToProcess->sum('qty');
        $ongkir = self::hitungOngkir($data['kurir'], $totalQty);

        // Metode tersimpan di tabel payments. COD tetap "cod" (status pending sampai
        // diterima). E-wallet & transfer bank disimpan persis nilainya dan langsung
        // dianggap selesai (sudah dibayar di gateway / sudah transfer).
        $isInstant = in_array($data['metode'], [
            'va_dana', 'va_ovo', 'va_gopay', 'bank_bni', 'bank_bri', 'bank_bca',
        ], true);

        $order = DB::transaction(function () use ($itemsToProcess, $data, $isInstant, $user, $ongkir) {
            $totalHarga = $itemsToProcess->sum(function ($item) {
                return $item->product->harga * $item->qty;
            }) + $ongkir;

            $order = Order::create([
                'user_id' => $user->id,
                'total_harga' => $totalHarga,
                'status' => $isInstant ? 'dibayar' : 'pending',
                'penerima_nama' => $data['penerima_nama'],
                'alamat_lengkap' => $data['alamat_lengkap'],
                'nomor_telepon' => $data['nomor_telepon'],
                'kurir' => $data['kurir'],
                'ongkir' => $ongkir,
            ]);

            foreach ($itemsToProcess as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'harga' => $item->product->harga,
                ]);

                $item->product->decrement('stok', $item->qty, []);
            }

            $productTotals = [];
            foreach ($order->orderDetails()->with('product')->get() as $detail) {
                $productId = $detail->product_id;
                if (!isset($productTotals[$productId])) {
                    $productTotals[$productId] = [
                        'total' => 0,
                        'umkm_id' => $detail->product->umkm_id,
                    ];
                }
                $productTotals[$productId]['total'] += $detail->harga * $detail->qty;
            }

            foreach ($productTotals as $productId => $detailData) {
                Keuangan::create([
                    'product_id' => $productId,
                    'umkm_id' => $detailData['umkm_id'],
                    'jenis' => 'pemasukan',
                    'jumlah' => $detailData['total'],
                    'keterangan' => 'Penjualan dari Order #' . $order->id,
                    'tanggal' => now()->toDateString(),
                ]);
            }

            Payment::create([
                'order_id' => $order->id,
                'metode' => $data['metode'],
                'jumlah' => $order->total_harga,
                'status' => $isInstant ? 'selesai' : 'pending',
            ]);

            // Hanya hapus item yang benar-benar ikut dibayar (sisanya tetap di keranjang)
            $processedIds = $itemsToProcess->pluck('id')->all();
            \App\Models\CartItem::whereIn('id', $processedIds)->delete();

            return $order;
        });

        // Bersihkan pilihan checkout dari session
        session()->forget('checkout_item_ids');

        return redirect()->route('user.dashboard')->with('success', 'Pesanan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
