<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Umkm;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Keuangan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pemasukan = Keuangan::where('jenis', 'pemasukan')->sum('jumlah');
        $pengeluaran = Keuangan::where('jenis', 'pengeluaran')->sum('jumlah');

        return view('home', [
            'totalProduk' => Product::count(),
            'totalKategori' => Category::count(),
            'totalUmkm' => Umkm::count(),
            'totalOrder' => Order::count(),
            'totalPayment' => Payment::count(),
            'totalKeuangan' => Keuangan::count(),
            'saldoKeuangan' => $pemasukan - $pengeluaran,
        ]);
    }
}
