@extends('layouts.app')

@section('content')
<style>
    .user-order-detail-page .navbar {
        display: none;
    }

    .user-order-detail-page main.py-4 {
        padding: 0 !important;
    }

    .order-detail-page {
        min-height: 100vh;
        background: #9fdc8a;
        color: #243025;
    }

    .order-topbar {
        background: #8eaf84;
        padding: 14px 0;
    }

    .order-container {
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

    .order-panel {
        background: #efe185;
        border-radius: 28px;
        padding: 24px;
    }

    .summary-card {
        background: #ebddb6;
        border-radius: 16px;
        padding: 18px;
        height: 100%;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        background: #7ea577;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        padding: 5px 12px;
    }

    .detail-table-wrap {
        background: #f8efd8;
        border-radius: 16px;
        padding: 14px;
    }

    .detail-table th {
        color: #486746;
        font-size: 13px;
        border-bottom: 1px solid #d6c99f;
    }

    .detail-table td {
        border-bottom: 1px solid #eadfbe;
        vertical-align: middle;
    }

    .total-line {
        font-size: 22px;
        font-weight: 800;
        color: #314c2f;
    }

    .btn-soft-primary,
    .btn-soft-secondary {
        border: 0;
        border-radius: 999px;
        height: 44px;
        padding: 0 20px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-soft-primary {
        background: #7ea577;
        color: #f4f7ef;
    }

    .btn-soft-secondary {
        background: #c6d6b3;
        color: #1d2a1f;
    }
</style>

<script>
    document.body.classList.add('user-order-detail-page');
</script>

<div class="order-detail-page">
    <div class="order-topbar">
        <div class="container order-container d-flex align-items-center justify-content-between">
            <a href="{{ route('orders.index') }}" class="nav-mini-btn">&larr; Kembali ke Riwayat</a>
            <span class="nav-mini-btn">Detail Pesanan</span>
        </div>
    </div>

    <div class="container order-container py-4">
        <div class="order-panel">
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <div class="summary-card">
                        <div class="text-muted small mb-1">No. Pesanan</div>
                        <h4 class="fw-bold mb-0">#{{ sprintf('%04d', $order->id) }}</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <div class="text-muted small mb-1">Status</div>
                        <span class="status-badge">{{ ucfirst($order->status) }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <div class="text-muted small mb-1">Tanggal</div>
                        <div class="fw-semibold">{{ $order->created_at->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <div class="detail-table-wrap mb-3">
                <h5 class="fw-bold mb-3">Detail Produk</h5>
                <div class="table-responsive">
                    <table class="table detail-table mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-end">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetails as $detail)
                                <tr>
                                    <td>{{ $detail->product->nama_produk }}</td>
                                    <td class="text-end">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $detail->qty }}</td>
                                    <td class="text-end fw-semibold">Rp {{ number_format($detail->harga * $detail->qty, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div class="total-line">Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                <div class="d-flex gap-2">
                    @if ($order->status == 'pending' && auth()->user()->role !== 'admin')
                        <a href="{{ route('payments.create', ['order' => $order->id]) }}" class="btn-soft-primary">Bayar Sekarang</a>
                    @endif
                    <a href="{{ route('orders.index') }}" class="btn-soft-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
