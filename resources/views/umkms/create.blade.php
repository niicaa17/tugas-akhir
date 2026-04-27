@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: #a0e29c;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9">
                <div class="card rounded-4 border-0" style="background: rgba(255,255,255,0.9);">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold mb-0">Tambah Anggota</h3>
                            <a href="{{ route('umkms.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                        </div>

                        <form action="{{ route('umkms.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nama_umkm" class="form-label">Nama Produk</label>
                                <input type="text" name="nama_umkm" id="nama_umkm" class="form-control @error('nama_umkm') is-invalid @enderror" value="{{ old('nama_umkm') }}" required>
                                @error('nama_umkm')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No HP</label>
                                <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" required>
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success rounded-pill px-4" style="background: #6aa34d; border-color: #5f993f;">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
