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

    .method-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .method-option {
        position: relative;
        display: block;
        border: 1px solid rgba(65, 91, 60, 0.18);
        border-radius: 16px;
        padding: 16px;
        background: #f7f0dc;
        cursor: pointer;
        transition: transform .15s ease, border-color .15s ease, box-shadow .15s ease;
    }

    .method-option:hover {
        transform: translateY(-1px);
        border-color: rgba(126, 165, 119, 0.75);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.05);
    }

    .method-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .method-option.is-active {
        border-color: #7ea577;
        box-shadow: 0 10px 24px rgba(126, 165, 119, 0.16);
        background: #fffaf0;
    }

    .method-title {
        font-size: 16px;
        font-weight: 800;
        color: #2c3f2a;
        margin-bottom: 4px;
    }

    .method-desc {
        margin: 0;
        color: #5b7854;
        font-size: 13px;
        line-height: 1.45;
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
        const methodInputs = document.querySelectorAll('input[name="metode"]');
        const paymentInfo = document.getElementById('paymentInfo');
        const paymentLabel = document.getElementById('paymentLabel');
        const paymentValue = document.getElementById('paymentValue');

        function updateMethodState() {
            const selected = document.querySelector('input[name="metode"]:checked');
            const metode = selected ? selected.value : 'cod';

            document.querySelectorAll('.method-option').forEach(function(option) {
                option.classList.toggle('is-active', option.dataset.method === metode);
            });

            if (metode === 'transfer') {
                paymentInfo.classList.remove('d-none');
                paymentLabel.textContent = 'Rekening Transfer';
                paymentValue.textContent = 'BCA 1234567890 a.n. Rumah Rimpang';
                return;
            }

            paymentInfo.classList.add('d-none');
        }

        methodInputs.forEach(function(input) {
            input.addEventListener('change', updateMethodState);
        });

        updateMethodState();
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
            <h3 class="fw-bold mb-3">Transaksi Pesanan</h3>

            @if ($errors->any())
                <div class="alert alert-danger rounded-4 border-0">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="payment-card mb-3">
                <div class="meta-label">Pesanan</div>
                <div class="meta-value">#{{ sprintf('%04d', $order->id) }}</div>
                <div class="meta-label mt-3">Total Pesanan</div>
                <div class="meta-value">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
            </div>

            <div class="payment-card">
                <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="mb-3">
                        <label class="form-label d-block mb-2">Metode Transaksi</label>
                        <div class="method-grid">
                            <label class="method-option {{ old('metode', 'cod') === 'cod' ? 'is-active' : '' }}" data-method="cod">
                                <input type="radio" name="metode" value="cod" {{ old('metode', 'cod') === 'cod' ? 'checked' : '' }}>
                                <div class="method-title">COD</div>
                                <p class="method-desc">Bayar saat pesanan diterima. Cocok untuk transaksi langsung.</p>
                            </label>

                            <label class="method-option {{ old('metode') === 'transfer' ? 'is-active' : '' }}" data-method="transfer">
                                <input type="radio" name="metode" value="transfer" {{ old('metode') === 'transfer' ? 'checked' : '' }}>
                                <div class="method-title">Transfer</div>
                                <p class="method-desc">Transfer ke rekening toko dan pesanan akan diproses setelah pembayaran masuk.</p>
                            </label>
                        </div>
                        @error('metode')
                            <div class="text-danger mt-2" style="font-size: 13px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="paymentInfo" class="payment-card mb-3 d-none">
                        <div class="meta-label" id="paymentLabel"></div>
                        <div class="meta-value" id="paymentValue"></div>
                    </div>

                    <div class="mb-4 text-muted" style="font-size: 14px;">
                        Pilih COD jika ingin bayar saat pesanan diterima, atau Transfer jika ingin bayar melalui rekening toko.
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn-soft-primary">Kirim Transaksi</button>
                        <a href="{{ route('orders.show', $order) }}" class="btn-soft-secondary">Kembali</a>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
