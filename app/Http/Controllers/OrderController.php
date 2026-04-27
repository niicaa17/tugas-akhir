<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $orderQuery = Order::where('user_id', Auth::id())
            ->with('orderDetails.product')
            ->latest();

        if (isset($statusMap[$statusTab])) {
            $orderQuery->whereIn('status', $statusMap[$statusTab]);
        }

        $orders = $orderQuery->paginate(8)->withQueryString();

        $topProducts = Product::withSum('orderDetails as total_terjual', 'qty')
            ->orderByDesc('total_terjual')
            ->orderBy('nama_produk')
            ->limit(3)
            ->get();

        $categories = Category::orderBy('nama_kategori')->limit(3)->get();

        return view('orders.index', compact('orders', 'statusTab', 'topProducts', 'categories'));
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
            $item->product->decrement('stok', $item->qty);
        }

        $cart->cartItems()->delete();

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

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Check if order belongs to current user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
