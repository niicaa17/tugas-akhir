@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: #a0e29c;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9">
                <div class="card rounded-4 border-0" style="background: rgba(255,255,255,0.9);">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4">Detail Data Keuangan</h3>

                        <p><strong>Nama Produk:</strong> {{ $keuangan->product->nama_produk ?? '-' }}</p>
                        <p><strong>Jenis:</strong> {{ ucfirst($keuangan->jenis) }}</p>
                        <p><strong>Jumlah:</strong> Rp {{ number_format($keuangan->jumlah, 0, ',', '.') }}</p>
                        <p><strong>Keterangan:</strong> {{ $keuangan->keterangan ?: '-' }}</p>
                        <p><strong>Tanggal:</strong> {{ $keuangan->tanggal->format('d M Y') }}</p>
                        <p><strong>Dibuat:</strong> {{ $keuangan->created_at->format('d M Y H:i') }}</p>

                        <a href="{{ route('keuangans.edit', $keuangan) }}" class="btn btn-success rounded-pill px-4 me-2" style="background: #6aa34d; border-color: #5f993f;">Edit</a>
                        <a href="{{ route('keuangans.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
