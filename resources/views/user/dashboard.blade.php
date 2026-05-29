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
        --shadow-md: 0 4px 20px rgba(28,43,36,0.09);
        --radius: 14px;
        --radius-sm: 8px;
        --radius-lg: 20px;
    }

    /* Override layout.app styles aggressively */
    #udp-shell,
    #udp-shell * { font-family: 'DM Sans', -apple-system, sans-serif !important; }

    #udp-shell {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: var(--cream);
        overflow-y: auto;
        color: var(--ink);
        -webkit-font-smoothing: antialiased;
    }

    /* ═══ NAV ═══ */
    .udp-nav {
        position: sticky;
        top: 0;
        z-index: 100;
        height: 62px;
        background: rgba(247,244,238,0.95);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
    }

    .udp-nav-inner {
        max-width: 1020px;
        margin: 0 auto;
        padding: 0 28px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .udp-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        flex-shrink: 0;
        cursor: pointer;
    }

    .udp-brand-logo {
        width: 36px; height: 36px;
        border-radius: 8px;
        background: var(--gold-pale);
        border: 1px solid rgba(201,168,76,0.2);
        overflow: hidden;
        display: flex; align-items: center; justify-content: center;
    }

    .udp-brand-logo img { width: 100%; height: 100%; object-fit: cover; }

    .udp-brand-name {
        font-family: 'Playfair Display', serif !important;
        font-size: 14px; font-weight: 600;
        color: var(--ink); line-height: 1.2;
    }

    .udp-brand-sub {
        font-size: 9.5px; font-weight: 600;
        letter-spacing: 0.12em; text-transform: uppercase;
        color: var(--muted);
    }

    .udp-nav-links { display: flex; align-items: center; gap: 2px; }

    .udp-nav-link {
        padding: 7px 13px;
        border-radius: 7px;
        text-decoration: none;
        font-size: 13px; font-weight: 500;
        color: var(--ink-soft);
        transition: all 0.17s;
        cursor: pointer;
        border: none; background: none;
        font-family: 'DM Sans', sans-serif !important;
    }

    .udp-nav-link:hover { background: var(--sage-pale); color: var(--sage-deep); }
    .udp-nav-link.active { background: var(--sage-pale); color: var(--sage-deep); font-weight: 600; }

    .udp-nav-right { display: flex; align-items: center; gap: 8px; }

    .udp-cart-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 14px;
        background: var(--surface);
        border: 1px solid var(--border-strong);
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-size: 13px; font-weight: 500;
        color: var(--ink-soft);
        transition: all 0.17s;
    }

    .udp-cart-btn:hover { background: var(--sage-pale); border-color: var(--sage); color: var(--sage-deep); }

    .udp-logout-btn {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 7px 14px;
        background: rgba(201,168,76,0.08);
        border: 1px solid rgba(201,168,76,0.25);
        border-radius: var(--radius-sm);
        font-size: 13px; font-weight: 500;
        color: #8B6914;
        cursor: pointer;
        transition: all 0.17s;
        font-family: 'DM Sans', sans-serif !important;
    }

    .udp-logout-btn:hover { background: rgba(201,168,76,0.18); }

    /* ═══ CONTENT ═══ */
    .udp-page { display: none; }
    .udp-page.active { display: block; }

    .udp-wrap {
        max-width: 1020px;
        margin: 0 auto;
        padding: 0 28px 80px;
    }

    /* ═══ HERO ═══ */
    .udp-hero {
        margin: 32px 0 30px;
        background: var(--ink);
        border-radius: var(--radius-lg);
        overflow: hidden;
        position: relative;
        display: flex;
        align-items: center;
        padding: 38px 42px;
        min-height: 196px;
    }

    .udp-hero::before {
        content: '';
        position: absolute; top: -70px; right: -70px;
        width: 280px; height: 280px;
        border-radius: 50%;
        background: rgba(124,185,154,0.07);
        pointer-events: none;
    }

    .udp-hero::after {
        content: '';
        position: absolute; bottom: -50px; left: 220px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(201,168,76,0.05);
        pointer-events: none;
    }

    .udp-hero-text { position: relative; z-index: 1; flex: 1; min-width: 0; }

    .udp-hero-eyebrow {
        font-size: 10.5px; font-weight: 700;
        letter-spacing: 0.16em; text-transform: uppercase;
        color: var(--sage-light); margin-bottom: 10px;
    }

    .udp-hero-title {
        font-family: 'Playfair Display', serif !important;
        font-size: 30px; font-weight: 600;
        color: #fff; line-height: 1.2;
        margin-bottom: 8px;
        letter-spacing: -0.01em;
    }

    .udp-hero-title span { color: var(--gold-light); }

    .udp-hero-sub {
        font-size: 14px; font-weight: 300;
        color: rgba(255,255,255,0.45);
        margin-bottom: 22px;
        line-height: 1.6;
        max-width: 340px;
    }

    .udp-hero-cta {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 11px 22px;
        background: var(--gold);
        color: #fff;
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-size: 13.5px; font-weight: 600;
        transition: all 0.2s;
        box-shadow: 0 3px 12px rgba(201,168,76,0.35);
        position: relative; z-index: 2;
        cursor: pointer;
    }

    .udp-hero-cta:hover {
        background: #b8953e;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(201,168,76,0.45);
        color: #fff;
    }

    .udp-hero-img {
        position: relative; z-index: 1;
        width: 160px; height: 160px;
        border-radius: 14px;
        object-fit: cover;
        flex-shrink: 0;
        margin-left: 36px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.35);
        display: block;
    }

    .udp-hero-img-ph {
        position: relative; z-index: 1;
        width: 160px; height: 160px;
        border-radius: 14px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        flex-shrink: 0;
        margin-left: 36px;
        display: flex; align-items: center; justify-content: center;
        font-size: 36px;
    }

    /* ═══ QUICK CARDS ═══ */
    .udp-quick {
        display: grid;
        grid-template-columns: repeat(3,1fr);
        gap: 14px;
        margin-bottom: 38px;
    }

    .udp-quick-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 18px 20px;
        text-decoration: none;
        color: inherit;
        display: flex; align-items: center; gap: 14px;
        transition: all 0.2s;
        cursor: pointer;
        position: relative; overflow: hidden;
    }

    .udp-quick-card::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0; height: 2px;
        background: var(--sage);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.25s;
    }

    .udp-quick-card.qgold::after { background: var(--gold); }
    .udp-quick-card.qpink::after { background: #E07FA8; }

    .udp-quick-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
        border-color: var(--border-strong);
    }

    .udp-quick-card:hover::after { transform: scaleX(1); }

    .udp-quick-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 19px; flex-shrink: 0;
    }

    .qicon-green { background: var(--sage-pale); }
    .qicon-gold { background: var(--gold-pale); }
    .qicon-pink { background: #FEF0F6; }

    .udp-quick-label { font-size: 14px; font-weight: 600; color: var(--ink); }
    .udp-quick-sub { font-size: 11.5px; color: var(--muted); margin-top: 2px; }
    .udp-quick-arrow { margin-left: auto; color: var(--muted); font-size: 16px; flex-shrink: 0; transition: transform 0.2s; }
    .udp-quick-card:hover .udp-quick-arrow { transform: translateX(3px); }

    /* ═══ SECTION TITLE ═══ */
    .udp-section-hd {
        font-family: 'Playfair Display', serif !important;
        font-size: 21px; font-weight: 600;
        color: var(--ink);
        margin-bottom: 16px;
    }

    /* ═══ PRODUCT GRID ═══ */
    .udp-products {
        display: grid;
        grid-template-columns: repeat(3,1fr);
        gap: 16px;
        margin-bottom: 38px;
    }

    .udp-prod-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: flex; flex-direction: column;
        transition: all 0.2s;
    }

    .udp-prod-card:hover { box-shadow: var(--shadow-md); transform: translateY(-3px); }

    .udp-prod-img-wrap {
        width: 100%; aspect-ratio: 1/1;
        overflow: hidden; background: var(--cream);
        position: relative;
        padding: 10px;
        border-bottom: 1px solid var(--border);
    }

    .udp-prod-img {
        width: 100%; height: 100%;
        object-fit: contain; display: block;
        transition: transform 0.32s;
    }

    .udp-prod-card:hover .udp-prod-img { transform: scale(1.04); }

    .udp-prod-img-ph {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        color: var(--muted); font-size: 13px;
    }

    .udp-sold-ov {
        position: absolute; top: 9px; left: 9px;
        background: rgba(28,43,36,0.72);
        color: #fff;
        font-size: 10.5px; font-weight: 600;
        padding: 3px 8px; border-radius: 20px;
        backdrop-filter: blur(4px);
    }

    .udp-habis-ov {
        position: absolute; top: 9px; right: 9px;
        background: linear-gradient(135deg, #d1546a, #b8364c);
        color: #fff;
        font-size: 10.5px; font-weight: 700;
        padding: 4px 10px; border-radius: 20px;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        box-shadow: 0 2px 8px rgba(209,84,106,0.4);
    }

    .udp-prod-card.udp-habis .udp-prod-img,
    .udp-prod-card.udp-habis .udp-prod-img-ph {
        filter: grayscale(0.7) opacity(0.65);
    }

    .udp-prod-card.udp-habis .udp-buy-btn {
        background: rgba(209,84,106,0.12);
        color: #b8364c;
        cursor: not-allowed;
    }

    .udp-prod-body { padding: 13px 15px 15px; flex: 1; display: flex; flex-direction: column; }
    .udp-prod-name { font-size: 14px; font-weight: 600; color: var(--ink); line-height: 1.3; margin-bottom: 4px; }
    .udp-prod-price {
        font-family: 'Playfair Display', serif !important;
        font-size: 15px; font-weight: 600;
        color: var(--ink); margin-bottom: 10px;
    }
    .udp-prod-foot { margin-top: auto; display: flex; align-items: center; justify-content: space-between; }
    .udp-sold-lbl { font-size: 11px; font-weight: 500; color: var(--muted); }
    .udp-buy-btn {
        display: inline-flex; align-items: center;
        padding: 5px 12px;
        background: var(--sage-pale);
        color: var(--sage-deep);
        border-radius: 20px;
        font-size: 12px; font-weight: 600;
    }

    /* ═══ CATEGORIES ═══ */
    .udp-cats {
        display: grid;
        grid-template-columns: repeat(3,1fr);
        gap: 12px;
        margin-bottom: 38px;
    }

    .udp-cat {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 15px 18px;
        display: flex; align-items: center; gap: 12px;
        font-size: 14px; font-weight: 500;
        color: var(--ink-soft);
        transition: all 0.18s;
    }

    .udp-cat:hover { background: var(--sage-pale); border-color: var(--sage); color: var(--sage-deep); }
    .udp-cat-icon { font-size: 21px; flex-shrink: 0; }

    /* ═══ ABOUT ═══ */
    .udp-about-hero {
        background: var(--ink);
        border-radius: var(--radius-lg);
        padding: 38px 42px;
        margin: 32px 0 26px;
        position: relative; overflow: hidden;
    }

    .udp-about-hero::before {
        content: '';
        position: absolute; top: -50px; right: -50px;
        width: 220px; height: 220px;
        border-radius: 50%;
        background: rgba(124,185,154,0.07);
        pointer-events: none;
    }

    .udp-ah-eye {
        font-size: 10.5px; font-weight: 700;
        letter-spacing: 0.16em; text-transform: uppercase;
        color: var(--sage-light); margin-bottom: 10px;
        position: relative; z-index: 1;
    }

    .udp-ah-title {
        font-family: 'Playfair Display', serif !important;
        font-size: 28px; font-weight: 600;
        color: #fff; margin-bottom: 8px;
        position: relative; z-index: 1;
    }

    .udp-ah-sub {
        font-size: 14px; font-weight: 300;
        color: rgba(255,255,255,0.42);
        position: relative; z-index: 1;
    }

    .udp-acard {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 22px 24px;
        margin-bottom: 16px;
        box-shadow: var(--shadow-sm);
    }

    .udp-acard-hd {
        display: flex; align-items: center; gap: 12px;
        margin-bottom: 14px;
    }

    .udp-acard-icon {
        width: 36px; height: 36px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 17px; flex-shrink: 0;
        background: var(--sage-pale);
    }

    .udp-acard-icon.gold { background: var(--gold-pale); }

    .udp-acard-title {
        font-family: 'Playfair Display', serif !important;
        font-size: 17px; font-weight: 600; color: var(--ink);
    }

    .udp-acard-text { font-size: 14.5px; color: var(--ink-soft); line-height: 1.7; }

    .udp-tl-grid {
        display: grid;
        grid-template-columns: repeat(4,1fr);
        gap: 12px; margin-top: 16px;
    }

    .udp-tl-item {
        background: var(--cream);
        border-radius: 10px; padding: 14px;
        border: 1px solid var(--border);
    }

    .udp-year {
        display: inline-block;
        background: var(--sage); color: #fff;
        font-size: 11px; font-weight: 700;
        padding: 3px 10px; border-radius: 20px;
        margin-bottom: 9px;
    }

    .udp-tl-text { font-size: 12.5px; color: var(--ink-soft); line-height: 1.6; }

    .udp-vm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }

    .udp-mission-list {
        padding-left: 18px;
        font-size: 14.5px; color: var(--ink-soft); line-height: 1.7;
        margin: 0;
    }

    .udp-mission-list li { margin-bottom: 8px; }
    .udp-mission-list li:last-child { margin-bottom: 0; }

    /* ═══ EMPTY ═══ */
    .udp-empty {
        text-align: center; padding: 48px 20px;
        background: var(--surface); border-radius: var(--radius);
        border: 1px solid var(--border); margin-bottom: 38px;
    }

    .udp-empty-icon { font-size: 30px; margin-bottom: 10px; opacity: 0.4; }
    .udp-empty-title { font-size: 14.5px; font-weight: 600; color: var(--ink-soft); }

    /* ═══ RESPONSIVE ═══ */
    @media (max-width: 800px) {
        .udp-products, .udp-quick { grid-template-columns: repeat(2,1fr); }
        .udp-tl-grid { grid-template-columns: repeat(2,1fr); }
        .udp-vm-grid { grid-template-columns: 1fr; }
        .udp-hero { padding: 28px 24px; }
        .udp-hero-img, .udp-hero-img-ph { width: 120px; height: 120px; margin-left: 18px; }
        .udp-hero-title { font-size: 24px; }
        .udp-nav-links { display: none; }
    }

    @media (max-width: 560px) {
        .udp-wrap { padding: 0 16px 60px; }
        .udp-nav-inner { padding: 0 16px; }
        .udp-products { grid-template-columns: repeat(2,1fr); gap: 10px; }
        .udp-cats { grid-template-columns: 1fr 1fr; }
        .udp-quick { grid-template-columns: 1fr; }
        .udp-hero-img, .udp-hero-img-ph { display: none; }
        .udp-tl-grid { grid-template-columns: 1fr; }
    }
