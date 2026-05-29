@extends('layouts.app')

@section('content')
@if(auth()->check() && auth()->user()->isAdmin())
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap');

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
        --radius: 14px;
        --radius-sm: 8px;
        --radius-lg: 20px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', -apple-system, sans-serif; background: var(--cream); color: var(--ink); -webkit-font-smoothing: antialiased; }
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
    .logout-btn { display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 12px; border-radius: var(--radius-sm); border: none; background: rgba(201,168,76,0.1); color: var(--gold-light); font-size: 13.5px; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: all 0.2s; }
    .logout-btn:hover { background: rgba(201,168,76,0.2); }

    .main { margin-left: 260px; flex: 1; padding: 36px 40px; min-height: 100vh; }
    .topbar { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 28px; gap: 12px; padding-bottom: 20px; border-bottom: 1px solid var(--border); }
    .page-eyebrow { font-size: 11px; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; color: var(--sage-deep); margin-bottom: 6px; }
    .page-title { font-family: 'Playfair Display', Georgia, serif; font-size: 30px; font-weight: 600; color: var(--ink); margin: 0; }
    .page-subtitle { font-size: 13.5px; color: var(--muted); margin-top: 6px; }
    .btn-back { display: inline-flex; align-items: center; gap: 7px; padding: 10px 18px; border-radius: var(--radius-sm); border: 1px solid var(--border-strong); background: var(--surface); color: var(--ink-soft); text-decoration: none; font-size: 13px; font-weight: 500; transition: all 0.2s; }
    .btn-back:hover { background: var(--sage-pale); border-color: var(--sage); color: var(--sage-deep); }

    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 22px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px 22px; position: relative; overflow: hidden; transition: box-shadow 0.2s, transform 0.2s; }
    .stat-card:hover { box-shadow: 0 4px 20px rgba(28,43,36,0.09); transform: translateY(-2px); }
    .stat-card::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; }
    .stat-card.one::after { background: linear-gradient(90deg, var(--sage), var(--sage-light)); }
    .stat-card.two::after { background: linear-gradient(90deg, var(--gold), var(--gold-light)); }
    .stat-card.three::after { background: linear-gradient(90deg, #5B9BD5, #8FC4F5); }
    .stat-card.four::after { background: linear-gradient(90deg, var(--sage-deep), var(--sage)); }
    .stat-label { font-size: 10.5px; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); margin-bottom: 10px; font-weight: 700; }
    .stat-value { font-family: 'Playfair Display', Georgia, serif; font-size: 26px; color: var(--ink); }

    .filter-tabs { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px; }
    .filter-tab { text-decoration: none; border-radius: 20px; padding: 8px 16px; background: var(--surface); color: var(--ink-soft); font-size: 12.5px; font-weight: 500; border: 1px solid var(--border-strong); transition: all 0.18s; }
    .filter-tab:hover { background: var(--sage-pale); border-color: var(--sage); color: var(--sage-deep); }
    .filter-tab.active { background: var(--sage); border-color: var(--sage); color: #fff; font-weight: 600; }

    .table-card { background: var(--surface); border-radius: var(--radius-lg); border: 1px solid var(--border); overflow: hidden; }
    .table-toolbar { padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; gap: 10px; flex-wrap: wrap; }
    .table-toolbar-left { display: flex; align-items: center; gap: 12px; }
    .table-title { font-size: 15px; font-weight: 700; color: var(--ink); }
    .record-pill { font-size: 11.5px; font-weight: 500; color: var(--muted); background: var(--cream); border: 1px solid var(--border); border-radius: 20px; padding: 3px 10px; }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: var(--cream); border-bottom: 1px solid var(--border-strong); }
    th { padding: 13px 18px; text-align: left; font-size: 10.5px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); white-space: nowrap; }
    td { padding: 14px 18px; border-bottom: 1px solid var(--border); font-size: 13.5px; color: var(--ink-soft); vertical-align: middle; }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr { transition: background 0.15s; }
    tbody tr:hover { background: var(--sage-pale); }

    .order-id { font-family: 'Playfair Display', serif; font-size: 14px; font-weight: 600; color: var(--ink); }
    .amount { font-weight: 600; color: var(--ink); }
    .method-pill { display: inline-block; padding: 3px 8px; background: var(--cream-dark); color: var(--ink-soft); border-radius: 4px; font-size: 11px; font-weight: 600; letter-spacing: 0.04em; }

    .badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; white-space: nowrap; }
    .badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .badge-pending, .badge-dibayar, .badge-diproses { background: var(--gold-pale); color: #8B6914; border: 1px solid rgba(201,168,76,0.3); }
    .badge-pending::before, .badge-dibayar::before, .badge-diproses::before { background: var(--gold); }
    .badge-dikirim { background: #EAF0FF; color: #3660B8; border: 1px solid rgba(54,96,184,0.2); }
    .badge-dikirim::before { background: #5B9BD5; }
    .badge-selesai { background: var(--sage-pale); color: var(--sage-deep); border: 1px solid rgba(124,185,154,0.3); }
    .badge-selesai::before { background: var(--sage); }
    .badge-dibatalkan { background: #FEF2F2; color: #9B2C2C; border: 1px solid rgba(155,44,44,0.2); }
    .badge-dibatalkan::before { background: #E05252; }

    .btn-action { display: inline-flex; align-items: center; gap: 5px; padding: 7px 14px; border-radius: var(--radius-sm); font-size: 12.5px; font-weight: 500; text-decoration: none; background: var(--cream); border: 1px solid var(--border-strong); color: var(--ink-soft); transition: all 0.15s; }
    .btn-action:hover { background: var(--sage-pale); border-color: var(--sage); color: var(--sage-deep); }
    .action-cell { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; }
    .btn-delete { display: inline-flex; align-items: center; gap: 4px; padding: 7px 12px; border-radius: var(--radius-sm); font-size: 12.5px; font-weight: 600; font-family: inherit; cursor: pointer; background: #FEF2F2; border: 1px solid rgba(155,44,44,0.25); color: #9B2C2C; transition: all 0.15s; }
    .btn-delete:hover { background: #fde8e8; border-color: #c53030; color: #822727; }

    .alert-ok { background: var(--sage-pale); border: 1px solid rgba(124,185,154,0.4); border-radius: var(--radius-sm); padding: 12px 16px; color: var(--sage-deep); font-size: 13.5px; font-weight: 500; margin: 16px 24px 0; display: flex; align-items: center; gap: 8px; }
    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-icon { font-size: 36px; margin-bottom: 14px; opacity: 0.4; }
    .empty-title { font-size: 15px; font-weight: 600; color: var(--ink-soft); margin-bottom: 6px; }
    .empty-sub { font-size: 13px; color: var(--muted); }
    .pagination-wrap { padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border); flex-wrap: wrap; gap: 10px; }
    .pagination-info { font-size: 12.5px; color: var(--muted); }
    .pagination-info strong { color: var(--ink-soft); font-weight: 600; }

    @media (max-width: 900px) { .sidebar { width: 220px; } .main { margin-left: 220px; padding: 24px 22px; } .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 680px) { .sidebar { display: none; } .main { margin-left: 0; padding: 20px 16px; } .stats-grid { grid-template-columns: 1fr; } .topbar { flex-direction: column; } }
</style>

@php
    $statusSummary = ['pending'=>0,'dibayar'=>0,'dikirim'=>0,'selesai'=>0,'dibatalkan'=>0];
    foreach ($orders as $item) {
        $statusSummary[$item->status] = ($statusSummary[$item->status] ?? 0) + 1;
    }
@endphp

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
            <a href="{{ route('orders.index') }}" class="nav-item active"><span class="nav-icon">◷</span>Transaksi</a>
        </nav>
        <div class="sidebar-footer">
            <a href="{{ route('admin.profile') }}" class="profile-link"><span style="font-size:15px">◐</span>Profil Admin</a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="logout-btn"><span style="font-size:15px">↩</span>Keluar</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <div class="page-eyebrow">Transaksi</div>
                <h1 class="page-title">Manajemen Transaksi</h1>
                <p class="page-subtitle">Monitor seluruh pesanan, metode pembayaran, dan progres pemesanan.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">← Dashboard</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card one">
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-value">{{ $orders->total() }}</div>
            </div>
            <div class="stat-card two">
                <div class="stat-label">Menunggu Proses</div>
                <div class="stat-value">{{ $statusSummary['pending'] + $statusSummary['dibayar'] }}</div>
            </div>
            <div class="stat-card three">
                <div class="stat-label">Sedang Dikirim</div>
                <div class="stat-value">{{ $statusSummary['dikirim'] }}</div>
            </div>
            <div class="stat-card four">
                <div class="stat-label">Selesai</div>
                <div class="stat-value">{{ $statusSummary['selesai'] }}</div>
            </div>
        </div>

        <div class="filter-tabs">
            <a href="{{ route('orders.index') }}" class="filter-tab {{ $statusTab === 'semua' ? 'active' : '' }}">Semua</a>
            <a href="{{ route('orders.index', ['status' => 'diproses']) }}" class="filter-tab {{ $statusTab === 'diproses' ? 'active' : '' }}">Diproses</a>
            <a href="{{ route('orders.index', ['status' => 'dikirim']) }}" class="filter-tab {{ $statusTab === 'dikirim' ? 'active' : '' }}">Dikirim</a>
            <a href="{{ route('orders.index', ['status' => 'selesai']) }}" class="filter-tab {{ $statusTab === 'selesai' ? 'active' : '' }}">Selesai</a>
        </div>

        @if (session('success'))
            <div class="alert-ok" style="margin-bottom:16px">✓ {{ session('success') }}</div>
        @endif

        <div class="table-card">
            <div class="table-toolbar">
                <div class="table-toolbar-left">
                    <span class="table-title">Daftar Transaksi</span>
                    <span class="record-pill">{{ $orders->total() }} pesanan</span>
                </div>
            </div>

            @if ($orders->count())
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                @php
                                    $firstPayment = $order->payments->first();
                                    $rawMetode = strtolower($firstPayment->metode ?? 'cod');
                                    $methodLabelsShort = [
                                        'cod'      => 'COD',
                                        'va_dana'  => 'DANA',
                                        'va_ovo'   => 'OVO',
                                        'va_gopay' => 'GoPay',
                                    ];
                                    $paymentMethod = $methodLabelsShort[$rawMetode] ?? strtoupper($rawMetode);
                                @endphp
                                <tr>
                                    <td><span class="order-id">#{{ sprintf('%04d', $order->id) }}</span></td>
                                    <td>{{ $order->user?->name ?? 'Pelanggan' }}</td>
                                    <td><span class="amount">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span></td>
                                    <td><span class="method-pill">{{ $paymentMethod }}</span></td>
                                    <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                    <td style="color:var(--muted);font-size:13px">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <div class="action-cell">
                                            <a href="{{ route('orders.show', $order) }}" class="btn-action">Detail →</a>
                                            <form action="{{ route('orders.destroy', $order) }}" method="POST" style="margin:0;display:inline" onsubmit="return confirm('Hapus transaksi #{{ sprintf('%04d', $order->id) }}? Stok produk akan dikembalikan dan catatan keuangan penjualan ini dihapus.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">📋</div>
                    <div class="empty-title">Belum ada transaksi</div>
                    <div class="empty-sub">Pesanan akan muncul di sini setelah ada pembeli.</div>
                </div>
            @endif

            <div class="pagination-wrap">
                <div class="pagination-info">
                    @if($orders->count())
                        Menampilkan <strong>{{ $orders->firstItem() }}–{{ $orders->lastItem() }}</strong> dari <strong>{{ $orders->total() }}</strong>
                    @endif
                </div>
                {{ $orders->links() }}
            </div>
        </div>
    </main>
</div>

@else
{{-- ════════════ USER VIEW ════════════ --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap');

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
        --ink-soft: #4A6858;
        --muted: #8A9E93;
        --surface: #FFFFFF;
        --border: rgba(124,185,154,0.18);
        --border-strong: rgba(124,185,154,0.35);
        --radius: 14px;
        --radius-sm: 8px;
        --radius-lg: 20px;
        --shadow-sm: 0 1px 4px rgba(28,43,36,0.06);
        --shadow-md: 0 4px 20px rgba(28,43,36,0.09);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .uop-body {
        font-family: 'DM Sans', -apple-system, sans-serif;
        background: var(--cream);
        color: var(--ink);
        min-height: 100vh;
        -webkit-font-smoothing: antialiased;
    }

    .uop-wrap { max-width: 900px; margin: 0 auto; padding: 36px 24px 60px; }

    /* ─── Header ─── */
    .uop-header { margin-bottom: 28px; }
    .uop-eyebrow { font-size: 11px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: var(--sage-deep); margin-bottom: 6px; }
    .uop-title { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 600; color: var(--ink); }

    /* ─── Filter Tabs ─── */
    .uop-tabs { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 24px; }
    .uop-tab { text-decoration: none; border-radius: 20px; padding: 8px 16px; background: var(--surface); color: var(--ink-soft); font-size: 13px; font-weight: 500; border: 1px solid var(--border-strong); transition: all 0.18s; }
    .uop-tab:hover { background: var(--sage-pale); border-color: var(--sage); color: var(--sage-deep); }
    .uop-tab.active { background: var(--sage); border-color: var(--sage); color: #fff; font-weight: 600; }

    /* ─── Alert ─── */
    .uop-alert { background: var(--sage-pale); border: 1px solid rgba(124,185,154,0.4); border-radius: var(--radius-sm); padding: 12px 16px; color: var(--sage-deep); font-size: 13.5px; font-weight: 500; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }

    /* ─── Featured Order Card ─── */
    .uop-featured-label { font-size: 10.5px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: var(--muted); margin-bottom: 12px; }

    .uop-featured {
        background: var(--surface);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        display: grid;
        grid-template-columns: 96px 1fr auto;
        align-items: center;
        gap: 22px;
        padding: 22px 24px;
        margin-bottom: 28px;
        transition: box-shadow 0.2s;
    }
    .uop-featured:hover { box-shadow: var(--shadow-md); }

    .uop-thumb {
        width: 96px; height: 96px;
        border-radius: 12px;
        overflow: hidden;
        background: var(--cream-dark);
        flex-shrink: 0;
    }
    .uop-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .uop-thumb-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 12px; }

    .uop-product-name { font-family: 'Playfair Display', serif; font-size: 19px; font-weight: 600; color: var(--ink); margin-bottom: 5px; line-height: 1.25; }
    .uop-date { font-size: 12.5px; color: var(--muted); margin-bottom: 10px; }
    .uop-total { font-size: 15px; font-weight: 600; color: var(--ink); margin-top: 8px; }

    .uop-featured-cta { display: flex; flex-direction: column; align-items: flex-end; gap: 8px; flex-shrink: 0; }
    .uop-btn-primary { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; background: var(--ink); color: #fff; border-radius: var(--radius-sm); text-decoration: none; font-size: 13px; font-weight: 600; transition: all 0.2s; white-space: nowrap; }
    .uop-btn-primary:hover { background: #2E4A3A; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(28,43,36,0.2); }
    .uop-order-num { font-size: 11.5px; color: var(--muted); }

    /* ─── Empty ─── */
    .uop-empty { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 50px 20px; text-align: center; margin-bottom: 28px; }
    .uop-empty-icon { font-size: 34px; margin-bottom: 12px; opacity: 0.4; }
    .uop-empty-title { font-size: 15px; font-weight: 600; color: var(--ink-soft); margin-bottom: 6px; }
    .uop-empty-sub { font-size: 13px; color: var(--muted); }

    /* ─── History table ─── */
    .uop-history { background: var(--surface); border-radius: var(--radius-lg); border: 1px solid var(--border); overflow: hidden; box-shadow: var(--shadow-sm); margin-bottom: 28px; }
    .uop-history-header { padding: 18px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; }
    .uop-history-title { font-size: 15px; font-weight: 600; color: var(--ink); }
    .uop-count-pill { font-size: 11.5px; font-weight: 500; color: var(--muted); background: var(--cream); border: 1px solid var(--border); border-radius: 20px; padding: 3px 10px; }

    .uop-table-wrap { overflow-x: auto; }
    .uop-table { width: 100%; border-collapse: collapse; }
    .uop-table thead tr { background: var(--cream); border-bottom: 1px solid var(--border-strong); }
    .uop-table th { padding: 12px 18px; text-align: left; font-size: 10.5px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); white-space: nowrap; }
    .uop-table td { padding: 13px 18px; border-bottom: 1px solid var(--border); font-size: 13.5px; color: var(--ink-soft); vertical-align: middle; }
    .uop-table tbody tr:last-child td { border-bottom: none; }
    .uop-table tbody tr { transition: background 0.15s; }
    .uop-table tbody tr:hover { background: var(--sage-pale); }

    .uop-order-id { font-family: 'Playfair Display', serif; font-size: 13.5px; font-weight: 600; color: var(--ink); }
    .uop-amount { font-weight: 600; color: var(--ink); }
    .uop-prod-name { max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    /* Badges (shared) */
    .badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; white-space: nowrap; }
    .badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .badge-pending, .badge-dibayar, .badge-diproses { background: var(--gold-pale); color: #8B6914; border: 1px solid rgba(201,168,76,0.3); }
    .badge-pending::before, .badge-dibayar::before, .badge-diproses::before { background: var(--gold); }
    .badge-dikirim { background: #EAF0FF; color: #3660B8; border: 1px solid rgba(54,96,184,0.2); }
    .badge-dikirim::before { background: #5B9BD5; }
    .badge-selesai { background: var(--sage-pale); color: var(--sage-deep); border: 1px solid rgba(124,185,154,0.3); }
    .badge-selesai::before { background: var(--sage); }
    .badge-dibatalkan { background: #FEF2F2; color: #9B2C2C; border: 1px solid rgba(155,44,44,0.2); }
    .badge-dibatalkan::before { background: #E05252; }

    .uop-btn-detail { display: inline-flex; align-items: center; gap: 5px; padding: 7px 14px; background: var(--cream); border: 1px solid var(--border-strong); border-radius: var(--radius-sm); color: var(--ink-soft); text-decoration: none; font-size: 12.5px; font-weight: 500; transition: all 0.15s; white-space: nowrap; }
    .uop-btn-detail:hover { background: var(--sage-pale); border-color: var(--sage); color: var(--sage-deep); }

    .uop-pagination { padding: 14px 22px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; }

    /* ─── Recommended products ─── */
    .uop-section-label { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 600; color: var(--ink); margin-bottom: 14px; }

    .uop-products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; margin-bottom: 28px; }

    .uop-product-card .uop-product-name { font-family: 'DM Sans', -apple-system, sans-serif; font-size: 12.5px; font-weight: 600; color: var(--ink); line-height: 1.3; margin-bottom: 4px; }
    .uop-product-card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); overflow: hidden; text-decoration: none; color: inherit; display: flex; flex-direction: column; transition: all 0.2s; }
    .uop-product-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
    .uop-product-img { width: 100%; aspect-ratio: 1; object-fit: cover; display: block; background: var(--cream-dark); }
    .uop-product-body { padding: 10px 12px 14px; }
    .uop-product-price { font-size: 12px; color: var(--muted); margin-bottom: 8px; }
    .uop-product-cta { display: inline-flex; align-items: center; padding: 4px 10px; background: var(--sage-pale); color: var(--sage-deep); border-radius: 20px; font-size: 11px; font-weight: 600; }

    /* ─── Categories ─── */
    .uop-categories { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
    .uop-cat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 16px; display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 500; color: var(--ink-soft); transition: all 0.2s; }
    .uop-cat-card:hover { background: var(--sage-pale); border-color: var(--sage); color: var(--sage-deep); }
    .uop-cat-icon { font-size: 20px; flex-shrink: 0; }

    /* ─── Responsive ─── */
    @media (max-width: 680px) {
        .uop-wrap { padding: 24px 16px 40px; }
        .uop-featured { grid-template-columns: 76px 1fr; gap: 14px; }
        .uop-featured-cta { grid-column: 1 / -1; flex-direction: row; justify-content: space-between; align-items: center; }
        .uop-thumb { width: 76px; height: 76px; }
        .uop-categories { grid-template-columns: 1fr 1fr; }
        .uop-products-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 400px) {
        .uop-categories { grid-template-columns: 1fr; }
        .uop-tabs { gap: 4px; }
        .uop-tab { font-size: 12px; padding: 7px 12px; }
    }
</style>

@php
    $statusLabel = ['pending'=>'Diproses','dibayar'=>'Diproses','dikirim'=>'Dikirim','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'];
    $primaryOrder  = $orders->first();
    $primaryDetail  = $primaryOrder?->orderDetails->first();
    $primaryProduct = $primaryDetail?->product;
    $categoryIcons  = ['☕','🥤','📦','🌿','🍃','✨'];
@endphp

<div class="uop-body">
<div class="uop-wrap">

    {{-- Header --}}
    <div class="uop-header">
        <div class="uop-eyebrow">Akun Saya</div>
        <h1 class="uop-title">Pesanan Saya</h1>
    </div>

    {{-- Tabs --}}
    <div class="uop-tabs">
        <a href="{{ route('orders.index') }}" class="uop-tab {{ $statusTab === 'semua' ? 'active' : '' }}">Semua</a>
        <a href="{{ route('orders.index', ['status' => 'diproses']) }}" class="uop-tab {{ $statusTab === 'diproses' ? 'active' : '' }}">Diproses</a>
        <a href="{{ route('orders.index', ['status' => 'dikirim']) }}" class="uop-tab {{ $statusTab === 'dikirim' ? 'active' : '' }}">Dikirim</a>
        <a href="{{ route('orders.index', ['status' => 'selesai']) }}" class="uop-tab {{ $statusTab === 'selesai' ? 'active' : '' }}">Selesai</a>
    </div>

    @if (session('success'))
        <div class="uop-alert">✓ {{ session('success') }}</div>
    @endif

    {{-- Featured latest order --}}
    @if ($primaryOrder)
        <div class="uop-featured-label">Pesanan Terbaru</div>
        <div class="uop-featured">
            <div class="uop-thumb">
                @if ($primaryProduct?->gambar)
                    <img src="{{ asset('storage/' . $primaryProduct->gambar) }}" alt="{{ $primaryProduct->nama_produk }}">
                @else
                    <div class="uop-thumb-placeholder">No Image</div>
                @endif
            </div>
            <div>
                <div class="uop-product-name">
                    {{ $primaryProduct?->nama_produk ?? 'Pesanan #' . sprintf('%04d', $primaryOrder->id) }}
                </div>
                <div class="uop-date">{{ $primaryOrder->created_at->translatedFormat('d F Y') }}</div>
                <span class="badge badge-{{ $primaryOrder->status }}">
                    {{ $statusLabel[$primaryOrder->status] ?? ucfirst($primaryOrder->status) }}
                </span>
                <div class="uop-total">Rp {{ number_format($primaryOrder->total_harga, 0, ',', '.') }}</div>
            </div>
            <div class="uop-featured-cta">
                <a href="{{ route('orders.show', $primaryOrder) }}" class="uop-btn-primary">Lihat Detail →</a>
                <span class="uop-order-num">#{{ sprintf('%04d', $primaryOrder->id) }}</span>
            </div>
        </div>
    @else
        <div class="uop-empty">
            <div class="uop-empty-icon">📦</div>
            <div class="uop-empty-title">Belum ada pesanan</div>
            <div class="uop-empty-sub">Yuk mulai belanja produk UMKM kami!</div>
        </div>
    @endif

    {{-- History table (skip first/featured order) --}}
    @if ($orders->count() > 1)
    <div class="uop-history">
        <div class="uop-history-header">
            <span class="uop-history-title">Riwayat Pesanan</span>
            <span class="uop-count-pill">{{ $orders->total() }} pesanan</span>
        </div>
        <div class="uop-table-wrap">
            <table class="uop-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Produk</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders->skip(1) as $order)
                        @php
                            $det = $order->orderDetails->first();
                            $prod = $det?->product;
                        @endphp
                        <tr>
                            <td><span class="uop-order-id">#{{ sprintf('%04d', $order->id) }}</span></td>
                            <td><span class="uop-prod-name">{{ $prod?->nama_produk ?? '—' }}</span></td>
                            <td><span class="uop-amount">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span></td>
                            <td><span class="badge badge-{{ $order->status }}">{{ $statusLabel[$order->status] ?? ucfirst($order->status) }}</span></td>
                            <td style="color:var(--muted);font-size:13px">{{ $order->created_at->format('d M Y') }}</td>
                            <td><a href="{{ route('orders.show', $order) }}" class="uop-btn-detail">Detail →</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="uop-pagination">{{ $orders->links() }}</div>
    </div>
    @endif

    {{-- Recommended products --}}
    @if (isset($topProducts) && $topProducts->count())
    <div style="margin-bottom:28px">
        <div class="uop-section-label">Produk Pilihan</div>
        <div class="uop-products-grid">
            @foreach ($topProducts->take(4) as $product)
            <a href="{{ route('user.products.show', $product) }}" class="uop-product-card">
                @if ($product->gambar)
                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="uop-product-img">
                @else
                    <div class="uop-product-img" style="display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:12px">No Image</div>
                @endif
                <div class="uop-product-body">
                    <div class="uop-product-name">{{ $product->nama_produk }}</div>
                    <div class="uop-product-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                    <span class="uop-product-cta">Beli →</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
</div>

@endif
@endsection