@extends('layouts.app')

@section('content')
<style>
    .auth-register-page .navbar {
        display: none;
    }

    .auth-register-page main.py-4 {
        padding: 0 !important;
    }

    .auth-register-wrap {
        min-height: 100vh;
        background: #9ed58d;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }

    .auth-register-card {
        width: 100%;
        max-width: 470px;
        background: rgba(173, 216, 159, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 14px;
        padding: 28px 28px 22px;
        box-shadow: 0 14px 30px rgba(58, 92, 45, 0.18);
    }

    .auth-register-head {
        font-size: 30px;
        font-weight: 800;
        color: #111b13;
        margin: 0;
        text-align: center;
    }

    .auth-register-sub {
        font-size: 13px;
        color: #1f2c20;
        text-align: center;
        margin: 4px 0 20px;
    }

    .auth-register-field {
        position: relative;
    }

    .auth-register-field .form-control {
        height: 48px;
        border-radius: 8px;
        border: 1px solid #c8d2e9;
        padding-right: 40px;
        background: #f4f6ff;
        font-size: 14px;
    }

    .auth-register-field .input-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #111;
        line-height: 1;
    }

    .btn-auth-register,
    .btn-auth-login {
        width: 100%;
        height: 44px;
        border-radius: 8px;
        border: none;
        font-size: 15px;
        font-weight: 700;
    }

    .btn-auth-register {
        background: #f4e58a;
        color: #141414;
        box-shadow: 0 7px 0 rgba(210, 228, 255, 0.7);
    }

    .btn-auth-register:hover {
        background: #ecdd80;
        color: #141414;
    }

    .btn-auth-login {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        background: #f4e58a;
        color: #141414;
        box-shadow: 0 7px 0 rgba(210, 228, 255, 0.7);
    }

    .btn-auth-login:hover {
        background: #ecdd80;
        color: #141414;
    }
</style>

<script>
    document.body.classList.add('auth-register-page');
</script>

<div class="auth-register-wrap">
    <div class="auth-register-card">
        <h1 class="auth-register-head">Buat Akun</h1>
        <p class="auth-register-sub">Daftar dulu, biar transaksi bisa langsung jalan.</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3 auth-register-field">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nama Lengkap">
                <span class="input-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"/>
                        <path d="M5 22C5 18.6863 8.13401 16 12 16C15.866 16 19 18.6863 19 22"/>
                    </svg>
                </span>
                @error('name')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3 auth-register-field">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                <span class="input-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M3 6C3 4.89543 3.89543 4 5 4H19C20.1046 4 21 4.89543 21 6V18C21 19.1046 20.1046 20 19 20H5C3.89543 20 3 19.1046 3 18V6Z"/>
                        <path d="M5 7L12 12L19 7" fill="none" stroke="#9ed58d" stroke-width="2"/>
                    </svg>
                </span>
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3 auth-register-field">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
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

            <div class="mb-3 auth-register-field">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi Password">
                <span class="input-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M17 8H16V6C16 3.79086 14.2091 2 12 2C9.79086 2 8 3.79086 8 6V8H7C5.89543 8 5 8.89543 5 10V20C5 21.1046 5.89543 22 7 22H17C18.1046 22 19 21.1046 19 20V10C19 8.89543 18.1046 8 17 8ZM10 6C10 4.89543 10.8954 4 12 4C13.1046 4 14 4.89543 14 6V8H10V6Z"/>
                    </svg>
                </span>
            </div>

            <button type="submit" class="btn-auth-register mt-2">Buat Akun</button>
            <a href="{{ route('login') }}" class="btn-auth-login mt-3">Kembali ke Login</a>
        </form>
    </div>
</div>
        </div>
    </div>
</div>
@endsection
