@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300;1,9..40,400&family=Playfair+Display:wght@500;600;700&display=swap');

    /* Hide default Bootstrap navbar/padding from layout */
    body > #app > nav.navbar { display: none !important; }
    body > #app > main.py-4 { padding: 0 !important; }

    :root {
        --sage: #7CB99A;
        --sage-light: #A8D4BC;
        --sage-pale: #E8F4EE;
        --sage-deep: #4A8A6A;
        --cream: #F7F4EE;
        --cream-dark: #EDE8DF;
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
        --shadow-sm: 0 1px 4px rgba(28, 43, 36, 0.06);
        --shadow-md: 0 6px 24px rgba(28, 43, 36, 0.10);
        --shadow-lg: 0 14px 48px rgba(28, 43, 36, 0.14);
        --radius-sm: 8px;
        --radius: 14px;
        --radius-lg: 22px;
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
    .profile-link { display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 12px; border-radius: var(--radius-sm); background: rgba(124, 185, 154, 0.18); color: var(--sage-light); font-size: 13.5px; text-decoration: none; transition: all 0.2s; font-weight: 500; }
    .profile-link.active { background: rgba(124, 185, 154, 0.28); }
    .profile-link:hover { background: rgba(124, 185, 154, 0.32); color: var(--sage-light); }
    .logout-btn { display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 12px; border-radius: var(--radius-sm); border: none; background: rgba(201, 168, 76, 0.1); color: var(--gold-light); font-size: 13.5px; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: all 0.2s; text-align: left; }
    .logout-btn:hover { background: rgba(201, 168, 76, 0.2); }

    .main { margin-left: 260px; flex: 1; padding: 36px 40px 48px; min-height: 100vh; }

    /* Hero card */
    .profile-hero {
        position: relative;
        border-radius: var(--radius-lg);
        background:
            radial-gradient(circle at 100% 0%, rgba(232,201,122,0.22), transparent 55%),
            radial-gradient(circle at 0% 100%, rgba(124,185,154,0.30), transparent 60%),
            linear-gradient(135deg, #1C2B24 0%, #2E4A3A 100%);
        color: #fff;
        padding: 32px 36px;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        margin-bottom: 26px;
    }
    .profile-hero::before {
        content: '';
        position: absolute; right: -40px; top: -40px;
        width: 220px; height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(232,201,122,0.18), transparent 70%);
        pointer-events: none;
    }
    .hero-eyebrow { display: inline-flex; align-items: center; gap: 8px; font-size: 11px; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--gold-light); padding: 6px 14px; border: 1px solid rgba(232,201,122,0.35); border-radius: 999px; }
    .hero-row { display: flex; gap: 24px; align-items: center; margin-top: 20px; flex-wrap: wrap; }
    .hero-avatar {
        width: 92px; height: 92px; border-radius: 50%;
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        color: var(--ink); display: flex; align-items: center; justify-content: center;
        font-family: 'Playfair Display', serif; font-size: 38px; font-weight: 700;
        flex-shrink: 0;
        box-shadow: 0 8px 28px rgba(0,0,0,0.32);
        border: 3px solid rgba(255,255,255,0.12);
    }
    .hero-name { font-family: 'Playfair Display', Georgia, serif; font-size: 30px; font-weight: 600; line-height: 1.15; color: #fff; }
    .hero-role { display: inline-block; margin-top: 6px; padding: 3px 10px; border-radius: 999px; background: rgba(255,255,255,0.12); color: var(--gold-light); font-size: 10.5px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; }
    .hero-meta-list { margin-top: 14px; display: flex; flex-direction: column; gap: 6px; }
    .hero-meta-item { display: inline-flex; align-items: center; gap: 8px; font-size: 13.5px; color: rgba(255,255,255,0.78); }
    .hero-meta-icon { opacity: 0.7; }

    .hero-spacer { flex: 1; }

    .hero-actions { display: flex; gap: 10px; flex-wrap: wrap; }

    /* Stat grid */
    .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 26px; }
    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px 22px;
        position: relative;
        overflow: hidden;
        transition: all 0.25s;
    }
    .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); border-color: var(--border-strong); }
    .stat-card::after {
        content: '';
        position: absolute; left: 0; bottom: 0; right: 0;
        height: 3px; background: var(--accent, var(--sage));
    }
    .stat-card.stat-sage { --accent: linear-gradient(90deg, #7CB99A, #A8D4BC); }
    .stat-card.stat-gold { --accent: linear-gradient(90deg, #C9A84C, #E8C97A); }
    .stat-card.stat-rose { --accent: linear-gradient(90deg, #d1546a, #e88a9c); }
    .stat-card.stat-blue { --accent: linear-gradient(90deg, #5a8aa6, #8fb4c9); }
    .stat-card::after { background: var(--accent); }

    .stat-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; margin-bottom: 12px; }
    .stat-card.stat-sage .stat-icon { background: var(--sage-pale); color: var(--sage-deep); }
    .stat-card.stat-gold .stat-icon { background: var(--gold-pale); color: #8B6914; }
    .stat-card.stat-rose .stat-icon { background: rgba(209,84,106,0.12); color: #b8364c; }
    .stat-card.stat-blue .stat-icon { background: rgba(90,138,166,0.14); color: #355063; }

    .stat-label { font-size: 11.5px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); }
    .stat-value { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 600; color: var(--ink); margin-top: 4px; line-height: 1.1; }
    .stat-sub { font-size: 12px; color: var(--muted); margin-top: 4px; }

    /* Forms grid */
    .grid-2 { display: grid; grid-template-columns: 1.05fr 1fr; gap: 22px; }
    @media (max-width: 1100px) { .grid-2 { grid-template-columns: 1fr; } }

    .form-card {
        background: var(--surface);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        transition: all 0.2s;
    }
    .form-card:hover { box-shadow: var(--shadow-md); }

    .form-card-head { padding: 22px 28px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 14px; background: linear-gradient(180deg, rgba(232,244,238,0.55), transparent); }
    .form-card-icon { width: 44px; height: 44px; border-radius: 12px; background: var(--sage-pale); color: var(--sage-deep); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; box-shadow: 0 2px 10px rgba(124,185,154,0.18); }
    .form-card-icon.gold { background: var(--gold-pale); color: #8B6914; box-shadow: 0 2px 10px rgba(201,168,76,0.18); }
    .form-card-title { font-size: 16px; font-weight: 700; color: var(--ink); }
    .form-card-sub { margin-top: 2px; font-size: 12.5px; color: var(--muted); }
    .form-card-body { padding: 24px 28px 26px; }

    .form-group { margin-bottom: 18px; }
    .form-group:last-child { margin-bottom: 0; }
    .form-label { display: block; font-weight: 700; color: var(--ink-mid); margin-bottom: 8px; font-size: 13px; }
    .form-control {
        padding: 12px 14px; border-radius: 12px;
        border: 1px solid var(--border-strong);
        background: #fff; color: var(--ink);
        width: 100%; font-family: 'DM Sans', sans-serif; font-size: 14px;
        transition: all 0.2s;
    }
    .form-control:focus { outline: none; border-color: var(--sage); box-shadow: 0 0 0 4px rgba(124,185,154,0.20); background: #fff; }
    .form-control.is-invalid { border-color: #d1546a; background: #fdf3f5; }
    .invalid-feedback { color: #d1546a; font-size: 12px; margin-top: 6px; font-weight: 500; }
    .form-hint { color: var(--muted); font-size: 12px; margin-top: 6px; }
    textarea.form-control { resize: vertical; min-height: 96px; }

    .input-with-icon { position: relative; }
    .input-with-icon .form-control { padding-left: 44px; }
    .input-with-icon .input-icon {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        color: var(--muted); font-size: 16px; pointer-events: none;
    }

    .form-section-title {
        font-size: 11px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase;
        color: var(--sage-deep);
        margin: 22px 0 14px;
        padding-top: 18px;
        border-top: 1px dashed var(--border);
        display: flex; align-items: center; gap: 8px;
    }
    .form-section-title::before { content: '✦'; color: var(--gold); font-size: 13px; }

    /* Sticky action bar */
    .actions-bar {
        position: sticky;
        bottom: 16px;
        margin-top: 22px;
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(10px);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 14px 20px;
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
        box-shadow: var(--shadow-md);
        z-index: 5;
        flex-wrap: wrap;
    }
    .actions-info { font-size: 13px; color: var(--ink-soft); display: flex; align-items: center; gap: 8px; }
    .actions-info-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--sage); box-shadow: 0 0 0 4px rgba(124,185,154,0.22); }
    .actions-buttons { display: flex; gap: 10px; flex-wrap: wrap; }

    .btn-save, .btn-back, .btn-ghost {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 11px 22px; border-radius: var(--radius-sm);
        text-decoration: none; font-size: 13px; font-weight: 700;
        transition: all 0.2s; border: none; cursor: pointer;
        font-family: 'DM Sans', sans-serif; letter-spacing: 0.01em;
    }
    .btn-back, .btn-ghost { background: #fff; color: var(--ink); border: 1px solid var(--border-strong); }
    .btn-back:hover, .btn-ghost:hover { background: var(--sage-pale); color: var(--ink); }
    .btn-save { background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--ink); box-shadow: 0 6px 20px rgba(201,168,76,0.35); }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 10px 28px rgba(201,168,76,0.45); color: var(--ink); }
    .btn-save .btn-icon { font-size: 15px; }

    .alert-success {
        background: linear-gradient(135deg, rgba(124,185,154,0.16), rgba(168,212,188,0.06));
        border: 1px solid var(--border-strong);
        color: var(--sage-deep);
        border-radius: var(--radius);
        padding: 14px 18px;
        font-size: 13px; font-weight: 500;
        margin-bottom: 22px;
        display: flex; align-items: center; gap: 10px;
    }
    .alert-success::before { content: '✓'; width: 24px; height: 24px; border-radius: 50%; background: var(--sage); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0; }

    /* topbar */
    .topbar { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 28px; flex-wrap: wrap; }
    .page-eyebrow { font-size: 11px; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--sage-deep); margin-bottom: 6px; }
    .page-title { font-family: 'Playfair Display', Georgia, serif; font-size: 32px; font-weight: 600; color: var(--ink); line-height: 1.15; }
    .page-sub { font-size: 14px; color: var(--muted); margin-top: 8px; max-width: 620px; line-height: 1.6; }

    /* Responsive */
    @media (max-width: 1100px) {
        .stat-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 900px) {
        .sidebar { width: 220px; }
        .main { margin-left: 220px; padding: 24px 22px; }
        .profile-hero { padding: 26px 24px; }
        .hero-name { font-size: 26px; }
    }
    @media (max-width: 680px) {
        .sidebar { display: none; }
        .main { margin-left: 0; padding: 20px 16px; }
        .stat-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
        .topbar { flex-direction: column; }
        .page-title { font-size: 26px; }
        .hero-row { flex-direction: column; align-items: flex-start; }
        .form-card-head, .form-card-body { padding: 18px; }
        .actions-bar { flex-direction: column; align-items: stretch; }
        .actions-buttons { justify-content: stretch; }
        .actions-buttons .btn-save, .actions-buttons .btn-back { flex: 1; }
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
            <a href="{{ route('members.index') }}" class="nav-item"><span class="nav-icon">☰</span>Anggota UMKM</a>
            <a href="{{ route('keuangans.index') }}" class="nav-item"><span class="nav-icon">◈</span>Keuangan</a>
            <a href="{{ route('products.index') }}" class="nav-item"><span class="nav-icon">◫</span>Produk UMKM</a>
            <a href="{{ route('orders.index') }}" class="nav-item"><span class="nav-icon">◷</span>Transaksi</a>
        </nav>
        <div class="sidebar-footer">
            <a href="{{ route('admin.profile') }}" class="profile-link active">
                <span style="font-size:15px;">◐</span>Profil Admin
            </a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="logout-btn"><span style="font-size:15px;">↩</span>Keluar</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <div class="page-eyebrow">Pengaturan Akun</div>
                <h1 class="page-title">Profil Admin</h1>
                <p class="page-sub">Kelola identitas akun Anda dan profil UMKM yang ditampilkan ke pelanggan dalam satu halaman terpadu.</p>
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn-ghost">← Dashboard</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- Hero --}}
        <div class="profile-hero">
            <span class="hero-eyebrow">✦ Profil Aktif</span>
            <div class="hero-row">
                <div class="hero-avatar">{{ strtoupper(mb_substr($user->name ?? 'A', 0, 1)) }}</div>
                <div>
                    <div class="hero-name">{{ $user->name }}</div>
                    <span class="hero-role">Administrator</span>
                    <div class="hero-meta-list">
                        <div class="hero-meta-item"><span class="hero-meta-icon">✉</span> {{ $user->email }}</div>
                        @if ($umkm)
                            <div class="hero-meta-item"><span class="hero-meta-icon">◎</span> {{ $umkm->nama_umkm }}</div>
                            <div class="hero-meta-item"><span class="hero-meta-icon">📞</span> {{ $umkm->no_hp }}</div>
                        @else
                            <div class="hero-meta-item" style="color:var(--gold-light);"><span class="hero-meta-icon">⚠</span> Profil UMKM belum diisi</div>
                        @endif
                        <div class="hero-meta-item"><span class="hero-meta-icon">⏱</span> Bergabung {{ $accountAge }} lalu</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stat cards --}}
        <div class="stat-grid">
            <div class="stat-card stat-sage">
                <div class="stat-icon">◫</div>
                <div class="stat-label">Total Produk</div>
                <div class="stat-value">{{ number_format($stats['totalProduk'], 0, ',', '.') }}</div>
                <div class="stat-sub">Produk aktif di etalase</div>
            </div>
            <div class="stat-card stat-gold">
                <div class="stat-icon">☰</div>
                <div class="stat-label">Anggota UMKM</div>
                <div class="stat-value">{{ number_format($stats['totalAnggota'], 0, ',', '.') }}</div>
                <div class="stat-sub">Karyawan terdaftar</div>
            </div>
            <div class="stat-card stat-blue">
                <div class="stat-icon">◷</div>
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-value">{{ number_format($stats['totalOrder'], 0, ',', '.') }}</div>
                <div class="stat-sub">Sepanjang waktu</div>
            </div>
            <div class="stat-card stat-rose">
                <div class="stat-icon">◈</div>
                <div class="stat-label">Pemasukan</div>
                <div class="stat-value">Rp {{ number_format($stats['totalPemasukan'], 0, ',', '.') }}</div>
                <div class="stat-sub">Akumulasi penjualan</div>
            </div>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="grid-2">
                {{-- Akun --}}
                <div class="form-card">
                    <div class="form-card-head">
                        <div class="form-card-icon">◐</div>
                        <div>
                            <div class="form-card-title">Akun Admin</div>
                            <div class="form-card-sub">Identitas login dan kontak admin</div>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="form-group">
                            <label class="form-label" for="name">Nama Lengkap</label>
                            <div class="input-with-icon">
                                <span class="input-icon">👤</span>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            </div>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <div class="input-with-icon">
                                <span class="input-icon">✉</span>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            </div>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-section-title">Ubah Password (opsional)</div>

                        <div class="form-group">
                            <label class="form-label" for="password">Password Baru</label>
                            <div class="input-with-icon">
                                <span class="input-icon">🔒</span>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak diubah" autocomplete="new-password">
                            </div>
                            <div class="form-hint">Minimal 8 karakter. Gunakan kombinasi huruf, angka, dan simbol.</div>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
                            <div class="input-with-icon">
                                <span class="input-icon">🔑</span>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" autocomplete="new-password">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- UMKM --}}
                <div class="form-card">
                    <div class="form-card-head">
                        <div class="form-card-icon gold">◎</div>
                        <div>
                            <div class="form-card-title">Profil UMKM</div>
                            <div class="form-card-sub">Identitas usaha untuk pelanggan & laporan</div>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="form-group">
                            <label class="form-label" for="nama_umkm">Nama UMKM</label>
                            <div class="input-with-icon">
                                <span class="input-icon">🏪</span>
                                <input type="text" id="nama_umkm" name="nama_umkm" class="form-control @error('nama_umkm') is-invalid @enderror" value="{{ old('nama_umkm', $umkm->nama_umkm ?? '') }}" required>
                            </div>
                            @error('nama_umkm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="no_hp">No HP / WhatsApp</label>
                            <div class="input-with-icon">
                                <span class="input-icon">📞</span>
                                <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $umkm->no_hp ?? '') }}" required>
                            </div>
                            @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="alamat">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat lengkap usaha" required>{{ old('alamat', $umkm->alamat ?? '') }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="deskripsi">Deskripsi Usaha</label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Cerita singkat tentang UMKM Anda — produk unggulan, latar belakang, nilai usaha, dll.">{{ old('deskripsi', $umkm->deskripsi ?? '') }}</textarea>
                            <div class="form-hint">Deskripsi ini akan tampil di halaman pelanggan.</div>
                            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="actions-bar">
                <div class="actions-info">
                    <span class="actions-info-dot"></span>
                    Perubahan otomatis disimpan ke akun Anda dan profil UMKM
                </div>
                <div class="actions-buttons">
                    <a href="{{ route('admin.dashboard') }}" class="btn-back">Batal</a>
                    <button type="submit" class="btn-save"><span class="btn-icon">✓</span> Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </main>
</div>
@endsection
