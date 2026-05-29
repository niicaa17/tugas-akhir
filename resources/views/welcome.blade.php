<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rumah Rimpang &mdash; Minuman Herbal dari Kebun ke Tanganmu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
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

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--ink);
            background: var(--cream);
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; }

        /* ───── NAV ───── */
        .nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(247, 244, 238, 0.92);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
        }
        .nav-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }
        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        .brand-logo {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: var(--gold-pale);
            border: 1px solid rgba(201,168,76,0.2);
            overflow: hidden;
            display: flex; align-items: center; justify-content: center;
        }
        .brand-logo img { width: 100%; height: 100%; object-fit: cover; }
        .brand-logo svg { color: var(--sage-deep); }
        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 600;
            color: var(--ink);
            line-height: 1;
        }
        .brand-sub {
            font-size: 9.5px;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--muted);
            margin-top: 4px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .nav-links a {
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--ink-soft);
            transition: background .18s, color .18s;
        }
        .nav-links a:hover { background: var(--sage-pale); color: var(--sage-deep); }

        .nav-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-weight: 600;
            line-height: 1;
            cursor: pointer;
            transition: transform .18s, background .18s, box-shadow .18s, border-color .18s, color .18s;
            border: 1px solid transparent;
            text-decoration: none;
        }
        .btn-primary {
            background: var(--ink);
            color: #fff;
        }
        .btn-primary:hover {
            background: var(--ink-mid);
            transform: translateY(-1px);
        }
        .btn-gold {
            background: var(--gold);
            color: #fff;
            box-shadow: 0 3px 12px rgba(201,168,76,0.32);
        }
        .btn-gold:hover {
            background: #b8953e;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(201,168,76,0.42);
            color: #fff;
        }
        .btn-ghost {
            background: var(--surface);
            color: var(--ink-soft);
            border-color: var(--border-strong);
        }
        .btn-ghost:hover {
            background: var(--sage-pale);
            border-color: var(--sage);
            color: var(--sage-deep);
        }
        .btn-lg {
            padding: 13px 28px;
            font-size: 14.5px;
        }

        /* ───── HERO ───── */
        .hero {
            max-width: 1100px;
            margin: 0 auto;
            padding: 56px 28px 24px;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 48px;
            align-items: center;
        }
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--sage-deep);
            background: var(--sage-pale);
            padding: 6px 12px;
            border-radius: 999px;
            margin-bottom: 20px;
        }
        .eyebrow .dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--sage-deep);
        }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(34px, 5vw, 52px);
            font-weight: 600;
            line-height: 1.08;
            color: var(--ink);
            letter-spacing: -0.02em;
            margin: 0 0 16px;
        }
        .hero-title em {
            font-style: italic;
            color: var(--sage-deep);
        }
        .hero-sub {
            font-size: 16px;
            line-height: 1.65;
            color: var(--ink-soft);
            margin: 0 0 28px;
            max-width: 480px;
        }
        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .hero-trust {
            display: flex;
            gap: 28px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
        }
        .trust-item .num {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 600;
            color: var(--ink);
        }
        .trust-item .lbl {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        .hero-visual {
            position: relative;
            aspect-ratio: 1;
            background: linear-gradient(160deg, #2a4536 0%, #1c2b24 100%);
            border-radius: 28px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 30px 60px rgba(28,43,36,0.18);
        }
        .hero-visual::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 320px; height: 320px;
            border-radius: 50%;
            background: rgba(201,168,76,0.18);
            filter: blur(20px);
        }
        .hero-visual::after {
            content: '';
            position: absolute;
            bottom: -100px; left: -60px;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: rgba(124,185,154,0.18);
            filter: blur(30px);
        }
        .hero-leaf {
            position: relative;
            z-index: 1;
            font-size: 120px;
            color: var(--sage-light);
            opacity: 0.9;
        }
        .hero-tag {
            position: absolute;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            padding: 12px 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.18);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 2;
            font-size: 13px;
            color: var(--ink);
        }
        .hero-tag .ic {
            width: 30px; height: 30px;
            border-radius: 8px;
            background: var(--sage-pale);
            color: var(--sage-deep);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .hero-tag.t1 { top: 40px; left: -28px; }
        .hero-tag.t2 { bottom: 60px; right: -32px; }
        .hero-tag strong { display: block; font-size: 12.5px; }
        .hero-tag .sub { font-size: 11px; color: var(--muted); }

        /* ───── FEATURES ───── */
        .features {
            max-width: 1100px;
            margin: 60px auto 0;
            padding: 0 28px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        .feat {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px 22px;
            transition: transform .2s, box-shadow .2s, border-color .2s;
        }
        .feat:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            border-color: var(--border-strong);
        }
        .feat-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            background: var(--sage-pale);
            color: var(--sage-deep);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            margin-bottom: 14px;
        }
        .feat-icon.gold { background: var(--gold-pale); color: #8B6914; }
        .feat-icon.pink { background: #FEF0F6; color: #B8527A; }
        .feat-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--ink);
            margin: 0 0 6px;
        }
        .feat-text {
            font-size: 13.5px;
            line-height: 1.6;
            color: var(--ink-soft);
            margin: 0;
        }

        /* ───── HOW IT WORKS ───── */
        .how {
            max-width: 1100px;
            margin: 80px auto 0;
            padding: 0 28px;
        }
        .section-head {
            text-align: center;
            margin-bottom: 36px;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 600;
            color: var(--ink);
            margin: 8px 0 8px;
            letter-spacing: -0.01em;
        }
        .section-sub {
            font-size: 14.5px;
            color: var(--ink-soft);
            max-width: 540px;
            margin: 0 auto;
            line-height: 1.6;
        }
        .steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            position: relative;
        }
        .step {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px 20px;
            position: relative;
        }
        .step-num {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: var(--ink);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            margin-bottom: 12px;
        }
        .step-title {
            font-size: 14.5px;
            font-weight: 600;
            color: var(--ink);
            margin: 0 0 4px;
        }
        .step-text {
            font-size: 12.5px;
            color: var(--ink-soft);
            line-height: 1.55;
            margin: 0;
        }

        /* ───── CTA STRIP ───── */
        .cta-strip {
            max-width: 1100px;
            margin: 80px auto 0;
            padding: 0 28px;
        }
        .cta-card {
            background: var(--ink);
            border-radius: var(--radius-lg);
            padding: 44px 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
            position: relative;
            overflow: hidden;
            flex-wrap: wrap;
        }
        .cta-card::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 240px; height: 240px;
            border-radius: 50%;
            background: rgba(124,185,154,0.10);
            pointer-events: none;
        }
        .cta-card::after {
            content: '';
            position: absolute;
            bottom: -80px; right: 200px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(201,168,76,0.08);
            pointer-events: none;
        }
        .cta-text { position: relative; z-index: 1; flex: 1; min-width: 260px; }
        .cta-eyebrow {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--sage-light);
            margin-bottom: 8px;
        }
        .cta-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 600;
            color: #fff;
            margin: 0 0 6px;
            line-height: 1.2;
        }
        .cta-title span { color: var(--gold-light); }
        .cta-sub {
            font-size: 14px;
            color: rgba(255,255,255,0.55);
            margin: 0;
            max-width: 420px;
            line-height: 1.55;
        }
        .cta-actions { position: relative; z-index: 1; display: flex; gap: 10px; flex-wrap: wrap; }

        /* ───── FOOTER ───── */
        footer.foot {
            max-width: 1100px;
            margin: 60px auto 0;
            padding: 32px 28px 40px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }
        .foot-text {
            font-size: 12.5px;
            color: var(--muted);
        }
        .foot-text strong { color: var(--ink-soft); font-weight: 600; }
        .foot-links {
            display: flex;
            gap: 18px;
            font-size: 12.5px;
        }
        .foot-links a { color: var(--ink-soft); }
        .foot-links a:hover { color: var(--sage-deep); }

        /* ───── RESPONSIVE ───── */
        @media (max-width: 880px) {
            .hero {
                grid-template-columns: 1fr;
                padding-top: 36px;
                gap: 32px;
            }
            .hero-visual { aspect-ratio: 4/3; max-width: 480px; margin: 0 auto; width: 100%; }
            .hero-tag.t1 { left: 12px; }
            .hero-tag.t2 { right: 12px; }
            .features { grid-template-columns: 1fr; }
            .steps { grid-template-columns: repeat(2, 1fr); }
            .nav-links { display: none; }
            .cta-card { padding: 32px 28px; }
        }
        @media (max-width: 520px) {
            .nav-inner { padding: 12px 18px; }
            .hero { padding: 28px 18px 8px; }
            .features, .how, .cta-strip { padding-left: 18px; padding-right: 18px; }
            footer.foot { padding-left: 18px; padding-right: 18px; }
            .steps { grid-template-columns: 1fr; }
            .cta-card { flex-direction: column; align-items: flex-start; }
            .hero-trust { gap: 18px; }
            .brand-sub { display: none; }
        }
    </style>
