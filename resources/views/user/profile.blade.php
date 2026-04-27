@extends('layouts.app')

@section('content')
<style>
    .user-profile-page .navbar {
        display: none;
    }

    .user-profile-page main.py-4 {
        padding: 0 !important;
    }

    .profile-page {
        min-height: 100vh;
        background: #9fdc8a;
        color: #223022;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    .profile-topbar {
        background: #8eaf84;
        padding: 14px 0;
    }

    .profile-container {
        max-width: 980px;
    }

    .nav-mini-btn {
        color: #1e2a1f;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        font-size: 14px;
    }

    .profile-panel {
        background: #efe185;
        border-radius: 26px;
        padding: 22px;
        border: 1px solid rgba(57, 85, 48, 0.1);
    }

    .profile-main {
        background: #f8efd8;
        border-radius: 18px;
        padding: 18px;
        border: 1px solid rgba(57, 85, 48, 0.1);
    }

    .avatar-circle {
        width: 84px;
        height: 84px;
        border-radius: 999px;
        background: #7ea577;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .profile-name {
        margin: 0 0 2px;
        font-size: 28px;
        font-weight: 800;
        line-height: 1.2;
        color: #2c4327;
    }

    .profile-email {
        margin: 0;
        color: #4f6b48;
        font-size: 14px;
    }

    .profile-role {
        display: inline-flex;
        margin-top: 8px;
        border-radius: 999px;
        background: #e3d6b3;
        color: #2f462b;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .detail-list {
        margin-top: 12px;
        display: grid;
        gap: 8px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        background: #ece0be;
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 14px;
    }

    .detail-label {
        color: #50694a;
        font-weight: 600;
    }

    .detail-value {
        font-weight: 700;
        color: #243b22;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .stat-card {
        background: #ebddb6;
        border-radius: 14px;
        padding: 14px;
        border: 1px solid rgba(57, 85, 48, 0.1);
    }

    .stat-label {
        margin: 0;
        color: #4f6b48;
        font-size: 13px;
        font-weight: 600;
    }

    .stat-value {
        margin: 2px 0 0;
        color: #21371f;
        font-size: 24px;
        font-weight: 800;
        line-height: 1.1;
    }

    .last-order-card {
        margin-top: 14px;
        background: #ebddb6;
        border-radius: 14px;
        padding: 14px;
        border: 1px solid rgba(57, 85, 48, 0.1);
    }

    .last-order-title {
        margin: 0 0 8px;
        font-size: 16px;
        font-weight: 800;
        color: #2c4327;
    }

    .last-order-line {
        margin: 0;
        font-size: 14px;
        color: #4b6846;
    }

    .last-order-total {
        margin-top: 7px;
        font-size: 18px;
        font-weight: 800;
        color: #1f361d;
    }

    .profile-actions {
        margin-top: 16px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .btn-soft {
        border: 0;
        border-radius: 999px;
        height: 42px;
        padding: 0 16px;
        font-size: 13px;
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
        background: #d8cda9;
        color: #274023;
    }

    @media (max-width: 767.98px) {
        .profile-name {
            font-size: 24px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .detail-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
        }
    }
</style>

<script>
    document.body.classList.add('user-profile-page');
</script>

<div class="profile-page">
    <div class="profile-topbar">
        <div class="container profile-container d-flex align-items-center justify-content-between">
            <a href="{{ route('user.dashboard') }}" class="nav-mini-btn">&larr; Kembali ke Dashboard</a>
            <span class="nav-mini-btn">Profil Saya</span>
        </div>
    </div>

    <div class="container profile-container py-4">
        <div class="profile-panel">
            <div class="row g-3">
                <div class="col-lg-5">
                    <div class="profile-main h-100">
                        <div class="avatar-circle">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        <h3 class="profile-name">{{ $user->name }}</h3>
                        <p class="profile-email">{{ $user->email }}</p>
                        <span class="profile-role">{{ $user->role ?? 'user' }}</span>

                        <div class="detail-list">
                            <div class="detail-row">
                                <span class="detail-label">Bergabung</span>
                                <span class="detail-value">{{ $user->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Terakhir Login</span>
                                <span class="detail-value">Aktif</span>
                            </div>
                        </div>

                        <div class="profile-actions">
                            <a href="{{ route('orders.index') }}" class="btn-soft btn-soft-primary">Lihat Pesanan</a>
                            <a href="{{ route('carts.index') }}" class="btn-soft btn-soft-secondary">Buka Keranjang</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="stats-grid">
                        <div class="stat-card">
                            <p class="stat-label">Total Pesanan</p>
                            <h4 class="stat-value">{{ $orderCount }}</h4>
                        </div>
                        <div class="stat-card">
                            <p class="stat-label">Pesanan Aktif</p>
                            <h4 class="stat-value">{{ $activeOrderCount }}</h4>
                        </div>
                        <div class="stat-card">
                            <p class="stat-label">Pesanan Selesai</p>
                            <h4 class="stat-value">{{ $completedOrderCount }}</h4>
                        </div>
                        <div class="stat-card">
                            <p class="stat-label">Item di Keranjang</p>
                            <h4 class="stat-value">{{ $cartItemCount }}</h4>
                        </div>
                    </div>

                    <div class="last-order-card">
                        <h5 class="last-order-title">Ringkasan Akun</h5>
                        <p class="last-order-line">Total Belanja: <strong>Rp {{ number_format($totalSpent, 0, ',', '.') }}</strong></p>
                        @if ($lastOrder)
                            <p class="last-order-line mt-1">Pesanan Terakhir: #{{ sprintf('%04d', $lastOrder->id) }} ({{ ucfirst($lastOrder->status) }})</p>
                            <div class="last-order-total">Rp {{ number_format($lastOrder->total_harga, 0, ',', '.') }}</div>
                        @else
                            <p class="last-order-line mt-1">Belum ada pesanan. Mulai belanja untuk melihat ringkasan transaksi.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
