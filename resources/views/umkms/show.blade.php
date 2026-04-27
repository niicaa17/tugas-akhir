@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Detail UMKM</h3>
                </div>

                <div class="card-body">
                    @if ($umkm->logo)
                        <img src="{{ asset('storage/' . $umkm->logo) }}" alt="Logo" width="150" class="mb-3">
                    @endif

                    <p><strong>ID:</strong> {{ $umkm->id }}</p>
                    <p><strong>Nama Produk:</strong> {{ $umkm->nama_umkm }}</p>
                    <p><strong>Alamat:</strong> {{ $umkm->alamat }}</p>
                    <p><strong>No HP:</strong> {{ $umkm->no_hp }}</p>
                    <p><strong>Deskripsi:</strong> {{ $umkm->deskripsi }}</p>
                    <p><strong>Pemilik:</strong> {{ $umkm->user->name }}</p>
                    <p><strong>Dibuat:</strong> {{ $umkm->created_at->format('d M Y H:i') }}</p>
                    <p><strong>Diupdate:</strong> {{ $umkm->updated_at->format('d M Y H:i') }}</p>

                    <a href="{{ route('umkms.edit', $umkm) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('umkms.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
