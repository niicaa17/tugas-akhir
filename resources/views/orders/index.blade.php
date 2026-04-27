@extends('layouts.app')

@section('content')
<style>
    .user-order-page .navbar {
        display: none;
    }

    .user-order-page main.py-4 {
        padding: 0 !important;
    }

    .order-page {
        min-height: 100vh;
        background: #9fdc8a;
        color: #1f2b1d;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    .order-container {
        max-width: 980px;
    }

    .order-panel {
        background: #f8efd8;
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid rgba(57, 83, 52, 0.08);
    }

    .status-tabs {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        padding: 22px;
    }

    .status-tab {
        border: 0;
        border-radius: 999px;
        text-align: center;
        text-decoration: none;
        padding: 11px 10px;
        font-size: 15px;
        font-weight: 700;
        line-height: 1;
        color: #1f2b1d;
        background: #eadfc0;
        transition: background-color .2s ease, color .2s ease, transform .2s ease;
    }

    .status-tab:hover {
        background: #ddcfaa;
        color: #152515;
        transform: translateY(-1px);
    }

    .status-tab.active {
        background: #85ad7f;
        color: #fff;
    }

    .order-highlight-wrap {
        background: #9fdc8a;
        padding: 16px 12px 12px;
    }

    .order-highlight {
        background: #f8efd8;
        border-radius: 14px;
        padding: 12px;
        display: grid;
        grid-template-columns: 110px 1fr;
        gap: 14px;
        align-items: start;
    }

    .thumb-card {
        background: #f2f2f2;
        border-radius: 10px;
        padding: 8px;
    }

    .thumb-image {
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        border-radius: 8px;
        display: block;
        background: #ddd;
    }

    .order-title {
        margin: 2px 0 4px;
        font-size: 30px;
        font-weight: 700;
        line-height: 1.2;
        color: #1f2b1d;
    }

    .order-date {
        margin: 0 0 8px;
        font-size: 13px;
        color: #435b40;
    }

    .status-line {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin: 0;
        color: #263a24;
        font-size: 13px;
        font-weight: 600;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: #7ea577;
        display: inline-block;
    }

    .status-dot.dikirim {
        background: #f4b74f;
    }

    .status-dot.selesai {
        background: #4fa043;
    }

    .status-dot.dibatalkan {
        background: #cc6b6b;
    }

    .order-total {
        margin-top: 10px;
        font-size: 16px;
        font-weight: 700;
        color: #1f2b1d;
    }

    .order-link {
        display: inline-flex;
        margin-top: 8px;
        border-radius: 999px;
        background: #8ea484;
        color: #fff;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        padding: 6px 12px;
    }

    .order-empty {
        background: #f8efd8;
        border-radius: 12px;
        padding: 16px;
        color: #4a5f47;
    }

    .mini-products {
        margin-top: 18px;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        justify-content: end;
        max-width: 390px;
        margin-left: auto;
    }

    .mini-card {
        background: #f6eed6;
        border-radius: 12px;
        padding: 8px;
        text-decoration: none;
        color: inherit;
        border: 1px solid rgba(57, 83, 52, 0.08);
    }

    .mini-card-image {
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        object-position: center;
        display: block;
        border-radius: 8px;
        background: #dfd5bc;
    }

    .mini-name {
        margin-top: 7px;
        margin-bottom: 1px;
        font-size: 11px;
        font-weight: 700;
        color: #3b4e37;
        line-height: 1.25;
    }

    .mini-price {
        font-size: 10px;
        color: #53724e;
        margin-bottom: 5px;
    }

    .mini-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 6px;
    }

    .mini-badge {
        font-size: 8px;
        color: #fff;
        background: #8aa883;
        border-radius: 999px;
        padding: 2px 6px;
    }

    .mini-buy {
        font-size: 8px;
        color: #fff;
        background: #93a98a;
        border-radius: 999px;
        padding: 2px 6px;
    }

    .category-section {
        margin-top: 16px;
    }

    .category-title {
        margin: 0 0 10px;
        font-size: 35px;
        font-weight: 700;
        color: #1f2b1d;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .category-card {
        border-radius: 10px;
        background: #f7efd7;
        min-height: 46px;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 15px;
        font-weight: 600;
        color: #75a364;
    }

    .category-icon {
        font-size: 18px;
        color: #21361f;
        line-height: 1;
    }

    .order-pagination {
        margin-top: 16px;
    }

    @media (max-width: 767.98px) {
        .status-tabs {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            padding: 16px;
        }

        .order-highlight {
            grid-template-columns: 1fr;
        }

        .thumb-card {
            max-width: 130px;
        }

        .order-title {
            font-size: 24px;
        }

        .mini-products {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            max-width: 100%;
            margin-left: 0;
        }

        .category-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .category-title {
            font-size: 26px;
        }
    }
