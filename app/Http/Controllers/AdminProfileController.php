<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Member;
use App\Models\Order;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Tampilkan halaman profil admin (akun + data UMKM + statistik).
     */
    public function index()
    {
        $user = Auth::user();
        $umkm = Umkm::first(); // singleton

        $stats = [
            'totalProduk' => Product::count(),
            'totalAnggota' => Member::count(),
            'totalOrder' => Order::count(),
            'totalPemasukan' => (int) Keuangan::where('jenis', 'pemasukan')->sum('jumlah'),
        ];

        $accountAge = $user->created_at ? $user->created_at->diffForHumans(now(), ['parts' => 1]) : '-';

        return view('admin.profile', compact('user', 'umkm', 'stats', 'accountAge'));
    }

    /**
     * Simpan perubahan akun admin & profil UMKM dalam satu request.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            // Akun admin
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            // Profil UMKM
            'nama_umkm' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_hp' => ['required', 'string', 'max:20'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        // Update user
        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        // Update / create UMKM (singleton)
        $umkm = Umkm::first();
        $umkmData = [
            'nama_umkm' => $data['nama_umkm'],
            'alamat' => $data['alamat'],
            'no_hp' => $data['no_hp'],
            'deskripsi' => $data['deskripsi'] ?? null,
        ];

        if ($umkm) {
            $umkm->update($umkmData);
        } else {
            $umkmData['user_id'] = $user->id;
            Umkm::create($umkmData);
        }

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui');
    }
}
