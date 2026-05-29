@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300;1,9..40,400&family=Playfair+Display:wght@500;600;700&display=swap');

    /* Hide default Bootstrap navbar */
    body > #app > nav.navbar { display: none !important; }
    body > #app > main.py-4 { padding: 0 !important; }

    :root {
        --sage: #7CB99A;
        --sage-light: #A8D4BC;
        --sage-pale: #E8F4EE;
        --sage-deep: #4A8A6A;
        --cream: #F7F4EE;
        --gold: #C9A84C;
        --gold-light: #E8C97A;
        --gold-pale: #FDF6E3;
        --ink: #1C2B24;
        --ink-mid: #2E4A3A;
        --ink-soft: #4A6858;
        --muted: #8A9E93;
        --surface: #FFFFFF;
        --border: rgba(124, 185, 154, 0.18);
        --shadow-sm: 0 1px 4px rgba(28, 43, 36, 0.06);
        --radius-sm: 8px;
        --radius-lg: 20px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', -apple-system, sans-serif; background: var(--cream); color: var(--ink); -webkit-font-smoothing: antialiased; }
    .layout { display: flex; min-height: 100vh; }
    .sidebar { width: 260px; background: var(--ink); position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto; display: flex; flex-direction: column; z-index: 100; }
    .sidebar-brand { padding: 28px 24px 24px; border-bottom: 1px solid rgba(255,255,255,0.06); display: flex; align-items: center; gap: 12px; }
    .sidebar-logo-wrap { width: 42px; height: 42px; border-radius: 10px; overflow: hidden; background: var(--sage-pale); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .sidebar-logo-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .sidebar-brand-name { font-family: 'Playfair Display', Georgia, serif; font-size: 15px; font-weight: 600; color: #fff; line-height: 1.2; }
    .sidebar-brand-role { font-size: 10.5px; font-weight: 500; color: var(--sage-light); letter-spacing: 0.12em; text-transform: uppercase; margin-top: 2px; }
    .sidebar-nav { padding: 20px 14px; flex: 1; display: flex; flex-direction: column; gap: 2px; }
    .nav-section-label { font-size: 10px; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; color: var(--muted); padding: 16px 10px 8px; }
    .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: var(--radius-sm); text-decoration: none; color: rgba(255,255,255,0.58); font-size: 13.5px; transition: all 0.2s; position: relative; }
    .nav-item:hover, .nav-item.active { background: rgba(124, 185, 154, 0.18); color: var(--sage-light); }
    .nav-item.active::before { content: ''; position: absolute; left: 0; top: 6px; bottom: 6px; width: 3px; background: var(--sage); border-radius: 0 2px 2px 0; }
    .nav-icon { width: 18px; height: 18px; opacity: 0.7; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 15px; }
    .sidebar-footer { padding: 16px 14px 24px; border-top: 1px solid rgba(255,255,255,0.06); display: flex; flex-direction: column; gap: 6px; }
    .profile-link { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px; background: rgba(124, 185, 154, 0.12); color: #A8D4BC; font-size: 13.5px; text-decoration: none; transition: all 0.2s; }
    .profile-link:hover { background: rgba(124, 185, 154, 0.22); color: #A8D4BC; }
    .logout-btn { display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 12px; border-radius: var(--radius-sm); border: none; background: rgba(201, 168, 76, 0.1); color: var(--gold-light); font-size: 13.5px; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: all 0.2s; text-align: left; }
    .logout-btn:hover { background: rgba(201, 168, 76, 0.2); }

    .main { margin-left: 260px; flex: 1; padding: 36px 40px; min-height: 100vh; }
    .topbar { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 28px; }
    .page-eyebrow { font-size: 11px; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; color: var(--sage-deep); margin-bottom: 6px; }
    .page-title { font-family: 'Playfair Display', Georgia, serif; font-size: 30px; font-weight: 600; color: var(--ink); line-height: 1.2; }
    .topbar-actions { display: flex; align-items: center; gap: 10px; }
    .btn-add { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; background: var(--gold); color: #fff; border-radius: var(--radius-sm); text-decoration: none; font-size: 13px; font-weight: 600; font-family: 'DM Sans', sans-serif; transition: all 0.2s; border: none; cursor: pointer; box-shadow: 0 2px 10px rgba(201, 168, 76, 0.3); }
    .btn-add:hover { background: #b8953e; transform: translateY(-1px); color: #fff; }

    .alert-soft { border: 1px solid var(--border); border-radius: 14px; background: var(--sage-pale); color: var(--ink); }
    .page-card { background: var(--surface); border-radius: var(--radius-lg); border: 1px solid var(--border); box-shadow: var(--shadow-sm); overflow: hidden; }
    .page-card-head { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 22px 28px; border-bottom: 1px solid var(--border); flex-wrap: wrap; }
    .page-card-title { font-size: 15px; font-weight: 700; color: var(--ink); letter-spacing: -0.01em; }
    .page-card-subtitle { margin-top: 4px; font-size: 12.5px; color: var(--muted); }
    .page-card-body { padding: 24px 28px 28px; }

    .table-wrap { overflow-x: auto; border: 1px solid var(--border); border-radius: 18px; background: #fff; }
    .table { margin-bottom: 0; }
    .table thead th { background: var(--cream); color: var(--ink-soft); font-weight: 700; font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; border-bottom: 1px solid var(--border); padding-top: 15px; padding-bottom: 15px; white-space: nowrap; }
    .table tbody td { padding-top: 16px; padding-bottom: 16px; color: var(--ink-mid); border-color: var(--border); vertical-align: middle; }
    .table tbody tr:hover { background: var(--sage-pale); }

    .badge-soft { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; letter-spacing: 0.04em; white-space: nowrap; }
    .badge-soft::before { content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .badge-jabatan { background: var(--sage-pale); color: var(--sage-deep); border: 1px solid rgba(124, 185, 154, 0.22); }
    .badge-jabatan::before { background: var(--sage); }
    .badge-umkm { background: var(--gold-pale); color: #8B6914; border: 1px solid rgba(201, 168, 76, 0.22); }
    .badge-umkm::before { background: var(--gold); }

    .action-group { display: inline-flex; justify-content: flex-end; gap: 8px; flex-wrap: wrap; }
    .btn-action { display: inline-flex; align-items: center; justify-content: center; padding: 7px 12px; border-radius: 10px; font-size: 12px; font-weight: 700; text-decoration: none; border: 1px solid transparent; transition: all 0.2s; line-height: 1; }
    .btn-edit { background: var(--sage-pale); color: var(--sage-deep); border-color: rgba(124, 185, 154, 0.24); }
    .btn-edit:hover { background: #dff0e8; color: var(--sage-deep); }
    .btn-delete { background: var(--gold-pale); color: #8B6914; border-color: rgba(201, 168, 76, 0.24); }
    .btn-delete:hover { background: #f7e8b7; color: #8B6914; }

    .pagination-bar { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 18px 28px 0; flex-wrap: wrap; }
    .pagination-info { font-size: 12.5px; color: var(--muted); }
    .pagination-info strong { color: var(--ink-soft); font-weight: 600; }

    /* Pagination styling */
    .pagination-bar nav { display: flex; }
    .pagination-bar .pagination {
        display: inline-flex; gap: 4px; list-style: none; margin: 0; padding: 0;
        background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 4px;
    }
    .pagination-bar .pagination li { display: inline-flex; }
    .pagination-bar .pagination .page-link,
    .pagination-bar .pagination span,
    .pagination-bar .pagination a {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 36px; height: 36px; padding: 0 12px;
        border-radius: 8px; border: none !important;
        font-size: 13px; font-weight: 600; color: var(--ink-mid);
        text-decoration: none; background: transparent;
        transition: all 0.18s;
    }
    .pagination-bar .pagination a:hover { background: var(--sage-pale); color: var(--sage-deep); }
    .pagination-bar .pagination .active span,
    .pagination-bar .pagination .active .page-link { background: var(--sage); color: #fff; box-shadow: 0 2px 8px rgba(124,185,154,0.32); }
    .pagination-bar .pagination .disabled span { color: var(--muted); opacity: 0.5; cursor: not-allowed; background: transparent; }
    .pagination-bar .pagination svg { width: 16px; height: 16px; }

    .empty-state { text-align: center; padding: 58px 20px; }
    .empty-icon { font-size: 38px; margin-bottom: 14px; opacity: 0.55; }
    .empty-title { font-size: 15px; font-weight: 700; color: var(--ink-mid); margin-bottom: 6px; }
    .empty-sub { font-size: 13px; color: var(--muted); }

    @media (max-width: 900px) {
        .sidebar { width: 220px; }
        .main { margin-left: 220px; padding: 24px 22px; }
    }
    @media (max-width: 680px) {
        .sidebar { display: none; }
        .main { margin-left: 0; padding: 20px 16px; }
        .topbar { flex-direction: column; gap: 12px; }
        .page-title { font-size: 24px; }
        .page-card-head { padding: 18px 18px 14px; }
        .page-card-body { padding: 18px; }
        .pagination-bar { padding: 16px 18px 0; }
    }
</style>

<div class="layout">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo-wrap"><img src="{{ asset('images/logo.png') }}" alt="Logo"></div>
            <div>
                <div class="sidebar-brand-name">UMKM Panel</div>
                <div class="sidebar-brand-role">Administrator</div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item"><span class="nav-icon">⌂</span>Dashboard</a>
            <div class="nav-section-label">Manajemen</div>
            <a href="{{ route('members.index') }}" class="nav-item active"><span class="nav-icon">☰</span>Anggota UMKM</a>
            <a href="{{ route('keuangans.index') }}" class="nav-item"><span class="nav-icon">◈</span>Keuangan</a>
            <a href="{{ route('products.index') }}" class="nav-item"><span class="nav-icon">◫</span>Produk UMKM</a>
            <a href="{{ route('orders.index') }}" class="nav-item"><span class="nav-icon">◷</span>Transaksi</a>
        </nav>
        <div class="sidebar-footer">
            <a href="{{ route('admin.profile') }}" class="profile-link"><span style="font-size:15px;">◐</span>Profil Admin</a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="logout-btn"><span style="font-size:15px;">↩</span>Keluar</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <div class="page-eyebrow">Manajemen Anggota</div>
                <h1 class="page-title">Anggota UMKM</h1>
            </div>
            <div class="topbar-actions">
                <a href="{{ route('members.create') }}" class="btn-add">+ Tambah Anggota</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-soft alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="page-card">
            <div class="page-card-head">
                <div>
                    <div class="page-card-title">Daftar Anggota</div>
                    <div class="page-card-subtitle">Kelola data anggota/karyawan untuk setiap UMKM.</div>
                </div>
            </div>

            <div class="page-card-body">
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Karyawan</th>
                                    <th>UMKM</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Jabatan</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($members as $member)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $member->nama_karyawan }}</div>
                                        </td>
                                        <td>
                                            <span class="badge-soft badge-umkm">{{ $member->umkm->nama_umkm ?? '-' }}</span>
                                        </td>
                                        <td>{{ $member->alamat_karyawan ?: '-' }}</td>
                                        <td>{{ $member->telepon_karyawan ?: '-' }}</td>
                                        <td>
                                            <span class="badge-soft badge-jabatan">{{ $member->jabatan }}</span>
                                        </td>
                                        <td class="text-end">
                                            <div class="action-group">
                                                <a href="{{ route('members.edit', $member) }}" class="btn-action btn-edit">Edit</a>
                                                <form action="{{ route('members.destroy', $member) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-action btn-delete" onclick="return confirm('Hapus anggota ini?')">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <div class="empty-icon">👥</div>
                                                <div class="empty-title">Belum ada anggota</div>
                                                <div class="empty-sub">Klik tombol Tambah Anggota untuk mendaftarkan karyawan UMKM.</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="pagination-bar">
                    <div class="pagination-info">
                        Menampilkan <strong>{{ $members->firstItem() ?? 0 }}–{{ $members->lastItem() ?? 0 }}</strong>
                        dari <strong>{{ $members->total() }}</strong> data
                    </div>
                    <div>
                        {{ $members->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
