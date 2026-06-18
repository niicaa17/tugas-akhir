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
        --gold: #C9A84C;
        --gold-light: #E8C97A;
        --gold-pale: #FDF6E3;
        --ink: #1C2B24;
        --ink-soft: #4A6858;
        --muted: #8A9E93;
        --surface: #FFFFFF;
        --border: rgba(124, 185, 154, 0.18);
        --radius: 14px;
        --radius-sm: 8px;
        --radius-lg: 20px;
    }

    *, *::before, *::after { box-sizing: border-box; }
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
    .page-title { font-family: 'Playfair Display', Georgia, serif; font-size: 30px; font-weight: 600; color: var(--ink); margin: 0; }
    .btn-back { display: inline-flex; align-items: center; gap: 7px; padding: 10px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); text-decoration: none; font-size: 13px; font-weight: 600; color: var(--ink); background: var(--surface); }

    .summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 20px; }
    .summary-card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); padding: 16px 18px; }
    .summary-label { font-size: 11px; font-weight: 700; letter-spacing: 0.08em; color: var(--muted); text-transform: uppercase; margin-bottom: 6px; }
    .summary-value { font-size: 21px; font-weight: 700; color: var(--ink); }
    .status-badge { display: inline-flex; align-items: center; border-radius: 999px; padding: 6px 12px; font-size: 12px; font-weight: 700; }
    .status-badge.pending, .status-badge.dibayar { background: var(--gold-pale); color: #7f6519; }
    .status-badge.dikirim { background: var(--sage-pale); color: #2d6a45; }
    .status-badge.selesai { background: #d6f2dd; color: #1f7a36; }
    .status-badge.dibatalkan { background: #f7dfe0; color: #9e3b3e; }

    .content-grid { display: grid; grid-template-columns: 1.7fr 1fr; gap: 18px; }
    .card { background: var(--surface); border-radius: var(--radius-lg); border: 1px solid var(--border); overflow: hidden; }
    .card-head { padding: 18px 20px; border-bottom: 1px solid var(--border); }
    .card-title { margin: 0; font-size: 16px; font-weight: 700; color: var(--ink); }
    .card-body { padding: 18px 20px; }

    .table-wrap { overflow-x: auto; }
    .detail-table { width: 100%; border-collapse: collapse; }
    .detail-table th, .detail-table td { padding: 12px 10px; border-bottom: 1px solid var(--border); }
    .detail-table th { font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted); text-align: left; }
    .detail-table .text-end { text-align: right; }
    .detail-table .text-center { text-align: center; }
    .meta-list { display: grid; gap: 12px; }
    .meta-item { border: 1px solid var(--border); border-radius: 12px; padding: 12px; }
    .meta-key { font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted); margin-bottom: 4px; }
    .meta-val { font-size: 14px; color: var(--ink-soft); font-weight: 600; }

    .form-label { display: block; font-size: 12px; font-weight: 700; margin-bottom: 7px; color: var(--ink-soft); }
    .form-select { width: 100%; border: 1px solid var(--border); border-radius: 10px; padding: 10px 12px; }
    .btn-save { margin-top: 12px; width: 100%; border: 0; border-radius: 10px; padding: 10px 14px; font-size: 13px; font-weight: 700; background: var(--gold); color: #fff; }
    .btn-delete-order { margin-top: 10px; width: 100%; border: 1px solid rgba(155,44,44,0.3); border-radius: 10px; padding: 10px 14px; font-size: 13px; font-weight: 700; background: #FEF2F2; color: #9B2C2C; cursor: pointer; font-family: inherit; transition: background 0.15s, border-color 0.15s; }
    .btn-delete-order:hover { background: #fde8e8; border-color: #c53030; color: #822727; }
    .total-line { margin-top: 14px; font-size: 22px; font-weight: 800; color: var(--ink); }

    @media (max-width: 980px) {
        .summary-grid { grid-template-columns: 1fr; }
        .content-grid { grid-template-columns: 1fr; }
        .order-hero { flex-direction: column; align-items: flex-start; }
    }
    @media (max-width: 680px) {
        .sidebar { display: none; }
        .main { margin-left: 0; padding: 20px 16px; }
        .topbar { flex-direction: column; }
        .page-title { font-size: 24px; }
        .order-hero h2 { font-size: 24px; }
        .order-panel { padding: 16px; border-radius: 22px; }
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
            <a href="{{ route('orders.index') }}" class="nav-item active"><span class="nav-icon">◷</span>Transaksi</a>
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
                <div class="page-eyebrow">Transaksi</div>
                <h1 class="page-title">Detail Pesanan #{{ sprintf('%04d', $order->id) }}</h1>
            </div>
            <a href="{{ route('orders.index') }}" class="btn-back">Kembali ke Daftar</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 rounded-4">{{ session('success') }}</div>
        @endif

        @php
            $firstPayment = $order->payments->first();
            $displayStatus = $order->status;
            $paymentStatusLabel = ucfirst($firstPayment->status ?? 'Menunggu');
            if ($firstPayment && strtolower((string) $firstPayment->metode) === 'cod' && ($firstPayment->status ?? 'pending') === 'pending') {
                $displayStatus = 'pending';
            }

            if ($order->status === 'selesai' && $firstPayment) {
                $paymentStatusLabel = 'Selesai';
            }
        @endphp

        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-label">Pelanggan</div>
                <div class="summary-value" style="font-size:18px;">{{ $order->user?->name ?? 'Pelanggan' }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">Tanggal Pesanan</div>
                <div class="summary-value" style="font-size:18px;">{{ $order->created_at->format('d M Y H:i') }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">Status Saat Ini</div>
                <span class="status-badge {{ $displayStatus }}">{{ ucfirst($displayStatus) }}</span>
            </div>
        </div>

        <div class="content-grid">
            <div class="card">
                <div class="card-head">
                    <h3 class="card-title">Rincian Produk</h3>
                </div>
                <div class="card-body">
                    <div class="table-wrap">
                        <table class="detail-table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderDetails as $detail)
                                    <tr>
                                        <td>{{ $detail->product->nama_produk ?? '-' }}</td>
                                        <td class="text-end">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $detail->qty }}</td>
                                        <td class="text-end">Rp {{ number_format($detail->harga * $detail->qty, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="total-line">Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <h3 class="card-title">Manajemen Status</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-4" style="margin-bottom:12px;">{{ $errors->first() }}</div>
                    @endif

                    @php
                        $statusHints = [
                            'pending'    => 'Pesanan baru. Tunggu pembayaran masuk (untuk transfer/VA) atau set ke "Dikirim" jika COD dan barang sudah dikirim.',
                            'dikirim'    => 'Barang sedang dalam pengiriman. Tunggu pelanggan konfirmasi penerimaan, atau set "Selesai" manual jika sudah dipastikan diterima.',
                            'selesai'    => 'Pesanan tuntas dan pembayaran tercatat selesai.',
                            'dibatalkan' => 'Pesanan dibatalkan. Stok produk perlu dikembalikan manual jika belum.',
                        ];
                        $hint = $statusHints[$order->status] ?? '';
                    @endphp

                    @if ($hint)
                        <div style="font-size:12.5px;line-height:1.55;color:var(--ink-soft);background:var(--gold-pale);border:1px solid rgba(201,168,76,0.35);border-radius:10px;padding:10px 12px;margin-bottom:14px;">
                            <strong style="color:var(--ink);">Catatan:</strong> {{ $hint }}
                        </div>
                    @endif

                    <form action="{{ route('orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <label class="form-label">Ubah Status Pesanan</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }} {{ in_array($order->status, ['dikirim','selesai'], true) ? '' : 'disabled' }}>Selesai{{ in_array($order->status, ['dikirim','selesai'], true) ? '' : ' (set "Dikirim" dulu)' }}</option>
                            <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        <button type="submit" class="btn-save">Simpan Perubahan</button>
                    </form>

                    <form action="{{ route('orders.destroy', $order) }}" method="POST" style="margin:0" onsubmit="return confirm('Hapus transaksi ini? Stok produk akan dikembalikan dan catatan keuangan terkait juga dihapus.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete-order">Hapus transaksi</button>
                    </form>

                    <div class="meta-list" style="margin-top:16px;">
                        <div class="meta-item">
                            <div class="meta-key">No. Pesanan</div>
                            <div class="meta-val">#{{ sprintf('%04d', $order->id) }}</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-key">Metode Pembayaran</div>
@php
    $methodLabels = [
        'cod'      => 'Bayar di Tempat (COD)',
        'va_dana'  => 'E-Wallet DANA',
        'va_ovo'   => 'E-Wallet OVO',
        'va_gopay' => 'E-Wallet GoPay',
        'bank_bni' => 'Transfer Bank BNI',
        'bank_bri' => 'Transfer Bank BRI',
        'bank_bca' => 'Transfer Bank BCA',
    ];
    $rawMetode = $firstPayment->metode ?? 'cod';
    $metodeLabel = $methodLabels[$rawMetode] ?? strtoupper($rawMetode);
@endphp
                            <div class="meta-val">{{ $metodeLabel }}</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-key">Status Pembayaran</div>
                            <div class="meta-val">{{ $paymentStatusLabel }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@else
{{-- ===================== USER VIEW ===================== --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Instrument+Serif:ital@0;1&display=swap');

    :root {
        --brand: #2D6A4F;
        --brand-mid: #40916C;
        --brand-light: #52B788;
        --brand-pale: #D8F3DC;
        --brand-pale2: #B7E4C7;
        --amber: #E76F00;
        --amber-pale: #FFF3E0;
        --red-soft: #FEE2E2;
        --red: #DC2626;
        --ink: #0D1F15;
        --ink-60: #3D5C4A;
        --ink-40: #6B8C79;
        --ink-20: #A8C4B4;
        --surface: #FFFFFF;
        --bg: #F2FAF5;
        --border: #D1EAD9;
        --border-strong: #A8D5B8;
        --radius: 16px;
        --radius-sm: 10px;
        --radius-lg: 24px;
        --shadow-sm: 0 2px 8px rgba(45,106,79,0.08);
        --shadow-md: 0 6px 24px rgba(45,106,79,0.12);
        --shadow-lg: 0 16px 48px rgba(45,106,79,0.16);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .user-order-detail-page .navbar { display: none !important; }
    .user-order-detail-page main.py-4 { padding: 0 !important; }

    .ecom-page {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--bg);
        min-height: 100vh;
        color: var(--ink);
    }

    /* ── TOPBAR ── */
    .ecom-topbar {
        background: var(--brand);
        padding: 0;
        position: sticky;
        top: 0;
        z-index: 50;
        box-shadow: 0 2px 12px rgba(0,0,0,0.15);
    }
    .ecom-topbar-inner {
        max-width: 1100px;
        margin: 0 auto;
        padding: 14px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .ecom-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: rgba(255,255,255,0.85);
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: color 0.2s;
    }
    .ecom-back-btn:hover { color: #fff; }
    .ecom-back-btn svg { width: 16px; height: 16px; }
    .ecom-topbar-title {
        font-size: 15px;
        font-weight: 700;
        color: #fff;
        letter-spacing: 0.01em;
    }
    .ecom-topbar-id {
        font-size: 13px;
        color: rgba(255,255,255,0.7);
        font-weight: 600;
    }

    /* ── BODY WRAPPER ── */
    .ecom-wrap {
        max-width: 1100px;
        margin: 0 auto;
        padding: 32px 24px 60px;
    }

    /* ── STATUS TRACKER ── */
    .status-tracker {
        background: var(--surface);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        padding: 28px 32px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-sm);
    }
    .tracker-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .tracker-order-info h2 {
        font-family: 'Instrument Serif', Georgia, serif;
        font-size: 26px;
        color: var(--ink);
        margin-bottom: 4px;
    }
    .tracker-order-info p {
        color: var(--ink-40);
        font-size: 13.5px;
    }
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.02em;
    }
    .status-pill.pending  { background: #FEF3C7; color: #92400E; }
    .status-pill.dibayar  { background: #DBEAFE; color: #1E40AF; }
    .status-pill.dikirim  { background: #E0F2FE; color: #0369A1; }
    .status-pill.selesai  { background: var(--brand-pale); color: var(--brand); }
    .status-pill.dibatalkan { background: var(--red-soft); color: var(--red); }
    .status-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: currentColor;
        animation: pulse-dot 2s infinite;
    }
    @keyframes pulse-dot {
        0%,100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    /* Step tracker */
    .steps-row {
        display: flex;
        align-items: flex-start;
        gap: 0;
        position: relative;
    }
    .step-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        text-align: center;
    }
    .step-item:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 18px;
        left: 50%;
        width: 100%;
        height: 2px;
        background: var(--border);
        z-index: 0;
    }
    .step-item.done:not(:last-child)::after { background: var(--brand-light); }
    .step-circle {
        width: 36px; height: 36px;
        border-radius: 50%;
        border: 2px solid var(--border);
        background: var(--surface);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        z-index: 1;
        position: relative;
        transition: all 0.3s;
        color: var(--ink-20);
    }
    .step-item.done .step-circle {
        background: var(--brand);
        border-color: var(--brand);
        color: #fff;
        box-shadow: 0 4px 12px rgba(45,106,79,0.3);
    }
    .step-item.active .step-circle {
        background: var(--brand-pale);
        border-color: var(--brand-light);
        color: var(--brand);
        box-shadow: 0 0 0 4px rgba(82,183,136,0.2);
    }
    .step-label {
        margin-top: 8px;
        font-size: 11px;
        font-weight: 700;
        color: var(--ink-40);
        letter-spacing: 0.03em;
        text-transform: uppercase;
    }
    .step-item.done .step-label,
    .step-item.active .step-label { color: var(--brand); }

    /* ── MAIN GRID ── */
    .ecom-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 20px;
        align-items: start;
    }

    /* ── CARD GENERIC ── */
    .ecard {
        background: var(--surface);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }
    .ecard-head {
        padding: 18px 22px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .ecard-head-icon {
        width: 34px; height: 34px;
        border-radius: 9px;
        background: var(--brand-pale);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .ecard-title {
        font-size: 15px;
        font-weight: 800;
        color: var(--ink);
    }
    .ecard-body { padding: 20px 22px; }

    /* ── PRODUCT TABLE ── */
    .prod-table { width: 100%; border-collapse: collapse; }
    .prod-table th {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--ink-40);
        padding: 0 10px 12px;
        border-bottom: 1px solid var(--border);
        text-align: left;
    }
    .prod-table th.tar { text-align: right; }
    .prod-table th.tac { text-align: center; }
    .prod-table td {
        padding: 14px 10px;
        border-bottom: 1px solid #EFF7F2;
        vertical-align: middle;
    }
    .prod-table tbody tr:last-child td { border-bottom: none; }
    .prod-table tbody tr:hover { background: #F7FDF9; }
    .prod-name { font-weight: 700; color: var(--ink); font-size: 14px; }
    .prod-price { color: var(--ink-60); font-size: 13.5px; }
    .prod-qty-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px; height: 30px;
        border-radius: 8px;
        background: var(--brand-pale);
        color: var(--brand);
        font-weight: 800;
        font-size: 13px;
    }
    .prod-subtotal { font-weight: 800; color: var(--ink); font-size: 14px; text-align: right; }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 10px 0;
        margin-top: 4px;
        border-top: 2px solid var(--border);
    }
    .total-row-label { font-size: 14px; font-weight: 700; color: var(--ink-60); }
    .total-row-value { font-size: 22px; font-weight: 800; color: var(--brand); }

    /* ── INFO ROWS (alamat, pembayaran) ── */
    .info-row {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 14px 0;
        border-bottom: 1px solid #EFF7F2;
    }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-row:first-child { padding-top: 0; }
    .info-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        background: var(--brand-pale);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .info-label {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--ink-40);
        margin-bottom: 4px;
    }
    .info-val {
        font-size: 14px;
        font-weight: 600;
        color: var(--ink);
        line-height: 1.55;
    }
    .info-sub {
        font-size: 12.5px;
        color: var(--ink-40);
        font-weight: 500;
        margin-top: 2px;
    }

    /* ── PAYMENT METHOD CHIPS ── */
    .pay-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 13px;
        border-radius: 9px;
        background: var(--brand-pale);
        color: var(--brand);
        font-weight: 800;
        font-size: 13px;
        border: 1.5px solid var(--brand-pale2);
    }

    /* ── SIDEBAR CARD ── */
    .summary-sidebar {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .price-breakdown {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .pb-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13.5px;
        color: var(--ink-60);
        font-weight: 500;
    }
    .pb-row.total {
        padding-top: 12px;
        border-top: 1.5px solid var(--border);
        font-size: 17px;
        font-weight: 800;
        color: var(--ink);
    }
    .pb-row.total span:last-child { color: var(--brand); font-size: 20px; }

    /* ── CTA BUTTON ── */
    .btn-cta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 15px 20px;
        border-radius: var(--radius);
        border: none;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        letter-spacing: 0.01em;
    }
    .btn-cta-primary {
        background: linear-gradient(135deg, var(--brand-mid) 0%, var(--brand) 100%);
        color: #fff;
        box-shadow: 0 6px 20px rgba(45,106,79,0.35);
    }
    .btn-cta-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(45,106,79,0.4);
        color: #fff;
    }
    .btn-cta-ghost {
        background: transparent;
        color: var(--ink-60);
        border: 1.5px solid var(--border-strong);
        font-size: 14px;
    }
    .btn-cta-ghost:hover {
        background: var(--bg);
        border-color: var(--brand-light);
        color: var(--brand);
    }

    /* ── ALERT NOTE ── */
    .order-note {
        background: var(--amber-pale);
        border: 1.5px solid #FFD08A;
        border-radius: var(--radius);
        padding: 14px 16px;
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }
    .order-note-icon { font-size: 18px; flex-shrink: 0; }
    .order-note-text { font-size: 13px; font-weight: 600; color: #7C4A00; line-height: 1.55; }

    /* ── RESPONSIVE ── */
    @media (max-width: 860px) {
        .ecom-grid { grid-template-columns: 1fr; }
        .summary-sidebar { order: -1; }
        .steps-row { gap: 0; }
        .step-label { font-size: 10px; }
    }
    @media (max-width: 560px) {
        .ecom-wrap { padding: 20px 16px 48px; }
        .status-tracker { padding: 20px 18px; }
        .ecard-body { padding: 16px 16px; }
        .tracker-header { flex-direction: column; align-items: flex-start; }
    }

    /* ── PETA PENGIRIMAN ── */
    .ship-map-wrap {
        margin-top: 16px;
        border: 1px solid rgba(74,138,106,0.18);
        border-radius: 14px;
        overflow: hidden;
        background: #fff;
    }
    .ship-map-head {
        display: flex; align-items: center; gap: 8px;
        padding: 11px 14px;
        font-size: 12.5px; font-weight: 700; color: #2f5a44;
        background: linear-gradient(180deg, #eef7f1, #fff);
        border-bottom: 1px solid rgba(74,138,106,0.14);
    }
    .ship-map-dot {
        width: 9px; height: 9px; border-radius: 50%;
        background: #34c759;
        box-shadow: 0 0 0 4px rgba(52,199,89,0.2);
        flex-shrink: 0;
    }
    .ship-map-status {
        margin-left: auto;
        font-size: 11px; font-weight: 600; color: #6b8c7c;
    }
    .ship-map {
        width: 100%; height: 280px;
        background: #aadaff;
        z-index: 0;
    }
    .ship-map-foot {
        padding: 10px 14px;
        font-size: 12px; color: #6b8c7c;
        border-top: 1px solid rgba(74,138,106,0.12);
        background: #fafdfb;
    }

    /* ── PANEL LACAK PAKET (terang, ala Shopee) ── */
    .track-panel { background: #fff; }
    .track-eta {
        display: flex; align-items: center; gap: 10px;
        padding: 13px 14px;
        background: linear-gradient(180deg, #eef7f1, #fff);
        border-bottom: 1px solid rgba(74,138,106,0.12);
    }
    .track-eta-icon { font-size: 20px; }
    .track-eta-label { font-size: 11px; color: #6b8c7c; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; }
    .track-eta-date { font-size: 15px; font-weight: 800; color: #2f5a44; }
    .track-courier {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 14px;
        border-bottom: 1px solid rgba(74,138,106,0.10);
    }
    .track-courier-logo {
        width: 40px; height: 40px; border-radius: 9px;
        background: #D8232A; color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 11px; flex-shrink: 0;
    }
    .track-courier-name { font-size: 13.5px; font-weight: 700; color: #1f3a2c; }
    .track-courier-sub { font-size: 11.5px; color: #6b8c7c; }
    .track-resi {
        margin-left: auto; text-align: right;
    }
    .track-resi-label { font-size: 10.5px; color: #6b8c7c; }
    .track-resi-no { font-size: 12.5px; font-weight: 700; color: #2f5a44; letter-spacing: .02em; }

    .track-timeline { padding: 16px 16px 6px; background: #fff; }
    .track-step {
        position: relative;
        padding: 0 0 20px 28px;
    }
    .track-step::before {
        content: '';
        position: absolute; left: 6px; top: 16px; bottom: -4px;
        width: 2px; background: #d8e6dd;
    }
    .track-step:last-child::before { display: none; }
    .track-dot {
        position: absolute; left: 0; top: 2px;
        width: 14px; height: 14px; border-radius: 50%;
        background: #cdd8d1; border: 3px solid #fff;
        box-shadow: 0 0 0 1px #cdd8d1;
    }
    .track-step.is-active .track-dot {
        background: #D8232A; box-shadow: 0 0 0 1px #D8232A, 0 0 0 5px rgba(216,35,42,.15);
    }
    .track-step.is-done .track-dot { background: #4A8A6A; box-shadow: 0 0 0 1px #4A8A6A; }
    .track-step.is-active .track-text { color: #1f3a2c; font-weight: 700; }
    .track-text { font-size: 13px; color: #5a6b62; line-height: 1.45; }
    .track-time { font-size: 11px; color: #93a39a; margin-top: 2px; }
    .track-highlight {
        margin-top: 6px; padding: 8px 11px;
        background: #fff4f4; border: 1px solid #ffd9d9; border-radius: 8px;
        font-size: 11.5px; color: #b8364c; font-weight: 600; line-height: 1.4;
    }

    /* ── ULASAN PRODUK ── */
    .rv-flash {
        margin-bottom: 14px; padding: 10px 13px;
        background: #eaf7ef; border: 1px solid #b9e3cb; border-radius: 9px;
        color: #2f7a4d; font-size: 13px; font-weight: 600;
    }
    .rv-item {
        padding: 14px 0;
        border-bottom: 1px solid rgba(74,138,106,0.12);
    }
    .rv-item:last-child { border-bottom: none; }
    .rv-prod { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    .rv-prod-img {
        width: 42px; height: 42px; border-radius: 9px; overflow: hidden;
        background: #f0f5f1; display: flex; align-items: center; justify-content: center;
        font-size: 18px; flex-shrink: 0;
    }
    .rv-prod-img img { width: 100%; height: 100%; object-fit: cover; }
    .rv-prod-name { font-size: 13.5px; font-weight: 700; color: #1f3a2c; }

    .rv-stars { display: flex; align-items: center; gap: 4px; margin-bottom: 8px; }
    .rv-star {
        background: none; border: none; cursor: pointer; padding: 0;
        font-size: 26px; line-height: 1; color: #d6ddd6; transition: color .12s, transform .12s;
    }
    .rv-star:hover { transform: scale(1.12); }
    .rv-star.on { color: #f5b50a; }

    .rv-textarea {
        width: 100%; border: 1px solid rgba(74,138,106,0.25); border-radius: 9px;
        padding: 9px 11px; font-size: 13px; font-family: inherit; resize: vertical;
        color: #1f3a2c; background: #fff; margin-bottom: 9px;
    }
    .rv-textarea:focus { outline: none; border-color: #4A8A6A; box-shadow: 0 0 0 3px rgba(74,138,106,.15); }

    .rv-foto-label {
        display: inline-flex; align-items: center; gap: 6px; cursor: pointer;
        font-size: 12.5px; font-weight: 600; color: #4A8A6A;
        padding: 7px 11px; border: 1px dashed rgba(74,138,106,0.4); border-radius: 8px;
        margin-bottom: 10px;
    }
    .rv-foto-label:hover { background: #f0f7f2; }
    .rv-foto-name { color: #6b8c7c; font-weight: 500; }

    .rv-submit {
        display: block; width: 100%;
        background: #4A8A6A; color: #fff; border: none; cursor: pointer;
        padding: 10px; border-radius: 9px; font-size: 13.5px; font-weight: 700;
        transition: background .15s;
    }
    .rv-submit:hover { background: #3a7256; }
    .rv-err { color: #d1546a; font-size: 11.5px; margin-bottom: 6px; }

    .rv-done { background: #f7faf8; border-radius: 9px; padding: 11px 13px; }
    .rv-stars-static { display: flex; align-items: center; gap: 2px; }
    .rv-stars-static span { font-size: 17px; color: #d6ddd6; }
    .rv-stars-static span.on { color: #f5b50a; }
    .rv-rating-num { font-size: 12px; font-weight: 700; color: #6b8c7c; margin-left: 6px; }
    .rv-comment { font-size: 13px; color: #3d5c4a; margin: 7px 0 0; line-height: 1.5; font-style: italic; }
    .rv-photo { margin-top: 8px; max-width: 110px; border-radius: 8px; border: 1px solid rgba(74,138,106,0.15); }
    .rv-by { font-size: 11px; color: #93a39a; margin-top: 7px; }
</style>

{{-- Leaflet (OpenStreetMap) — gratis, tanpa API key --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>document.body.classList.add('user-order-detail-page');</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mapEl = document.getElementById('shipMap');
        if (!mapEl || typeof L === 'undefined') return;

        const statusEl = document.getElementById('shipMapStatus');
        const footEl = document.getElementById('shipMapFoot');
        const alamat   = (mapEl.dataset.alamat || '').trim();
        const tokoAlm  = (mapEl.dataset.toko || '').trim();
        const tokoNama = (mapEl.dataset.tokoNama || 'Toko').trim();
        const orderStatus = (mapEl.dataset.status || 'pending').trim();
        let progress = parseFloat(mapEl.dataset.progress || '0.06');
        if (isNaN(progress)) progress = 0.06;

        const fallback = [-2.5489, 118.0149];

        const map = L.map(mapEl, { scrollWheelZoom: false }).setView(fallback, 5);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            subdomains: 'abcd',
            attribution: '&copy; OpenStreetMap &copy; CARTO'
        }).addTo(map);

        // ── Ikon kustom (toko, kurir, tujuan) ──
        function divIcon(emoji, bg) {
            return L.divIcon({
                className: 'ship-pin',
                html: '<div style="width:34px;height:34px;border-radius:50% 50% 50% 2px;'
                    + 'transform:rotate(45deg);background:' + bg + ';box-shadow:0 3px 8px rgba(0,0,0,.3);'
                    + 'display:flex;align-items:center;justify-content:center;border:2px solid #fff;">'
                    + '<span style="transform:rotate(-45deg);font-size:16px;">' + emoji + '</span></div>',
                iconSize: [34, 34],
                iconAnchor: [17, 34],
                popupAnchor: [0, -32],
            });
        }
        const courierIcon = L.divIcon({
            className: 'ship-courier',
            html: '<div style="width:38px;height:38px;border-radius:50%;background:#fff;'
                + 'box-shadow:0 4px 12px rgba(216,35,42,.4);display:flex;align-items:center;'
                + 'justify-content:center;border:3px solid #D8232A;font-size:18px;">🛵</div>',
            iconSize: [38, 38],
            iconAnchor: [19, 19],
            popupAnchor: [0, -20],
        });

        // Geocode satu alamat → {lat, lon} | null
        function geocode(q) {
            if (!q) return Promise.resolve(null);
            const url = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&countrycodes=id&q='
                + encodeURIComponent(q);
            return fetch(url, { headers: { 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(d => (Array.isArray(d) && d.length) ? { lat: +d[0].lat, lon: +d[0].lon } : null)
                .catch(() => null);
        }

        // Titik di sepanjang garis origin→dest pada fraksi t (0..1)
        function lerp(a, b, t) {
            return [a[0] + (b[0] - a[0]) * t, a[1] + (b[1] - a[1]) * t];
        }

        function statusText() {
            if (orderStatus === 'selesai') return 'Paket telah sampai di tujuan';
            if (orderStatus === 'dikirim') return 'Paket sedang dalam perjalanan';
            return 'Paket sedang disiapkan toko';
        }

        if (!alamat) {
            if (statusEl) statusEl.textContent = 'Alamat tidak tersedia';
            setTimeout(() => map.invalidateSize(), 200);
            return;
        }

        // Geocode tujuan & toko sekaligus
        Promise.all([geocode(alamat), geocode(tokoAlm)]).then(([dest, origin]) => {
            if (!dest) {
                if (statusEl) statusEl.textContent = 'Lokasi tidak ditemukan';
                if (footEl) footEl.textContent = 'Peta menampilkan area umum. Alamat tetap dipakai untuk pengiriman.';
                setTimeout(() => map.invalidateSize(), 200);
                return;
            }

            const destLL = [dest.lat, dest.lon];

            // Marker tujuan (selalu ada)
            L.marker(destLL, { icon: divIcon('🏠', '#4A8A6A') })
                .addTo(map)
                .bindPopup('<strong>Tujuan</strong><br>' + alamat);

            // Kalau alamat toko tidak ketemu, jatuh ke titik buatan dekat tujuan
            const originLL = origin
                ? [origin.lat, origin.lon]
                : [dest.lat + 0.045, dest.lon - 0.06];

            // Marker toko (asal)
            L.marker(originLL, { icon: divIcon('🏪', '#C8922A') })
                .addTo(map)
                .bindPopup('<strong>' + tokoNama + '</strong><br>Titik asal pengiriman');

            // Garis rute: bagian sudah dilewati (solid) + sisa (putus-putus)
            const courierLL = lerp(originLL, destLL, progress);

            L.polyline([originLL, courierLL], {
                color: '#ff4d4d', weight: 4, opacity: 0.95
            }).addTo(map);
            L.polyline([courierLL, destLL], {
                color: '#7d8694', weight: 3, opacity: 0.8, dashArray: '6, 8'
            }).addTo(map);

            // Marker kurir (posisi paket saat ini)
            const courierMarker = L.marker(courierLL, { icon: courierIcon })
                .addTo(map)
                .bindPopup('<strong>Posisi Paket</strong><br>' + statusText());

            if (orderStatus === 'dikirim') courierMarker.openPopup();

            // Fit semua titik ke layar
            const bounds = L.latLngBounds([originLL, destLL, courierLL]).pad(0.25);
            map.fitBounds(bounds);

            if (statusEl) statusEl.textContent = statusText();
            if (footEl) {
                footEl.textContent = orderStatus === 'selesai'
                    ? 'Paket sudah diterima di alamat tujuan.'
                    : (orderStatus === 'dikirim'
                        ? 'Ikon 🛵 menunjukkan perkiraan posisi paket menuju alamatmu.'
                        : 'Paket sedang disiapkan di ' + tokoNama + ' sebelum dikirim.');
            }

            // Animasi kecil: kurir bergerak maju dikit saat status "dikirim"
            if (orderStatus === 'dikirim') {
                let t = progress, dir = 1;
                setInterval(() => {
                    t += dir * 0.004;
                    if (t > progress + 0.05 || t < progress - 0.05) dir *= -1;
                    courierMarker.setLatLng(lerp(originLL, destLL, t));
                }, 120);
            }

            setTimeout(() => map.invalidateSize(), 200);
        });
    });
</script>

<script>
    // ── Star rating + foto picker untuk form ulasan ──
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-stars]').forEach(function (group) {
            const stars = group.querySelectorAll('.rv-star');
            const input = group.querySelector('input[name="rating"]');

            function paint(val) {
                stars.forEach(s => s.classList.toggle('on', parseInt(s.dataset.val, 10) <= val));
            }

            stars.forEach(function (star) {
                star.addEventListener('mouseenter', () => paint(parseInt(star.dataset.val, 10)));
                star.addEventListener('click', () => {
                    input.value = star.dataset.val;
                    paint(parseInt(star.dataset.val, 10));
                });
            });
            group.addEventListener('mouseleave', () => paint(parseInt(input.value || '0', 10)));
        });

        // Tampilkan nama file foto yang dipilih
        document.querySelectorAll('.rv-foto-label input[type="file"]').forEach(function (inp) {
            inp.addEventListener('change', function () {
                const nameEl = inp.parentElement.querySelector('.rv-foto-name');
                if (nameEl) nameEl.textContent = inp.files.length ? '· ' + inp.files[0].name : '';
            });
        });

        // Guard submit: rating wajib diisi
        document.querySelectorAll('.rv-form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                const rating = form.querySelector('input[name="rating"]');
                if (!rating.value) {
                    e.preventDefault();
                    alert('Pilih dulu jumlah bintang sebelum mengirim ulasan.');
                }
            });
        });
    });
</script>

@php
    $firstPayment = $order->payments->first();
    $displayStatus = $order->status;
    $paymentStatusLabel = ucfirst($firstPayment->status ?? 'Menunggu');
    if ($firstPayment && strtolower((string) $firstPayment->metode) === 'cod' && ($firstPayment->status ?? 'pending') === 'pending') {
        $displayStatus = 'pending';
    }

    if ($order->status === 'selesai' && $firstPayment) {
        $paymentStatusLabel = 'Selesai';
    }

    $statusSteps = ['pending','dikirim','selesai'];
    $currentIdx = array_search($order->status, $statusSteps);
    $stepLabels = ['Pesanan Dibuat','Sedang Dikirim','Selesai'];
    $stepIcons  = ['📋','🚚','✅'];
@endphp

<div class="ecom-page">

    {{-- TOPBAR --}}
    <div class="ecom-topbar">
        <div class="ecom-topbar-inner">
            <a href="{{ route('orders.index') }}" class="ecom-back-btn">
                <svg fill="none" viewBox="0 0 16 16" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 3L5 8l5 5"/>
                </svg>
                Riwayat Pesanan
            </a>
            <span class="ecom-topbar-title">Detail Pesanan</span>
            <span class="ecom-topbar-id">#{{ sprintf('%04d', $order->id) }}</span>
        </div>
    </div>

    <div class="ecom-wrap">

        {{-- STATUS TRACKER CARD --}}
        <div class="status-tracker">
            <div class="tracker-header">
                <div class="tracker-order-info">
                    <h2>Pesanan #{{ sprintf('%04d', $order->id) }}</h2>
                    <p>Ditempatkan pada {{ $order->created_at->format('d M Y') }} · {{ $order->created_at->format('H:i') }} WIB</p>
                </div>
                <span class="status-pill {{ $order->status }}">
                    <span class="status-dot"></span>
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            @if($order->status !== 'dibatalkan')
            <div class="steps-row">
                @foreach($statusSteps as $i => $step)
                @php
                    $isDone   = $currentIdx !== false && $i < $currentIdx;
                    $isActive = $currentIdx !== false && $i === $currentIdx;
                    $cls = $isDone ? 'done' : ($isActive ? 'active' : '');
                @endphp
                <div class="step-item {{ $cls }}">
                    <div class="step-circle">{{ $isDone ? '✓' : $stepIcons[$i] }}</div>
                    <div class="step-label">{{ $stepLabels[$i] }}</div>
                </div>
                @endforeach
            </div>
            @else
            <div style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:#FEE2E2;border-radius:12px;border:1.5px solid #FECACA;">
                <span style="font-size:20px;">❌</span>
                <span style="font-size:13.5px;font-weight:700;color:#991B1B;">Pesanan ini telah dibatalkan.</span>
            </div>
            @endif
        </div>

        <div class="ecom-grid">

            {{-- LEFT COLUMN --}}
            <div style="display:flex;flex-direction:column;gap:20px;">

                {{-- PRODUK --}}
                <div class="ecard">
                    <div class="ecard-head">
                        <div class="ecard-head-icon">🛍️</div>
                        <div>
                            <div class="ecard-title">Produk yang Dipesan</div>
                        </div>
                        <span style="margin-left:auto;font-size:12px;font-weight:700;color:var(--ink-40);">{{ $order->orderDetails->count() }} item</span>
                    </div>
                    <div class="ecard-body" style="padding-top:16px;">
                        <table class="prod-table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="tac">Qty</th>
                                    <th class="tar">Harga</th>
                                    <th class="tar">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderDetails as $detail)
                                <tr>
                                    <td>
                                        <div class="prod-name">{{ $detail->product->nama_produk ?? '-' }}</div>
                                        <div class="prod-price">Rp {{ number_format($detail->harga, 0, ',', '.') }} / pcs</div>
                                    </td>
                                    <td style="text-align:center;">
                                        <span class="prod-qty-badge">{{ $detail->qty }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span style="font-size:13.5px;color:var(--ink-60);font-weight:600;">Rp {{ number_format($detail->harga, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="prod-subtotal">Rp {{ number_format($detail->harga * $detail->qty, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="total-row">
                            <span class="total-row-label">Total Pembayaran</span>
                            <span class="total-row-value">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- ULASAN PRODUK (hanya saat pesanan selesai) --}}
                @if($order->status === 'selesai')
                <div class="ecard">
                    <div class="ecard-head">
                        <div class="ecard-head-icon">⭐</div>
                        <div>
                            <div class="ecard-title">Beri Ulasan</div>
                        </div>
                    </div>
                    <div class="ecard-body" style="padding-top:8px;">
                        @if(session('success'))
                            <div class="rv-flash">{{ session('success') }}</div>
                        @endif

                        @foreach ($order->orderDetails as $detail)
                        <div class="rv-item">
                            <div class="rv-prod">
                                <div class="rv-prod-img">
                                    @if($detail->product?->gambar)
                                        <img src="{{ asset('storage/' . $detail->product->gambar) }}" alt="{{ $detail->product->nama_produk }}">
                                    @else
                                        <span>📦</span>
                                    @endif
                                </div>
                                <div class="rv-prod-name">{{ $detail->product->nama_produk ?? 'Produk' }}</div>
                            </div>

                            @if($detail->isReviewed())
                                {{-- Sudah diulas: tampilkan hasil --}}
                                <div class="rv-done">
                                    <div class="rv-stars-static">
                                        @for($s = 1; $s <= 5; $s++)
                                            <span class="{{ $s <= $detail->rating ? 'on' : '' }}">★</span>
                                        @endfor
                                        <span class="rv-rating-num">{{ $detail->rating }}/5</span>
                                    </div>
                                    @if($detail->review_komentar)
                                        <p class="rv-comment">"{{ $detail->review_komentar }}"</p>
                                    @endif
                                    @if($detail->review_foto)
                                        <img class="rv-photo" src="{{ asset('storage/' . $detail->review_foto) }}" alt="Foto ulasan">
                                    @endif
                                    <div class="rv-by"> Diulas oleh {{ $order->user?->name ?? 'kamu' }} · {{ $detail->reviewed_at?->format('d M Y') }}</div>
                                </div>
                            @else
                                {{-- Belum diulas: form --}}
                                <form action="{{ route('reviews.store', [$order, $detail]) }}" method="POST" enctype="multipart/form-data" class="rv-form">
                                    @csrf
                                    <div class="rv-stars" data-stars>
                                        @for($s = 1; $s <= 5; $s++)
                                            <button type="button" class="rv-star" data-val="{{ $s }}" aria-label="{{ $s }} bintang">★</button>
                                        @endfor
                                        <input type="hidden" name="rating" value="" required>
                                    </div>
                                    @error('rating')<div class="rv-err">{{ $message }}</div>@enderror

                                    <textarea name="review_komentar" class="rv-textarea" rows="2" maxlength="1000" placeholder="Bagaimana produk ini? (opsional)"></textarea>

                                    <label class="rv-foto-label">
                                        📷 Tambah foto (opsional)
                                        <input type="file" name="review_foto" accept="image/*" hidden>
                                        <span class="rv-foto-name"></span>
                                    </label>
                                    @error('review_foto')<div class="rv-err">{{ $message }}</div>@enderror

                                    <button type="submit" class="rv-submit">Kirim Ulasan</button>
                                </form>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- ALAMAT PENGIRIMAN --}}
                <div class="ecard">
                    <div class="ecard-head">
                        <div class="ecard-head-icon">📍</div>
                        <div class="ecard-title">Alamat Pengiriman</div>
                    </div>
                    <div class="ecard-body">
                        <div class="info-row">
                            <div class="info-icon">👤</div>
                            <div>
                                <div class="info-label">Penerima</div>
                                <div class="info-val">{{ $order->user?->name ?? 'Pelanggan' }}</div>
                                <div class="info-sub">{{ $order->user?->phone ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon">🏠</div>
                            <div>
                                <div class="info-label">Alamat Lengkap</div>
                                <div class="info-val">{{ $order->alamat_lengkap ?? $order->alamat ?? 'Alamat tidak tersedia' }}</div>
                                @if($order->kota ?? $order->user?->kota)
                                <div class="info-sub">{{ $order->kota ?? $order->user?->kota }}{{ ($order->kode_pos ?? $order->user?->kode_pos) ? ', ' . ($order->kode_pos ?? $order->user?->kode_pos) : '' }}</div>
                                @endif
                            </div>
                        </div>
                        @if($order->catatan)
                        <div class="info-row">
                            <div class="info-icon">📝</div>
                            <div>
                                <div class="info-label">Catatan Pesanan</div>
                                <div class="info-val">{{ $order->catatan }}</div>
                            </div>
                        </div>
                        @endif

                        {{-- PETA LOKASI PENGIRIMAN --}}
                        @php
                            $mapAlamat = trim(($order->alamat_lengkap ?? $order->alamat ?? '') . ' ' . ($order->kota ?? $order->user?->kota ?? ''));
                            $shopUmkm  = $order->orderDetails->first(fn($d) => $d->product && $d->product->umkm)?->product?->umkm;
                            $shopNama  = $shopUmkm?->nama_umkm ?? 'Toko UMKM';
                            $shopAlamat = trim((string) ($shopUmkm?->alamat ?? ''));
                            // Progress paket berdasarkan status order: pending=0, dikirim=tengah, selesai=tiba
                            $mapProgress = match ($order->status) {
                                'selesai'  => 1.0,
                                'dikirim'  => 0.5,
                                default    => 0.06,
                            };
                        @endphp
                        <div class="ship-map-wrap">
                            <div class="ship-map-head">
                                <span class="ship-map-dot"></span>
                                <span>Lokasi Pengiriman</span>
                                <span class="ship-map-status" id="shipMapStatus">Memuat peta…</span>
                            </div>
                            <div id="shipMap" class="ship-map"
                                 data-alamat="{{ $mapAlamat }}"
                                 data-toko="{{ $shopAlamat }}"
                                 data-toko-nama="{{ $shopNama }}"
                                 data-status="{{ $order->status }}"
                                 data-progress="{{ $mapProgress }}"></div>
                            <div class="ship-map-foot" id="shipMapFoot">
                                Paket akan dikirim ke alamat di atas.
                            </div>

                            {{-- ── PANEL LACAK PAKET (timeline ala Shopee) ── --}}
                            @php
                                $courierLabels = [
                                    'jnt'         => ['J&T Express', 'JNT'],
                                    'jne_reguler' => ['JNE Reguler', 'JNE'],
                                    'spx_standar' => ['SPX Standar', 'SPX'],
                                ];
                                $kurirKey   = $order->kurir ?? 'jnt';
                                $kurirNama  = $courierLabels[$kurirKey][0] ?? strtoupper($kurirKey);
                                $kurirLogo  = $courierLabels[$kurirKey][1] ?? 'EXP';

                                $orderDate  = $order->created_at;
                                // Resi dummy yang stabil per order
                                $resi = strtoupper($kurirLogo) . str_pad((string) $order->id, 9, '0', STR_PAD_LEFT) . 'ID';

                                // Estimasi tiba: 2-4 hari setelah order
                                $etaStart = $orderDate?->copy()->addDays(2);
                                $etaEnd   = $orderDate?->copy()->addDays(4);
                                $etaText  = $etaStart && $etaEnd
                                    ? $etaStart->translatedFormat('d') . ' - ' . $etaEnd->translatedFormat('d M Y')
                                    : '-';

                                $st = $order->status;
                                // Tahap: dibuat -> dikemas -> dikirim -> tiba
                                $stepDone = [
                                    'dibuat'  => in_array($st, ['pending','dikirim','selesai'], true),
                                    'dikemas' => in_array($st, ['dikirim','selesai'], true),
                                    'dikirim' => in_array($st, ['dikirim','selesai'], true),
                                    'tiba'    => $st === 'selesai',
                                ];
                            @endphp

                            @if($st !== 'dibatalkan')
                            <div class="track-panel">
                                <div class="track-eta">
                                    <span class="track-eta-icon">🚚</span>
                                    <div>
                                        <div class="track-eta-label">Estimasi Tiba</div>
                                        <div class="track-eta-date">{{ $etaText }}</div>
                                    </div>
                                </div>

                                <div class="track-courier">
                                    <div class="track-courier-logo">{{ $kurirLogo }}</div>
                                    <div>
                                        <div class="track-courier-name">{{ $kurirNama }}</div>
                                        <div class="track-courier-sub">Reguler</div>
                                    </div>
                                    <div class="track-resi">
                                        <div class="track-resi-label">No. Resi</div>
                                        <div class="track-resi-no">{{ $resi }}</div>
                                    </div>
                                </div>

                                <div class="track-timeline">
                                    @if($st === 'selesai')
                                    <div class="track-step is-active">
                                        <span class="track-dot"></span>
                                        <div class="track-text">Pesanan telah sampai di tujuan</div>
                                        <div class="track-time">{{ $etaEnd?->translatedFormat('d M Y, H:i') }} WIB</div>
                                        <div class="track-highlight">Paket telah diterima di {{ $order->kota ?? $order->user?->kota ?? 'alamat tujuan' }}.</div>
                                    </div>
                                    @endif

                                    <div class="track-step {{ $st === 'dikirim' ? 'is-active' : ($stepDone['dikirim'] ? 'is-done' : '') }}">
                                        <span class="track-dot"></span>
                                        <div class="track-text">Paket dalam perjalanan menuju alamatmu</div>
                                        @if($stepDone['dikirim'])
                                        <div class="track-time">{{ $orderDate?->copy()->addDay()->translatedFormat('d M Y, H:i') }} WIB</div>
                                        @if($st === 'dikirim')
                                        <div class="track-highlight">Paket sedang dikirim oleh kurir {{ $kurirNama }} menuju {{ $order->kota ?? $order->user?->kota ?? 'kotamu' }}.</div>
                                        @endif
                                        @else
                                        <div class="track-time">Menunggu paket dikirim</div>
                                        @endif
                                    </div>

                                    <div class="track-step {{ $stepDone['dikemas'] && $st !== 'dikirim' && $st !== 'selesai' ? 'is-active' : ($stepDone['dikemas'] ? 'is-done' : '') }}">
                                        <span class="track-dot"></span>
                                        <div class="track-text">Paket telah disiapkan & diserahkan ke kurir</div>
                                        @if($stepDone['dikemas'])
                                        <div class="track-time">{{ $orderDate?->copy()->addHours(6)->translatedFormat('d M Y, H:i') }} WIB</div>
                                        @else
                                        <div class="track-time">Penjual sedang menyiapkan pesanan</div>
                                        @endif
                                    </div>

                                    <div class="track-step {{ $st === 'pending' ? 'is-active' : 'is-done' }}">
                                        <span class="track-dot"></span>
                                        <div class="track-text">Pesanan dibuat & menunggu diproses</div>
                                        <div class="track-time">{{ $orderDate?->translatedFormat('d M Y, H:i') }} WIB</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- METODE PEMBAYARAN --}}
                <div class="ecard">
                    <div class="ecard-head">
                        <div class="ecard-head-icon">💳</div>
                        <div class="ecard-title">Metode Pembayaran</div>
                    </div>
                    <div class="ecard-body">
                        <div class="info-row">
                            <div class="info-icon">🏦</div>
                            <div>
                                <div class="info-label">Metode</div>
                                <div style="margin-top:6px;">
                                    <span class="pay-chip">
                                        @php
                                            $rawMetode = strtolower($firstPayment->metode ?? 'cod');
                                            $methodLabels = [
                                                'cod'      => 'Bayar di Tempat (COD)',
                                                'va_dana'  => 'E-Wallet DANA',
                                                'va_ovo'   => 'E-Wallet OVO',
                                                'va_gopay' => 'E-Wallet GoPay',
                                                'bank_bni' => 'Transfer Bank BNI',
                                                'bank_bri' => 'Transfer Bank BRI',
                                                'bank_bca' => 'Transfer Bank BCA',
                                            ];
                                            $methodIcons = [
                                                'cod'      => '🛵',
                                                'va_dana'  => '📱',
                                                'va_ovo'   => '📱',
                                                'va_gopay' => '📱',
                                                'bank_bni' => '🏦',
                                                'bank_bri' => '🏦',
                                                'bank_bca' => '🏦',
                                            ];
                                            $metodeLabel = $methodLabels[$rawMetode] ?? strtoupper($rawMetode);
                                            $metodeIcon  = $methodIcons[$rawMetode]  ?? '💰';
                                        @endphp
                                        {{ $metodeIcon }}
                                        {{ $metodeLabel }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @if($firstPayment && $firstPayment->created_at)
                        <div class="info-row">
                            <div class="info-icon">📅</div>
                            <div>
                                <div class="info-label">Waktu Pembayaran</div>
                                <div class="info-val">{{ $firstPayment->created_at->format('d M Y, H:i') }} WIB</div>
                                <div class="info-sub">Status: <strong>{{ $paymentStatusLabel }}</strong></div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="summary-sidebar">

                {{-- RINGKASAN HARGA --}}
                <div class="ecard">
                    <div class="ecard-head">
                        <div class="ecard-head-icon">🧾</div>
                        <div class="ecard-title">Ringkasan Harga</div>
                    </div>
                    <div class="ecard-body">
                        <div class="price-breakdown">
                            <div class="pb-row">
                                <span>Subtotal ({{ $order->orderDetails->count() }} item)</span>
                                <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="pb-row">
                                <span>Biaya Pengiriman</span>
                                <span style="color:#059669;font-weight:700;">Gratis</span>
                            </div>
                            <div class="pb-row">
                                <span>Diskon</span>
                                <span>Rp 0</span>
                            </div>
                            <div class="pb-row total">
                                <span>Total</span>
                                <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- AKSI --}}
                @if (session('success'))
                    <div class="order-note" style="background:#D1FADF;border-color:#A6E9C5;">
                        <span class="order-note-icon">✅</span>
                        <span class="order-note-text" style="color:#166534;">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="order-note" style="background:#FEE2E2;border-color:#FCA5A5;">
                        <span class="order-note-icon">⚠️</span>
                        <span class="order-note-text" style="color:#991B1B;">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($order->status === 'pending' && auth()->user()->role !== 'admin')
                    <div class="order-note">
                        <span class="order-note-icon">⏳</span>
                        <span class="order-note-text">Pesanan Anda sedang menunggu konfirmasi pembayaran. Silakan selesaikan pembayaran untuk melanjutkan proses pesanan.</span>
                    </div>

                    <a href="{{ route('payments.create', ['order' => $order->id]) }}" class="btn-cta btn-cta-primary">
                        <span>🛒</span> Lanjut Checkout
                    </a>
                @endif

                @if ($order->status === 'dikirim' && auth()->user()->role !== 'admin')
                    <div class="order-note" style="background:#E0F2FE;border-color:#7DD3FC;">
                        <span class="order-note-icon">🚚</span>
                        <span class="order-note-text" style="color:#075985;">Pesanan sedang dalam pengiriman. Klik tombol di bawah setelah barang sampai di tangan Anda.</span>
                    </div>

                    <form action="{{ route('orders.confirm', $order) }}" method="POST" style="margin:0;"
                          onsubmit="return confirm('Konfirmasi: barang sudah Anda terima? Status pesanan akan menjadi Selesai.');">
                        @csrf
                        <button type="submit" class="btn-cta btn-cta-primary" style="width:100%;">
                            <span>✓</span> Konfirmasi Pesanan Diterima
                        </button>
                    </form>
                @endif

                @if ($order->status === 'selesai')
                    <div class="order-note" style="background:#D1FADF;border-color:#A6E9C5;">
                        <span class="order-note-icon">🎉</span>
                        <span class="order-note-text" style="color:#166534;">Pesanan ini sudah selesai. Terima kasih telah berbelanja di Rumah Rimpang.</span>
                    </div>
                @endif

                <a href="{{ route('orders.index') }}" class="btn-cta btn-cta-ghost">
                    ← Kembali ke Riwayat
                </a>

                {{-- INFO PESANAN --}}
                <div class="ecard">
                    <div class="ecard-head">
                        <div class="ecard-head-icon">ℹ️</div>
                        <div class="ecard-title">Info Pesanan</div>
                    </div>
                    <div class="ecard-body" style="padding-top:14px;">
                        <div class="info-row" style="padding-top:0;">
                            <div>
                                <div class="info-label">No. Pesanan</div>
                                <div class="info-val" style="font-size:15px;font-weight:800;letter-spacing:0.02em;">#{{ sprintf('%04d', $order->id) }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div>
                                <div class="info-label">Tanggal Pesanan</div>
                                <div class="info-val">{{ $order->created_at->format('d M Y') }}</div>
                                <div class="info-sub">{{ $order->created_at->format('H:i') }} WIB</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div>
                                <div class="info-label">Status</div>
                                <span class="status-pill {{ $order->status }}" style="margin-top:6px;">
                                    <span class="status-dot"></span>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endif
@endsection