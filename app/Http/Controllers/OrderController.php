<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Keuangan;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statusTab = $request->query('status', 'semua');

        $statusMap = [
            'diproses' => ['pending', 'dibayar'],
            'dikirim' => ['dikirim'],
            'selesai' => ['selesai'],
        ];

        $orderQuery = Order::with(['orderDetails.product', 'user', 'payments'])->latest();

        if (! Auth::user()->isAdmin()) {
            $orderQuery->where('user_id', Auth::id());
        }

        if (isset($statusMap[$statusTab])) {
            $orderQuery->whereIn('status', $statusMap[$statusTab]);
        }

        $orders = $orderQuery->paginate(8)->withQueryString();

        $topProducts = Product::withSum('orderDetails as total_terjual', 'qty')
            ->orderByDesc('total_terjual')
            ->orderBy('nama_produk')
            ->limit(3)
            ->get();

        return view('orders.index', compact('orders', 'statusTab', 'topProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart;
        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong');
        }

        $totalHarga = 0;
        foreach ($cart->cartItems as $item) {
            $totalHarga += $item->product->harga * $item->qty;
        }

        $order = Order::create([
            'user_id' => $user->id,
            'total_harga' => $totalHarga,
        ]);

        foreach ($cart->cartItems as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'harga' => $item->product->harga,
            ]);

            // Kurangi stok produk
            $item->product->decrement('stok', $item->qty, []);
        }

        // Catat pemasukan ke keuangan untuk setiap produk
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

        foreach ($productTotals as $productId => $data) {
            \App\Models\Keuangan::create([
                'product_id' => $productId,
                'umkm_id' => $data['umkm_id'],
                'jenis' => 'pemasukan',
                'jumlah' => $data['total'],
                'keterangan' => 'Penjualan dari Order #' . $order->id,
                'tanggal' => now()->toDateString(),
            ]);
        }

        return redirect()->route('payments.create', ['order' => $order->id])
            ->with('success', 'Pesanan dibuat. Lengkapi checkout lalu klik Buat Pesanan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if (! Auth::user()->isAdmin() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('orderDetails.product.umkm', 'payments', 'user');

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403);
        }

        $data = $request->validate([
            'status' => 'required|in:pending,dikirim,selesai,dibatalkan',
        ]);

        // Aturan: status hanya boleh "selesai" jika order sudah pernah dikirim
        // (atau memang sudah selesai). Ini menjaga urutan flow:
        //   pending/dibayar -> dikirim -> selesai
        if ($data['status'] === 'selesai'
            && ! in_array($order->status, ['dikirim', 'selesai'], true)) {
            return back()->withErrors([
                'status' => 'Pesanan harus berstatus "Dikirim" dulu sebelum bisa ditandai "Selesai".',
            ]);
        }

        $order->update([
            'status' => $data['status'],
        ]);

        // Sinkronkan status pembayaran:
        // - Jika order selesai, payment juga jadi selesai (untuk COD ini berarti uang sudah diterima).
        // - Jika order dibatalkan, payment ikut dibatalkan.
        if ($data['status'] === 'selesai') {
            $payment = $order->payments()->first();
            if ($payment) {
                $payment->update(['status' => 'selesai']);
            }
        } elseif ($data['status'] === 'dibatalkan') {
            $payment = $order->payments()->first();
            if ($payment) {
                $payment->update(['status' => 'dibatalkan']);
            }
        }

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Status transaksi berhasil diperbarui.');
    }

    /**
     * User mengkonfirmasi bahwa pesanannya sudah diterima.
     * Status order otomatis jadi "selesai" dan pembayaran (termasuk COD)
     * ditandai selesai juga.
     */
    public function confirm(Request $request, Order $order)
    {
        // Hanya pemilik order yang boleh konfirmasi penerimaan
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'dikirim') {
            return back()->with('error', 'Pesanan ini belum berstatus "Dikirim", jadi belum bisa dikonfirmasi diterima.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'selesai']);

            $payment = $order->payments()->first();
            if ($payment) {
                $payment->update(['status' => 'selesai']);
            }
        });

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Terima kasih! Pesanan ditandai selesai.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403);
        }

        DB::transaction(function () use ($order) {
            $order->load('orderDetails.product');

            foreach ($order->orderDetails as $detail) {
                if ($detail->product) {
                    $detail->product->increment('stok', $detail->qty);
                }
            }

            Keuangan::where('keterangan', 'Penjualan dari Order #' . $order->id)->delete();

            $order->delete();
        });

        return redirect()
            ->route('orders.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
