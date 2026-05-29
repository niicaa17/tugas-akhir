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
        --ink: #1C2B24;
        --ink-mid: #2E4A3A;
        --muted: #8A9E93;
        --surface: #FFFFFF;
        --border: rgba(124, 185, 154, 0.18);
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
    .btn-back, .btn-edit { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 18px; border-radius: var(--radius-sm); text-decoration: none; font-size: 13px; font-weight: 600; border: none; }
    .btn-back { background: #fff; color: var(--ink); border: 1px solid var(--border); }
    .btn-edit { background: var(--gold); color: #fff; }

    .detail-card { background: var(--surface); border-radius: var(--radius-lg); border: 1px solid var(--border); overflow: hidden; }
    .detail-card-head { padding: 22px 28px; border-bottom: 1px solid var(--border); }
    .detail-card-body { padding: 24px 28px 28px; }
    .detail-grid { display: grid; grid-template-columns: 260px minmax(0, 1fr); gap: 24px; align-items: start; }
    .product-figure {
        background: linear-gradient(180deg, rgba(232, 244, 238, 0.75), rgba(255, 255, 255, 0.95));
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 14px;
        box-shadow: 0 8px 20px rgba(28, 43, 36, 0.05);
    }
    .product-preview { width: 100%; aspect-ratio: 1 / 1; object-fit: cover; border-radius: 14px; border: 0; display: block; }
    .product-placeholder { width: 100%; aspect-ratio: 1 / 1; border-radius: 14px; border: 1px dashed var(--border); background: var(--sage-pale); display: flex; align-items: center; justify-content: center; color: var(--muted); }
    .detail-meta { display: grid; gap: 10px; }
    .meta-row { display: grid; grid-template-columns: 160px 1fr; gap: 12px; padding: 10px 0; border-bottom: 1px dashed var(--border); }
    .meta-key { color: var(--muted); font-weight: 600; }
    .meta-val { color: var(--ink-mid); font-weight: 500; }
    .description-card {
        margin-top: 22px;
        padding: 18px;
        border-radius: 18px;
        background: linear-gradient(180deg, #fffdf7 0%, #f8f4e6 100%);
        border: 1px solid var(--border);
    }
    .description-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 8px;
    }
    .description-text {
        color: var(--ink-mid);
        line-height: 1.75;
        font-size: 14px;
        white-space: pre-line;
    }

    @media (max-width: 900px) { .sidebar { width: 220px; } .main { margin-left: 220px; padding: 24px 22px; } }
    @media (max-width: 680px) { .sidebar { display: none; } .main { margin-left: 0; padding: 20px 16px; } .topbar { flex-direction: column; } .page-title { font-size: 24px; } .detail-grid { grid-template-columns: 1fr; } .meta-row { grid-template-columns: 1fr; gap: 4px; } }
</style>

<div class="layout">
    <aside class="sidebar">
        <div class="sidebar-brand"><div class="sidebar-logo-wrap"><img src="{{ asset('images/logo.png') }}" alt="Logo"></div><div><div class="sidebar-brand-name">UMKM Panel</div><div class="sidebar-brand-role">Administrator</div></div></div>
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
            <div><div class="page-eyebrow">Produk UMKM</div><h1 class="page-title">Detail Produk</h1></div>
            <div style="display:flex;gap:10px;">
                <a href="{{ route('products.index') }}" class="btn-back">Kembali</a>
                <a href="{{ route('products.edit', $product) }}" class="btn-edit">Edit Produk</a>
            </div>
        </div>

        <div class="detail-card">
            <div class="detail-card-head">
                <div style="font-size:15px;font-weight:700;color:var(--ink);">Informasi Produk</div>
                <div style="font-size:12.5px;color:var(--muted);margin-top:4px;">Ringkasan detail lengkap produk UMKM.</div>
            </div>
            <div class="detail-card-body">
                <div class="detail-grid">
                    <div class="product-figure">
                        @if ($product->gambar)
                            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="product-preview">
                        @else
                            <div class="product-placeholder">No Image</div>
                        @endif
                    </div>
                    <div class="detail-meta">
                        <div class="meta-row"><div class="meta-key">Nama Produk</div><div class="meta-val">{{ $product->nama_produk }}</div></div>
                        <div class="meta-row"><div class="meta-key">Anggota UMKM</div><div class="meta-val">{{ $product->umkm->nama_umkm ?? '-' }}</div></div>
                        <div class="meta-row"><div class="meta-key">Harga</div><div class="meta-val">Rp {{ number_format($product->harga, 0, ',', '.') }}</div></div>
                        <div class="meta-row"><div class="meta-key">Stok</div><div class="meta-val">{{ $product->stok }}</div></div>
                    </div>
                </div>

                <div class="description-card">
                    <div class="description-label">Deskripsi Produk</div>
                    <div class="description-text">{{ $product->deskripsi ?? '-' }}</div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
