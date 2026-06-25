@extends('layouts.app')

@section('content')
@verbatim
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&family=Playfair+Display:wght@600;700&display=swap');

    .auth-login-page .navbar {
        display: none;
    }

    .auth-login-page main.py-4 {
        padding: 0 !important;
    }

    .auth-login-page #app {
        min-height: 100vh;
    }

    .auth-login-wrap {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: clamp(20px, 4vw, 40px);
        font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        background:
            radial-gradient(ellipse 90% 70% at 10% 20%, rgba(124, 185, 154, 0.35), transparent 55%),
            radial-gradient(ellipse 70% 50% at 90% 80%, rgba(201, 168, 76, 0.18), transparent 50%),
            linear-gradient(165deg, #e8f4ee 0%, #f7f4ee 40%, #ede8df 100%);
        position: relative;
        overflow: hidden;
    }

    .auth-login-wrap::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%234a8a6a' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.9;
        pointer-events: none;
    }

    .auth-login-inner {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 420px;
    }

    .auth-card {
        width: 100%;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, #fff 100%);
        border-radius: 24px;
        padding: clamp(32px, 5vw, 44px) clamp(28px, 4vw, 40px);
        border: 1px solid rgba(124, 185, 154, 0.22);
        box-shadow:
            0 4px 6px rgba(28, 43, 36, 0.04),
            0 24px 48px rgba(28, 43, 36, 0.1);
    }

    .auth-brand-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        margin-bottom: 28px;
    }

    .auth-logo-frame {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: linear-gradient(145deg, #e8f4ee, #fff);
        border: 1px solid rgba(124, 185, 154, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        box-shadow: 0 4px 14px rgba(74, 138, 106, 0.12);
    }

    .auth-logo-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .auth-eyebrow {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #4a8a6a;
        text-align: center;
        margin-bottom: 8px;
    }

    .auth-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(26px, 5vw, 32px);
        font-weight: 700;
        color: #1c2b24;
        margin: 0 0 10px;
        text-align: center;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .auth-subtitle {
        font-size: 14px;
        color: #4a6858;
        line-height: 1.55;
        font-weight: 400;
        text-align: center;
        margin: 0 0 28px;
        max-width: 320px;
        margin-left: auto;
        margin-right: auto;
    }

    .auth-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #2e4a3a;
        margin-bottom: 8px;
        letter-spacing: 0.02em;
    }

    .auth-field {
        position: relative;
        margin-bottom: 18px;
    }

    .auth-field:last-of-type {
        margin-bottom: 22px;
    }

    .auth-field .form-control {
        height: 50px;
        border-radius: 14px;
        border: 1px solid rgba(124, 185, 154, 0.35);
        padding: 12px 16px 12px 48px;
        background: #fafbf9;
        font-size: 15px;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        font-weight: 500;
        color: #1c2b24;
    }

    .auth-field .form-control:hover {
        border-color: rgba(124, 185, 154, 0.55);
        background: #fff;
    }

    .auth-field .form-control:focus {
        background: #fff;
        border-color: #7cb99a;
        box-shadow: 0 0 0 4px rgba(124, 185, 154, 0.15);
        outline: none;
    }

    .auth-field .form-control::placeholder {
        color: #8a9e93;
        font-weight: 400;
    }

    .auth-field .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #4a8a6a;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }

    .btn-auth-main {
        width: 100%;
        height: 50px;
        border-radius: 14px;
        border: none;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.15s, box-shadow 0.2s, background 0.2s;
        font-family: 'DM Sans', sans-serif;
        background: linear-gradient(135deg, #4a8a6a 0%, #7cb99a 100%);
        color: #fff;
        box-shadow: 0 4px 16px rgba(74, 138, 106, 0.35);
    }

    .btn-auth-main:hover {
        background: linear-gradient(135deg, #3d7a5c 0%, #6aa98a 100%);
        color: #fff;
        box-shadow: 0 8px 24px rgba(74, 138, 106, 0.4);
        transform: translateY(-1px);
    }

    .btn-auth-main:active {
        transform: translateY(0);
    }

    .btn-auth-secondary {
        width: 100%;
        height: 48px;
        border-radius: 14px;
        border: 1px solid rgba(124, 185, 154, 0.45);
        background: transparent;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-family: 'DM Sans', sans-serif;
        color: #2e4a3a;
        margin-top: 12px;
    }

    .btn-auth-secondary:hover {
        background: rgba(232, 244, 238, 0.8);
        border-color: #7cb99a;
        color: #1c2b24;
    }

    .auth-field .is-invalid {
        border-color: #e05252;
        background-color: #fef2f2;
    }

    .invalid-feedback {
        color: #b91c1c;
        font-size: 13px;
        margin-top: 8px;
        font-weight: 500;
    }

    .auth-alert {
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 13px;
        margin-bottom: 20px;
        border: 1px solid rgba(224, 82, 82, 0.25);
        background: #fef2f2;
        color: #991b1b;
    }

    .auth-alert-success {
        display: flex;
        align-items: center;
        gap: 10px;
        border-color: rgba(74, 138, 106, 0.3);
        background: #ecf7f1;
        color: #1f6b48;
    }

    .auth-alert-success svg {
        flex-shrink: 0;
    }

    @media (max-width: 480px) {
        .auth-card {
            border-radius: 20px;
        }

        .auth-field .form-control {
            height: 48px;
        }

        .btn-auth-main {
            height: 48px;
        }
    }
</style>
@endverbatim

<script>
    document.body.classList.add('auth-login-page');
</script>

<div class="auth-login-wrap">
    <div class="auth-login-inner">
        <div class="auth-card">
            <div class="auth-brand-row">
                <div class="auth-logo-frame">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}">
                </div>
            </div>

            <p class="auth-eyebrow">Selamat datang kembali</p>
            <h1 class="auth-title">Masuk</h1>
            <p class="auth-subtitle">Kelola UMKM dan pesanan dengan akun Anda.</p>

            @if (session('status'))
                <div class="auth-alert auth-alert-success" role="status">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M12 2C6.48 2 2 6.48 2 12S6.48 22 12 22 22 17.52 22 12 17.52 2 12 2ZM10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z"/>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="auth-alert" role="alert">
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <label class="auth-label" for="email">Email</label>
                <div class="auth-field">
                    <span class="input-icon" aria-hidden="true">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6C22 4.9 21.1 4 20 4ZM20 8L12 13L4 8V6L12 11L20 6V8Z"/>
                        </svg>
                    </span>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nama@email.com">
                </div>

                <label class="auth-label" for="password">Kata sandi</label>
                <div class="auth-field">
                    <span class="input-icon" aria-hidden="true">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 8H17V6C17 3.24 14.76 1 12 1S7 3.24 7 6V8H6C4.9 8 4 8.9 4 10V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V10C20 8.9 19.1 8 18 8ZM12 17C10.9 17 10 16.1 10 15S10.9 13 12 13 14 13.9 14 15 13.1 17 12 17ZM15 8H9V6C9 4.34 10.34 3 12 3S15 4.34 15 6V8Z"/>
                        </svg>
                    </span>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                </div>

                <button type="submit" class="btn-auth-main">Masuk</button>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-auth-secondary">Belum punya akun? Daftar</a>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
