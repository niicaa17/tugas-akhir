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
                                <h2 class="fw-bold">👥 Data Anggota UMKM</h2>
                            </div>
                            <a href="{{ route('members.create') }}" class="btn btn-success rounded-pill px-4" style="background: #6aa34d; border-color: #5f993f;">Tambah Karyawan</a>
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
                                        <th class="py-3">Nama Karyawan</th>
                                        <th class="py-3">Alamat Karyawan</th>
                                        <th class="py-3">Telepon Karyawan</th>
                                        <th class="py-3">Jabatan</th>
                                        <th class="py-3 text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($members as $member)
                                        <tr class="align-middle">
                                            <td class="py-3">{{ $member->nama_karyawan }}</td>
                                            <td class="py-3">{{ $member->alamat_karyawan }}</td>
                                            <td class="py-3">{{ $member->telepon_karyawan }}</td>
                                            <td class="py-3">
                                                <span class="badge rounded-pill" style="background: #6aa34d; color: white;">
                                                    {{ $member->jabatan }}
                                                </span>
                                            </td>
                                            <td class="py-3 text-end">
                                                <a href="{{ route('members.edit', $member) }}" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                                <form action="{{ route('members.destroy', $member) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus anggota ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">Belum ada anggota UMKM.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            {{ $members->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