</style>

<script>
    document.body.classList.add('user-order-page');
</script>

<div class="order-page py-4">
    <div class="container order-container">
        <div class="order-panel">
            <div class="status-tabs">
                <a href="{{ route('orders.index') }}" class="status-tab {{ $statusTab === 'semua' ? 'active' : '' }}">Semua</a>
                <a href="{{ route('orders.index', ['status' => 'diproses']) }}" class="status-tab {{ $statusTab === 'diproses' ? 'active' : '' }}">Diproses</a>
                <a href="{{ route('orders.index', ['status' => 'dikirim']) }}" class="status-tab {{ $statusTab === 'dikirim' ? 'active' : '' }}">Dikirim</a>
                <a href="{{ route('orders.index', ['status' => 'selesai']) }}" class="status-tab {{ $statusTab === 'selesai' ? 'active' : '' }}">Selesai</a>
            </div>

            @if (session('success'))
                <div class="px-3">
                    <div class="alert alert-success mb-0">{{ session('success') }}</div>
                </div>
            @endif

            <div class="order-highlight-wrap">
                @php
                    $primaryOrder = $orders->first();
                    $primaryDetail = $primaryOrder?->orderDetails->first();
                    $primaryProduct = $primaryDetail?->product;

                    $statusLabel = [
                        'pending' => 'Diproses',
                        'dibayar' => 'Diproses',
                        'dikirim' => 'Dikirim',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                    ];
                @endphp

                @if ($primaryOrder)
                    @php
                        $orderStatusKey = $primaryOrder->status;
                        $dotClass = in_array($orderStatusKey, ['pending', 'dibayar'], true)
                            ? ''
                            : (in_array($orderStatusKey, ['dikirim'], true) ? 'dikirim' : (in_array($orderStatusKey, ['selesai'], true) ? 'selesai' : 'dibatalkan'));
                    @endphp
                    <div class="order-highlight">
                        <div class="thumb-card">
                            @if ($primaryProduct?->gambar)
                                <img src="{{ asset('storage/' . $primaryProduct->gambar) }}" alt="{{ $primaryProduct->nama_produk }}" class="thumb-image">
                            @else
                                <div class="thumb-image d-flex align-items-center justify-content-center text-muted">No Image</div>
                            @endif
                        </div>
                        <div>
                            <h3 class="order-title">{{ $primaryProduct?->nama_produk ?? 'Pesanan Kamu' }}</h3>
                            <p class="order-date">{{ $primaryOrder->created_at->translatedFormat('d F Y') }}</p>
                            <p class="status-line"><span class="status-dot {{ $dotClass }}"></span>{{ $statusLabel[$primaryOrder->status] ?? ucfirst($primaryOrder->status) }}</p>
                            <div class="order-total">Total Rp {{ number_format($primaryOrder->total_harga, 0, ',', '.') }}</div>
                            <a href="{{ route('orders.show', $primaryOrder) }}" class="order-link">Lihat Detail</a>
                        </div>
                    </div>
                @else
                    <div class="order-empty">Belum ada pesanan untuk status ini.</div>
                @endif
            </div>
        </div>

        <div class="mini-products">
            @forelse ($topProducts->take(2) as $product)
                <a href="{{ route('user.products.show', $product) }}" class="mini-card">
                    @if ($product->gambar)
                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="mini-card-image">
                    @else
                        <div class="mini-card-image d-flex align-items-center justify-content-center text-muted">No Image</div>
                    @endif
                    <div class="mini-name">{{ $product->nama_produk }}</div>
                    <div class="mini-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                    <div class="mini-bottom">
                        <span class="mini-badge">Rekomendasi</span>
                        <span class="mini-buy">Beli ›</span>
                    </div>
                </a>
            @empty
            @endforelse
        </div>

        <div class="category-section">
            <h4 class="category-title">Kategor Produk</h4>
            @php
                $categoryIcons = ['☕', '🥤', '📦'];
            @endphp
            <div class="category-grid">
                @forelse ($categories as $category)
                    <div class="category-card">
                        <span class="category-icon">{{ $categoryIcons[$loop->index % count($categoryIcons)] }}</span>
                        <span>{{ $category->nama_kategori }}</span>
                    </div>
                @empty
                    <div class="category-card"><span class="category-icon">☕</span><span>Wedang</span></div>
                    <div class="category-card"><span class="category-icon">🥤</span><span>Kitsaju</span></div>
                    <div class="category-card"><span class="category-icon">📦</span><span>Paketan</span></div>
                @endforelse
            </div>
        </div>

        <div class="order-pagination d-flex justify-content-end">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
