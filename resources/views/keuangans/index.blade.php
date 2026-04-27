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
                                <h2 class="fw-bold">Laporan Keuangan</h2>
                            </div>
                            <a href="{{ route('keuangans.create') }}" class="btn btn-success rounded-pill px-4" style="background: #6aa34d; border-color: #5f993f;">Tambah Data</a>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table align-middle mb-0 rounded-4" style="background: #f9fafb;">
                                <thead style="background: #d1e5b8;">
                                    <tr>
                                        <th class="py-3">Nama Produk</th>
                                        <th class="py-3">Jenis</th>
                                        <th class="py-3">Jumlah</th>
                                        <th class="py-3">Keterangan</th>
                                        <th class="py-3">Tanggal</th>
                                        <th class="py-3 text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalPemasukan = 0; $totalPengeluaran = 0; @endphp
                                    @forelse ($keuangans as $keuangan)
                                        <tr class="align-middle">
                                            <td class="py-3">{{ $keuangan->product->nama_produk ?? '-' }}</td>
                                            <td class="py-3">
                                                <span class="badge rounded-pill" style="background: {{ $keuangan->jenis == 'pemasukan' ? '#5f993f' : '#d9534f' }}; color: white;">
                                                    {{ ucfirst($keuangan->jenis) }}
                                                </span>
                                            </td>
                                            <td class="py-3">Rp {{ number_format($keuangan->jumlah, 0, ',', '.') }}</td>
                                            <td class="py-3">{{ $keuangan->keterangan }}</td>
                                            <td class="py-3">{{ $keuangan->tanggal->format('d M Y') }}</td>
                                            <td class="py-3 text-end">
                                                <a href="{{ route('keuangans.edit', $keuangan) }}" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                                <form action="{{ route('keuangans.destroy', $keuangan) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @if ($keuangan->jenis == 'pemasukan')
                                            @php $totalPemasukan += $keuangan->jumlah; @endphp
                                        @else
                                            @php $totalPengeluaran += $keuangan->jumlah; @endphp
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data keuangan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="card rounded-3 border-0" style="background: #e8f4e3;">
                                    <div class="card-body">
                                        <h6 class="text-muted">Total Pemasukan</h6>
                                        <h4 class="fw-bold" style="color: #5f993f;">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card rounded-3 border-0" style="background: #fce8e6;">
                                    <div class="card-body">
                                        <h6 class="text-muted">Total Pengeluaran</h6>
                                        <h4 class="fw-bold" style="color: #d9534f;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card rounded-3 border-0" style="background: #f5e87d;">
                                    <div class="card-body">
                                        <h6 class="text-muted">Saldo</h6>
                                        <h4 class="fw-bold" style="color: #a0826d;">Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            {{ $keuangans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