</style>

{{-- Portal: covers the entire viewport over layouts.app --}}
<div id="udp-shell">

    {{-- ── NAV ── --}}
    <nav class="udp-nav">
        <div class="udp-nav-inner">
            <div class="udp-brand" onclick="udpShow('home')">
                <div class="udp-brand-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                </div>
                <div>
                    <div class="udp-brand-name">Rumah Rimpang</div>
                    <div class="udp-brand-sub">Herbal UMKM</div>
                </div>
            </div>

            <div class="udp-nav-links">
                <button class="udp-nav-link active" id="nl-home" onclick="udpShow('home')">Home</button>
                <button class="udp-nav-link" id="nl-shop" onclick="udpShow('home'); setTimeout(()=>document.getElementById('udp-produk')?.scrollIntoView({behavior:'smooth'}),80)">Shop</button>
                <button class="udp-nav-link" id="nl-about" onclick="udpShow('about')">About Us</button>
                <a href="{{ route('user.profile') }}" class="udp-nav-link">Profil</a>
            </div>

            <div class="udp-nav-right">
                <a href="{{ route('carts.index') }}" class="udp-cart-btn">🛒 Keranjang</a>
                <form action="{{ route('logout') }}" method="POST" style="margin:0">
                    @csrf
                    <button type="submit" class="udp-logout-btn">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    {{-- ══════════ HOME PAGE ══════════ --}}
    <div class="udp-page active" id="udp-home">
    <div class="udp-wrap">

        {{-- Hero --}}
        @php $heroImg = $topProducts->first()?->gambar ? asset('storage/'.$topProducts->first()->gambar) : null; @endphp
        <div class="udp-hero">
            <div class="udp-hero-text">
                <div class="udp-hero-eyebrow">Produk Herbal Pilihan</div>
                <h1 class="udp-hero-title">Selamat Datang di<br><span>Rumah Rimpang</span> 🌿</h1>
                <p class="udp-hero-sub">Minuman herbal segar dari rimpang pilihan, langsung dari kebun ke tanganmu.</p>
                <a href="#" class="udp-hero-cta" onclick="document.getElementById('udp-produk')?.scrollIntoView({behavior:'smooth'});return false;">
                    Belanja Sekarang →
                </a>
            </div>
            @if($heroImg)
                <img src="{{ $heroImg }}" alt="Produk unggulan" class="udp-hero-img">
            @else
                <div class="udp-hero-img-ph">🌿</div>
            @endif
        </div>

        {{-- Quick access --}}
        <div class="udp-quick">
            <a href="{{ route('carts.index') }}" class="udp-quick-card">
                <div class="udp-quick-icon qicon-green">🛒</div>
                <div><div class="udp-quick-label">Keranjang</div><div class="udp-quick-sub">Lihat pilihan kamu</div></div>
                <span class="udp-quick-arrow">→</span>
            </a>
            <a href="{{ route('orders.index') }}" class="udp-quick-card qgold">
                <div class="udp-quick-icon qicon-gold">🧾</div>
                <div><div class="udp-quick-label">Pesanan Saya</div><div class="udp-quick-sub">Lacak status pembelian</div></div>
                <span class="udp-quick-arrow">→</span>
            </a>
            <div class="udp-quick-card qpink" style="cursor:default">
                <div class="udp-quick-icon qicon-pink">💗</div>
                <div><div class="udp-quick-label">Favorit</div><div class="udp-quick-sub">Produk yang kamu sukai</div></div>
                <span class="udp-quick-arrow">→</span>
            </div>
        </div>

        {{-- Products --}}
        <div id="udp-produk">
            <div class="udp-section-hd">🔥 Produk Terlaris</div>
            @if($topProducts->count())
            <div class="udp-products">
                @foreach($topProducts as $product)
                @php $isHabis = ($product->stok ?? 0) <= 0; @endphp
                <a href="{{ route('user.products.show', $product) }}" class="udp-prod-card {{ $isHabis ? 'udp-habis' : '' }}">
                    <div class="udp-prod-img-wrap">
                        @if($product->gambar)
                            <img src="{{ asset('storage/'.$product->gambar) }}" alt="{{ $product->nama_produk }}" class="udp-prod-img">
                        @else
                            <div class="udp-prod-img-ph">No Image</div>
                        @endif
                        @if($product->total_terjual ?? 0)
                            <span class="udp-sold-ov">{{ (int)$product->total_terjual }}× terjual</span>
                        @endif
                        @if($isHabis)
                            <span class="udp-habis-ov">Habis</span>
                        @endif
                    </div>
                    <div class="udp-prod-body">
                        <div class="udp-prod-name">{{ $product->nama_produk }}</div>
                        <div class="udp-prod-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                        <div class="udp-prod-foot">
                            <span class="udp-sold-lbl">
                                @if($isHabis)
                                    Stok habis
                                @else
                                    {{ $product->total_terjual ? 'Terjual '.(int)$product->total_terjual : 'Produk baru' }}
                                @endif
                            </span>
                            <span class="udp-buy-btn">{{ $isHabis ? 'Habis' : 'Beli →' }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="udp-empty"><div class="udp-empty-icon">📦</div><div class="udp-empty-title">Belum ada produk</div></div>
            @endif
        </div>

    </div>
    </div>

    {{-- ══════════ ABOUT PAGE ══════════ --}}
    <div class="udp-page" id="udp-about">
    <div class="udp-wrap">

        <div class="udp-about-hero">
            <div class="udp-ah-eye">Kenali Kami</div>
            <h2 class="udp-ah-title">Tentang Rumah Rimpang 🌿</h2>
            <p class="udp-ah-sub">Produsen minuman herbal berbahan rimpang dari Desa Suka Maju, Mestong</p>
        </div>

        <div class="udp-acard">
            <div class="udp-acard-hd">
                <div class="udp-acard-icon">🌱</div>
                <div class="udp-acard-title">Tentang Kami</div>
            </div>
            <p class="udp-acard-text">
                Rumah Rimpang merupakan usaha berbasis kelompok tani dari Desa Suka Maju, Mestong,
                yang berfokus pada pengolahan minuman herbal berbahan dasar rimpang seperti jahe dan kunyit.
                Usaha ini lahir dari semangat kebersamaan untuk mengembangkan potensi hasil pertanian
                menjadi produk bernilai tambah bagi masyarakat lokal.
            </p>
        </div>

        <div class="udp-acard">
            <div class="udp-acard-hd">
                <div class="udp-acard-icon">📖</div>
                <div class="udp-acard-title">Sejarah Singkat</div>
            </div>
            <div class="udp-tl-grid">
                <div class="udp-tl-item"><span class="udp-year">2020</span><p class="udp-tl-text">Kelompok tani didirikan untuk mengembangkan usaha bersama, awalnya berfokus pada kegiatan budidaya dan membangun kebersamaan.</p></div>
                <div class="udp-tl-item"><span class="udp-year">2022</span><p class="udp-tl-text">Mulai berinovasi mengolah hasil panen menjadi produk wedang jahe serbuk dan kunyit asam cair yang bernilai jual tinggi.</p></div>
                <div class="udp-tl-item"><span class="udp-year">2023</span><p class="udp-tl-text">Fasilitas bottling modern beroperasi. Merek Rumah Rimpang lahir dari ibu-ibu kelompok tani yang memimpin pengolahan produk.</p></div>
                <div class="udp-tl-item"><span class="udp-year">2024</span><p class="udp-tl-text">Kelompok resmi mendapat legalitas melalui akta notaris, memperkuat fondasi pengembangan usaha secara profesional.</p></div>
            </div>
        </div>

        <div class="udp-vm-grid">
            <div class="udp-acard" style="margin-bottom:0">
                <div class="udp-acard-hd">
                    <div class="udp-acard-icon gold">🏆</div>
                    <div class="udp-acard-title">Visi</div>
                </div>
                <p class="udp-acard-text">Menjadi produsen minuman herbal berbahan dasar jahe dan kunyit yang terkemuka dan terpercaya, dengan jaminan keamanan produk serta menghadirkan cita rasa otentik dan inovatif.</p>
            </div>
            <div class="udp-acard" style="margin-bottom:0">
                <div class="udp-acard-hd">
                    <div class="udp-acard-icon">✳</div>
                    <div class="udp-acard-title">Misi</div>
                </div>
                <ol class="udp-mission-list">
                    <li>Menghasilkan produk minuman herbal berkualitas tinggi, aman, dan berbahan alami.</li>
                    <li>Mengembangkan inovasi varian rasa sesuai tren dan kebutuhan pasar.</li>
                    <li>Memperluas jangkauan pasar agar produk lebih dikenal masyarakat luas.</li>
                </ol>
            </div>
        </div>

        <div style="height:40px"></div>

    </div>
    </div>

</div>{{-- /udp-shell --}}

<script>
    function udpShow(page) {
        document.querySelectorAll('.udp-page').forEach(el => el.classList.remove('active'));
        document.getElementById('udp-' + page)?.classList.add('active');
        document.querySelectorAll('[id^="nl-"]').forEach(el => el.classList.remove('active'));
        document.getElementById('nl-' + page)?.classList.add('active');
        document.getElementById('udp-shell').scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endsection