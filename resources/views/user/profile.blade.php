@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&family=Playfair+Display:wght@500;600;700&display=swap');

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
        --border: rgba(124,185,154,0.18);
        --border-strong: rgba(124,185,154,0.35);
        --shadow-sm: 0 1px 4px rgba(28,43,36,0.06);
        --shadow-md: 0 6px 24px rgba(28,43,36,0.10);
        --shadow-lg: 0 14px 48px rgba(28,43,36,0.14);
        --radius-sm: 8px;
        --radius: 14px;
        --radius-lg: 20px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    #upp-shell {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: var(--cream);
        overflow-y: auto;
        font-family: 'DM Sans', -apple-system, sans-serif;
        color: var(--ink);
        -webkit-font-smoothing: antialiased;
    }

    /* ── NAV ── */
    .upp-nav {
        position: sticky; top: 0; z-index: 50;
        height: 62px;
        background: rgba(247,244,238,0.95);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center;
    }
    .upp-nav-inner {
        max-width: 1080px; margin: 0 auto;
        padding: 0 28px; width: 100%;
        display: flex; align-items: center; justify-content: space-between;
    }
    .upp-back {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 7px 14px;
        background: var(--surface);
        border: 1px solid var(--border-strong);
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-size: 13px; font-weight: 500;
        color: var(--ink-soft);
        transition: all 0.17s;
    }
    .upp-back:hover { background: var(--sage-pale); border-color: var(--sage); color: var(--sage-deep); }
    .upp-nav-title { font-family: 'Playfair Display', serif; font-size: 16px; font-weight: 600; color: var(--ink); }
    .upp-nav-right { display: flex; gap: 8px; }
    .upp-nav-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 14px; border-radius: var(--radius-sm);
        text-decoration: none; font-size: 13px; font-weight: 500;
        transition: all 0.17s;
        border: 1px solid var(--border-strong);
        background: var(--surface);
        color: var(--ink-soft);
    }
    .upp-nav-btn:hover { background: var(--sage-pale); border-color: var(--sage); color: var(--sage-deep); }

    /* ── LAYOUT ── */
    .upp-wrap {
        max-width: 1080px; margin: 0 auto;
        padding: 28px 28px 80px;
    }

    /* ── 2-COL LAYOUT (Shopee style) ── */
    .upp-shell-grid {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 22px;
        align-items: start;
    }

    /* ── LEFT SIDEBAR ── */
    .upp-sidebar {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        position: sticky;
        top: 78px;
    }
    .upp-side-head {
        padding: 22px 22px 18px;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 14px;
    }
    .upp-side-avatar {
        width: 52px; height: 52px; border-radius: 50%;
        background: linear-gradient(135deg, var(--sage), var(--sage-deep));
        color: #fff; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 600;
        overflow: hidden;
        border: 2px solid var(--surface);
        box-shadow: 0 2px 8px rgba(28,43,36,0.12);
    }
    .upp-side-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .upp-side-name {
        font-size: 14px; font-weight: 700; color: var(--ink);
        line-height: 1.3;
        overflow: hidden; text-overflow: ellipsis;
        white-space: nowrap;
    }
    .upp-side-edit {
        font-size: 12px; color: var(--muted);
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 4px;
        transition: color 0.18s;
    }
    .upp-side-edit:hover { color: var(--sage-deep); }

    .upp-side-nav { padding: 8px 0; }
    .upp-side-section {
        padding: 12px 22px 6px;
        font-size: 11px; font-weight: 700;
        letter-spacing: 0.1em; text-transform: uppercase;
        color: var(--muted);
        display: flex; align-items: center; gap: 12px;
        line-height: 1;
    }
    .upp-side-section .ic {
        width: 22px; height: 22px;
        border-radius: 6px;
        background: var(--sage-pale);
        color: var(--sage-deep);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
    }
    .upp-side-link {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 22px;
        text-decoration: none;
        font-size: 13.5px; font-weight: 500;
        color: var(--ink-soft);
        transition: all 0.18s;
        position: relative;
        border-left: 3px solid transparent;
        line-height: 1.2;
    }
    .upp-side-link:hover {
        background: var(--sage-pale);
        color: var(--sage-deep);
        border-left-color: var(--sage);
    }
    .upp-side-link.is-active {
        background: var(--sage-pale);
        color: var(--sage-deep);
        border-left-color: var(--sage);
        font-weight: 600;
    }
    .upp-side-link .lk-ic {
        width: 22px; height: 22px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
        opacity: 0.85;
    }
    .upp-side-link .lk-text { flex: 1; min-width: 0; }
    .upp-side-link .lk-badge {
        margin-left: auto;
        font-size: 10.5px; font-weight: 700;
        padding: 2px 8px; border-radius: 999px;
        background: var(--gold-pale); color: #8B6914;
        flex-shrink: 0;
    }

    /* ── RIGHT MAIN ── */
    .upp-main { display: flex; flex-direction: column; gap: 18px; }

    .upp-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }
    .upp-card-head {
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--border);
    }
    .upp-card-title {
        font-family: 'Playfair Display', serif;
        font-size: 18px; font-weight: 600;
        color: var(--ink); line-height: 1.2;
    }
    .upp-card-sub {
        font-size: 12.5px; color: var(--muted);
        margin-top: 4px;
    }
    .upp-card-body { padding: 24px; }

    /* ── TWO-COL FORM (Shopee profile) ── */
    .upp-form-grid {
        display: grid;
        grid-template-columns: 1fr 1px 240px;
        gap: 32px;
        align-items: stretch;
    }
    .upp-form-divider {
        background: var(--border);
        width: 1px;
        align-self: stretch;
    }

    .upp-fields { display: flex; flex-direction: column; gap: 12px; }
    .upp-field-row {
        display: grid;
        grid-template-columns: 130px 1fr;
        align-items: start;
        gap: 16px;
    }
    .upp-field-label {
        font-size: 13px; color: var(--muted);
        text-align: right;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        line-height: 1.2;
    }
    .upp-field-value {
        font-size: 14px; color: var(--ink); font-weight: 500;
    }
    .upp-field-control {
        display: flex; flex-direction: column; gap: 5px;
        min-width: 0;
    }
    .upp-field-control > .upp-input,
    .upp-field-control > .upp-select,
    .upp-field-control > .upp-radio-row {
        height: 42px;
    }
    .upp-field-control > .upp-radio-row {
        display: flex; align-items: center; gap: 8px;
    }

    .upp-input, .upp-select {
        width: 100%;
        height: 42px;
        padding: 0 14px;
        border-radius: 10px;
        border: 1px solid var(--border-strong);
        background: #fff;
        color: var(--ink);
        font-family: 'DM Sans', sans-serif; font-size: 13.5px;
        transition: all 0.18s;
    }
    .upp-input:focus, .upp-select:focus {
        outline: none;
        border-color: var(--sage);
        box-shadow: 0 0 0 3px rgba(124,185,154,0.18);
    }
    .upp-input.is-error, .upp-select.is-error { border-color: #d1546a; background: #fdf3f5; }
    .upp-error { color: #d1546a; font-size: 11.5px; margin-top: 5px; }
    .upp-hint { color: var(--muted); font-size: 11.5px; margin-top: 5px; }

    .upp-radio-row { display: flex; gap: 8px; flex-wrap: wrap; }
    .upp-radio {
        position: relative;
        cursor: pointer;
    }
    .upp-radio input { position: absolute; opacity: 0; pointer-events: none; }
    .upp-radio span {
        display: inline-flex; align-items: center; gap: 7px;
        height: 42px;
        padding: 0 16px;
        border: 1px solid var(--border-strong);
        border-radius: 10px;
        font-size: 13.5px; font-weight: 500;
        color: var(--ink-soft);
        background: #fff;
        transition: all 0.18s;
    }
    .upp-radio:hover span { border-color: var(--sage); color: var(--sage-deep); }
    .upp-radio input:checked + span {
        background: var(--sage-pale);
        border-color: var(--sage);
        color: var(--sage-deep);
        font-weight: 600;
    }
    .upp-radio input:checked + span::before {
        content: '';
        width: 8px; height: 8px; border-radius: 50%;
        background: var(--sage);
    }

    /* ── AVATAR UPLOAD ── */
    .upp-avatar-col {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center;
        gap: 16px;
    }
    .upp-avatar-display {
        width: 110px; height: 110px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--sage), var(--sage-deep));
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Playfair Display', serif;
        font-size: 44px; font-weight: 600;
        overflow: hidden;
        border: 4px solid var(--surface);
        box-shadow: 0 4px 18px rgba(28,43,36,0.16);
        position: relative;
    }
    .upp-avatar-display img {
        width: 100%; height: 100%; object-fit: cover;
        display: block;
    }
    .upp-avatar-actions { display: flex; flex-direction: column; gap: 8px; align-items: center; width: 100%; }
    .upp-avatar-btn {
        display: inline-flex; align-items: center; justify-content: center;
        gap: 6px; cursor: pointer;
        padding: 9px 18px;
        border: 1px solid var(--border-strong);
        background: #fff;
        border-radius: 10px;
        font-size: 13px; font-weight: 600; color: var(--ink-soft);
        transition: all 0.18s;
    }
    .upp-avatar-btn:hover { background: var(--sage-pale); border-color: var(--sage); color: var(--sage-deep); }
    .upp-avatar-hint {
        font-size: 11.5px;
        color: var(--muted);
        text-align: center;
        line-height: 1.5;
    }
    .upp-avatar-hint strong { color: var(--ink-soft); font-weight: 600; }
    .upp-avatar-title {
        height: 42px;
        display: flex;
        align-items: center;
        font-size: 13px; font-weight: 600;
        color: var(--ink-soft);
        letter-spacing: 0.02em;
    }
    #avatarInput { display: none; }

    /* ── ACTIONS BAR ── */
    .upp-form-actions {
        margin-top: 24px;
        padding-top: 22px;
        border-top: 1px dashed var(--border);
        display: flex; justify-content: flex-end; gap: 10px;
        flex-wrap: wrap;
    }
    .upp-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 7px;
        padding: 11px 28px;
        border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif;
        font-size: 13px; font-weight: 700;
        cursor: pointer;
        border: none; text-decoration: none;
        transition: all 0.18s;
    }
    .upp-btn-ghost { background: var(--cream); color: var(--ink-soft); border: 1px solid var(--border-strong); }
    .upp-btn-ghost:hover { background: var(--cream-dark); color: var(--ink); }
    .upp-btn-primary {
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        color: var(--ink);
        box-shadow: 0 4px 14px rgba(201,168,76,0.32);
    }
    .upp-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 22px rgba(201,168,76,0.42); color: var(--ink); }

    /* ── ALERT ── */
    .upp-alert {
        background: linear-gradient(135deg, rgba(124,185,154,0.16), rgba(168,212,188,0.06));
        border: 1px solid var(--border-strong);
        color: var(--sage-deep);
        border-radius: var(--radius);
        padding: 13px 18px;
        font-size: 13px; font-weight: 500;
        margin-bottom: 18px;
        display: flex; align-items: center; gap: 10px;
    }
    .upp-alert::before { content: '✓'; width: 22px; height: 22px; border-radius: 50%; background: var(--sage); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0; }

    /* ── STATS STRIP ── */
    .upp-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }
    .upp-stat {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 16px 18px;
        position: relative; overflow: hidden;
        transition: all 0.2s;
    }
    .upp-stat:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
    .upp-stat::after {
        content: '';
        position: absolute; left: 0; bottom: 0; right: 0; height: 3px;
    }
    .upp-stat:nth-child(1)::after { background: linear-gradient(90deg, var(--sage), var(--sage-light)); }
    .upp-stat:nth-child(2)::after { background: linear-gradient(90deg, var(--gold), var(--gold-light)); }
    .upp-stat:nth-child(3)::after { background: linear-gradient(90deg, var(--sage-deep), var(--sage)); }
    .upp-stat:nth-child(4)::after { background: linear-gradient(90deg, #5B9BD5, #8FC4F5); }
    .upp-stat-icon {
        width: 30px; height: 30px;
        border-radius: 8px;
        background: var(--sage-pale); color: var(--sage-deep);
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        margin-bottom: 8px;
    }
    .upp-stat:nth-child(2) .upp-stat-icon { background: var(--gold-pale); color: #8B6914; }
    .upp-stat:nth-child(4) .upp-stat-icon { background: #EAF0FF; color: #3660B8; }
    .upp-stat-label {
        font-size: 10.5px; font-weight: 700;
        letter-spacing: 0.08em; text-transform: uppercase;
        color: var(--muted); margin-bottom: 4px;
    }
    .upp-stat-value {
        font-family: 'Playfair Display', serif;
        font-size: 24px; font-weight: 600;
        color: var(--ink); line-height: 1;
    }

    /* ── LAST ORDER (compact) ── */
    .upp-last-order {
        display: flex; align-items: center; gap: 14px;
        padding: 16px 22px;
        background: var(--cream);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        margin: 4px 24px 24px;
    }
    .upp-last-icon {
        width: 42px; height: 42px;
        border-radius: 10px;
        background: var(--gold-pale); color: #8B6914;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .upp-last-text { flex: 1; min-width: 0; }
    .upp-last-id {
        font-family: 'Playfair Display', serif;
        font-size: 16px; font-weight: 600; color: var(--ink);
        line-height: 1.2;
    }
    .upp-last-meta { font-size: 12.5px; color: var(--muted); margin-top: 3px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .upp-last-amount {
        font-family: 'Playfair Display', serif;
        font-size: 17px; font-weight: 600; color: var(--ink);
        flex-shrink: 0;
    }
    .upp-last-link {
        font-size: 12.5px; font-weight: 600; color: var(--sage-deep);
        text-decoration: none; flex-shrink: 0;
        padding: 7px 14px; border-radius: 999px;
        border: 1px solid var(--border-strong);
        transition: all 0.18s;
    }
    .upp-last-link:hover { background: var(--sage); color: #fff; border-color: var(--sage); }

    .upp-status {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 9px; border-radius: 20px;
        font-size: 11px; font-weight: 700;
        text-transform: capitalize;
    }
    .upp-status::before { content: ''; width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .upp-status.selesai { background: var(--sage-pale); color: var(--sage-deep); }
    .upp-status.selesai::before { background: var(--sage); }
    .upp-status.dikirim { background: #EAF0FF; color: #3660B8; }
    .upp-status.dikirim::before { background: #5B9BD5; }
    .upp-status.pending, .upp-status.dibayar { background: var(--gold-pale); color: #8B6914; }
    .upp-status.pending::before, .upp-status.dibayar::before { background: var(--gold); }
    .upp-status.dibatalkan { background: #FEF2F2; color: #9B2C2C; }
    .upp-status.dibatalkan::before { background: #E05252; }

    /* ── RESPONSIVE ── */
    @media (max-width: 920px) {
        .upp-shell-grid { grid-template-columns: 1fr; }
        .upp-sidebar { position: static; }
        .upp-side-nav { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0; padding-bottom: 14px; }
        .upp-side-section { grid-column: 1 / -1; }
        .upp-form-grid { grid-template-columns: 1fr; }
        .upp-form-divider { display: none; }
        .upp-avatar-col { padding-top: 24px; border-top: 1px solid var(--border); flex-direction: row; justify-content: flex-start; align-items: center; gap: 22px; }
        .upp-avatar-actions { align-items: flex-start; }
        .upp-stats { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 540px) {
        .upp-wrap { padding: 22px 16px 60px; }
        .upp-nav-inner { padding: 0 16px; }
        .upp-nav-title { display: none; }
        .upp-nav-right .upp-nav-btn span { display: none; }
        .upp-field-row { grid-template-columns: 1fr; gap: 6px; }
        .upp-field-label { text-align: left; font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; }
        .upp-side-nav { grid-template-columns: 1fr; }
        .upp-card-body { padding: 18px; }
        .upp-stats { grid-template-columns: 1fr 1fr; gap: 10px; }
        .upp-avatar-col { flex-direction: column; align-items: center; }
        .upp-avatar-actions { align-items: center; }
    }
</style>

<div id="upp-shell">

    {{-- ── NAV ── --}}
    <nav class="upp-nav">
        <div class="upp-nav-inner">
            <a href="{{ route('user.dashboard') }}" class="upp-back">← Dashboard</a>
            <span class="upp-nav-title">Akun Saya</span>
            <div class="upp-nav-right">
                <a href="{{ route('orders.index') }}" class="upp-nav-btn">🧾 <span>Pesanan</span></a>
                <a href="{{ route('carts.index') }}" class="upp-nav-btn">🛒 <span>Keranjang</span></a>
            </div>
        </div>
    </nav>

    <div class="upp-wrap">

        @if (session('success'))
            <div class="upp-alert">{{ session('success') }}</div>
        @endif

        <div class="upp-shell-grid">

            {{-- ════ SIDEBAR ════ --}}
            <aside class="upp-sidebar">
                <div class="upp-side-head">
                    <div class="upp-side-avatar">
                        @if ($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                        @else
                            {{ strtoupper(mb_substr($user->name ?? 'U', 0, 1)) }}
                        @endif
                    </div>
                    <div style="min-width:0;flex:1;">
                        <div class="upp-side-name" title="{{ $user->name }}">{{ $user->name }}</div>
                        <a href="#upp-form" class="upp-side-edit">✎ Ubah Profil</a>
                    </div>
                </div>

                <div class="upp-side-nav">
                    <div class="upp-side-section"><span class="ic">👤</span> Akun Saya</div>
                    <a href="#upp-form" class="upp-side-link is-active">
                        <span class="lk-ic">📝</span>
                        <span class="lk-text">Profil</span>
                    </a>
                    <a href="#upp-form" class="upp-side-link">
                        <span class="lk-ic">🔐</span>
                        <span class="lk-text">Ubah Password</span>
                    </a>

                    <div class="upp-side-section"><span class="ic">🛍</span> Belanja</div>
                    <a href="{{ route('orders.index') }}" class="upp-side-link">
                        <span class="lk-ic">🧾</span>
                        <span class="lk-text">Pesanan Saya</span>
                        @if ($activeOrderCount > 0)<span class="lk-badge">{{ $activeOrderCount }}</span>@endif
                    </a>
                    <a href="{{ route('carts.index') }}" class="upp-side-link">
                        <span class="lk-ic">🛒</span>
                        <span class="lk-text">Keranjang</span>
                        @if ($cartItemCount > 0)<span class="lk-badge">{{ $cartItemCount }}</span>@endif
                    </a>
                    <a href="{{ route('user.dashboard') }}" class="upp-side-link">
                        <span class="lk-ic">🏠</span>
                        <span class="lk-text">Beranda</span>
                    </a>

                    <div class="upp-side-section"><span class="ic">⚙</span> Lainnya</div>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0">
                        @csrf
                        <button type="submit" class="upp-side-link" style="background:none;border:none;width:100%;text-align:left;cursor:pointer;font-family:inherit;color:#a13a4d;border-left-color:transparent;">
                            <span class="lk-ic">↩</span>
                            <span class="lk-text">Keluar</span>
                        </button>
                    </form>
                </div>
            </aside>

            {{-- ════ MAIN ════ --}}
            <div class="upp-main">

                {{-- Stats strip --}}
                <div class="upp-stats">
                    <div class="upp-stat">
                        <div class="upp-stat-icon">🧾</div>
                        <div class="upp-stat-label">Total Pesanan</div>
                        <div class="upp-stat-value">{{ $orderCount }}</div>
                    </div>
                    <div class="upp-stat">
                        <div class="upp-stat-icon">⏳</div>
                        <div class="upp-stat-label">Sedang Aktif</div>
                        <div class="upp-stat-value">{{ $activeOrderCount }}</div>
                    </div>
                    <div class="upp-stat">
                        <div class="upp-stat-icon">✓</div>
                        <div class="upp-stat-label">Selesai</div>
                        <div class="upp-stat-value">{{ $completedOrderCount }}</div>
                    </div>
                    <div class="upp-stat">
                        <div class="upp-stat-icon">💰</div>
                        <div class="upp-stat-label">Total Belanja</div>
                        <div class="upp-stat-value" style="font-size:18px;">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
                    </div>
                </div>

                {{-- Last order quick card --}}
                @if ($lastOrder)
                <div class="upp-card" style="overflow:visible;">
                    <div class="upp-card-head">
                        <div class="upp-card-title">Pesanan Terakhir</div>
                        <div class="upp-card-sub">Cek progres pengiriman pesanan terbarumu.</div>
                    </div>
                    <div class="upp-last-order">
                        <div class="upp-last-icon">🧾</div>
                        <div class="upp-last-text">
                            <div class="upp-last-id">Pesanan #{{ sprintf('%04d', $lastOrder->id) }}</div>
                            <div class="upp-last-meta">
                                <span class="upp-status {{ $lastOrder->status }}">{{ $lastOrder->status }}</span>
                                <span>·</span>
                                <span>{{ $lastOrder->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="upp-last-amount">Rp {{ number_format($lastOrder->total_harga, 0, ',', '.') }}</div>
                        <a href="{{ route('orders.show', $lastOrder) }}" class="upp-last-link">Detail →</a>
                    </div>
                </div>
                @endif

                {{-- Profile form (Shopee style) --}}
                <div class="upp-card" id="upp-form">
                    <div class="upp-card-head">
                        <div class="upp-card-title">Profil Saya</div>
                        <div class="upp-card-sub">Kelola informasi profil agar akun lebih aman dan personal.</div>
                    </div>

                    <div class="upp-card-body">
                        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                            @csrf
                            @method('PATCH')

                            <div class="upp-form-grid">
                                {{-- KIRI: fields --}}
                                <div class="upp-fields">
                                    <div class="upp-field-row">
                                        <label class="upp-field-label" for="name">Nama</label>
                                        <div class="upp-field-control">
                                            <input type="text" id="name" name="name" class="upp-input @error('name') is-error @enderror" value="{{ old('name', $user->name) }}" maxlength="255" required>
                                            @error('name')<div class="upp-error">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="upp-field-row">
                                        <label class="upp-field-label" for="email">Email</label>
                                        <div class="upp-field-control">
                                            <input type="email" id="email" name="email" class="upp-input @error('email') is-error @enderror" value="{{ old('email', $user->email) }}" required>
                                            @error('email')<div class="upp-error">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="upp-field-row">
                                        <label class="upp-field-label" for="nomor_telepon">No. Telepon</label>
                                        <div class="upp-field-control">
                                            <input type="text" id="nomor_telepon" name="nomor_telepon" class="upp-input @error('nomor_telepon') is-error @enderror" value="{{ old('nomor_telepon', $user->nomor_telepon) }}" placeholder="Contoh: 0812xxxxxxx">
                                            @error('nomor_telepon')<div class="upp-error">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="upp-field-row">
                                        <label class="upp-field-label" for="alamat">Alamat</label>
                                        <div class="upp-field-control">
                                            <input type="text" id="alamat" name="alamat" class="upp-input @error('alamat') is-error @enderror" value="{{ old('alamat', $user->alamat) }}" placeholder="Alamat pengiriman">
                                            @error('alamat')<div class="upp-error">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="upp-field-row">
                                        <span class="upp-field-label">Jenis Kelamin</span>
                                        <div class="upp-field-control">
                                            <div class="upp-radio-row">
                                                <label class="upp-radio">
                                                    <input type="radio" name="jenis_kelamin" value="laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) === 'laki-laki' ? 'checked' : '' }}>
                                                    <span>Laki-laki</span>
                                                </label>
                                                <label class="upp-radio">
                                                    <input type="radio" name="jenis_kelamin" value="perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) === 'perempuan' ? 'checked' : '' }}>
                                                    <span>Perempuan</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="upp-field-row">
                                        <label class="upp-field-label" for="tanggal_lahir">Tanggal Lahir</label>
                                        <div class="upp-field-control">
                                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="upp-input @error('tanggal_lahir') is-error @enderror" value="{{ old('tanggal_lahir', optional($user->tanggal_lahir)->format('Y-m-d')) }}">
                                            @error('tanggal_lahir')<div class="upp-error">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="upp-field-row" style="border-top:1px dashed var(--border);padding-top:14px;margin-top:6px;">
                                        <label class="upp-field-label" for="password">Password Baru</label>
                                        <div class="upp-field-control">
                                            <input type="password" id="password" name="password" class="upp-input @error('password') is-error @enderror" placeholder="Kosongkan jika tidak ingin diubah" autocomplete="new-password">
                                            <div class="upp-hint">Min. 8 karakter. Kosongkan jika tidak ingin ubah password.</div>
                                            @error('password')<div class="upp-error">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="upp-field-row">
                                        <label class="upp-field-label" for="password_confirmation">Konfirmasi</label>
                                        <div class="upp-field-control">
                                            <input type="password" id="password_confirmation" name="password_confirmation" class="upp-input" placeholder="Ulangi password baru" autocomplete="new-password">
                                        </div>
                                    </div>
                                </div>

                                {{-- DIVIDER --}}
                                <div class="upp-form-divider"></div>

                                {{-- KANAN: avatar --}}
                                <div class="upp-avatar-col">
                                    <div class="upp-avatar-display" id="avatarPreview">
                                        @if ($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                                        @else
                                            {{ strtoupper(mb_substr($user->name ?? 'U', 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="upp-avatar-actions">
                                        <label for="avatarInput" class="upp-avatar-btn">📷 Pilih Foto</label>
                                        <input type="file" id="avatarInput" name="avatar" accept="image/jpeg,image/png,image/jpg,image/webp">
                                        <div class="upp-avatar-hint">
                                            Ukuran maksimal <strong>2 MB</strong><br>
                                            Format: JPG, JPEG, PNG, WEBP
                                        </div>
                                        @error('avatar')<div class="upp-error" style="text-align:center;">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            <div class="upp-form-actions">
                                <a href="{{ route('user.dashboard') }}" class="upp-btn upp-btn-ghost">Batal</a>
                                <button type="submit" class="upp-btn upp-btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
(function () {
    const input = document.getElementById('avatarInput');
    const preview = document.getElementById('avatarPreview');
    if (!input || !preview) return;

    input.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            alert('Foto terlalu besar. Maksimal 2 MB.');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = (ev) => {
            preview.innerHTML = '<img src="' + ev.target.result + '" alt="preview">';
        };
        reader.readAsDataURL(file);
    });
})();
</script>
@endsection
