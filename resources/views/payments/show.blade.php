@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Detail Pembayaran</h3>
                </div>

                <div class="card-body">
                    <p><strong>Order ID:</strong> {{ $payment->order_id }}</p>
                    <p><strong>Metode:</strong> {{ $payment->metode }}</p>
                    <p><strong>Jumlah:</strong> Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</p>
                    <p><strong>Status:</strong> {{ $payment->status }}</p>
                    @if ($payment->bukti_bayar)
                        <p><strong>Bukti Bayar:</strong> <img src="{{ asset('storage/' . $payment->bukti_bayar) }}" alt="Bukti Bayar" width="200"></p>
                    @endif
                    <p><strong>Dibuat:</strong> {{ $payment->created_at->format('d M Y H:i') }}</p>

                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
