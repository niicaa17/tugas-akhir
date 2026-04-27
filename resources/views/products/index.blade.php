@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: #a0e29c;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card rounded-4 border-0" style="background: rgba(255,255,255,0.9);">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h2 class="fw-bold">Kelola Produk</h2>
                            </div>
                            <a href="{{ route('products.create') }}" class="btn btn-success rounded-pill px-4" style="background: #6aa34d; border-color: #5f993f;">Tambah Barang</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle mb-0 rounded-4" style="background: #f9fafb;">
                                <thead style="background: #d1e5b8;">
                                    <tr>
                                        <th class="py-3">Foto</th>
                                        <th class="py-3">Nama Produk</th>
                                        <th class="py-3">Brand / UMKM</th>
                                        <th class="py-3">Harga</th>
                                        <th class="py-3">Stok</th>
                                        <th class="py-3">Kode Barang</th>
                                        <th class="py-3 text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr class="align-middle">
                                            <td class="py-3">
                                                @if ($product->gambar)
                                                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="rounded-3 border" style="width: 56px; height: 56px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-3 border d-inline-flex align-items-center justify-content-center text-muted" style="width: 56px; height: 56px;">-</div>
                                                @endif
                                            </td>
                                            <td class="py-3">{{ $product->nama_produk }}</td>
                                            <td class="py-3">{{ $product->umkm->nama_umkm ?? '-' }}</td>
                                            <td class="py-3">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                            <td class="py-3">
                                                <span class="badge rounded-pill" style="background: #5f993f; color: white;">{{ $product->stok }}</span>
                                            </td>
                                            <td class="py-3">{{ sprintf('WJK%04d', $product->id) }}</td>
                                            <td class="py-3 text-end">
                                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">Belum ada produk.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
