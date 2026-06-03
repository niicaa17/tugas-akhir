<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display the user's favorite products.
     */
    public function index()
    {
        $favorites = Auth::user()
            ->favoriteProducts()
            ->with('umkm')
            ->withSum('orderDetails as total_terjual', 'qty')
            ->orderByDesc('favorites.created_at')
            ->get();

        return view('user.favorites', compact('favorites'));
    }

    /**
     * Toggle a product in the user's favorites.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Produk dihapus dari favorit';
            $favorited = false;
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
            ]);
            $message = 'Produk ditambahkan ke favorit';
            $favorited = true;
        }

        if ($request->wantsJson()) {
            return response()->json([
                'favorited' => $favorited,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
