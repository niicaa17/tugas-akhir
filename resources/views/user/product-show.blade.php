@extends('layouts.app')

@section('content')
<style>
    .user-product-page .navbar {
        display: none;
    }

    .user-product-page main.py-4 {
        padding: 0 !important;
    }

    .product-detail-wrap {
        min-height: 100vh;
        background: #9fdc8a;
        color: #243025;
    }

    .detail-topbar {
        background: #8eaf84;
        padding: 14px 0;
    }

    .detail-container {
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

    .yellow-panel {
        background: #efe185;
        border-radius: 32px;
        padding: 26px;
    }

    .main-card {
        background: #ebddb6;
        border-radius: 14px;
        padding: 20px;
    }

    .main-image {
        width: 100%;
        max-width: 315px;
        height: 310px;
        border-radius: 10px;
        object-fit: cover;
        background: #dfd2b0;
    }

    .product-brand {
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    .rating {
        color: #e1a500;
        font-weight: 700;
        font-size: 14px;
    }

    .meta-line {
        margin-bottom: 8px;
        font-size: 28px;
        font-weight: 700;
    }

    .qty-wrap {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 20px;
        margin: 8px 0 18px;
    }

    .qty-btn {
        width: 28px;
        height: 28px;
        border: 0;
        border-radius: 6px;
        background: #7ea577;
        color: #112013;
        font-weight: 700;
        line-height: 1;
    }

    .action-row {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }

    .btn-soft {
        min-width: 190px;
        height: 52px;
        border: 0;
        border-radius: 999px;
        background: #8eb08a;
        color: #f2f6ef;
        font-weight: 700;
    }

    .sub-title {
        font-size: 30px;
        margin-right: 6px;
    }

    .other-card {
        background: #f8efd8;
        border-radius: 16px;
        padding: 10px;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .other-image {
        width: 100%;
        height: 130px;
        object-fit: cover;
        border-radius: 10px;
        background: #e8dcc5;
    }

    .other-name {
        font-weight: 700;
        margin-top: 8px;
        line-height: 1.2;
    }

    .buy-pill {
        border-radius: 999px;
        border: 0;
        background: #7ea577;
        color: #122012;
        font-size: 12px;
        font-weight: 700;
        padding: 3px 14px;
    }
</style>

<script>
    document.body.classList.add('user-product-page');

    function changeQty(delta) {
        const qtyInput = document.getElementById('qtyInput');
        let current = parseInt(qtyInput.value || '1', 10);
        current += delta;
        if (current < 1) {
            current = 1;
        }
        if (current > {{ max(1, (int) $product->stok) }}) {
            current = {{ max(1, (int) $product->stok) }};
        }
        qtyInput.value = current;
        const qtyText = document.getElementById('qtyText');
        qtyText.textContent = current;
    }
</script>

<div class="product-detail-wrap">
    <div class="detail-topbar">
        <div class="container detail-container d-flex align-items-center justify-content-between">
            <a href="{{ route('user.dashboard') }}" class="nav-mini-btn">&larr; Kembali</a>
            <a href="{{ route('carts.index') }}" class="nav-mini-btn">Keranjang</a>
        </div>
    </div>

    <div class="container detail-container py-5">
        <div class="yellow-panel">
            <div class="main-card mb-4">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-5 text-center text-lg-start">
                        @if ($product->gambar)
                            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="main-image">
                        @else
                            <div class="main-image d-flex align-items-center justify-content-center text-muted">No Image</div>
                        @endif
                    </div>
                    <div class="col-lg-7">
                        <div class="product-brand mb-1">{{ strtoupper($product->umkm->nama_umkm ?? 'PRODUK') }}</div>
                        <div class="rating mb-2">★★★★★ <span style="color:#8e9b6f; font-weight:500;">({{ max(1, (int) ($product->total_terjual ?? 0)) }})</span></div>
                        <div class="meta-line">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                        <div class="mb-1">Stok: {{ $product->stok }} Botol</div>
                        <div class="mb-1">🚚 Gratis Ongkir</div>
                        <div class="mb-2">📍 Dikirim dari Jambi</div>

                        <div class="qty-wrap">
                            <button type="button" class="qty-btn" onclick="changeQty(-1)">-</button>
                            <span id="qtyText">1</span>
                            <button type="button" class="qty-btn" onclick="changeQty(1)">+</button>
                        </div>

                        <div class="action-row">
                            <form action="{{ route('carts.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="qty" id="qtyInput" value="1">
                                <button type="submit" class="btn-soft">Tambah ke Keranjang</button>
                            </form>

                            <form action="{{ route('carts.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="qty" value="1">
                                <button type="submit" class="btn-soft">Beli Sekarang</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="fw-bold mb-3"><span class="sub-title">🍃</span>Produk lainnya</h4>
            <div class="row g-3">
                @forelse ($otherProducts as $other)
                    <div class="col-md-4 col-lg-3">
                        <a href="{{ route('user.products.show', $other) }}" class="other-card">
                            @if ($other->gambar)
                                <img src="{{ asset('storage/' . $other->gambar) }}" alt="{{ $other->nama_produk }}" class="other-image">
                            @else
                                <div class="other-image d-flex align-items-center justify-content-center text-muted">No Image</div>
                            @endif
                            <div class="other-name">{{ $other->nama_produk }}</div>
                            <div>Rp {{ number_format($other->harga, 0, ',', '.') }}</div>
                            <div class="mt-2 d-flex justify-content-end">
                                <span class="buy-pill">Beli →</span>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border-0">Belum ada produk lain.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
