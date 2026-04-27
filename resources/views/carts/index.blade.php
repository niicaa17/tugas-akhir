@extends('layouts.app')

@section('content')
<style>
    .user-cart-page .navbar {
        display: none;
    }

    .user-cart-page main.py-4 {
        padding: 0 !important;
    }

    .cart-page {
        min-height: 100vh;
        background: #9fdc8a;
        color: #243025;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    .cart-topbar {
        background: #8eaf84;
        padding: 14px 0;
    }

    .cart-container {
        max-width: 980px;
    }

    .nav-mini-btn {
        color: #1e2a1f;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
    }

    .cart-panel {
        background: #efe185;
        border-radius: 28px;
        padding: 24px;
        border: 1px solid rgba(57, 85, 48, 0.08);
    }

    .cart-item-card {
        background: #f8efd8;
        border-radius: 16px;
        padding: 14px;
        margin-bottom: 12px;
        border: 1px solid rgba(57, 85, 48, 0.08);
    }

    .cart-item-image {
        width: 100%;
        max-width: 120px;
        height: 110px;
        border-radius: 10px;
        object-fit: cover;
        background: #e9ddc4;
    }

    .cart-item-name {
        font-size: 19px;
        font-weight: 700;
        margin-bottom: 4px;
        color: #2b3d28;
    }

    .cart-item-meta {
        font-size: 14px;
        color: #54704f;
        margin-bottom: 2px;
    }

    .qty-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 28px;
        border-radius: 999px;
        background: #7da877;
        color: #fff;
        font-weight: 700;
        font-size: 13px;
    }

    .qty-controls {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 999px;
        background: #e8dcc1;
        padding: 5px 8px;
    }

    .btn-soft-plus {
        border: 0;
        border-radius: 999px;
        background: #7ea577;
        color: #f3f6ef;
        height: 30px;
        padding: 0 12px;
        font-weight: 700;
        font-size: 12px;
    }

    .summary-card {
        background: #ebddb6;
        border-radius: 16px;
        padding: 18px;
        position: sticky;
        top: 20px;
        border: 1px solid rgba(57, 85, 48, 0.09);
    }

    .summary-heading {
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 14px;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 14px;
        color: #3e5938;
    }

    .summary-total {
        border-top: 1px dashed rgba(57, 85, 48, 0.25);
        margin-top: 10px;
        padding-top: 12px;
        display: flex;
        justify-content: space-between;
        font-size: 17px;
        font-weight: 800;
    }

    .checkout-btn {
        width: 100%;
        border: 0;
        border-radius: 999px;
        background: #7ea577;
        color: #f3f6ef;
        font-weight: 700;
        height: 46px;
        margin-top: 14px;
    }

    .shop-link {
        display: inline-block;
        margin-top: 10px;
        color: #3d5e37;
        font-weight: 600;
        text-decoration: none;
    }

    .wedjangku-section {
        margin-top: 20px;
        background: #f8efd8;
        border-radius: 18px;
        padding: 16px;
        border: 1px solid rgba(57, 85, 48, 0.08);
    }

    .wedjangku-title {
        margin: 0;
        font-size: 24px;
        font-weight: 800;
        color: #254322;
    }

    .wedjangku-sub {
        margin: 3px 0 0;
        font-size: 14px;
        color: #4d6e47;
    }

    .wedjangku-card {
        margin-top: 14px;
        background: #ebddb6;
        border-radius: 14px;
        padding: 12px;
        display: grid;
        grid-template-columns: 94px 1fr auto;
        gap: 12px;
        align-items: center;
    }

    .wedjangku-image {
        width: 94px;
        height: 86px;
        border-radius: 10px;
        object-fit: cover;
        background: #ded1b5;
    }

    .wedjangku-name {
        margin: 0 0 2px;
        font-size: 17px;
        font-weight: 800;
        color: #243d22;
    }

    .wedjangku-price {
        margin: 0;
        color: #43603e;
        font-size: 13px;
    }

    .wedjangku-btn {
        border: 0;
        border-radius: 999px;
        background: #7ea577;
        color: #fff;
        height: 36px;
        padding: 0 16px;
        font-size: 13px;
        font-weight: 700;
    }

    .reco-grid {
        margin-top: 14px;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .reco-card {
        background: #f6eed6;
        border-radius: 12px;
        padding: 9px;
        border: 1px solid rgba(57, 85, 48, 0.08);
    }

    .reco-image {
        width: 100%;
        aspect-ratio: 4 / 3;
        object-fit: cover;
        border-radius: 8px;
        background: #ded3b8;
    }

    .reco-name {
        margin-top: 7px;
        font-size: 13px;
        line-height: 1.25;
        font-weight: 700;
        color: #2f4a2d;
    }

    .reco-price {
        margin-bottom: 6px;
        font-size: 12px;
        color: #53724e;
    }

    .reco-btn {
        border: 0;
        border-radius: 999px;
        background: #8ea484;
        color: #fff;
        height: 28px;
        width: 100%;
        font-size: 11px;
        font-weight: 700;
    }

    @media (max-width: 767.98px) {
        .wedjangku-card {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .wedjangku-image {
            margin: 0 auto;
        }

        .reco-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    document.body.classList.add('user-cart-page');
</script>

<div class="cart-page">
    <div class="cart-topbar">
        <div class="container cart-container d-flex align-items-center justify-content-between">
            <a href="{{ route('user.dashboard') }}" class="nav-mini-btn">&larr; Kembali Belanja</a>
            <span class="nav-mini-btn">Keranjang Saya</span>
        </div>
    </div>

    <div class="container cart-container py-4">
        @php $total = 0; @endphp
        @if (session('success'))
            <div class="alert alert-success border-0 rounded-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="cart-panel">
            <div class="row g-4">
                <div class="col-lg-8">
                    <h3 class="fw-bold mb-3">Keranjang Belanja</h3>

                    @if ($cartItems->isEmpty())
                        <div class="cart-item-card text-center py-4">
                            <h5 class="mb-1">Keranjang masih kosong</h5>
                            <p class="text-muted mb-2">Yuk pilih produk dulu.</p>
                            <a href="{{ route('user.dashboard') }}" class="shop-link">Lihat produk</a>
                        </div>
                    @else
                        @foreach ($cartItems as $item)
                            @php $subtotal = $item->product->harga * $item->qty; @endphp
                            <div class="cart-item-card">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-3 text-center text-md-start">
                                        @if ($item->product->gambar)
                                            <img src="{{ asset('storage/' . $item->product->gambar) }}" alt="{{ $item->product->nama_produk }}" class="cart-item-image">
                                        @else
                                            <div class="cart-item-image d-flex align-items-center justify-content-center text-muted">No Image</div>
                                        @endif
                                    </div>

                                    <div class="col-md-5">
                                        <div class="cart-item-name">{{ $item->product->nama_produk }}</div>
                                        <div class="cart-item-meta">Harga: Rp {{ number_format($item->product->harga, 0, ',', '.') }}</div>
                                        <div class="cart-item-meta">Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                                    </div>

                                    <div class="col-md-4 text-md-end">
                                        <div class="mb-2 d-inline-flex">
                                            <div class="qty-controls">
                                                <span class="qty-badge">x{{ $item->qty }}</span>
                                            </div>
                                        </div>
                                        <form action="{{ route('carts.store') }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                            <input type="hidden" name="qty" value="1">
                                            <button type="submit" class="btn-soft-plus">+ Tambah</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @php $total += $subtotal; @endphp
                        @endforeach
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="summary-card">
                        <h5 class="summary-heading">Ringkasan Belanja</h5>
                        <div class="summary-line">
                            <span>Total Item</span>
                            <strong>{{ $cartItems->sum('qty') }}</strong>
                        </div>
                        <div class="summary-line">
                            <span>Produk Unik</span>
                            <strong>{{ $cartItems->count() }}</strong>
                        </div>
                        <div class="summary-total">
                            <span>Total Harga</span>
                            <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                        </div>

                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="checkout-btn" {{ $cartItems->isEmpty() ? 'disabled' : '' }}>Checkout Sekarang</button>
                        </form>

                        <a href="{{ route('user.dashboard') }}" class="shop-link">Lanjut belanja</a>
                    </div>
                </div>
            </div>

            <div class="wedjangku-section">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                    <div>
                        <h4 class="wedjangku-title">Wedjangku Pilihan</h4>
                        <p class="wedjangku-sub">Tambah cepat varian Wedjangku favoritmu.</p>
                    </div>
                </div>

                @if ($wedjangkuProduct)
                    <div class="wedjangku-card">
                        @if ($wedjangkuProduct->gambar)
                            <img src="{{ asset('storage/' . $wedjangkuProduct->gambar) }}" alt="{{ $wedjangkuProduct->nama_produk }}" class="wedjangku-image">
                        @else
                            <div class="wedjangku-image d-flex align-items-center justify-content-center text-muted">No Image</div>
                        @endif

                        <div>
                            <h5 class="wedjangku-name">{{ $wedjangkuProduct->nama_produk }}</h5>
                            <p class="wedjangku-price mb-1">Rp {{ number_format($wedjangkuProduct->harga, 0, ',', '.') }}</p>
                            <small class="text-muted">Stok: {{ $wedjangkuProduct->stok }}</small>
                        </div>

                        <form action="{{ route('carts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $wedjangkuProduct->id }}">
                            <input type="hidden" name="qty" value="1">
                            <button type="submit" class="wedjangku-btn">+ Tambah Wedjangku</button>
                        </form>
                    </div>
                @endif

                <div class="reco-grid">
                    @forelse ($recommendedProducts as $product)
                        <div class="reco-card">
                            @if ($product->gambar)
                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="reco-image">
                            @else
                                <div class="reco-image d-flex align-items-center justify-content-center text-muted">No Image</div>
                            @endif
                            <div class="reco-name">{{ $product->nama_produk }}</div>
                            <div class="reco-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>

                            <form action="{{ route('carts.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="qty" value="1">
                                <button type="submit" class="reco-btn">Tambah ke Keranjang</button>
                            </form>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
