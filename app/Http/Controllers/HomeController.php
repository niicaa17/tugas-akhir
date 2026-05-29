<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Member;
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
        $keuangans = Keuangan::orderBy('tanggal', 'desc')->paginate(10);

        return view('home', [
            'totalProduk' => Product::count(),
            'totalUmkm' => Umkm::count(),
            'totalAnggota' => Member::count(),
            'totalOrder' => Order::count(),
            'totalPayment' => Payment::count(),
            'totalKeuangan' => Keuangan::count(),
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'saldoKeuangan' => $pemasukan - $pengeluaran,
            'keuangans' => $keuangans,
        ]);
    }
}
