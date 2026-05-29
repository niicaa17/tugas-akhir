@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap');

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
        --border-strong: rgba(124, 185, 154, 0.35);
        --radius: 14px;
        --radius-sm: 8px;
        --radius-lg: 20px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', -apple-system, sans-serif; background: var(--cream); color: var(--ink); }
    .layout { display: flex; min-height: 100vh; }
    .sidebar { width: 260px; background: var(--ink); position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto; display: flex; flex-direction: column; z-index: 100; }
    .sidebar-brand { padding: 28px 24px 24px; border-bottom: 1px solid rgba(255,255,255,0.06); display: flex; align-items: center; gap: 12px; }
    .sidebar-logo-wrap { width: 42px; height: 42px; border-radius: 10px; overflow: hidden; background: var(--sage-pale); display: flex; align-items: center; justify-content: center; }
    .sidebar-logo-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .sidebar-brand-name { font-family: 'Playfair Display', Georgia, serif; font-size: 15px; font-weight: 600; color: #fff; line-height: 1.2; }
    .sidebar-brand-role { font-size: 10.5px; font-weight: 500; color: var(--sage-light); letter-spacing: 0.12em; text-transform: uppercase; margin-top: 2px; }
    .sidebar-nav { padding: 20px 14px; flex: 1; display: flex; flex-direction: column; gap: 2px; }
    .nav-section-label { font-size: 10px; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; color: var(--muted); padding: 16px 10px 8px; }
    .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: var(--radius-sm); text-decoration: none; color: rgba(255,255,255,0.58); font-size: 13.5px; transition: all 0.2s ease; position: relative; }
    .nav-item:hover, .nav-item.active { background: rgba(124,185,154,0.18); color: var(--sage-light); }
    .nav-item.active::before { content: ''; position: absolute; left: 0; top: 6px; bottom: 6px; width: 3px; background: var(--sage); border-radius: 0 2px 2px 0; }
    .nav-icon { width: 18px; text-align: center; font-size: 15px; }
    .sidebar-footer { padding: 16px 14px 24px; border-top: 1px solid rgba(255,255,255,0.06); display: flex; flex-direction: column; gap: 6px; }
    .profile-link { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px; background: rgba(124, 185, 154, 0.12); color: #A8D4BC; font-size: 13.5px; text-decoration: none; transition: all 0.2s; }
    .profile-link:hover { background: rgba(124, 185, 154, 0.22); color: #A8D4BC; }
    .logout-btn { display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 12px; border-radius: var(--radius-sm); border: none; background: rgba(201,168,76,0.1); color: var(--gold-light); font-size: 13.5px; cursor: pointer; }

    .main { margin-left: 260px; flex: 1; padding: 36px 40px; min-height: 100vh; }
    .topbar { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; gap: 12px; }
    .page-eyebrow { font-size: 11px; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; color: var(--sage-deep); margin-bottom: 6px; }
    .page-title { font-family: 'Playfair Display', Georgia, serif; font-size: 30px; font-weight: 600; color: var(--ink); }
    .btn-primary-soft { display: inline-flex; align-items: center; gap: 7px; padding: 10px 16px; border-radius: var(--radius-sm); border: none; text-decoration: none; font-size: 13px; font-weight: 600; color: #fff; background: var(--gold); box-shadow: 0 2px 10px rgba(201,168,76,0.3); }
    .btn-primary-soft:hover { background: #b8953e; color: #fff; }

    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 22px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 18px 20px; }
    .stat-label { font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); margin-bottom: 8px; font-weight: 700; }
    .stat-value { font-family: 'Playfair Display', Georgia, serif; font-size: 24px; color: var(--ink); }
    .stat-card.one { border-bottom: 3px solid var(--sage); }
    .stat-card.two { border-bottom: 3px solid var(--gold); }
    .stat-card.three { border-bottom: 3px solid var(--sage-deep); }

    .table-card { background: var(--surface); border-radius: var(--radius-lg); border: 1px solid var(--border); overflow: hidden; }
    .table-toolbar { padding: 20px 24px; border-bottom: 1px solid var(--border); }
    .table-title { font-size: 15px; font-weight: 700; color: var(--ink); }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: var(--cream); border-bottom: 1px solid var(--border-strong); }
    th { padding: 13px 18px; text-align: left; font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted); }
    td { padding: 14px 18px; border-bottom: 1px solid var(--border); font-size: 13.5px; color: var(--ink-soft); vertical-align: middle; }
    tbody tr:hover { background: var(--sage-pale); }
    .thumb { width: 56px; height: 56px; border-radius: 12px; border: 1px solid var(--border); object-fit: cover; }
    .thumb-empty { width: 56px; height: 56px; border-radius: 12px; border: 1px solid var(--border); display: inline-flex; align-items: center; justify-content: center; color: var(--muted); }
    .stock-badge { background: var(--sage-pale); color: var(--sage-deep); border: 1px solid rgba(124,185,154,0.3); border-radius: 999px; padding: 4px 10px; font-size: 11px; font-weight: 700; }
    .actions { display: inline-flex; gap: 8px; justify-content: flex-end; }
    .btn-action { padding: 6px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none; border: 1px solid transparent; }
    .btn-edit { background: var(--sage-pale); color: var(--sage-deep); border-color: rgba(124,185,154,0.24); }
    .btn-delete { background: var(--gold-pale); color: #8B6914; border-color: rgba(201,168,76,0.24); }
    .text-right { text-align: right; }
    .pagination-wrap { padding: 16px 24px; display: flex; justify-content: flex-end; }

    @media (max-width: 900px) { .sidebar { width: 220px; } .main { margin-left: 220px; padding: 24px 22px; } .stats-grid { grid-template-columns: 1fr; } }
    @media (max-width: 680px) { .sidebar { display: none; } .main { margin-left: 0; padding: 20px 16px; } .topbar { flex-direction: column; } .page-title { font-size: 24px; } }
</style>

@php
    $totalProduk = $products->total();
    $totalStok = $products->sum('stok');
    $avgHarga = $products->count() ? (int) round($products->avg('harga')) : 0;
@endphp

<div class="layout">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo-wrap"><img src="{{ asset('images/logo.png') }}" alt="Logo"></div>
            <div><div class="sidebar-brand-name">UMKM Panel</div><div class="sidebar-brand-role">Administrator</div></div>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item"><span class="nav-icon">⌂</span>Dashboard</a>
            <div class="nav-section-label">Manajemen</div>
            <a href="{{ route('members.index') }}" class="nav-item"><span class="nav-icon">☰</span>Anggota UMKM</a>
            <a href="{{ route('keuangans.index') }}" class="nav-item"><span class="nav-icon">◈</span>Keuangan</a>
            <a href="{{ route('products.index') }}" class="nav-item active"><span class="nav-icon">◫</span>Produk UMKM</a>
            <a href="{{ route('orders.index') }}" class="nav-item"><span class="nav-icon">◷</span>Transaksi</a>
        </nav>
        <div class="sidebar-footer">
            <a href="{{ route('admin.profile') }}" class="profile-link"><span style="font-size:15px;">◐</span>Profil Admin</a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">@csrf<button type="submit" class="logout-btn"><span style="font-size:15px;">↩</span>Keluar</button></form>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <div class="page-eyebrow">Produk UMKM</div>
                <h1 class="page-title">Kelola Produk</h1>
            </div>
            <a href="{{ route('products.create') }}" class="btn-primary-soft">+ Tambah Barang</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card one"><div class="stat-label">Total Produk</div><div class="stat-value">{{ $totalProduk }}</div></div>
            <div class="stat-card two"><div class="stat-label">Total Stok (Halaman Ini)</div><div class="stat-value">{{ $totalStok }}</div></div>
            <div class="stat-card three"><div class="stat-label">Rata-Rata Harga</div><div class="stat-value">Rp {{ number_format($avgHarga, 0, ',', '.') }}</div></div>
        </div>

        <div class="table-card">
            <div class="table-toolbar"><div class="table-title">Daftar Produk</div></div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama Produk</th>
                            <th>UMKM</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Kode Barang</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>
                                    @if ($product->gambar)
                                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="thumb">
                                    @else
                                        <span class="thumb-empty">-</span>
                                    @endif
                                </td>
                                <td>{{ $product->nama_produk }}</td>
                                <td>{{ $product->umkm->nama_umkm ?? '-' }}</td>
                                <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td><span class="stock-badge">{{ $product->stok }}</span></td>
                                <td>{{ sprintf('WJK%04d', $product->id) }}</td>
                                <td class="text-right">
                                    <div class="actions">
                                        <a href="{{ route('products.show', $product) }}" class="btn-action btn-edit">Detail</a>
                                        <a href="{{ route('products.edit', $product) }}" class="btn-action btn-edit">Edit</a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrap">{{ $products->links() }}</div>
        </div>
    </main>
</div>
@endsection
