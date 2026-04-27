<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * Display the customer dashboard.
     */
    public function index()
    {
        $topProducts = Product::with(['umkm'])
            ->withSum('orderDetails as total_terjual', 'qty')
            ->orderByDesc('total_terjual')
            ->orderBy('nama_produk')
            ->limit(3)
            ->get();

        $categories = Category::orderBy('nama_kategori')->limit(3)->get();

        return view('user.dashboard', compact('topProducts', 'categories'));
    }

    /**
     * Display user-facing product detail page.
     */
    public function showProduct(Product $product)
    {
        $product->load('umkm');
        $product->loadSum('orderDetails as total_terjual', 'qty');

        $otherProducts = Product::with('umkm')
            ->where('id', '!=', $product->id)
            ->withSum('orderDetails as total_terjual', 'qty')
            ->orderByDesc('total_terjual')
            ->orderBy('nama_produk')
            ->limit(3)
            ->get();

        return view('user.product-show', compact('product', 'otherProducts'));
    }

    /**
     * Display user profile page.
     */
    public function profile()
    {
        $user = Auth::user();

        $ordersQuery = $user->orders();

        $orderCount = (clone $ordersQuery)->count();
        $activeOrderCount = (clone $ordersQuery)
            ->whereIn('status', ['pending', 'dibayar', 'dikirim'])
            ->count();
        $completedOrderCount = (clone $ordersQuery)
            ->where('status', 'selesai')
            ->count();
        $totalSpent = (clone $ordersQuery)
            ->where('status', '!=', 'dibatalkan')
            ->sum('total_harga');

        $cartItemCount = optional($user->cart)
            ? $user->cart->cartItems()->sum('qty')
            : 0;

        $lastOrder = (clone $ordersQuery)->latest()->first();

        return view('user.profile', compact(
            'user',
            'orderCount',
            'activeOrderCount',
            'completedOrderCount',
            'totalSpent',
            'cartItemCount',
            'lastOrder'
        ));
    }
}
