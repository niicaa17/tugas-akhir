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

    #ush-shell,
    #ush-shell * { font-family: 'DM Sans', -apple-system, sans-serif !important; }

    #ush-shell {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: var(--cream);
        overflow-y: auto;
        color: var(--ink);
        -webkit-font-smoothing: antialiased;
    }

    /* ═══ NAV ═══ */
    .ush-nav {
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

    .ush-nav-inner {
        max-width: 1020px;
        margin: 0 auto;
        padding: 0 28px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .ush-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        flex-shrink: 0;
        cursor: pointer;
    }

    .ush-brand-logo {
        width: 36px; height: 36px;
        border-radius: 8px;
        background: var(--gold-pale);
        border: 1px solid rgba(201,168,76,0.2);
        overflow: hidden;
        display: flex; align-items: center; justify-content: center;
    }

    .ush-brand-logo img { width: 100%; height: 100%; object-fit: cover; }
    .ush-brand-name { font-family: 'Playfair Display', serif !important; font-size: 14px; font-weight: 600; color: var(--ink); line-height: 1.2; }
    .ush-brand-sub { font-size: 9.5px; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase; color: var(--muted); }

    .ush-nav-links { display: flex; align-items: center; gap: 2px; }

    .ush-nav-link {
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

    .ush-nav-link:hover { background: var(--sage-pale); color: var(--sage-deep); }
    .ush-nav-link.active { background: var(--sage-pale); color: var(--sage-deep); font-weight: 600; }

    .ush-nav-right { display: flex; align-items: center; gap: 8px; }

    .ush-cart-btn {
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

    .ush-cart-btn:hover { background: var(--sage-pale); border-color: var(--sage); color: var(--sage-deep); }

    /* ═══ CONTENT ═══ */
    .ush-wrap { max-width: 1020px; margin: 0 auto; padding: 0 28px 80px; }

    .ush-header { margin: 36px 0 22px; }
    .ush-eyebrow {
        font-size: 10.5px; font-weight: 700;
        letter-spacing: 0.16em; text-transform: uppercase;
        color: var(--sage-deep); margin-bottom: 8px;
    }
    .ush-title {
        font-family: 'Playfair Display', serif !important;
        font-size: 30px; font-weight: 600;
        color: var(--ink); line-height: 1.2;
    }
    .ush-title span { color: var(--gold); }
    .ush-sub { font-size: 14px; color: var(--muted); margin-top: 6px; }

    /* ═══ TOOLBAR ═══ */
    .ush-toolbar {
        display: flex; align-items: center; gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 26px;
    }
    .ush-search {
        display: flex; align-items: center; gap: 8px;
        flex: 1; min-width: 240px;
        background: var(--surface);
        border: 1px solid var(--border-strong);
        border-radius: var(--radius-sm);
        padding: 0 14px;
        transition: border-color 0.17s;
    }
    .ush-search:focus-within { border-color: var(--sage); }
    .ush-search svg { flex-shrink: 0; color: var(--muted); }
    .ush-search input {
        flex: 1; border: none; outline: none; background: none;
        padding: 11px 0; font-size: 13.5px; color: var(--ink);
        font-family: 'DM Sans', sans-serif !important;
    }
    .ush-search input::placeholder { color: var(--muted); }

    .ush-sort {
        border: 1px solid var(--border-strong);
        border-radius: var(--radius-sm);
        background: var(--surface);
        padding: 10px 14px;
        font-size: 13.5px; font-weight: 500; color: var(--ink-soft);
        cursor: pointer; outline: none;
        font-family: 'DM Sans', sans-serif !important;
    }
    .ush-sort:focus { border-color: var(--sage); }

    .ush-search-btn {
        padding: 11px 20px;
        background: var(--sage-deep); color: #fff;
        border: none; border-radius: var(--radius-sm);
        font-size: 13.5px; font-weight: 600; cursor: pointer;
        transition: background 0.17s;
        font-family: 'DM Sans', sans-serif !important;
    }
    .ush-search-btn:hover { background: #3d7a5a; }

    .ush-result-note { font-size: 13px; color: var(--muted); margin-bottom: 16px; }

    /* ═══ PRODUCT GRID ═══ */
    .ush-products {
        display: grid;
        grid-template-columns: repeat(3,1fr);
        gap: 16px;
        margin-bottom: 32px;
    }

    .ush-prod-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        display: flex; flex-direction: column;
        transition: all 0.2s;
        position: relative;
    }

    .ush-prod-card:hover { box-shadow: var(--shadow-md); transform: translateY(-3px); }

    .ush-prod-link { text-decoration: none; color: inherit; display: flex; flex-direction: column; flex: 1; }

    .ush-prod-img-wrap {
        width: 100%; aspect-ratio: 1/1;
        overflow: hidden; background: var(--cream);
        position: relative;
        padding: 10px;
        border-bottom: 1px solid var(--border);
    }

    .ush-prod-img { width: 100%; height: 100%; object-fit: contain; display: block; transition: transform 0.32s; }
    .ush-prod-card:hover .ush-prod-img { transform: scale(1.04); }
    .ush-prod-img-ph { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 13px; }

    .ush-sold-ov {
        position: absolute; top: 9px; left: 9px;
        background: rgba(28,43,36,0.72); color: #fff;
        font-size: 10.5px; font-weight: 600;
        padding: 3px 8px; border-radius: 20px;
        backdrop-filter: blur(4px);
    }

    .ush-habis-ov {
        position: absolute; top: 9px; right: 9px;
        background: linear-gradient(135deg, #d1546a, #b8364c);
        color: #fff; font-size: 10.5px; font-weight: 700;
        padding: 4px 10px; border-radius: 20px;
        letter-spacing: 0.06em; text-transform: uppercase;
        box-shadow: 0 2px 8px rgba(209,84,106,0.4);
    }

    .ush-prod-card.ush-habis .ush-prod-img,
    .ush-prod-card.ush-habis .ush-prod-img-ph { filter: grayscale(0.7) opacity(0.65); }

    /* ═══ FAVORITE BUTTON ═══ */
    .ush-fav-btn {
        position: absolute; top: 9px; right: 9px;
        width: 34px; height: 34px;
        border-radius: 50%;
        background: rgba(255,255,255,0.92);
        border: 1px solid var(--border-strong);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; z-index: 3;
        font-size: 16px; line-height: 1;
        transition: all 0.18s;
        backdrop-filter: blur(4px);
    }
    .ush-fav-btn:hover { transform: scale(1.12); border-color: #E07FA8; }
    .ush-fav-btn .ush-heart-empty { color: #c98aa8; }
    .ush-fav-btn .ush-heart-full { color: #E07FA8; display: none; }
    .ush-fav-btn.is-fav { background: #FEF0F6; border-color: #E07FA8; }
    .ush-fav-btn.is-fav .ush-heart-empty { display: none; }
    .ush-fav-btn.is-fav .ush-heart-full { display: inline; }
    /* nudge favorite button left if a habis badge shares the corner */
    .ush-prod-card.ush-habis .ush-fav-btn { top: 42px; }

    .ush-prod-body { padding: 13px 15px 15px; flex: 1; display: flex; flex-direction: column; }
    .ush-prod-name { font-size: 14px; font-weight: 600; color: var(--ink); line-height: 1.3; margin-bottom: 4px; }
    .ush-prod-price { font-family: 'Playfair Display', serif !important; font-size: 15px; font-weight: 600; color: var(--ink); margin-bottom: 10px; }
    .ush-prod-foot { margin-top: auto; display: flex; align-items: center; justify-content: space-between; }
    .ush-sold-lbl { font-size: 11px; font-weight: 500; color: var(--muted); }
    .ush-buy-btn {
        display: inline-flex; align-items: center;
        padding: 5px 12px;
        background: var(--sage-pale); color: var(--sage-deep);
        border-radius: 20px; font-size: 12px; font-weight: 600;
    }
    .ush-prod-card.ush-habis .ush-buy-btn { background: rgba(209,84,106,0.12); color: #b8364c; }

    /* ═══ EMPTY ═══ */
    .ush-empty {
        text-align: center; padding: 60px 20px;
        background: var(--surface); border-radius: var(--radius);
        border: 1px solid var(--border); margin-bottom: 38px;
    }
    .ush-empty-icon { font-size: 34px; margin-bottom: 12px; opacity: 0.4; }
    .ush-empty-title { font-size: 15px; font-weight: 600; color: var(--ink-soft); }
    .ush-empty-sub { font-size: 13px; color: var(--muted); margin-top: 6px; }

    /* ═══ PAGINATION ═══ */
    .ush-pagination { display: flex; justify-content: center; margin-top: 10px; }
    .ush-pagination nav > div:first-child { display: none; }
    .ush-pagination svg { width: 18px; height: 18px; }

    /* ═══ TOAST ═══ */
    .ush-toast {
        position: fixed;
        bottom: 28px; left: 50%;
        transform: translateX(-50%) translateY(20px);
        background: var(--ink); color: var(--cream);
        padding: 12px 22px; border-radius: 999px;
        font-size: 13.5px; font-weight: 600;
        opacity: 0; pointer-events: none; z-index: 10000;
        transition: opacity 0.3s, transform 0.3s;
        white-space: nowrap;
    }
    .ush-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

    /* ═══ RESPONSIVE ═══ */
    @media (max-width: 800px) {
        .ush-products { grid-template-columns: repeat(2,1fr); }
        .ush-nav-links { display: none; }
    }
    @media (max-width: 560px) {
        .ush-wrap { padding: 0 16px 60px; }
        .ush-nav-inner { padding: 0 16px; }
        .ush-products { grid-template-columns: repeat(2,1fr); gap: 10px; }
        .ush-toolbar { flex-direction: column; align-items: stretch; }
    }
</style>

<div id="ush-shell">

    {{-- ── NAV ── --}}
    <nav class="ush-nav">
        <div class="ush-nav-inner">
            <a href="{{ route('user.dashboard') }}" class="ush-brand">
                <div class="ush-brand-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                </div>
                <div>
                    <div class="ush-brand-name">Rumah Rimpang</div>
                    <div class="ush-brand-sub">Herbal UMKM</div>
                </div>
            </a>

            <div class="ush-nav-links">
                <a href="{{ route('user.dashboard') }}" class="ush-nav-link">Home</a>
                <a href="{{ route('user.shop') }}" class="ush-nav-link active">Shop</a>
                <a href="{{ route('user.favorites') }}" class="ush-nav-link">Favorit</a>
                <a href="{{ route('user.profile') }}" class="ush-nav-link">Profil</a>
            </div>

            <div class="ush-nav-right">
                <a href="{{ route('carts.index') }}" class="ush-cart-btn">🛒 Keranjang</a>
            </div>
        </div>
    </nav>

    <div class="ush-wrap">

        <div class="ush-header">
            <div class="ush-eyebrow">Katalog Produk</div>
            <h1 class="ush-title">Belanja Produk <span>Herbal</span> 🌿</h1>
            <p class="ush-sub">Temukan semua minuman herbal pilihan dari rimpang segar.</p>
        </div>

        <form method="GET" action="{{ route('user.shop') }}" class="ush-toolbar">
            <label class="ush-search">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari produk...">
            </label>
            <select name="sort" class="ush-sort" onchange="this.form.submit()">
                <option value="terlaris" {{ $sort === 'terlaris' ? 'selected' : '' }}>Terlaris</option>
                <option value="termurah" {{ $sort === 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                <option value="termahal" {{ $sort === 'termahal' ? 'selected' : '' }}>Harga Termahal</option>
                <option value="nama" {{ $sort === 'nama' ? 'selected' : '' }}>Nama A-Z</option>
            </select>
            <button type="submit" class="ush-search-btn">Cari</button>
        </form>

        @if($search !== '')
            <div class="ush-result-note">Menampilkan hasil untuk "<strong>{{ $search }}</strong>" — {{ $products->total() }} produk</div>
        @endif

        @if($products->count())
        <div class="ush-products">
            @foreach($products as $product)
            @php
                $isHabis = ($product->stok ?? 0) <= 0;
                $isFav = in_array($product->id, $favoriteIds);
            @endphp
            <div class="ush-prod-card {{ $isHabis ? 'ush-habis' : '' }}">
                <button type="button"
                        class="ush-fav-btn {{ $isFav ? 'is-fav' : '' }}"
                        data-product="{{ $product->id }}"
                        onclick="ushToggleFav(this)"
                        aria-label="Tambah ke favorit">
                    <span class="ush-heart-empty">♡</span>
                    <span class="ush-heart-full">♥</span>
                </button>
                <a href="{{ route('user.products.show', $product) }}" class="ush-prod-link">
                    <div class="ush-prod-img-wrap">
                        @if($product->gambar)
                            <img src="{{ asset('storage/'.$product->gambar) }}" alt="{{ $product->nama_produk }}" class="ush-prod-img">
                        @else
                            <div class="ush-prod-img-ph">No Image</div>
                        @endif
                        @if($product->total_terjual ?? 0)
                            <span class="ush-sold-ov">{{ (int)$product->total_terjual }}× terjual</span>
                        @endif
                        @if($isHabis)
                            <span class="ush-habis-ov">Habis</span>
                        @endif
                    </div>
                    <div class="ush-prod-body">
                        <div class="ush-prod-name">{{ $product->nama_produk }}</div>
                        <div class="ush-prod-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                        <div class="ush-prod-foot">
                            <span class="ush-sold-lbl">
                                @if($isHabis)
                                    Stok habis
                                @else
                                    {{ $product->total_terjual ? 'Terjual '.(int)$product->total_terjual : 'Produk baru' }}
                                @endif
                            </span>
                            <span class="ush-buy-btn">{{ $isHabis ? 'Habis' : 'Beli →' }}</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div class="ush-pagination">
            {{ $products->links() }}
        </div>
        @else
        <div class="ush-empty">
            <div class="ush-empty-icon">🔍</div>
            <div class="ush-empty-title">Produk tidak ditemukan</div>
            <div class="ush-empty-sub">Coba kata kunci lain atau lihat semua produk.</div>
        </div>
        @endif

    </div>
</div>

<div class="ush-toast" id="ushToast"></div>

<script>
    const USH_TOGGLE_URL = "{{ route('user.favorites.toggle') }}";
    const USH_CSRF = "{{ csrf_token() }}";

    function ushShowToast(msg) {
        const t = document.getElementById('ushToast');
        t.textContent = msg;
        t.classList.add('show');
        clearTimeout(t._timer);
        t._timer = setTimeout(() => t.classList.remove('show'), 2200);
    }

    function ushToggleFav(btn) {
        const productId = btn.dataset.product;
        btn.disabled = true;
        fetch(USH_TOGGLE_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': USH_CSRF,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ product_id: productId }),
        })
        .then(r => r.json())
        .then(data => {
            btn.classList.toggle('is-fav', data.favorited);
            ushShowToast(data.message);
        })
        .catch(() => ushShowToast('Gagal memperbarui favorit'))
        .finally(() => { btn.disabled = false; });
    }
</script>
@endsection
