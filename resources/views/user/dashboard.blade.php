@extends('layouts.app')

@section('content')
<style>
    .user-dashboard-page .navbar {
        display: none;
    }

    .user-dashboard-page main.py-4 {
        padding: 0 !important;
    }

    .user-page {
        min-height: 100vh;
        background: #9fdc8a;
        color: #1f2b1d;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.45;
    }

    .user-nav {
        background: #a7df90;
        border-bottom: 1px solid rgba(45, 77, 37, 0.08);
        position: sticky;
        top: 0;
        z-index: 20;
    }

    .user-nav .container {
        max-width: 980px;
    }

    .brand-pill {
        width: 120px;
        height: 60px;
        background: #f5e28f;
        border-radius: 0 0 30px 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 800;
        color: #2f7030;
        line-height: 1.1;
    }

    .menu-link {
        text-decoration: none;
        color: #1d2a1b;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }

    .cart-link {
        border: 1px solid #628d56;
        border-radius: 999px;
        padding: 4px 12px;
        text-decoration: none;
        color: #1f2b1d;
        font-size: 12px;
        font-weight: 600;
        background: rgba(255, 255, 255, 0.5);
    }

    .user-content {
        max-width: 980px;
    }

    .about-section {
        display: none;
    }

    .about-section:target {
        display: block;
    }

    .about-section:target ~ .home-hero-wrap,
    .about-section:target ~ .feature-row,
    .about-section:target ~ #produk {
        display: none;
    }

    .home-hero-wrap {
        padding-top: 18px;
        padding-bottom: 12px;
    }

    .home-hero {
        background: #efe17e;
        border-radius: 22px;
        min-height: 166px;
        padding: 24px 206px 20px 22px;
        position: relative;
        overflow: hidden;
    }

    .home-hero-title {
        margin: 0 0 4px;
        color: #54a04b;
        font-size: 34px;
        font-weight: 800;
        line-height: 1.15;
    }

    .home-hero-subtitle {
        margin: 0 0 14px;
        color: #69a85d;
        font-size: 18px;
        font-weight: 600;
    }

    .home-hero-cta {
        border: 0;
        border-radius: 999px;
        padding: 9px 18px;
        font-size: 14px;
        color: #f0f5ea;
        text-decoration: none;
        background: #8fa07d;
        display: inline-block;
        line-height: 1;
        font-weight: 700;
    }

    .home-hero-image {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 140px;
        height: 120px;
        object-fit: cover;
        object-position: center;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.7);
        display: block;
    }

    .about-hero {
        background: #e9dbb8;
        border-radius: 0 0 58px 58px;
        min-height: 170px;
        padding: 26px 20px 36px;
        position: relative;
        overflow: hidden;
    }

    .about-hero::after {
        content: "";
        position: absolute;
        left: -10%;
        right: -10%;
        bottom: -58px;
        height: 100px;
        background: #9fdc8a;
        border-radius: 50%;
    }

    .about-title {
        color: #5ea34d;
        font-size: 34px;
        font-weight: 800;
        line-height: 1.15;
        margin-bottom: 6px;
        position: relative;
        z-index: 1;
    }

    .about-subtitle {
        color: #63a552;
        font-size: 16px;
        font-weight: 600;
        position: relative;
        z-index: 1;
    }

    .about-card,
    .timeline-card,
    .vision-card,
    .mission-card {
        background: #f8efd8;
        border-radius: 14px;
        padding: 18px;
    }

    .about-card {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .about-icon {
        width: 40px;
        height: 40px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #8db080;
        color: #fff;
        font-size: 18px;
        flex-shrink: 0;
    }

    .about-heading {
        font-size: 28px;
        line-height: 1;
        font-weight: 700;
        margin-bottom: 8px;
        color: #1f2b1d;
    }

    .about-text {
        margin: 0;
        font-size: 15px;
        line-height: 1.6;
        color: #1f2b1d;
    }

    .timeline-card {
        margin-top: 14px;
    }

    .timeline-head {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 12px;
        color: #1f2b1d;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .timeline-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }

    .timeline-item {
        min-height: 142px;
    }

    .year-pill {
        display: block;
        text-align: center;
        border-radius: 999px;
        background: #8db080;
        color: #0f2711;
        font-weight: 700;
        font-size: 14px;
        padding: 4px 10px;
        margin-bottom: 10px;
    }

    .timeline-item p {
        font-size: 12px;
        line-height: 1.5;
        margin-bottom: 0;
        color: #222d20;
    }

    .vision-mission-grid {
        margin-top: 14px;
    }

    .vision-card,
    .mission-card {
        min-height: 240px;
    }

    .panel-head {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #1f2b1d;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .panel-text,
    .mission-list {
        font-size: 15px;
        line-height: 1.6;
        margin: 0;
        color: #2a3927;
    }

    .mission-list {
        padding-left: 24px;
    }

    .mission-list li {
        margin-bottom: 10px;
    }

    .mission-list li:last-child {
        margin-bottom: 0;
    }

    .feature-row {
        background: #f8efd8;
        border-top: 1px solid rgba(60, 85, 55, 0.06);
        border-bottom: 1px solid rgba(60, 85, 55, 0.06);
    }

    .feature-card {
        background: #e1d2ad;
        border-radius: 14px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: #2f4a2d;
        min-height: 82px;
        font-size: 30px;
        font-weight: 600;
    }

    .feature-icon {
        width: 34px;
        height: 34px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        background: #6da866;
        color: white;
        flex-shrink: 0;
    }

    .feature-icon.favorite {
        background: #ff6ca8;
    }

    .section-title {
        font-size: 28px;
        margin-right: 8px;
    }

    .product-card {
        background: #f6eed6;
        border-radius: 12px;
        padding: 10px;
        height: 100%;
    }

    .product-image-wrap {
        width: 100%;
        aspect-ratio: 5 / 4;
        border-radius: 8px;
        overflow: hidden;
        background: #ece2cb;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
    }

    .product-name {
        font-size: 14px;
        font-weight: 700;
        color: #2f4a2d;
        margin-top: 9px;
        line-height: 1.2;
    }

    .product-meta {
        font-size: 13px;
        color: #53724e;
        margin-bottom: 2px;
    }

    .product-bottom {
        margin-top: 5px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .sold-badge {
        display: inline-block;
        background: #86b37c;
        color: white;
        font-size: 10px;
        border-radius: 999px;
        padding: 2px 8px;
        font-weight: 700;
    }

    .go-badge {
        display: inline-block;
        background: #8ea484;
        color: #fff;
        font-size: 10px;
        border-radius: 999px;
        padding: 2px 8px;
        font-weight: 700;
    }

    .category-card {
        background: #f6eed6;
        border-radius: 12px;
        text-align: center;
        padding: 14px;
        font-weight: 600;
        color: #77a46c;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .category-icon {
        font-size: 18px;
        line-height: 1;
        color: #1f2b1d;
    }

    .logout-mini {
        border: 0;
        border-radius: 999px;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 700;
        background: #f4e58a;
        color: #1f2b1d;
    }

    @media (max-width: 991.98px) {
        .home-hero {
            padding-right: 168px;
        }

        .home-hero-title {
            font-size: 28px;
        }

        .home-hero-subtitle {
            font-size: 16px;
        }

        .home-hero-cta {
            font-size: 13px;
        }

        .feature-card {
            font-size: 20px;
        }

        .about-title {
            font-size: 30px;
        }

        .about-subtitle {
            font-size: 15px;
        }

        .about-heading,
        .timeline-head,
        .panel-head {
            font-size: 24px;
        }

        .about-text,
        .panel-text,
        .mission-list {
            font-size: 14px;
        }

        .timeline-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .timeline-item {
            min-height: auto;
        }
    }

    @media (max-width: 767.98px) {
        .home-hero {
            min-height: 148px;
            padding: 16px 16px 16px;
        }

        .home-hero-title {
            font-size: 22px;
            padding-right: 116px;
        }

        .home-hero-subtitle {
            font-size: 13px;
            padding-right: 116px;
        }

        .home-hero-cta {
            font-size: 12px;
            padding: 8px 14px;
        }

        .home-hero-image {
            width: 100px;
            height: 86px;
            right: 10px;
        }

        .feature-card {
            font-size: 16px;
            min-height: 68px;
            padding: 14px;
        }

        .about-hero {
            min-height: 180px;
            padding: 16px 16px 28px;
            border-radius: 0 0 30px 30px;
        }

        .about-title {
            font-size: 26px;
        }

        .about-subtitle {
            font-size: 13px;
        }

        .about-heading,
        .timeline-head,
        .panel-head {
            font-size: 21px;
        }

        .about-text,
        .panel-text,
        .mission-list {
            font-size: 14px;
        }

        .timeline-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    document.body.classList.add('user-dashboard-page');
</script>

<div class="user-page" id="home">
    <nav class="user-nav py-2">
        <div class="container d-flex align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-4">
                <div class="brand-pill">RUMAH<br>RIMPANG</div>
                <a href="#home" class="menu-link">Home</a>
                <a href="#produk" class="menu-link">Shop</a>
                <a href="#about-section" class="menu-link">About Us</a>
                <a href="{{ route('user.profile') }}" class="menu-link">Saya</a>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('carts.index') }}" class="cart-link">Keranjang</a>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="logout-mini">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div id="about-section" class="about-section">
        <div class="container user-content py-0">
            <div class="about-hero mb-3">
                <h3 class="about-title">Tentang Rumah Rimpang 🌿</h3>
                <p class="about-subtitle mb-0">Produsen minuman herbal berbahan rimpang dari Desa Suka Maju Mestong</p>
            </div>
        </div>

        <div class="container user-content pb-4">
            <div class="about-card mb-3">
                <span class="about-icon">🌱</span>
                <div>
                    <h4 class="about-heading">Tentang Kami</h4>
                    <p class="about-text">
                        Rumah Rimpang merupakan usaha berbasis kelompok tani dari Desa Suka Maju, Mestong,
                        yang berfokus pada pengolahan minuman herbal berbahan dasar rimpang seperti jahe dan kunyit.
                        Usaha ini lahir dari semangat kebersamaan untuk mengembangkan potensi hasil pertanian
                        menjadi produk bernilai tambah.
                    </p>
                </div>
            </div>

            <div class="timeline-card">
                <h4 class="timeline-head">📖 Sejarah Singkat</h4>
                <div class="timeline-grid">
                    <div class="timeline-item">
                        <span class="year-pill">2020</span>
                        <p>Kelompok tani didirikan pada tahun 2020 untuk mengembangkan usaha bersama. Pada awalnya, kelompok ini berfokus pada kegiatan budidaya dan membangun kebersamaan antar anggota.</p>
                    </div>
                    <div class="timeline-item">
                        <span class="year-pill">2022</span>
                        <p>Perkembangan signifikan terjadi pada tahun 2022, ketika kelompok tani mulai berinovasi mengolah hasil panen menjadi produk wedang jahe serbuk dan kunyit asam cair.</p>
                    </div>
                    <div class="timeline-item">
                        <span class="year-pill">2023</span>
                        <p>Tahun 2023 menjadi titik signifikan dengan mulainya fasilitas bottling modern. Pada tahun ini, ibu-ibu kelompok tani melahirkan merek Rumah Rimpang dan berperan dalam pengolahan produk, sementara bapak-bapak fokus pada budidaya.</p>
                    </div>
                    <div class="timeline-item">
                        <span class="year-pill">2024</span>
                        <p>Sebagai bentuk komitmen profesionalisme, pada akhir tahun 2024 kelompok ini resmi memiliki legalitas melalui akta notaris, sehingga semakin memperkuat pengembangan usaha ke depan.</p>
                    </div>
                </div>
            </div>

            <div class="row g-3 vision-mission-grid">
                <div class="col-md-6">
                    <div class="vision-card h-100">
                        <h4 class="panel-head">🏆 Visi</h4>
                        <p class="panel-text">Menjadi produsen minuman herbal berbahan dasar jahe dan kunyit yang terkemuka dan terpercaya, dengan jaminan keamanan produk serta menghadirkan cita rasa otentik dan inovatif.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mission-card h-100">
                        <h4 class="panel-head">✳ Misi</h4>
                        <ol class="mission-list">
                            <li>Menghasilkan produk minuman herbal yang berkualitas tinggi, aman, dan berbahan alami.</li>
                            <li>Mengembangkan inovasi varian rasa sesuai tren.</li>
                            <li>Memperluas jangkauan pasar agar produk lebih dikenal masyarakat.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $heroImage = $topProducts->first()?->gambar ? asset('storage/' . $topProducts->first()->gambar) : null;
    @endphp

    <div class="container user-content home-hero-wrap">
        <div class="home-hero">
            <h3 class="home-hero-title">Selamat Datang! 🌿</h3>
            <p class="home-hero-subtitle">Minuman herbal segar untuk harimu</p>
            <a href="#produk" class="home-hero-cta">Belanja Sekarang</a>
            @if ($heroImage)
                <img src="{{ $heroImage }}" alt="Produk unggulan" class="home-hero-image">
            @else
                <div class="home-hero-image d-flex align-items-center justify-content-center text-muted">Foto</div>
            @endif
        </div>
    </div>

    <div class="feature-row py-4 mb-3">
        <div class="container user-content">
            <div class="row g-3">
                <div class="col-md-4">
                    <a href="{{ route('carts.index') }}" class="feature-card">
                        <span class="feature-icon">🛒</span>
                        <span>keranjang Saya</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('orders.index') }}" class="feature-card">
                        <span class="feature-icon">🧾</span>
                        <span>Pesanan Saya</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <span class="feature-icon favorite">💗</span>
                        <span>Favorite</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container user-content py-2 pb-5" id="produk">
        <h4 class="fw-bold mb-3"><span class="section-title">🔥</span>Produk Terlaris</h4>
        <div class="row g-4 mb-4">
            @forelse ($topProducts as $product)
                <div class="col-md-4">
                    <a href="{{ route('user.products.show', $product) }}" class="text-decoration-none d-block">
                    <div class="product-card">
                        <div class="product-image-wrap">
                            @if ($product->gambar)
                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="product-image">
                            @else
                                <div class="product-image d-flex align-items-center justify-content-center text-muted">No Image</div>
                            @endif
                        </div>
                        <div class="product-name">{{ $product->nama_produk }}</div>
                        <div class="product-meta">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                        <div class="product-bottom">
                            <span class="sold-badge">terjual {{ (int) ($product->total_terjual ?? 0) }}</span>
                            <span class="go-badge">Beli ›</span>
                        </div>
                    </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border-0">Belum ada data produk.</div>
                </div>
            @endforelse
        </div>

        <h4 class="fw-bold mb-3"><span class="section-title">🍃</span>Kategor Produk</h4>
        @php
            $categoryIcons = ['☕', '🥤', '📦'];
        @endphp
        <div class="row g-4">
            @forelse ($categories as $category)
                <div class="col-md-4">
                    <div class="category-card">
                        <span class="category-icon">{{ $categoryIcons[$loop->index % count($categoryIcons)] }}</span>
                        <span>{{ $category->nama_kategori }}</span>
                    </div>
                </div>
            @empty
                <div class="col-md-4">
                    <div class="category-card"><span class="category-icon">☕</span><span>Wedang</span></div>
                </div>
                <div class="col-md-4">
                    <div class="category-card"><span class="category-icon">🥤</span><span>Kitsaju</span></div>
                </div>
                <div class="col-md-4">
                    <div class="category-card"><span class="category-icon">📦</span><span>Paketan</span></div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
