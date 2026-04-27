@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: #a0e29c;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card rounded-4 border-0" style="background: rgba(255,255,255,0.95);">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="fw-bold">Edit Produk</h2>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Kembali</a>
                        </div>

                        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Brand</label>
                                <select name="umkm_id" class="form-select @error('umkm_id') is-invalid @enderror">
                                    <option value="">Pilih Brand</option>
                                    @foreach ($umkms as $umkm)
                                        <option value="{{ $umkm->id }}" {{ old('umkm_id', $product->umkm_id) == $umkm->id ? 'selected' : '' }}>{{ $umkm->nama_umkm }}</option>
                                    @endforeach
                                </select>
                                @error('umkm_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" class="form-control @error('nama_produk') is-invalid @enderror">
                                @error('nama_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Harga</label>
                                    <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" class="form-control @error('harga') is-invalid @enderror">
                                    @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Stok</label>
                                    <input type="number" name="stok" value="{{ old('stok', $product->stok) }}" class="form-control @error('stok') is-invalid @enderror">
                                    @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Gambar Produk</label>
                                <input type="file" name="gambar" accept="image/*" class="form-control @error('gambar') is-invalid @enderror">
                                <small class="text-muted d-block mb-2">Format: JPG, PNG, GIF, WEBP. Maksimal 3MB.</small>
                                @if ($product->gambar)
                                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="Gambar Produk" class="rounded-3 border" style="width: 120px; height: 120px; object-fit: cover;">
                                @endif
                                @error('gambar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <button type="submit" class="btn btn-success px-4" style="background: #6aa34d; border-color: #5f993f;">Perbarui Produk</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
