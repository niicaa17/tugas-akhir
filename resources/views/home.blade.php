@extends('layouts.app')

@section('content')
@verbatim
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300;1,9..40,400&family=Playfair+Display:wght@500;600;700&display=swap');

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
        --shadow-md: 0 4px 20px rgba(28, 43, 36, 0.09);
        --shadow-lg: 0 12px 40px rgba(28, 43, 36, 0.12);
        --radius: 14px;
        --radius-sm: 8px;
        --radius-lg: 20px;
    }

    *, *::before, *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'DM Sans', -apple-system, sans-serif;
        background: var(--cream);
        color: var(--ink);
        -webkit-font-smoothing: antialiased;
    }

    /* ─── LAYOUT ─── */
    .layout {
        display: flex;
        min-height: 100vh;
    }

    /* ─── SIDEBAR ─── */
    .sidebar {
        width: 260px;
        background: var(--ink);
        position: fixed;
        top: 0; left: 0;
        height: 100vh;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        padding: 0;
        z-index: 100;
    }

    .sidebar-brand {
        padding: 28px 24px 24px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sidebar-logo-wrap {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        overflow: hidden;
        background: var(--sage-pale);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .sidebar-logo-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sidebar-brand-text {
        display: flex;
        flex-direction: column;
    }

    .sidebar-brand-name {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        letter-spacing: 0.01em;
        line-height: 1.2;
    }

    .sidebar-brand-role {
        font-size: 10.5px;
        font-weight: 500;
        color: var(--sage-light);
        letter-spacing: 0.12em;
        text-transform: uppercase;
        margin-top: 2px;
    }

    .sidebar-nav {
        padding: 20px 14px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .nav-section-label {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--muted);
        padding: 16px 10px 8px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        color: rgba(255,255,255,0.55);
        font-size: 13.5px;
        font-weight: 400;
        transition: all 0.2s ease;
        position: relative;
    }

    .nav-item:hover {
        background: rgba(124, 185, 154, 0.12);
        color: var(--sage-light);
    }

    .nav-item.active {
        background: rgba(124, 185, 154, 0.18);
        color: var(--sage-light);
        font-weight: 500;
    }

    .nav-item.active::before {
        content: '';
        position: absolute;
        left: 0; top: 6px; bottom: 6px;
        width: 3px;
        background: var(--sage);
        border-radius: 0 2px 2px 0;
    }

    .nav-icon {
        width: 18px;
        height: 18px;
        opacity: 0.7;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .sidebar-footer {
        padding: 16px 14px 24px;
        border-top: 1px solid rgba(255,255,255,0.06);
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .profile-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: var(--radius-sm);
        background: rgba(124, 185, 154, 0.12);
        color: var(--sage-light);
        font-size: 13.5px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .profile-link:hover, .profile-link.active {
        background: rgba(124, 185, 154, 0.22);
        color: var(--sage-light);
    }

    .logout-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 10px 12px;
        border-radius: var(--radius-sm);
        border: none;
        background: rgba(201, 168, 76, 0.1);
        color: var(--gold-light);
        font-size: 13.5px;
        font-family: 'DM Sans', sans-serif;
        font-weight: 400;
        cursor: pointer;
        transition: all 0.2s;
        text-align: left;
    }

    .logout-btn:hover {
        background: rgba(201, 168, 76, 0.2);
    }

    /* ─── MAIN ─── */
    .main {
        margin-left: 260px;
        flex: 1;
        padding: 36px 40px 48px;
        min-height: 100vh;
        background:
            radial-gradient(ellipse 80% 55% at 100% -10%, rgba(124, 185, 154, 0.14), transparent 55%),
            radial-gradient(ellipse 60% 40% at 0% 100%, rgba(201, 168, 76, 0.08), transparent 50%),
            linear-gradient(180deg, #f3efe8 0%, var(--cream) 28%, #eef5f0 100%);
    }

    /* ─── TOPBAR / HERO ─── */
    .dash-hero {
        position: relative;
        border-radius: var(--radius-lg);
        padding: 28px 32px 30px;
        margin-bottom: 28px;
        background: linear-gradient(125deg, var(--surface) 0%, rgba(232, 244, 238, 0.85) 55%, #fff 100%);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .dash-hero::before {
        content: '';
        position: absolute;
        top: -40%;
        right: -8%;
        width: min(420px, 55vw);
        height: 180%;
        background: radial-gradient(circle at center, rgba(124, 185, 154, 0.18) 0%, transparent 68%);
        pointer-events: none;
    }

    .dash-hero-inner {
        position: relative;
        z-index: 1;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
    }

    .dash-hero-text {
        max-width: 520px;
    }

    .page-eyebrow {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--sage-deep);
        margin-bottom: 8px;
    }

    .page-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(26px, 4vw, 34px);
        font-weight: 600;
        color: var(--ink);
        line-height: 1.15;
        letter-spacing: -0.02em;
    }

    .page-sub {
        margin-top: 10px;
        font-size: 14px;
        color: var(--ink-soft);
        line-height: 1.5;
        font-weight: 400;
    }

    .dash-date-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.75);
        border: 1px solid var(--border);
        font-size: 13px;
        font-weight: 500;
        color: var(--ink-soft);
        box-shadow: var(--shadow-sm);
        white-space: nowrap;
    }

    .dash-date-pill span {
        font-size: 16px;
        line-height: 1;
    }

    /* ─── INSIGHT TILES ─── */
    .insight-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 28px;
    }

    .insight-tile {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 18px 20px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        box-shadow: var(--shadow-sm);
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
        color: inherit;
    }

    a.insight-tile:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: rgba(124, 185, 154, 0.35);
    }

    .insight-tile-label {
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--muted);
    }

    .insight-tile-value {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 26px;
        font-weight: 600;
        color: var(--ink);
        line-height: 1;
    }

    .insight-tile-icon {
        font-size: 18px;
        margin-bottom: 4px;
        opacity: 0.85;
    }

    /* ─── STAT CARDS ─── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: linear-gradient(180deg, #fff 0%, rgba(255, 255, 255, 0.92) 100%);
        border-radius: var(--radius-lg);
        padding: 26px 28px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        position: relative;
        overflow: hidden;
        transition: box-shadow 0.2s, transform 0.2s;
    }

    .stat-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-3px);
    }

    .stat-card::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 3px;
    }

    .stat-card.pemasukan::after { background: linear-gradient(90deg, var(--sage), var(--sage-light)); }
    .stat-card.pengeluaran::after { background: linear-gradient(90deg, var(--gold), var(--gold-light)); }
    .stat-card.profit::after { background: linear-gradient(90deg, var(--sage-deep), var(--sage)); }

    .stat-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        margin-bottom: 16px;
    }

    .stat-card.pemasukan .stat-icon { background: var(--sage-pale); }
    .stat-card.pengeluaran .stat-icon { background: var(--gold-pale); }
    .stat-card.profit .stat-icon { background: #EAF0FF; }

    .stat-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 8px;
    }

    .stat-value {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 24px;
        font-weight: 600;
        color: var(--ink);
        line-height: 1;
        letter-spacing: -0.01em;
    }

    .stat-sub {
        font-size: 12px;
        color: var(--muted);
        margin-top: 8px;
        font-weight: 400;
    }

    /* ─── TABLE CARD ─── */
    .table-card {
        background: var(--surface);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .section-heading {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 18px;
        font-weight: 600;
        color: var(--ink);
        margin: 0 0 14px 2px;
        letter-spacing: -0.01em;
    }

    .insight-grid + .section-heading {
        margin-top: 6px;
    }

    .stats-grid + .section-heading {
        margin-top: 32px;
    }

    .table-toolbar {
        padding: 22px 28px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .table-toolbar-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .table-card-title {
        font-size: 15px;
        font-weight: 600;
        color: var(--ink);
        letter-spacing: -0.01em;
    }

    .record-count {
        font-size: 11.5px;
        font-weight: 500;
        color: var(--muted);
        background: var(--cream);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 3px 10px;
    }

    .search-wrap {
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        color: var(--muted);
        pointer-events: none;
    }

    .search-input {
        padding: 9px 14px 9px 36px;
        border: 1px solid var(--border-strong);
        border-radius: var(--radius-sm);
        font-size: 13px;
        font-family: 'DM Sans', sans-serif;
        width: 220px;
        background: var(--cream);
        color: var(--ink);
        transition: all 0.2s;
        outline: none;
    }

    .search-input::placeholder {
        color: var(--muted);
    }

    .search-input:focus {
        border-color: var(--sage);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(124, 185, 154, 0.12);
    }

    /* ─── TABLE ─── */
    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead tr {
        background: var(--cream);
        border-bottom: 1px solid var(--border-strong);
    }

    th {
        padding: 13px 20px;
        text-align: left;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--muted);
        white-space: nowrap;
    }

    td {
        padding: 15px 20px;
        font-size: 13.5px;
        color: var(--ink-soft);
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }

    tbody tr {
        transition: background 0.15s;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    tbody tr:hover {
        background: var(--sage-pale);
    }

    /* ─── BADGES ─── */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.04em;
        white-space: nowrap;
    }

    .badge::before {
        content: '';
        width: 5px;
        height: 5px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .badge-pemasukan {
        background: var(--sage-pale);
        color: var(--sage-deep);
        border: 1px solid rgba(124, 185, 154, 0.3);
    }

    .badge-pemasukan::before {
        background: var(--sage);
    }

    .badge-pengeluaran {
        background: var(--gold-pale);
        color: #8B6914;
        border: 1px solid rgba(201, 168, 76, 0.3);
    }

    .badge-pengeluaran::before {
        background: var(--gold);
    }

    /* ─── KATEGORI PILL ─── */
    .kategori-pill {
        display: inline-block;
        padding: 3px 9px;
        background: var(--cream-dark);
        color: var(--ink-soft);
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }

    /* ─── NOMINAL ─── */
    .nominal {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 14px;
        font-weight: 600;
        color: var(--ink);
        letter-spacing: -0.01em;
    }

    /* ─── DATE DISPLAY ─── */
    .date-cell {
        font-size: 13px;
        color: var(--ink-soft);
        font-variant-numeric: tabular-nums;
    }

    /* ─── KETERANGAN ─── */
    .keterangan-cell {
        max-width: 220px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: var(--muted);
        font-size: 13px;
    }

    /* ─── EMPTY STATE ─── */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        font-size: 38px;
        margin-bottom: 14px;
        opacity: 0.4;
    }

    .empty-title {
        font-size: 15px;
        font-weight: 600;
        color: var(--ink-soft);
        margin-bottom: 6px;
    }

    .empty-sub {
        font-size: 13px;
        color: var(--muted);
    }

    /* ─── PAGINATION ─── */
    .pagination-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        border-top: 1px solid var(--border);
        flex-wrap: wrap;
        gap: 12px;
    }

    .pagination-info {
        font-size: 12.5px;
        color: var(--muted);
        font-weight: 400;
    }

    .pagination-info strong {
        color: var(--ink-soft);
        font-weight: 600;
    }

    .pagination {
        display: flex;
        gap: 4px;
        align-items: center;
    }

    .pagination a,
    .pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border-radius: 7px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        color: var(--ink-soft);
        border: 1px solid var(--border);
        background: transparent;
        transition: all 0.15s;
    }

    .pagination a:hover {
        background: var(--sage-pale);
        border-color: var(--sage);
        color: var(--sage-deep);
    }

    .pagination span.active,
    .pagination .active span {
        background: var(--sage);
        border-color: var(--sage);
        color: #fff;
    }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 900px) {
        .sidebar {
            width: 220px;
        }
        .main {
            margin-left: 220px;
            padding: 24px 22px 40px;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .insight-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 680px) {
        .sidebar { display: none; }
        .main { margin-left: 0; padding: 20px 16px 36px; }
        .table-toolbar { flex-direction: column; align-items: flex-start; }
        .dash-hero { padding: 22px 20px; }
        .dash-hero-inner { flex-direction: column; align-items: flex-start; }
        .insight-grid { grid-template-columns: 1fr; }
    }
</style>
@endverbatim

<div class="layout">

    {{-- ═══ SIDEBAR ═══ --}}
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo-wrap">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </div>
            <div class="sidebar-brand-text">
                <span class="sidebar-brand-name">UMKM Panel</span>
                <span class="sidebar-brand-role">Administrator</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon">⌂</span>
                Dashboard
            </a>

            <div class="nav-section-label">Manajemen</div>

            <a href="{{ route('members.index') }}" class="nav-item {{ request()->routeIs('members.*') ? 'active' : '' }}">
                <span class="nav-icon">☰</span>
                Anggota UMKM
            </a>
            <a href="{{ route('keuangans.index') }}" class="nav-item {{ request()->routeIs('keuangans.*') ? 'active' : '' }}">
                <span class="nav-icon">◈</span>
                Keuangan
            </a>
            <a href="{{ route('products.index') }}" class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <span class="nav-icon">◫</span>
                Produk UMKM
            </a>
            <a href="{{ route('orders.index') }}" class="nav-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                <span class="nav-icon">◷</span>
                Transaksi
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('admin.profile') }}" class="profile-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                <span style="font-size:15px;">◐</span>
                Profil Admin
            </a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="logout-btn">
                    <span style="font-size:15px;">↩</span>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ═══ MAIN CONTENT ═══ --}}
    <main class="main">

        <div class="dash-hero">
            <div class="dash-hero-inner">
                <div class="dash-hero-text">
                    <div class="page-eyebrow">Ringkasan</div>
                    <h1 class="page-title">Dashboard</h1>
                    <p class="page-sub">Pantau arus kas, aktivitas toko, dan catatan keuangan Anggota UMKM dalam satu layar.</p>
                </div>
                <div class="dash-date-pill" title="Tanggal hari ini">
                    <span>📅</span>
                    {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </div>
            </div>
        </div>

        <p class="section-heading">Aktivitas singkat</p>
        <div class="insight-grid">
            <a href="{{ route('members.index') }}" class="insight-tile">
                <span class="insight-tile-icon">☰</span>
                <span class="insight-tile-label">Anggota UMKM</span>
                <span class="insight-tile-value">{{ number_format($totalAnggota, 0, ',', '.') }}</span>
            </a>
            <a href="{{ route('products.index') }}" class="insight-tile">
                <span class="insight-tile-icon">◫</span>
                <span class="insight-tile-label">Produk</span>
                <span class="insight-tile-value">{{ number_format($totalProduk, 0, ',', '.') }}</span>
            </a>
            <a href="{{ route('orders.index') }}" class="insight-tile">
                <span class="insight-tile-icon">◷</span>
                <span class="insight-tile-label">Pesanan</span>
                <span class="insight-tile-value">{{ number_format($totalOrder, 0, ',', '.') }}</span>
            </a>
            <a href="{{ route('keuangans.index') }}" class="insight-tile">
                <span class="insight-tile-icon">◈</span>
                <span class="insight-tile-label">Entri keuangan</span>
                <span class="insight-tile-value">{{ number_format($totalKeuangan, 0, ',', '.') }}</span>
            </a>
        </div>

        <p class="section-heading">Arus kas</p>
        <div class="stats-grid">
            <div class="stat-card pemasukan">
                <div class="stat-icon">↑</div>
                <div class="stat-label">Total Pemasukan</div>
                <div class="stat-value">Rp {{ number_format($pemasukan, 0, ',', '.') }}</div>
                <div class="stat-sub">Seluruh pemasukan tercatat</div>
            </div>
            <div class="stat-card pengeluaran">
                <div class="stat-icon">↓</div>
                <div class="stat-label">Total Pengeluaran</div>
                <div class="stat-value">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</div>
                <div class="stat-sub">Seluruh pengeluaran tercatat</div>
            </div>
            <div class="stat-card profit">
                <div class="stat-icon">≈</div>
                <div class="stat-label">Laba / Rugi</div>
                <div class="stat-value">Rp {{ number_format($saldoKeuangan, 0, ',', '.') }}</div>
                <div class="stat-sub">Saldo bersih saat ini</div>
            </div>
        </div>

        <p class="section-heading">Mutasi terkini</p>
        <div class="table-card">
            <div class="table-toolbar">
                <div class="table-toolbar-left">
                    <span class="table-card-title">Data Keuangan</span>
                    <span class="record-count">{{ $keuangans->total() }} entri</span>
                </div>
                <div class="search-wrap">
                    <span class="search-icon">🔍</span>
                    <input type="text" class="search-input" placeholder="Cari transaksi..." id="searchInput">
                </div>
            </div>

            <div class="table-wrap">
                <table id="keuanganTable">
                    <thead>
                        <tr>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th style="text-align:right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($keuangans as $item)
                        <tr>
                            <td>
                                @if($item->jenis === 'pemasukan')
                                    <span class="badge badge-pemasukan">Pemasukan</span>
                                @else
                                    <span class="badge badge-pengeluaran">Pengeluaran</span>
                                @endif
                            </td>
                            <td>
                                <span class="date-cell">{{ $item->tanggal->format('d M Y') }}</span>
                            </td>
                            <td>
                                <span class="kategori-pill">
                                    @if($item->jenis === 'pemasukan') Jasa @else Bahan Baku @endif
                                </span>
                            </td>
                            <td>
                                <span class="keterangan-cell" title="{{ $item->keterangan }}">{{ $item->keterangan }}</span>
                            </td>
                            <td style="text-align:right">
                                <span class="nominal">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-icon">📋</div>
                                    <div class="empty-title">Belum ada data</div>
                                    <div class="empty-sub">Transaksi keuangan akan muncul di sini.</div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-bar">
                <div class="pagination-info">
                    @if ($keuangans->total() > 0)
                        Menampilkan <strong>{{ $keuangans->firstItem() }}–{{ $keuangans->lastItem() }}</strong>
                        dari <strong>{{ $keuangans->total() }}</strong> data
                    @else
                        Belum ada data untuk ditampilkan
                    @endif
                </div>
                <div class="pagination">
                    {{ $keuangans->links() }}
                </div>
            </div>
        </div>

    </main>
</div>

<script>
    // Client-side search filter
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const q = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#keuanganTable tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = (!q || text.includes(q)) ? '' : 'none';
            });
        });
    }
</script>
@endsection