@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

    :root {
        --ink:        #1a2e1a;
        --ink-soft:   #3d5c3d;
        --ink-muted:  #6b8c6b;
        --parchment:  #faf6ed;
        --parchment2: #f3ecda;
        --parchment3: #e8dfc6;
        --moss:       #4a7c4a;
        --moss-light: #6b9e5e;
        --moss-pale:  #c8ddb8;
        --gold:       #c8922a;
        --gold-pale:  #f0d898;
        --cream:      #fffdf7;
        --line:       rgba(26, 46, 26, 0.08);
        --line-md:    rgba(26, 46, 26, 0.16);
        --line-strong:rgba(26, 46, 26, 0.24);
        --shadow-xs:  0 1px 4px rgba(26,46,26,0.06);
        --shadow-sm:  0 4px 16px rgba(26,46,26,0.08);
        --shadow-md:  0 10px 32px rgba(26,46,26,0.10);
        --shadow-bar: 0 -8px 28px rgba(26,46,26,0.12);
        --r-sm:  10px;
        --r-md:  16px;
        --r-lg:  20px;
    }

    .user-cart-page .navbar { display: none; }
    .user-cart-page main.py-4 { padding: 0 !important; }
    *, *::before, *::after { box-sizing: border-box; }

    /* ── PAGE ── */
    .cart-page {
        min-height: 100vh;
        background: linear-gradient(160deg, #f5f0e4 0%, #ede5cf 60%, #e4d9be 100%);
        font-family: 'DM Sans', sans-serif;
        color: var(--ink);
        padding-bottom: 120px; /* space for sticky bar */
    }

    /* ── TOPBAR ── */
    .cart-topbar {
        position: sticky;
        top: 0;
        z-index: 30;
        background: rgba(250, 246, 237, 0.92);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border-bottom: 1px solid var(--line-md);
    }
    .cart-topbar-inner {
        max-width: 1100px;
        margin: 0 auto;
        padding: 14px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .back-btn {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: 13px; font-weight: 600; color: var(--ink-soft);
        text-decoration: none;
        padding: 7px 14px 7px 10px;
        border-radius: 999px;
        border: 1px solid var(--line-md);
        background: var(--cream);
        transition: all .2s;
    }
    .back-btn:hover { color: var(--moss); border-color: var(--moss-pale); background: #f0f7ea; }
    .back-btn:hover svg { transform: translateX(-3px); }
    .back-btn svg { transition: transform .2s; flex-shrink: 0; }
    .topbar-brand { font-family: 'DM Serif Display', serif; font-size: 17px; color: var(--ink); letter-spacing: -.02em; }
    .topbar-pill {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 12px; font-weight: 600; color: var(--moss);
        background: rgba(74,124,74,0.10);
        border: 1px solid rgba(74,124,74,0.18);
        border-radius: 999px;
        padding: 5px 12px;
    }

    /* ── WRAP ── */
    .cart-wrap {
        max-width: 1100px;
        margin: 0 auto;
        padding: 24px 24px 32px;
    }

    /* ── ALERT ── */
    .cart-alert {
        background: rgba(74,124,74,0.10);
        border: 1px solid rgba(74,124,74,0.22);
        border-radius: var(--r-sm);
        padding: 12px 16px;
        font-size: 13px; color: var(--moss);
        margin-bottom: 16px; font-weight: 500;
        display: flex; align-items: center; gap: 10px;
    }
    .cart-alert::before {
        content: '✓'; width: 22px; height: 22px;
        border-radius: 50%; background: var(--moss); color: #fff;
        display: inline-flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 12px; flex-shrink: 0;
    }
    .cart-alert.is-error::before { content: '!'; background: #b8364c; }

    /* ── HEADER (column titles) ── */
    .cart-head {
        background: var(--cream);
        border: 1px solid var(--line-md);
        border-radius: var(--r-md);
        padding: 14px 22px;
        margin-bottom: 12px;
        display: grid;
        grid-template-columns: 28px 1.6fr 130px 100px 130px 60px;
        gap: 14px;
        align-items: center;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--ink-muted);
    }
    .cart-head-cell { display: flex; align-items: center; }
    .cart-head .ch-text { color: var(--ink-soft); font-weight: 700; }

    /* ── CHECKBOX ── */
    .cb {
        appearance: none; -webkit-appearance: none;
        width: 18px; height: 18px;
        border: 1.6px solid var(--line-strong);
        border-radius: 5px;
        background: #fff;
        display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: all 0.18s;
        flex-shrink: 0;
        position: relative;
    }
    .cb:checked {
        background: var(--moss);
        border-color: var(--moss);
    }
    .cb:checked::after {
        content: '';
        position: absolute;
        left: 5px; top: 1px;
        width: 5px; height: 9px;
        border: solid #fff;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    .cb:hover { border-color: var(--moss); }

    /* ── SHOP CARD (per UMKM) ── */
    .shop-card {
        background: var(--cream);
        border: 1px solid var(--line-md);
        border-radius: var(--r-md);
        margin-bottom: 12px;
        overflow: hidden;
    }
    .shop-head {
        display: flex; align-items: center; gap: 12px;
        padding: 16px 22px;
        border-bottom: 1px solid var(--line);
        background: linear-gradient(180deg, var(--parchment2), var(--cream));
    }
    .shop-head .cb { margin-right: 4px; }
    .shop-tag {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 10.5px; font-weight: 700; letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--gold);
        padding: 3px 9px; border-radius: 4px;
        background: var(--gold-pale);
    }
    .shop-name {
        font-family: 'DM Serif Display', serif;
        font-size: 15px;
        color: var(--ink);
        letter-spacing: -.01em;
    }
    .shop-arrow { color: var(--ink-muted); transition: transform 0.18s; }
    .shop-head:hover .shop-arrow { transform: translateX(3px); color: var(--moss); }

    /* ── ITEM ROW ── */
    .item-row {
        display: grid;
        grid-template-columns: 28px 1.6fr 130px 100px 130px 60px;
        gap: 14px;
        align-items: center;
        padding: 18px 22px;
        border-top: 1px solid var(--line);
        transition: background 0.18s;
    }
    .item-row:first-of-type { border-top: none; }
    .item-row:hover { background: rgba(74,124,74,0.03); }
    .item-row.is-habis { opacity: 0.7; background: rgba(160,64,64,0.025); }

    .item-info {
        display: flex; gap: 14px; align-items: center;
        min-width: 0;
    }
    .item-img-wrap {
        width: 76px; height: 76px;
        border-radius: var(--r-sm);
        overflow: hidden;
        background: var(--parchment);
        flex-shrink: 0;
        border: 1px solid var(--line);
        padding: 6px;
        display: flex; align-items: center; justify-content: center;
    }
    .item-img-wrap img { width: 100%; height: 100%; object-fit: contain; display: block; }
    .item-img-placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        color: var(--ink-muted); font-size: 11px;
    }
    .item-text { min-width: 0; flex: 1; }
    .item-name {
        font-size: 14px; font-weight: 600;
        color: var(--ink);
        line-height: 1.4;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .item-meta {
        display: flex; flex-wrap: wrap; gap: 6px;
    }
    .item-badge {
        font-size: 10.5px; font-weight: 600;
        padding: 3px 8px;
        border-radius: 4px;
        background: var(--parchment2);
        color: var(--ink-soft);
        border: 1px solid var(--line);
    }
    .item-badge.b-stock {
        background: rgba(74,124,74,0.10);
        color: var(--moss);
        border-color: rgba(74,124,74,0.22);
    }
    .item-badge.b-habis {
        background: linear-gradient(135deg, #d1546a, #b8364c);
        color: #fff;
        border-color: transparent;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .item-price {
        font-size: 14px; font-weight: 700; color: var(--ink);
    }
    .item-price-unit { font-size: 11px; color: var(--ink-muted); font-weight: 500; margin-top: 2px; }

    /* qty stepper */
    .qty-stepper {
        display: inline-flex; align-items: stretch;
        border: 1px solid var(--line-md);
        border-radius: 8px;
        background: #fff;
        height: 32px;
        overflow: hidden;
    }
    .qty-stepper form { margin: 0; display: flex; }
    .qty-btn {
        width: 30px; height: 30px;
        border: none; background: transparent;
        cursor: pointer;
        font-size: 14px; font-weight: 700;
        color: var(--ink-soft);
        display: flex; align-items: center; justify-content: center;
        transition: background .15s, color .15s;
    }
    .qty-btn:hover { background: var(--parchment2); color: var(--moss); }
    .qty-btn.minus:hover { color: #a04040; }
    .qty-num {
        min-width: 38px;
        text-align: center;
        font-size: 13px; font-weight: 700; color: var(--ink);
        border-left: 1px solid var(--line-md);
        border-right: 1px solid var(--line-md);
        line-height: 30px;
    }

    .item-subtotal {
        font-family: 'DM Serif Display', serif;
        font-size: 17px;
        color: var(--moss);
        letter-spacing: -.02em;
        font-weight: 500;
        text-align: right;
    }

    .del-btn {
        width: 36px; height: 36px;
        border: none;
        background: transparent;
        border-radius: 8px;
        cursor: pointer;
        color: var(--ink-muted);
        display: inline-flex; align-items: center; justify-content: center;
        transition: all .18s;
    }
    .del-btn:hover { background: #fff0f0; color: #a04040; }

    /* ── EMPTY ── */
    .empty-card {
        background: var(--cream);
        border: 1px dashed var(--line-md);
        border-radius: var(--r-lg);
        padding: 64px 32px; text-align: center;
    }
    .empty-icon {
        width: 64px; height: 64px;
        background: var(--parchment2); border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        margin-bottom: 18px;
    }
    .empty-title { font-family: 'DM Serif Display', serif; font-size: 24px; color: var(--ink); margin-bottom: 6px; }
    .empty-sub { font-size: 14px; color: var(--ink-muted); margin-bottom: 22px; }
    .empty-cta {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: 14px; font-weight: 600; color: #fff;
        text-decoration: none;
        background: var(--moss);
        border-radius: 999px;
        padding: 11px 24px;
        transition: all .18s;
        box-shadow: 0 4px 14px rgba(74,124,74,0.30);
    }
    .empty-cta:hover { background: #3d6a3d; transform: translateY(-1px); color: #fff; box-shadow: 0 6px 18px rgba(74,124,74,0.40); }

    /* ── BOTTOM TOOLBAR (sticky like Shopee) ── */
    .cart-toolbar {
        position: fixed;
        bottom: 16px;
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 32px);
        max-width: 1100px;
        background: var(--cream);
        border: 1px solid var(--line-md);
        border-radius: var(--r-md);
        padding: 14px 22px;
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 22px;
        align-items: center;
        box-shadow: var(--shadow-bar);
        z-index: 25;
    }
    .toolbar-select {
        display: inline-flex; align-items: center; gap: 10px;
        font-size: 13px; color: var(--ink-soft); font-weight: 500;
        cursor: pointer;
    }
    .toolbar-select strong { font-weight: 700; color: var(--ink); }
    .toolbar-mid { display: flex; align-items: center; gap: 18px; flex-wrap: wrap; }
    .toolbar-mid-info { font-size: 13px; color: var(--ink-soft); font-weight: 500; }
    .toolbar-mid-info strong { color: var(--ink); font-weight: 700; }
    .toolbar-spacer { flex: 1; }
    .toolbar-total-block {
        display: flex; align-items: baseline; gap: 8px;
        text-align: right;
    }
    .toolbar-total-label { font-size: 13px; color: var(--ink-soft); }
    .toolbar-total-amount {
        font-family: 'DM Serif Display', serif;
        font-size: 26px;
        color: var(--moss);
        letter-spacing: -.025em;
        line-height: 1;
        font-weight: 500;
    }
    .toolbar-total-amount span {
        font-family: 'DM Sans', sans-serif;
        font-size: 13px; color: var(--ink-muted);
        font-weight: 500; margin-right: 3px;
    }

    .checkout-btn {
        display: inline-flex; align-items: center; gap: 10px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px; font-weight: 700;
        color: var(--ink);
        background: linear-gradient(135deg, var(--gold-pale), #f5d68a);
        border: none; border-radius: 999px;
        height: 46px; padding: 0 28px; cursor: pointer;
        transition: all .2s;
        white-space: nowrap;
        box-shadow: 0 4px 16px rgba(200,146,42,0.32);
        letter-spacing: 0.01em;
        text-decoration: none;
    }
    .checkout-btn:hover {
        background: linear-gradient(135deg, #f0d070, #e8c860);
        transform: translateY(-1px);
        box-shadow: 0 8px 24px rgba(200,146,42,0.42);
        color: var(--ink);
    }
    .checkout-btn .ck-count {
        font-size: 11.5px; font-weight: 600;
        background: rgba(26,46,26,0.16); color: var(--ink);
        border-radius: 999px;
        padding: 2px 8px;
    }
    .checkout-btn:disabled {
        opacity: 0.5; cursor: not-allowed;
        background: var(--parchment3);
        color: var(--ink-muted);
        box-shadow: none;
    }

    /* ── RECO SECTION ── */
    .reco-section { margin-top: 28px; }
    .reco-section-head {
        display: flex; align-items: baseline; justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
    }
    .reco-section-title {
        font-family: 'DM Serif Display', serif;
        font-size: 22px;
        color: var(--ink);
        letter-spacing: -.02em;
        margin: 0 0 3px;
    }
    .reco-section-title em { font-style: italic; color: var(--moss); }
    .reco-section-sub { font-size: 13px; color: var(--ink-muted); }

    .reco-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }
    .reco-card {
        background: var(--cream);
        border: 1px solid var(--line-md);
        border-radius: var(--r-md);
        overflow: hidden;
        transition: box-shadow .22s, transform .22s, border-color .22s;
        position: relative;
    }
    .reco-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
        border-color: var(--moss-pale);
    }
    .reco-img-wrap { position: relative; background: var(--parchment); padding: 10px; }
    .reco-img {
        width: 100%; aspect-ratio: 1; object-fit: contain;
        background: transparent; display: block;
    }
    .reco-img-ph {
        width: 100%; aspect-ratio: 1; background: var(--parchment3);
        display: flex; align-items: center; justify-content: center;
        color: var(--ink-muted); font-size: 12px;
    }
    .reco-habis-badge {
        position: absolute; top: 10px; right: 10px;
        background: linear-gradient(135deg, #d1546a, #b8364c);
        color: #fff;
        font-size: 10.5px; font-weight: 700;
        padding: 4px 10px; border-radius: 20px;
        letter-spacing: 0.06em; text-transform: uppercase;
        box-shadow: 0 2px 8px rgba(209,84,106,0.4);
    }
    .reco-body { padding: 12px 14px 14px; }
    .reco-name {
        font-size: 13px; font-weight: 600; color: var(--ink);
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 36px;
        margin-bottom: 6px;
    }
    .reco-price {
        font-family: 'DM Serif Display', serif;
        font-size: 16px; color: var(--moss);
        letter-spacing: -.01em;
        font-weight: 500;
        margin-bottom: 6px;
    }
    .reco-rating { display: flex; align-items: center; gap: 5px; margin-bottom: 10px; }
    .reco-stars { color: var(--gold); font-size: 13px; letter-spacing: 1px; line-height: 1; }
    .reco-rating-val { font-size: 12px; font-weight: 600; color: var(--moss); }
    .reco-add-btn {
        width: 100%;
        font-family: 'DM Sans', sans-serif;
        font-size: 12px; font-weight: 700;
        color: var(--moss);
        background: rgba(74,124,74,0.10);
        border: 1px solid rgba(74,124,74,0.22);
        border-radius: 999px;
        height: 32px; cursor: pointer;
        transition: all .18s;
        display: inline-flex; align-items: center; justify-content: center; gap: 6px;
    }
    .reco-add-btn:hover {
        background: var(--moss); color: #fff;
        border-color: var(--moss);
        box-shadow: 0 4px 12px rgba(74,124,74,0.28);
    }
    .reco-add-btn:disabled {
        background: rgba(160,64,64,0.08); color: #a04040;
        border-color: rgba(160,64,64,0.18);
        cursor: not-allowed;
    }
    .reco-add-btn:disabled:hover { background: rgba(160,64,64,0.08); color: #a04040; box-shadow: none; }

    /* ── WEDJANGKU FEATURED ── */
    .wedjangku-card {
        background: linear-gradient(135deg, var(--ink) 0%, #263d26 100%);
        border-radius: var(--r-md); padding: 18px 22px;
        display: grid; grid-template-columns: 88px 1fr auto;
        gap: 18px; align-items: center; margin-bottom: 16px;
        position: relative; overflow: hidden;
    }
    .wedjangku-card::after {
        content: ''; position: absolute; top: -30px; right: -30px;
        width: 140px; height: 140px;
        background: radial-gradient(circle, rgba(200,146,42,0.20) 0%, transparent 70%);
        pointer-events: none;
    }
    .wedjangku-img { width: 88px; height: 78px; border-radius: 12px; object-fit: contain; background: rgba(255,255,255,0.92); padding: 8px; }
    .wedjangku-img-ph {
        width: 88px; height: 78px; border-radius: 12px;
        background: rgba(255,255,255,0.08);
        display: flex; align-items: center; justify-content: center;
        color: rgba(255,255,255,0.3); font-size: 11px;
    }
    .wedjangku-label { font-size: 10px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--gold-pale); opacity: .8; margin-bottom: 5px; }
    .wedjangku-name { font-family: 'DM Serif Display', serif; font-size: 17px; color: #fff; letter-spacing: -.02em; margin-bottom: 3px; line-height: 1.2; }
    .wedjangku-price { font-size: 13px; color: var(--gold-pale); font-weight: 500; }
    .wedjangku-add-btn {
        display: inline-flex; align-items: center; gap: 7px;
        font-size: 13px; font-weight: 700; color: var(--ink);
        background: var(--gold-pale); border: none; border-radius: 999px;
        height: 38px; padding: 0 18px; cursor: pointer; white-space: nowrap;
        transition: all .18s;
        box-shadow: 0 4px 12px rgba(200,146,42,0.25);
        flex-shrink: 0;
    }
    .wedjangku-add-btn:hover { background: #f0d070; transform: translateY(-1px); }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
        .cart-head { display: none; }
        .item-row {
            grid-template-columns: 28px 1fr;
            gap: 14px;
            row-gap: 14px;
            padding: 16px 18px;
        }
        .item-row > .cb-cell { grid-row: 1 / span 5; align-self: flex-start; padding-top: 4px; }
        .item-info { grid-column: 2; }
        .item-price-cell, .item-qty-cell, .item-subtotal-cell, .item-action-cell {
            grid-column: 2;
            display: flex; align-items: center; justify-content: space-between;
            font-size: 13px;
        }
        .item-price-cell::before { content: 'Harga'; font-size: 12px; color: var(--ink-muted); font-weight: 500; }
        .item-qty-cell::before { content: 'Jumlah'; font-size: 12px; color: var(--ink-muted); font-weight: 500; }
        .item-subtotal-cell::before { content: 'Subtotal'; font-size: 12px; color: var(--ink-muted); font-weight: 500; }
        .item-action-cell { justify-content: flex-end; }
        .reco-grid { grid-template-columns: repeat(2, 1fr); }
        .cart-toolbar {
            grid-template-columns: 1fr;
            gap: 12px;
        }
        .toolbar-mid { justify-content: space-between; }
        .toolbar-total-block { justify-content: space-between; width: 100%; }
        .checkout-btn { width: 100%; justify-content: center; }
        .topbar-brand { display: none; }
    }
    @media (max-width: 520px) {
        .cart-wrap { padding: 16px 12px 28px; }
        .item-img-wrap { width: 64px; height: 64px; }
        .reco-grid { grid-template-columns: 1fr 1fr; }
        .wedjangku-card { grid-template-columns: 64px 1fr; }
        .wedjangku-img, .wedjangku-img-ph { width: 64px; height: 56px; }
        .wedjangku-add-btn { grid-column: 1 / -1; width: 100%; justify-content: center; }
    }
</style>

<script>document.body.classList.add('user-cart-page');</script>

<div class="cart-page">

    {{-- TOPBAR --}}
    <div class="cart-topbar">
        <div class="cart-topbar-inner">
            <a href="{{ route('user.dashboard') }}" class="back-btn">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Kembali Belanja
            </a>
            <span class="topbar-brand">Keranjang Saya</span>
            <span class="topbar-pill">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M1 1h1.5l1 5.5h5l1-4H3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                {{ $cartItems->sum('qty') }} item
            </span>
        </div>
    </div>

    <div class="cart-wrap">

        @if (session('success'))
            <div class="cart-alert">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="cart-alert is-error" style="background:rgba(184,54,76,0.08);border-color:rgba(184,54,76,0.25);color:#a13a4d;">
                {{ session('error') }}
            </div>
        @endif

        @php $total = 0; $totalItems = 0; $totalActiveProducts = 0; @endphp

        @if ($cartItems->isEmpty())
            <div class="empty-card">
                <div class="empty-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="#6b8c6b" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3 6h18M16 10a4 4 0 01-8 0" stroke="#6b8c6b" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="empty-title">Keranjang masih kosong</h3>
                <p class="empty-sub">Yuk temukan produk favoritmu dan tambahkan ke keranjang.</p>
                <a href="{{ route('user.dashboard') }}" class="empty-cta">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 2l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Mulai Belanja
                </a>
            </div>
        @else
            {{-- Form kosong (tetap berdiri sendiri) — checkbox & tombol checkout submit ke sini --}}
            <form action="{{ route('carts.checkout') }}" method="POST" id="checkoutForm">@csrf</form>

            {{-- COLUMN HEADER --}}
            <div class="cart-head">
                <div class="cart-head-cell"><input type="checkbox" class="cb cb-select-all" id="cbSelectAllTop" checked aria-label="Pilih semua"></div>
                <div class="cart-head-cell"><span class="ch-text">Produk</span></div>
                <div class="cart-head-cell"><span class="ch-text">Harga Satuan</span></div>
                <div class="cart-head-cell"><span class="ch-text">Jumlah</span></div>
                <div class="cart-head-cell" style="justify-content:flex-end;"><span class="ch-text">Subtotal</span></div>
                <div class="cart-head-cell"><span class="ch-text">Aksi</span></div>
            </div>

            <div style="font-size:12.5px;color:var(--ink-soft);margin:-4px 4px 12px;">
                <span style="display:inline-flex;align-items:center;gap:6px;">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="1.4"/><path d="M7 4.5v3M7 9.5v.01" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                    Centang produk yang ingin dibayar. Hanya produk yang dicentang yang akan masuk ke pesanan.
                </span>
            </div>

            {{-- SHOP / UMKM CARD --}}
            <div class="shop-card">
                @php
                    $firstProductWithUmkm = $cartItems->first(fn($i) => $i->product && $i->product->umkm);
                    $namaToko = $firstProductWithUmkm?->product?->umkm?->nama_umkm ?? 'Toko UMKM';
                @endphp
                <div class="shop-head">
                    <input type="checkbox" class="cb cb-select-all" id="cbSelectAllShop" checked aria-label="Pilih semua produk dari toko">
                    <span class="shop-tag">★ Pilihan</span>
                    <span class="shop-name">{{ $namaToko }}</span>
                    <span style="margin-left:auto;font-size:11.5px;color:var(--ink-muted);">UMKM resmi</span>
                </div>

                @foreach ($cartItems as $item)
                    @if (!$item->product) @continue @endif
                    @php
                        $subtotal = $item->product->harga * $item->qty;
                        $habis = $item->product->stok <= 0;
                        $totalItems += $item->qty;
                        if (!$habis) {
                            $totalActiveProducts++;
                            $total += $subtotal;
                        }
                    @endphp

                    <div class="item-row {{ $habis ? 'is-habis' : '' }}" data-subtotal="{{ $subtotal }}" data-qty="{{ $item->qty }}" data-habis="{{ $habis ? '1' : '0' }}">
                        <div class="cb-cell">
                            <input type="checkbox"
                                   class="cb cb-item"
                                   name="cart_item_ids[]"
                                   value="{{ $item->id }}"
                                   form="checkoutForm"
                                   {{ $habis ? '' : 'checked' }}
                                   {{ $habis ? 'disabled' : '' }}
                                   aria-label="Pilih {{ $item->product->nama_produk }}">
                        </div>

                        <div class="item-info">
                            <div class="item-img-wrap">
                                @if ($item->product->gambar)
                                    <img src="{{ asset('storage/' . $item->product->gambar) }}" alt="{{ $item->product->nama_produk }}" style="{{ $habis ? 'filter:grayscale(0.7) opacity(0.7);' : '' }}">
                                @else
                                    <div class="item-img-placeholder">No Image</div>
                                @endif
                            </div>
                            <div class="item-text">
                                <div class="item-name">{{ $item->product->nama_produk }}</div>
                                <div class="item-meta">
                                    @if ($habis)
                                        <span class="item-badge b-habis">Stok habis</span>
                                    @else
                                        <span class="item-badge b-stock">Stok {{ $item->product->stok }}</span>
                                        <span class="item-badge">Siap kirim</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="item-price-cell">
                            <div>
                                <div class="item-price">Rp {{ number_format($item->product->harga, 0, ',', '.') }}</div>
                                <div class="item-price-unit">/ pcs</div>
                            </div>
                        </div>

                        <div class="item-qty-cell">
                            <div class="qty-stepper">
                                <form action="{{ route('carts.decrement') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                    <input type="hidden" name="qty" value="1">
                                    <button type="submit" class="qty-btn minus" aria-label="Kurangi">−</button>
                                </form>
                                <span class="qty-num">{{ $item->qty }}</span>
                                <form action="{{ route('carts.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                    <input type="hidden" name="qty" value="1">
                                    <button type="submit" class="qty-btn plus" aria-label="Tambah" {{ $habis ? 'disabled' : '' }}>+</button>
                                </form>
                            </div>
                        </div>

                        <div class="item-subtotal-cell" style="justify-content:flex-end;">
                            <span class="item-subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="item-action-cell">
                            <form action="{{ route('carts.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                <button type="submit" class="del-btn" aria-label="Hapus produk" onclick="return confirm('Hapus produk ini dari keranjang?');">
                                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                        <path d="M3 4h9M6 4V2.5h3V4M5.5 4l.5 7.5h3l.5-7.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- REKOMENDASI --}}
        <div class="reco-section">
            <div class="reco-section-head">
                <div>
                    <h3 class="reco-section-title">Mungkin <em>kamu suka</em></h3>
                    <p class="reco-section-sub">Pilihan herbal terbaik untuk melengkapi belanjamu.</p>
                </div>
            </div>

            @if ($wedjangkuProduct)
                @php $wHabis = $wedjangkuProduct->stok <= 0; @endphp
                <div class="wedjangku-card">
                    @if ($wedjangkuProduct->gambar)
                        <img src="{{ asset('storage/' . $wedjangkuProduct->gambar) }}" alt="{{ $wedjangkuProduct->nama_produk }}" class="wedjangku-img" style="{{ $wHabis ? 'filter:grayscale(0.7) opacity(0.65);' : '' }}">
                    @else
                        <div class="wedjangku-img-ph">No Image</div>
                    @endif
                    <div>
                        <div class="wedjangku-label">{{ $wHabis ? 'Stok Habis' : 'Pilihan utama' }}</div>
                        <div class="wedjangku-name">{{ $wedjangkuProduct->nama_produk }}</div>
                        <div class="wedjangku-price">Rp {{ number_format($wedjangkuProduct->harga, 0, ',', '.') }} &middot; {{ $wHabis ? 'Habis' : 'Stok ' . $wedjangkuProduct->stok }}</div>
                    </div>
                    @if ($wHabis)
                        <button type="button" class="wedjangku-add-btn" disabled style="opacity:0.55;cursor:not-allowed;background:#d1546a;border-color:transparent;color:#fff;">Habis</button>
                    @else
                        <form action="{{ route('carts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $wedjangkuProduct->id }}">
                            <input type="hidden" name="qty" value="1">
                            <button type="submit" class="wedjangku-add-btn">
                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><path d="M6.5 2v9M2 6.5h9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                Tambah
                            </button>
                        </form>
                    @endif
                </div>
            @endif

            <div class="reco-grid">
                @forelse ($recommendedProducts as $product)
                    @php $rHabis = $product->stok <= 0; @endphp
                    <div class="reco-card">
                        <div class="reco-img-wrap">
                            @if ($product->gambar)
                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="reco-img" style="{{ $rHabis ? 'filter:grayscale(0.7) opacity(0.65);' : '' }}">
                            @else
                                <div class="reco-img-ph">No Image</div>
                            @endif
                            @if ($rHabis)
                                <span class="reco-habis-badge">Habis</span>
                            @endif
                        </div>
                        <div class="reco-body">
                            <div class="reco-name">{{ $product->nama_produk }}</div>
                            <div class="reco-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                            <div class="reco-rating">
                                <span class="reco-stars">★★★★★</span>
                                <span class="reco-rating-val">4.9</span>
                            </div>
                            @if ($rHabis)
                                <button type="button" class="reco-add-btn" disabled>Stok habis</button>
                            @else
                                <form action="{{ route('carts.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="qty" value="1">
                                    <button type="submit" class="reco-add-btn">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M6 2v8M2 6h8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        Tambah
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>

    {{-- STICKY BOTTOM TOOLBAR --}}
    @if (!$cartItems->isEmpty())
        <div class="cart-toolbar">
            <label class="toolbar-select" for="cbSelectAllBottom">
                <input type="checkbox" class="cb cb-select-all" id="cbSelectAllBottom" checked>
                <span>Pilih Semua (<strong id="tbAllCount">{{ $totalActiveProducts }}</strong>)</span>
            </label>

            <div class="toolbar-mid">
                <span class="toolbar-mid-info">
                    <strong id="tbProdCount">{{ $totalActiveProducts }}</strong> produk
                    &middot; <strong id="tbItemCount">{{ $totalItems }}</strong> pcs dipilih
                </span>
            </div>

            <div style="display:flex;align-items:center;gap:18px;flex-wrap:wrap;">
                <div class="toolbar-total-block">
                    <span class="toolbar-total-label">Total:</span>
                    <span class="toolbar-total-amount"><span>Rp</span><span id="tbTotal">{{ number_format($total, 0, ',', '.') }}</span></span>
                </div>
                <button type="submit" form="checkoutForm" class="checkout-btn" id="tbCheckoutBtn">
                    Checkout
                    <span class="ck-count" id="tbBtnCount">{{ $totalActiveProducts }}</span>
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>
        </div>
    @endif
</div>

<script>
(function() {
    const itemCheckboxes = Array.from(document.querySelectorAll('.cb-item'));
    const selectAllBoxes = Array.from(document.querySelectorAll('.cb-select-all'));
    const totalEl = document.getElementById('tbTotal');
    const itemCountEl = document.getElementById('tbItemCount');
    const prodCountEl = document.getElementById('tbProdCount');
    const allCountEl = document.getElementById('tbAllCount');
    const btnCountEl = document.getElementById('tbBtnCount');
    const checkoutBtn = document.getElementById('tbCheckoutBtn');

    function fmt(n) { return n.toLocaleString('id-ID'); }

    function recalc() {
        let total = 0, itemQty = 0, prodCount = 0;
        itemCheckboxes.forEach(cb => {
            const row = cb.closest('.item-row');
            if (!row) return;
            if (cb.checked && !cb.disabled) {
                total    += parseInt(row.dataset.subtotal || '0', 10);
                itemQty  += parseInt(row.dataset.qty || '0', 10);
                prodCount++;
            }
        });

        if (totalEl)     totalEl.textContent     = fmt(total);
        if (itemCountEl) itemCountEl.textContent = itemQty;
        if (prodCountEl) prodCountEl.textContent = prodCount;
        if (allCountEl)  allCountEl.textContent  = prodCount;
        if (btnCountEl)  btnCountEl.textContent  = prodCount;

        const eligible = itemCheckboxes.filter(cb => !cb.disabled);
        const allChecked = eligible.length > 0 && eligible.every(cb => cb.checked);
        const someChecked = eligible.some(cb => cb.checked);
        selectAllBoxes.forEach(cb => {
            cb.checked = allChecked;
            cb.indeterminate = !allChecked && someChecked;
        });

        if (checkoutBtn) {
            checkoutBtn.disabled = (prodCount === 0);
        }
    }

    itemCheckboxes.forEach(cb => cb.addEventListener('change', recalc));
    selectAllBoxes.forEach(sa => sa.addEventListener('change', () => {
        const target = sa.checked;
        itemCheckboxes.forEach(cb => {
            if (!cb.disabled) cb.checked = target;
        });
        recalc();
    }));

    // Cegah submit kalau tidak ada yang dipilih
    const form = document.getElementById('checkoutForm');
    if (form) {
        form.addEventListener('submit', e => {
            const anySelected = itemCheckboxes.some(cb => cb.checked && !cb.disabled);
            if (!anySelected) {
                e.preventDefault();
                alert('Pilih minimal satu produk yang ingin dibayar.');
            }
        });
    }

    recalc();
})();
</script>
@endsection
