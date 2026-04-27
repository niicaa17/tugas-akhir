@extends('layouts.app')

@section('content')
<style>
    .auth-login-page .navbar {
        display: none;
    }

    .auth-login-page main.py-4 {
        padding: 0 !important;
    }

    .auth-login-wrap {
        min-height: 100vh;
        background: #9ed58d;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }

    .auth-card {
        width: 100%;
        max-width: 470px;
        background: rgba(173, 216, 159, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 14px;
        padding: 28px 28px 22px;
        box-shadow: 0 14px 30px rgba(58, 92, 45, 0.18);
    }

    .auth-brand {
        font-size: 12px;
        font-weight: 700;
        color: #e57b22;
        line-height: 1;
    }

    .auth-subtitle {
        font-size: 13px;
        color: #1f2c20;
    }

    .auth-icon-circle {
        width: 36px;
        height: 36px;
        border: 2px solid #162415;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
    }

    .auth-title {
        font-size: 28px;
        font-weight: 800;
        color: #111b13;
        margin: 0;
    }

    .auth-field {
        position: relative;
    }

    .auth-field .form-control {
        height: 48px;
        border-radius: 8px;
        border: 1px solid #c8d2e9;
        padding-right: 40px;
        background: #f4f6ff;
        font-size: 14px;
    }

    .auth-field .input-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #111;
        line-height: 1;
    }

    .btn-auth-main,
    .btn-auth-secondary {
        width: 100%;
        height: 44px;
        border-radius: 8px;
        border: none;
        font-size: 15px;
        font-weight: 700;
    }

    .btn-auth-main {
        background: #f4e58a;
        color: #141414;
        box-shadow: 0 7px 0 rgba(210, 228, 255, 0.7);
    }

    .btn-auth-main:hover {
        background: #ecdd80;
        color: #141414;
    }

    .btn-auth-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        background: #f4e58a;
        color: #141414;
        box-shadow: 0 7px 0 rgba(210, 228, 255, 0.7);
    }

    .btn-auth-secondary:hover {
        background: #ecdd80;
        color: #141414;
    }
</style>

<script>
    document.body.classList.add('auth-login-page');
</script>

<div class="auth-login-wrap">
    <div class="auth-card">
        <div class="d-flex align-items-center mb-3">
            <svg width="56" height="34" viewBox="0 0 56 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M1 27L18 9L31 22L23 22L17 16L9 24L1 27Z" fill="#2E7D32"/>
                <path d="M17 16L27 2L35 10L24 11L17 16Z" fill="#5FA349"/>
                <path d="M14 28H55" stroke="#E57B22" stroke-width="3" stroke-linecap="round"/>
            </svg>
            <span class="auth-brand ms-2">RUMAH RIMPANG</span>
        </div>

        <div class="text-center mb-4">
            <div class="auth-icon-circle">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/>
                    <path d="M4 20C4.8 16.9 7.9 15 12 15C16.1 15 19.2 16.9 20 20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <h1 class="auth-title">login</h1>
            <p class="mb-0 mt-2 fw-bold">Halo, sudah ingat password-nya belum?</p>
            <p class="auth-subtitle mb-0">Login dulu, kalau lupa, nganu reset kok!</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3 auth-field">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Username">
                <span class="input-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"/>
                        <path d="M5 22C5 18.6863 8.13401 16 12 16C15.866 16 19 18.6863 19 22"/>
                    </svg>
                </span>
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3 auth-field">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                <span class="input-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M17 8H16V6C16 3.79086 14.2091 2 12 2C9.79086 2 8 3.79086 8 6V8H7C5.89543 8 5 8.89543 5 10V20C5 21.1046 5.89543 22 7 22H17C18.1046 22 19 21.1046 19 20V10C19 8.89543 18.1046 8 17 8ZM10 6C10 4.89543 10.8954 4 12 4C13.1046 4 14 4.89543 14 6V8H10V6Z"/>
                    </svg>
                </span>
                @error('password')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn-auth-main mt-2">Login</button>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-auth-secondary mt-3">Buat Akun</a>
            @endif
        </form>
    </div>
</div>
@endsection
