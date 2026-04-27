<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Product;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keuangans = Keuangan::with(['product.umkm'])->paginate(10);
        return view('keuangans.index', compact('keuangans'));
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
}
