<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Reset pilihan checkout sebelumnya kalau user balik ke keranjang
        session()->forget('checkout_item_ids');

        $cart = $this->resolveUserCart(Auth::user());
        $cartItems = $cart->cartItems()->with('product')->get();

        $recommendedProducts = Product::withSum('orderDetails as total_terjual', 'qty')
            ->orderByDesc('total_terjual')
            ->orderBy('nama_produk')
            ->limit(3)
            ->get();

        $wedjangkuProduct = Product::where('nama_produk', 'like', '%wedjangku%', 'and')
            ->orderByDesc('stok')
            ->orderBy('nama_produk')
            ->first();

        return view('carts.index', compact('cartItems', 'recommendedProducts', 'wedjangkuProduct'));
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
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stok <= 0) {
            return redirect()->back()->with('error', 'Maaf, produk ' . $product->nama_produk . ' sudah habis.');
        }

        $user = Auth::user();
        $cart = $this->resolveUserCart($user);

        $cartItem = CartItem::where('cart_id', '=', $cart->id, 'and')
                    ->where('product_id', '=', $request->product_id, 'and')
                            ->first();

        $existingQty = $cartItem ? $cartItem->qty : 0;
        $newTotalQty = $existingQty + $request->qty;

        if ($newTotalQty > $product->stok) {
            return redirect()->back()->with('error', 'Stok ' . $product->nama_produk . ' tinggal ' . $product->stok . '. Tidak bisa menambah lebih banyak.');
        }

        if ($cartItem) {
            $cartItem->update(['qty' => $newTotalQty]);
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'qty' => $request->qty,
            ]);
        }

        if ($request->input('redirect_to') === 'checkout') {
            // Pilih hanya produk ini untuk checkout (Beli Sekarang)
            session(['checkout_item_ids' => [$cartItem->id]]);
            return redirect()->route('payments.create')->with('success', 'Lanjutkan pembayaran untuk produk ini');
        }

        return redirect()->route('carts.index')->with('success', 'Produk ditambahkan ke keranjang');
    }

    /**
     * Simpan pilihan item yang akan di-checkout ke session lalu lanjut ke halaman pembayaran.
     */
    public function checkout(Request $request)
    {
        $data = $request->validate([
            'cart_item_ids'   => 'required|array|min:1',
            'cart_item_ids.*' => 'integer',
        ], [
            'cart_item_ids.required' => 'Pilih minimal satu produk untuk di-checkout.',
        ]);

        $user = Auth::user();
        $cart = $this->resolveUserCart($user);

        // Validasi: semua id harus milik cart user dan produknya masih ada stoknya
        $validIds = CartItem::where('cart_id', '=', $cart->id, 'and')
            ->whereIn('id', $data['cart_item_ids'])
            ->with('product')
            ->get()
            ->filter(fn($i) => $i->product && $i->product->stok > 0)
            ->pluck('id')
            ->all();

        if (empty($validIds)) {
            return redirect()->route('carts.index')->with('error', 'Tidak ada produk valid yang bisa di-checkout.');
        }

        session(['checkout_item_ids' => $validIds]);

        return redirect()->route('payments.create');
    }

    /**
     * Decrease product quantity in cart or remove it when quantity reaches zero.
     */
    public function decrement(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $cart = $this->resolveUserCart($user);

        $cartItem = CartItem::where('cart_id', '=', $cart->id, 'and')
            ->where('product_id', '=', $request->product_id, 'and')
            ->first();

        if (! $cartItem) {
            return redirect()->route('carts.index')->with('success', 'Produk tidak ditemukan di keranjang');
        }

        if ($cartItem->qty <= 1) {
            return redirect()->route('carts.index')->with('success', 'Jumlah minimum 1, gunakan tombol hapus untuk menghapus produk');
        }

        $newQty = $cartItem->qty - $request->qty;

        if ($newQty < 1) {
            $newQty = 1;
        }

        $cartItem->update(['qty' => $newQty]);

        return redirect()->route('carts.index')->with('success', 'Jumlah produk dikurangi');
    }

    /**
     * Remove product from cart regardless of quantity.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();
        $cart = $this->resolveUserCart($user);

        $cartItem = CartItem::where('cart_id', '=', $cart->id, 'and')
            ->where('product_id', '=', $request->product_id, 'and')
            ->first();

        if (! $cartItem) {
            return redirect()->route('carts.index')->with('success', 'Produk tidak ditemukan di keranjang');
        }

        $cartItem->delete();

        return redirect()->route('carts.index')->with('success', 'Produk dihapus dari keranjang');
    }

    /**
     * Resolve single active cart for user and merge duplicated carts if any.
     */
    private function resolveUserCart($user): Cart
    {
        $carts = Cart::where('user_id', '=', $user->id, 'and')
            ->withCount('cartItems')
            ->orderByDesc('cart_items_count')
            ->orderByDesc('updated_at')
            ->get();

        if ($carts->isEmpty()) {
            return Cart::create(['user_id' => $user->id]);
        }

        $mainCart = $carts->first();
        $duplicateCarts = $carts->slice(1);

        foreach ($duplicateCarts as $duplicateCart) {
            foreach ($duplicateCart->cartItems as $dupItem) {
                $existingItem = CartItem::where('cart_id', '=', $mainCart->id, 'and')
                    ->where('product_id', '=', $dupItem->product_id, 'and')
                    ->first();

                if ($existingItem) {
                    $existingItem->update(['qty' => $existingItem->qty + $dupItem->qty]);
                    $dupItem->delete();
                } else {
                    $dupItem->update(['cart_id' => $mainCart->id]);
                }
            }

            $duplicateCart->delete();
        }

        return $mainCart;
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
