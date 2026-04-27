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
        $cart = $this->resolveUserCart(Auth::user());
        $cartItems = $cart->cartItems()->with('product')->get();

        $recommendedProducts = Product::withSum('orderDetails as total_terjual', 'qty')
            ->orderByDesc('total_terjual')
            ->orderBy('nama_produk')
            ->limit(3)
            ->get();

        $wedjangkuProduct = Product::where('nama_produk', 'like', '%wedjangku%')
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

        $user = Auth::user();
        $cart = $this->resolveUserCart($user);

        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $request->product_id)
                            ->first();

        if ($cartItem) {
            $cartItem->update(['qty' => $cartItem->qty + $request->qty]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'qty' => $request->qty,
            ]);
        }

        return redirect()->route('carts.index')->with('success', 'Produk ditambahkan ke keranjang');
    }

    /**
     * Resolve single active cart for user and merge duplicated carts if any.
     */
    private function resolveUserCart($user): Cart
    {
        $carts = Cart::where('user_id', $user->id)
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
                $existingItem = CartItem::where('cart_id', $mainCart->id)
                    ->where('product_id', $dupItem->product_id)
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
