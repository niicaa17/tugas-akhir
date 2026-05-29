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
     * Minimal jumlah pcs (qty total) di keranjang/order agar opsi
     * Bayar di Tempat (COD) bisa dipakai. Untuk pesanan kecil, COD
     * tidak ditawarkan.
     */
    public const COD_MIN_QTY = 5;

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
                'codAvailable' => $existingTotalQty >= self::COD_MIN_QTY,
                'codMinQty' => self::COD_MIN_QTY,
                'totalQty' => $existingTotalQty,
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
        $codAvailable = $totalQty >= self::COD_MIN_QTY;

        // Auto-fill dari profile user
        $alamatProfil = trim((string) ($user->alamat ?? ''));
        $kotaProfil = '';
        $kodePosProfil = '';

        // Coba ekstrak kode pos (5 digit) dari alamat user kalau ada
        if (preg_match('/(\d{5})/', $alamatProfil, $m)) {
            $kodePosProfil = $m[1];
        }

        $draftOrder = (object) [
            'id' => null,
            'total_harga' => $totalHarga,
            'penerima_nama' => $user->name,
            'alamat_lengkap' => $alamatProfil,
            'kota' => $kotaProfil,
            'kode_pos' => $kodePosProfil,
            'nomor_telepon' => $user->nomor_telepon ?? '',
            'user' => $user,
        ];

        return view('payments.create', [
            'order' => $draftOrder,
            'cartItems' => $cartItems,
            'isDraftCheckout' => true,
            'backUrl' => route('carts.index'),
            'codAvailable' => $codAvailable,
            'codMinQty' => self::COD_MIN_QTY,
            'totalQty' => $totalQty,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'nullable|exists:orders,id',
            'metode' => 'required|in:cod,va_dana,va_ovo,va_gopay',
            'penerima_nama' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string|max:255',
            'kota' => 'required|string|max:100',
            'kode_pos' => 'required|digits:5',
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

        // COD hanya untuk pesanan minimal beberapa pcs (lihat self::COD_MIN_QTY).
        if ($data['metode'] === 'cod') {
            $totalQty = (int) $itemsToProcess->sum('qty');
            if ($totalQty < self::COD_MIN_QTY) {
                return back()->withErrors([
                    'metode' => 'Bayar di Tempat (COD) hanya tersedia untuk pesanan minimal '
                        . self::COD_MIN_QTY . ' pcs. Saat ini di keranjangmu ada '
                        . $totalQty . ' pcs. Tambah produk atau pilih e-wallet (DANA/OVO/GoPay).',
                ])->withInput();
            }
        }

        // Metode tersimpan di tabel payments. COD tetap "cod" (status pending sampai
        // diterima), e-wallet disimpan persis nilainya (va_dana/va_ovo/va_gopay) dan
        // langsung dianggap selesai (sudah dibayar di gateway).
        $isEwallet = in_array($data['metode'], ['va_dana', 'va_ovo', 'va_gopay'], true);

        $order = DB::transaction(function () use ($itemsToProcess, $data, $isEwallet, $user) {
            $totalHarga = $itemsToProcess->sum(function ($item) {
                return $item->product->harga * $item->qty;
            });

            $order = Order::create([
                'user_id' => $user->id,
                'total_harga' => $totalHarga,
                'status' => $isEwallet ? 'dibayar' : 'pending',
                'penerima_nama' => $data['penerima_nama'],
                'alamat_lengkap' => $data['alamat_lengkap'],
                'kota' => $data['kota'],
                'kode_pos' => $data['kode_pos'],
                'nomor_telepon' => $data['nomor_telepon'],
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
                'status' => $isEwallet ? 'selesai' : 'pending',
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