</head>
<body>

    {{-- ───── NAVBAR ───── --}}
    <nav class="nav">
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="brand">
                <div class="brand-logo">
                    @if (file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="Rumah Rimpang">
                    @else
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2C8 6 6 10 6 14a6 6 0 0012 0c0-4-2-8-6-12z" fill="currentColor"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <div class="brand-name">Rumah Rimpang</div>
                    <div class="brand-sub">Herbal UMKM</div>
                </div>
            </a>

            <div class="nav-links">
                <a href="#produk">Produk</a>
                <a href="#cara">Cara Belanja</a>
                <a href="#tentang">Tentang Kami</a>
            </div>

            <div class="nav-cta">
                @auth
                    <a href="{{ route('home') }}" class="btn btn-primary">Buka Dashboard</a>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-ghost">Masuk</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    {{-- ───── HERO ───── --}}
    <section class="hero">
        <div>
            <span class="eyebrow"><span class="dot"></span> Minuman Herbal Asli Indonesia</span>
            <h1 class="hero-title">
                Rasa hangat dari <em>rimpang pilihan</em>, langsung ke meja Anda.
            </h1>
            <p class="hero-sub">
                Rumah Rimpang menyajikan minuman herbal alami berbahan jahe, kunyit, dan rempah pilihan
                dari Desa Suka Maju, Mestong &mdash; diproduksi oleh kelompok tani lokal dengan resep
                turun-temurun.
            </p>
            <div class="hero-actions">
                @auth
                    <a href="{{ route('user.dashboard') }}" class="btn btn-gold btn-lg">
                        Mulai Belanja
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-gold btn-lg">
                        Daftar &amp; Belanja
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-lg">Sudah Punya Akun</a>
                @endauth
            </div>

            <div class="hero-trust">
                <div class="trust-item">
                    <div class="num">100%</div>
                    <div class="lbl">Bahan Alami</div>
                </div>
                <div class="trust-item">
                    <div class="num">UMKM</div>
                    <div class="lbl">Resmi Berbadan Hukum</div>
                </div>
                <div class="trust-item">
                    <div class="num">2020</div>
                    <div class="lbl">Berdiri Sejak</div>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-leaf">
                <svg width="180" height="180" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C19 20 22 3 22 3c-1 2-8 2.25-13 3.25S2 11.5 2 13.5s1.75 3.75 1.75 3.75C7 8 17 8 17 8z"/>
                </svg>
            </div>
            <div class="hero-tag t1">
                <div class="ic">★</div>
                <div>
                    <strong>Resep Turun-Temurun</strong>
                    <div class="sub">Khas Mestong, Jambi</div>
                </div>
            </div>
            <div class="hero-tag t2">
                <div class="ic">✓</div>
                <div>
                    <strong>Bersertifikat</strong>
                    <div class="sub">Produksi higienis</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ───── FEATURES ───── --}}
    <section class="features" id="produk">
        <div class="feat">
            <div class="feat-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            </div>
            <h3 class="feat-title">Bahan Alami</h3>
            <p class="feat-text">Diolah dari rimpang segar pilihan tanpa pengawet sintetis dan tanpa pewarna buatan.</p>
        </div>
        <div class="feat">
            <div class="feat-icon gold">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 2l3 7h7l-5.5 4.5L18 21l-6-4-6 4 1.5-7.5L2 9h7l3-7z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
            </div>
            <h3 class="feat-title">Diproduksi UMKM</h3>
            <p class="feat-text">Setiap pembelian mendukung kelompok tani Desa Suka Maju, Mestong &mdash; ekonomi lokal jalan.</p>
        </div>
        <div class="feat">
            <div class="feat-icon pink">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
            </div>
            <h3 class="feat-title">Hangat di Tubuh</h3>
            <p class="feat-text">Minuman herbal yang menemani hari, dari pagi yang sejuk hingga malam yang dingin.</p>
        </div>
    </section>

    {{-- ───── HOW IT WORKS ───── --}}
    <section class="how" id="cara">
        <div class="section-head">
            <span class="eyebrow"><span class="dot"></span> Mudah dalam 4 langkah</span>
            <h2 class="section-title">Cara Belanja di Rumah Rimpang</h2>
            <p class="section-sub">Tidak perlu bingung. Ikuti langkah berikut, pesananmu langsung sampai ke rumah.</p>
        </div>

        <div class="steps">
            <div class="step">
                <div class="step-num">1</div>
                <h4 class="step-title">Daftar / Masuk</h4>
                <p class="step-text">Buat akun gratis atau masuk dengan akun yang sudah ada.</p>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <h4 class="step-title">Pilih Produk</h4>
                <p class="step-text">Telusuri katalog dan tambahkan minuman herbal favoritmu ke keranjang.</p>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <h4 class="step-title">Isi Alamat &amp; Bayar</h4>
                <p class="step-text">Pilih metode pembayaran (COD, transfer, debit, atau VA) sesuai kenyamananmu.</p>
            </div>
            <div class="step">
                <div class="step-num">4</div>
                <h4 class="step-title">Tunggu di Rumah</h4>
                <p class="step-text">Pesananmu kami siapkan dan kirim. Lacak status di halaman Pesanan Saya.</p>
            </div>
        </div>
    </section>

    {{-- ───── CTA ───── --}}
    <section class="cta-strip" id="tentang">
        <div class="cta-card">
            <div class="cta-text">
                <div class="cta-eyebrow">Siap mencoba?</div>
                <h2 class="cta-title">Hangatkan harimu bersama <span>Rumah Rimpang</span></h2>
                <p class="cta-sub">
                    Daftar sekali, belanja kapan saja. Rasa khas rimpang Mestong tinggal selangkah lagi.
                </p>
            </div>
            <div class="cta-actions">
                @auth
                    <a href="{{ route('user.dashboard') }}" class="btn btn-gold btn-lg">Mulai Belanja Sekarang</a>
                @else
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-gold btn-lg">Daftar Gratis</a>
                    @endif
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-ghost btn-lg" style="background:rgba(255,255,255,0.08);color:#fff;border-color:rgba(255,255,255,0.18);">Masuk</a>
                    @endif
                @endauth
            </div>
        </div>
    </section>

    {{-- ───── FOOTER ───── --}}
    <footer class="foot">
        <div class="foot-text">
            &copy; {{ date('Y') }} <strong>Rumah Rimpang</strong> &mdash; Desa Suka Maju, Mestong, Jambi
        </div>
        <div class="foot-links">
            <a href="#produk">Produk</a>
            <a href="#cara">Cara Belanja</a>
            @auth
                <a href="{{ route('home') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Masuk</a>
            @endauth
        </div>
    </footer>

</body>
</html>
