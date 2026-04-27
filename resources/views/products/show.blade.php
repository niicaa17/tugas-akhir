@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: #a0e29c;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card rounded-4 border-0" style="background: rgba(255,255,255,0.95);">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="fw-bold">Detail Produk</h2>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Kembali</a>
                        </div>

                        <dl class="row">
                            <dt class="col-sm-4">Foto Produk</dt>
                            <dd class="col-sm-8">
                                @if ($product->gambar)
                                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="rounded-3 border" style="width: 160px; height: 160px; object-fit: cover;">
                                @else
                                    -
                                @endif
                            </dd>

                            <dt class="col-sm-4">Nama Produk</dt>
                            <dd class="col-sm-8">{{ $product->nama_produk }}</dd>

                            <dt class="col-sm-4">Brand / UMKM</dt>
                            <dd class="col-sm-8">{{ $product->umkm->nama_umkm ?? '-' }}</dd>

                            <dt class="col-sm-4">Kategori</dt>
                            <dd class="col-sm-8">{{ $product->category->nama_kategori ?? '-' }}</dd>

                            <dt class="col-sm-4">Harga</dt>
                            <dd class="col-sm-8">Rp {{ number_format($product->harga, 0, ',', '.') }}</dd>

                            <dt class="col-sm-4">Stok</dt>
                            <dd class="col-sm-8">{{ $product->stok }}</dd>

                            <dt class="col-sm-4">Deskripsi</dt>
                            <dd class="col-sm-8">{{ $product->deskripsi ?? '-' }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
