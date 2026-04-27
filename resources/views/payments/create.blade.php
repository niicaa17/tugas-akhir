@extends('layouts.app')

@section('content')
<style>
    .user-payment-page .navbar {
        display: none;
    }

    .user-payment-page main.py-4 {
        padding: 0 !important;
    }

    .payment-page {
        min-height: 100vh;
        background: #9fdc8a;
        color: #243025;
    }

    .payment-topbar {
        background: #8eaf84;
        padding: 14px 0;
    }

    .payment-container {
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

    .payment-panel {
        background: #efe185;
        border-radius: 28px;
        padding: 24px;
    }

    .payment-card {
        background: #ebddb6;
        border-radius: 16px;
        padding: 18px;
    }

    .meta-label {
        font-size: 13px;
        color: #5b7854;
        margin-bottom: 4px;
    }

    .meta-value {
        font-weight: 700;
        color: #2f4a2d;
    }

    .form-label {
        font-weight: 600;
        color: #2c3f2a;
    }

    .form-control,
    .form-select {
        border-radius: 12px;
        border: 1px solid #c9ba8f;
        min-height: 46px;
        background: #f7f0dc;
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
    document.body.classList.add('user-payment-page');

    document.addEventListener('DOMContentLoaded', function() {
        const metodeSelect = document.getElementById('metode');
        const paymentInfo = document.getElementById('paymentInfo');
        const paymentLabel = document.getElementById('paymentLabel');
        const paymentValue = document.getElementById('paymentValue');
        const orderId = '{{ sprintf('%06d', $order->id) }}';

        function updatePaymentInfo() {
            const metode = metodeSelect.value;

            if (metode === 'debit') {
                paymentInfo.classList.remove('d-none');
                paymentLabel.textContent = 'No. Rekening Debit';
                paymentValue.textContent = 'BCA 1234567890 a.n. Rumah Rimpang';
                return;
            }

            if (metode === 'virtual_account') {
                paymentInfo.classList.remove('d-none');
                paymentLabel.textContent = 'No. Virtual Account';
                paymentValue.textContent = '8808' + orderId;
                return;
            }

            paymentInfo.classList.add('d-none');
        }

        metodeSelect.addEventListener('change', updatePaymentInfo);
        updatePaymentInfo();
    });
</script>

<div class="payment-page">
    <div class="payment-topbar">
        <div class="container payment-container d-flex align-items-center justify-content-between">
            <a href="{{ route('orders.show', $order) }}" class="nav-mini-btn">&larr; Kembali ke Detail Pesanan</a>
            <span class="nav-mini-btn">Pembayaran</span>
        </div>
    </div>

    <div class="container payment-container py-4">
        <div class="payment-panel">
            <h3 class="fw-bold mb-3">Upload Bukti Pembayaran</h3>

            @if ($errors->any())
                <div class="alert alert-danger rounded-4 border-0">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="payment-card">
                        <div class="meta-label">No. Pesanan</div>
                        <div class="meta-value">#{{ sprintf('%04d', $order->id) }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="payment-card">
                        <div class="meta-label">Total Tagihan</div>
                        <div class="meta-value">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <div class="payment-card">
                <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="mb-3">
                        <label for="metode" class="form-label">Metode Pembayaran</label>
                        <select name="metode" id="metode" class="form-select @error('metode') is-invalid @enderror" required>
                            <option value="cod" {{ old('metode') == 'cod' ? 'selected' : '' }}>COD</option>
                            <option value="debit" {{ old('metode') == 'debit' ? 'selected' : '' }}>Debit</option>
                            <option value="virtual_account" {{ old('metode') == 'virtual_account' ? 'selected' : '' }}>Virtual Account</option>
                        </select>
                        @error('metode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="paymentInfo" class="payment-card mb-3 d-none">
                        <div class="meta-label" id="paymentLabel"></div>
                        <div class="meta-value" id="paymentValue"></div>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah Pembayaran</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', $order->total_harga) }}" required>
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 text-muted" style="font-size: 14px;">
                        Pilih metode pembayaran. Jika Debit atau Virtual Account, gunakan nomor yang tampil di atas untuk melakukan pembayaran.
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn-soft-primary">Kirim Pembayaran</button>
                        <a href="{{ route('orders.show', $order) }}" class="btn-soft-secondary">Kembali</a>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
