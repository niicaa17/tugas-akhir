<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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

        return view('user.dashboard', compact('topProducts'));
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

        $isFavorited = Auth::user()->favorites()
            ->where('product_id', $product->id)
            ->exists();

        return view('user.product-show', compact('product', 'otherProducts', 'isFavorited'));
    }

    /**
     * Display the full shop catalog with search & sorting.
     */
    public function shop(Request $request)
    {
        $search = trim((string) $request->input('q', ''));
        $sort = $request->input('sort', 'terlaris');

        $products = Product::with('umkm')
            ->withSum('orderDetails as total_terjual', 'qty')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('nama_produk', 'like', '%' . $search . '%');
            });

        switch ($sort) {
            case 'termurah':
                $products->orderBy('harga')->orderBy('nama_produk');
                break;
            case 'termahal':
                $products->orderByDesc('harga')->orderBy('nama_produk');
                break;
            case 'nama':
                $products->orderBy('nama_produk');
                break;
            default:
                $sort = 'terlaris';
                $products->orderByDesc('total_terjual')->orderBy('nama_produk');
                break;
        }

        $products = $products->paginate(12)->withQueryString();

        $favoriteIds = Auth::user()->favorites()->pluck('product_id')->all();

        return view('user.shop', compact('products', 'search', 'sort', 'favoriteIds'));
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

    /**
     * Update user profile (data + foto).
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'nomor_telepon' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date', 'before:today'],
            'jenis_kelamin' => ['nullable', 'in:laki-laki,perempuan'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'avatar.max' => 'Foto profil maksimal 2 MB.',
            'avatar.mimes' => 'Format foto harus jpg, jpeg, png, atau webp.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->nomor_telepon = $data['nomor_telepon'] ?? null;
        $user->alamat = $data['alamat'] ?? null;
        $user->tanggal_lahir = $data['tanggal_lahir'] ?? null;
        $user->jenis_kelamin = $data['jenis_kelamin'] ?? null;

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui');
    }
}
