<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year', now()->year);

        $dbYears = Keuangan::selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->pluck('year')
            ->map(fn($y) => (int) $y)
            ->toArray();

        $startYear = 2024;
        $currentYear = (int) now()->year;
        $allYears = array_unique(array_merge(range($startYear, max($startYear, $currentYear)), $dbYears));
        sort($allYears);
        $availableYears = array_values($allYears);
        
        $query = Keuangan::with(['product.umkm']);
        
        // Filter by year if specified (and not 'all')
        if ($year && $year !== 'all' && is_numeric($year)) {
            $query->whereYear('tanggal', $year);
        }

        // Filter by month if provided
        if ($month && is_numeric($month) && $month >= 1 && $month <= 12) {
            $query->whereMonth('tanggal', $month);
        }
        
        $totalPemasukan = (clone $query)->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = (clone $query)->where('jenis', 'pengeluaran')->sum('jumlah');

        $keuangans = $query->orderBy('tanggal', 'desc')->paginate(10)->withQueryString();

        // Chart data: monthly pemasukan & pengeluaran for the selected year
        $chartQuery = Keuangan::select(
                DB::raw('MONTH(tanggal) as bulan'),
                'jenis',
                DB::raw('SUM(jumlah) as total')
            );

        if ($year && $year !== 'all' && is_numeric($year)) {
            $chartQuery->whereYear('tanggal', $year);
        }

        $chartData = $chartQuery->groupBy(DB::raw('MONTH(tanggal)'), 'jenis')
            ->orderBy(DB::raw('MONTH(tanggal)'))
            ->get();

        $monthlyPemasukan = array_fill(1, 12, 0);
        $monthlyPengeluaran = array_fill(1, 12, 0);

        foreach ($chartData as $row) {
            if ($row->jenis === 'pemasukan') {
                $monthlyPemasukan[(int) $row->bulan] = (int) $row->total;
            } else {
                $monthlyPengeluaran[(int) $row->bulan] = (int) $row->total;
            }
        }

        $chartPemasukan = array_values($monthlyPemasukan);
        $chartPengeluaran = array_values($monthlyPengeluaran);
        
        return view('keuangans.index', compact('keuangans', 'month', 'year', 'availableYears', 'chartPemasukan', 'chartPengeluaran', 'totalPemasukan', 'totalPengeluaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::with('umkm')->orderBy('nama_produk')->get();
        return view('keuangans.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        $product = Product::findOrFail($data['product_id']);
        $data['umkm_id'] = $product->umkm_id;

        Keuangan::create($data);

        return redirect()->route('keuangans.index')->with('success', 'Data keuangan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Keuangan $keuangan)
    {
        return view('keuangans.show', compact('keuangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keuangan $keuangan)
    {
        $products = Product::with('umkm')->orderBy('nama_produk')->get();
        return view('keuangans.edit', compact('keuangan', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keuangan $keuangan)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        $product = Product::findOrFail($data['product_id']);
        $data['umkm_id'] = $product->umkm_id;

        $keuangan->update($data);

        return redirect()->route('keuangans.index')->with('success', 'Data keuangan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keuangan $keuangan)
    {
        $keuangan->delete();
        return redirect()->route('keuangans.index')->with('success', 'Data keuangan berhasil dihapus');
    }

    /**
     * Print (cetak) laporan keuangan.
     */
    public function print(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year', now()->year);
        
        $dbYears = Keuangan::selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->pluck('year')
            ->map(fn($y) => (int) $y)
            ->toArray();

        $startYear = 2024;
        $currentYear = (int) now()->year;
        $allYears = array_unique(array_merge(range($startYear, max($startYear, $currentYear)), $dbYears));
        sort($allYears);
        $availableYears = array_values($allYears);

        $query = Keuangan::with(['product.umkm']);
        
        // Filter by year if specified (and not 'all')
        if ($year && $year !== 'all' && is_numeric($year)) {
            $query->whereYear('tanggal', $year);
        }

        // Filter by month if provided
        if ($month && is_numeric($month) && $month >= 1 && $month <= 12) {
            $query->whereMonth('tanggal', $month);
        }
        
        $keuangans = $query->orderBy('tanggal', 'desc')->get();

        $totalPemasukan = $keuangans->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $keuangans->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('keuangans.print', compact('keuangans', 'totalPemasukan', 'totalPengeluaran', 'saldo', 'month', 'year', 'availableYears'));
    }
}
