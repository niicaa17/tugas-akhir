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

    #ufv-shell,
    #ufv-shell * { font-family: 'DM Sans', -apple-system, sans-serif !important; }

    #ufv-shell {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: var(--cream);
        overflow-y: auto;
        color: var(--ink);
        -webkit-font-smoothing: antialiased;
    }

    /* ═══ NAV ═══ */
    .ufv-nav {
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

    .ufv-nav-inner {
        max-width: 1020px;
        margin: 0 auto;
        padding: 0 28px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .ufv-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; flex-shrink: 0; cursor: pointer; }
    .ufv-brand-logo {
        width: 36px; height: 36px; border-radius: 8px;
        background: var(--gold-pale); border: 1px solid rgba(201,168,76,0.2);
        overflow: hidden; display: flex; align-items: center; justify-content: center;
    }
    .ufv-brand-logo img { width: 100%; height: 100%; object-fit: cover; }
    .ufv-brand-name { font-family: 'Playfair Display', serif !important; font-size: 14px; font-weight: 600; color: var(--ink); line-height: 1.2; }
    .ufv-brand-sub { font-size: 9.5px; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase; color: var(--muted); }

    .ufv-nav-links { display: flex; align-items: center; gap: 2px; }
    .ufv-nav-link {
        padding: 7px 13px; border-radius: 7px; text-decoration: none;
        font-size: 13px; font-weight: 500; color: var(--ink-soft);
        transition: all 0.17s; cursor: pointer; border: none; background: none;
        font-family: 'DM Sans', sans-serif !important;
    }
    .ufv-nav-link:hover { background: var(--sage-pale); color: var(--sage-deep); }
    .ufv-nav-link.active { background: var(--sage-pale); color: var(--sage-deep); font-weight: 600; }

    .ufv-nav-right { display: flex; align-items: center; gap: 8px; }
    .ufv-cart-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 14px; background: var(--surface);
        border: 1px solid var(--border-strong); border-radius: var(--radius-sm);
        text-decoration: none; font-size: 13px; font-weight: 500; color: var(--ink-soft);
        transition: all 0.17s;
    }
    .ufv-cart-btn:hover { background: var(--sage-pale); border-color: var(--sage); color: var(--sage-deep); }

    /* ═══ CONTENT ═══ */
    .ufv-wrap { max-width: 1020px; margin: 0 auto; padding: 0 28px 80px; }

    .ufv-header { margin: 36px 0 26px; }
    .ufv-eyebrow {
        font-size: 10.5px; font-weight: 700; letter-spacing: 0.16em;
        text-transform: uppercase; color: #c45c8a; margin-bottom: 8px;
    }
    .ufv-title { font-family: 'Playfair Display', serif !important; font-size: 30px; font-weight: 600; color: var(--ink); line-height: 1.2; }
    .ufv-title span { color: #E07FA8; }
    .ufv-sub { font-size: 14px; color: var(--muted); margin-top: 6px; }

    /* ═══ PRODUCT GRID ═══ */
    .ufv-products { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; margin-bottom: 32px; }

    .ufv-prod-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
        display: flex; flex-direction: column; transition: all 0.2s; position: relative;
    }
    .ufv-prod-card:hover { box-shadow: var(--shadow-md); transform: translateY(-3px); }
    .ufv-prod-link { text-decoration: none; color: inherit; display: flex; flex-direction: column; flex: 1; }

    .ufv-prod-img-wrap {
        width: 100%; aspect-ratio: 1/1; overflow: hidden; background: var(--cream);
        position: relative; padding: 10px; border-bottom: 1px solid var(--border);
    }
    .ufv-prod-img { width: 100%; height: 100%; object-fit: contain; display: block; transition: transform 0.32s; }
    .ufv-prod-card:hover .ufv-prod-img { transform: scale(1.04); }
    .ufv-prod-img-ph { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 13px; }

    .ufv-sold-ov {
        position: absolute; top: 9px; left: 9px;
        background: rgba(28,43,36,0.72); color: #fff;
        font-size: 10.5px; font-weight: 600; padding: 3px 8px; border-radius: 20px;
        backdrop-filter: blur(4px);
    }
    .ufv-habis-ov {
        position: absolute; bottom: 9px; left: 9px;
        background: linear-gradient(135deg, #d1546a, #b8364c); color: #fff;
        font-size: 10.5px; font-weight: 700; padding: 4px 10px; border-radius: 20px;
        letter-spacing: 0.06em; text-transform: uppercase;
        box-shadow: 0 2px 8px rgba(209,84,106,0.4);
    }
    .ufv-prod-card.ufv-habis .ufv-prod-img,
    .ufv-prod-card.ufv-habis .ufv-prod-img-ph { filter: grayscale(0.7) opacity(0.65); }

    /* remove button (filled heart) */
    .ufv-fav-btn {
        position: absolute; top: 9px; right: 9px;
        width: 34px; height: 34px; border-radius: 50%;
        background: #FEF0F6; border: 1px solid #E07FA8;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; z-index: 3; font-size: 16px; line-height: 1;
        color: #E07FA8; transition: all 0.18s; backdrop-filter: blur(4px);
    }
    .ufv-fav-btn:hover { transform: scale(1.12); background: #fff; }

    .ufv-prod-body { padding: 13px 15px 15px; flex: 1; display: flex; flex-direction: column; }
    .ufv-prod-name { font-size: 14px; font-weight: 600; color: var(--ink); line-height: 1.3; margin-bottom: 4px; }
    .ufv-prod-price { font-family: 'Playfair Display', serif !important; font-size: 15px; font-weight: 600; color: var(--ink); margin-bottom: 10px; }
    .ufv-prod-rating { display: flex; align-items: center; gap: 5px; margin-bottom: 8px; }
    .ufv-prod-stars { color: var(--gold); font-size: 13px; letter-spacing: 1px; line-height: 1; }
    .ufv-prod-rating-val { font-size: 12px; font-weight: 600; color: var(--ink); }
    .ufv-prod-foot { margin-top: auto; display: flex; align-items: center; justify-content: space-between; }
    .ufv-sold-lbl { font-size: 11px; font-weight: 500; color: var(--muted); }
    .ufv-buy-btn {
        display: inline-flex; align-items: center; padding: 5px 12px;
        background: var(--sage-pale); color: var(--sage-deep);
        border-radius: 20px; font-size: 12px; font-weight: 600;
    }
    .ufv-prod-card.ufv-habis .ufv-buy-btn { background: rgba(209,84,106,0.12); color: #b8364c; }

    /* ═══ EMPTY ═══ */
    .ufv-empty {
        text-align: center; padding: 64px 20px;
        background: var(--surface); border-radius: var(--radius);
        border: 1px solid var(--border); margin-bottom: 38px;
    }
    .ufv-empty-icon { font-size: 40px; margin-bottom: 14px; }
    .ufv-empty-title { font-size: 16px; font-weight: 600; color: var(--ink-soft); }
    .ufv-empty-sub { font-size: 13.5px; color: var(--muted); margin: 8px 0 20px; }
    .ufv-empty-cta {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 11px 22px; background: var(--sage-deep); color: #fff;
        border-radius: var(--radius-sm); text-decoration: none;
        font-size: 13.5px; font-weight: 600; transition: background 0.18s;
    }
    .ufv-empty-cta:hover { background: #3d7a5a; color: #fff; }

    /* ═══ TOAST ═══ */
    .ufv-toast {
        position: fixed; bottom: 28px; left: 50%;
        transform: translateX(-50%) translateY(20px);
        background: var(--ink); color: var(--cream);
        padding: 12px 22px; border-radius: 999px;
        font-size: 13.5px; font-weight: 600;
        opacity: 0; pointer-events: none; z-index: 10000;
        transition: opacity 0.3s, transform 0.3s; white-space: nowrap;
    }
    .ufv-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

    /* ═══ RESPONSIVE ═══ */
    @media (max-width: 800px) {
        .ufv-products { grid-template-columns: repeat(2,1fr); }
        .ufv-nav-links { display: none; }
    }
    @media (max-width: 560px) {
        .ufv-wrap { padding: 0 16px 60px; }
        .ufv-nav-inner { padding: 0 16px; }
        .ufv-products { grid-template-columns: repeat(2,1fr); gap: 10px; }
    }
</style>

<div id="ufv-shell">

    {{-- ── NAV ── --}}
    <nav class="ufv-nav">
        <div class="ufv-nav-inner">
            <a href="{{ route('user.dashboard') }}" class="ufv-brand">
                <div class="ufv-brand-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                </div>
                <div>
                    <div class="ufv-brand-name">Rumah Rimpang</div>
                    <div class="ufv-brand-sub">Herbal UMKM</div>
                </div>
            </a>

            <div class="ufv-nav-links">
                <a href="{{ route('user.dashboard') }}" class="ufv-nav-link">Home</a>
                <a href="{{ route('user.shop') }}" class="ufv-nav-link">Shop</a>
                <a href="{{ route('user.favorites') }}" class="ufv-nav-link active">Favorit</a>
                <a href="{{ route('user.profile') }}" class="ufv-nav-link">Profil</a>
            </div>

            <div class="ufv-nav-right">
                <a href="{{ route('carts.index') }}" class="ufv-cart-btn">🛒 Keranjang</a>
            </div>
        </div>
    </nav>

    <div class="ufv-wrap">

        <div class="ufv-header">
            <div class="ufv-eyebrow">Koleksi Pribadi</div>
            <h1 class="ufv-title">Produk <span>Favorit</span> 💗</h1>
            <p class="ufv-sub">Produk yang kamu sukai, tersimpan di satu tempat.</p>
        </div>

        @if($favorites->count())
        <div class="ufv-products">
            @foreach($favorites as $product)
            @php $isHabis = ($product->stok ?? 0) <= 0; @endphp
            <div class="ufv-prod-card {{ $isHabis ? 'ufv-habis' : '' }}" id="favCard-{{ $product->id }}">
                <button type="button"
                        class="ufv-fav-btn"
                        data-product="{{ $product->id }}"
                        onclick="ufvRemoveFav(this)"
                        aria-label="Hapus dari favorit"
                        title="Hapus dari favorit">♥</button>
                <a href="{{ route('user.products.show', $product) }}" class="ufv-prod-link">
                    <div class="ufv-prod-img-wrap">
                        @if($product->gambar)
                            <img src="{{ asset('storage/'.$product->gambar) }}" alt="{{ $product->nama_produk }}" class="ufv-prod-img">
                        @else
                            <div class="ufv-prod-img-ph">No Image</div>
                        @endif
                        @if($product->total_terjual ?? 0)
                            <span class="ufv-sold-ov">{{ (int)$product->total_terjual }}× terjual</span>
                        @endif
                        @if($isHabis)
                            <span class="ufv-habis-ov">Habis</span>
                        @endif
                    </div>
                    <div class="ufv-prod-body">
                        <div class="ufv-prod-name">{{ $product->nama_produk }}</div>
                        <div class="ufv-prod-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                        <div class="ufv-prod-rating">
                            <span class="ufv-prod-stars">★★★★★</span>
                            <span class="ufv-prod-rating-val">4.9</span>
                        </div>
                        <div class="ufv-prod-foot">
                            <span class="ufv-sold-lbl">
                                @if($isHabis)
                                    Stok habis
                                @else
                                    {{ $product->total_terjual ? 'Terjual '.(int)$product->total_terjual : 'Produk baru' }}
                                @endif
                            </span>
                            <span class="ufv-buy-btn">{{ $isHabis ? 'Habis' : 'Lihat →' }}</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @else
        <div class="ufv-empty">
            <div class="ufv-empty-icon">💗</div>
            <div class="ufv-empty-title">Belum ada produk favorit</div>
            <div class="ufv-empty-sub">Tekan ikon hati pada produk untuk menyimpannya di sini.</div>
            <a href="{{ route('user.shop') }}" class="ufv-empty-cta">Jelajahi Produk →</a>
        </div>
        @endif

    </div>
</div>

<div class="ufv-toast" id="ufvToast"></div>

<script>
    const UFV_TOGGLE_URL = "{{ route('user.favorites.toggle') }}";
    const UFV_CSRF = "{{ csrf_token() }}";

    function ufvShowToast(msg) {
        const t = document.getElementById('ufvToast');
        t.textContent = msg;
        t.classList.add('show');
        clearTimeout(t._timer);
        t._timer = setTimeout(() => t.classList.remove('show'), 2200);
    }

    function ufvRemoveFav(btn) {
        const productId = btn.dataset.product;
        btn.disabled = true;
        fetch(UFV_TOGGLE_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': UFV_CSRF,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ product_id: productId }),
        })
        .then(r => r.json())
        .then(data => {
            ufvShowToast(data.message);
            const card = document.getElementById('favCard-' + productId);
            if (card) {
                card.style.transition = 'opacity 0.3s, transform 0.3s';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.92)';
                setTimeout(() => {
                    card.remove();
                    if (!document.querySelectorAll('.ufv-prod-card').length) {
                        window.location.reload();
                    }
                }, 320);
            }
        })
        .catch(() => { ufvShowToast('Gagal memperbarui favorit'); btn.disabled = false; });
    }
</script>
@endsection
