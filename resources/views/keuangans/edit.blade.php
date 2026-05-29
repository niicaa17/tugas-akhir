@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap');

    :root {
        --sage: #7CB99A;
        --sage-light: #A8D4BC;
        --sage-pale: #E8F4EE;
        --sage-deep: #4A8A6A;
        --cream: #F7F4EE;
        --gold: #C9A84C;
        --gold-light: #E8C97A;
        --ink: #1C2B24;
        --ink-mid: #2E4A3A;
        --muted: #8A9E93;
        --surface: #FFFFFF;
        --border: rgba(124, 185, 154, 0.18);
        --border-strong: rgba(124, 185, 154, 0.35);
        --radius: 14px;
        --radius-sm: 8px;
        --radius-lg: 20px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', -apple-system, sans-serif; background: var(--cream); color: var(--ink); }
    .layout { display: flex; min-height: 100vh; }
    .sidebar { width: 260px; background: var(--ink); position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto; display: flex; flex-direction: column; z-index: 100; }
    .sidebar-brand { padding: 28px 24px 24px; border-bottom: 1px solid rgba(255,255,255,0.06); display: flex; align-items: center; gap: 12px; }
    .sidebar-logo-wrap { width: 42px; height: 42px; border-radius: 10px; overflow: hidden; background: var(--sage-pale); display: flex; align-items: center; justify-content: center; }
    .sidebar-logo-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .sidebar-brand-name { font-family: 'Playfair Display', Georgia, serif; font-size: 15px; font-weight: 600; color: #fff; line-height: 1.2; }
    .sidebar-brand-role { font-size: 10.5px; font-weight: 500; color: var(--sage-light); letter-spacing: 0.12em; text-transform: uppercase; margin-top: 2px; }
    .sidebar-nav { padding: 20px 14px; flex: 1; display: flex; flex-direction: column; gap: 2px; }
    .nav-section-label { font-size: 10px; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; color: var(--muted); padding: 16px 10px 8px; }
    .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: var(--radius-sm); text-decoration: none; color: rgba(255,255,255,0.58); font-size: 13.5px; transition: all 0.2s ease; position: relative; }
    .nav-item:hover, .nav-item.active { background: rgba(124,185,154,0.18); color: var(--sage-light); }
    .nav-item.active::before { content: ''; position: absolute; left: 0; top: 6px; bottom: 6px; width: 3px; background: var(--sage); border-radius: 0 2px 2px 0; }
    .nav-icon { width: 18px; text-align: center; font-size: 15px; }
    .sidebar-footer { padding: 16px 14px 24px; border-top: 1px solid rgba(255,255,255,0.06); display: flex; flex-direction: column; gap: 6px; }
    .profile-link { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px; background: rgba(124, 185, 154, 0.12); color: #A8D4BC; font-size: 13.5px; text-decoration: none; transition: all 0.2s; }
    .profile-link:hover { background: rgba(124, 185, 154, 0.22); color: #A8D4BC; }
    .logout-btn { display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 12px; border-radius: var(--radius-sm); border: none; background: rgba(201,168,76,0.1); color: var(--gold-light); font-size: 13.5px; cursor: pointer; }

    .main { margin-left: 260px; flex: 1; padding: 36px 40px; min-height: 100vh; }
    .topbar { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; gap: 12px; }
    .page-eyebrow { font-size: 11px; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; color: var(--sage-deep); margin-bottom: 6px; }
    .page-title { font-family: 'Playfair Display', Georgia, serif; font-size: 30px; font-weight: 600; color: var(--ink); }
    .btn-back, .btn-save { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 18px; border-radius: var(--radius-sm); text-decoration: none; font-size: 13px; font-weight: 600; border: none; }
    .btn-back { background: #fff; color: var(--ink); border: 1px solid var(--border); }
    .btn-save { background: var(--gold); color: #fff; box-shadow: 0 2px 10px rgba(201,168,76,0.3); }

    .form-card { background: var(--surface); border-radius: var(--radius-lg); border: 1px solid var(--border); overflow: hidden; }
    .form-card-head { padding: 22px 28px; border-bottom: 1px solid var(--border); }
    .form-card-body { padding: 24px 28px 28px; }
    .form-label { font-weight: 700; color: var(--ink-mid); margin-bottom: 8px; }
    .form-control, .form-select { border-radius: 12px; border-color: var(--border-strong); padding: 12px 14px; }
    .form-control:focus, .form-select:focus { border-color: var(--sage); box-shadow: none; }

    @media (max-width: 900px) { .sidebar { width: 220px; } .main { margin-left: 220px; padding: 24px 22px; } }
    @media (max-width: 680px) { .sidebar { display: none; } .main { margin-left: 0; padding: 20px 16px; } .topbar { flex-direction: column; } .page-title { font-size: 24px; } .form-card-head, .form-card-body { padding: 18px; } }
</style>

<div class="layout">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo-wrap"><img src="{{ asset('images/logo.png') }}" alt="Logo"></div>
            <div><div class="sidebar-brand-name">UMKM Panel</div><div class="sidebar-brand-role">Administrator</div></div>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item"><span class="nav-icon">⌂</span>Dashboard</a>
            <div class="nav-section-label">Manajemen</div>
            <a href="{{ route('members.index') }}" class="nav-item"><span class="nav-icon">☰</span>Anggota UMKM</a>
            <a href="{{ route('keuangans.index') }}" class="nav-item active"><span class="nav-icon">◈</span>Keuangan</a>
            <a href="{{ route('products.index') }}" class="nav-item"><span class="nav-icon">◫</span>Produk UMKM</a>
            <a href="{{ route('orders.index') }}" class="nav-item"><span class="nav-icon">◷</span>Transaksi</a>
        </nav>
        <div class="sidebar-footer">
            <a href="{{ route('admin.profile') }}" class="profile-link"><span style="font-size:15px;">◐</span>Profil Admin</a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">@csrf<button type="submit" class="logout-btn"><span style="font-size:15px;">↩</span>Keluar</button></form>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <div class="page-eyebrow">Keuangan</div>
                <h1 class="page-title">Edit Data Keuangan</h1>
            </div>
            <a href="{{ route('keuangans.index') }}" class="btn-back">Kembali</a>
        </div>

        <div class="form-card">
            <div class="form-card-head">
                <div style="font-size:15px;font-weight:700;color:var(--ink);">Perbarui Transaksi</div>
                <div style="font-size:12.5px;color:var(--muted);margin-top:4px;">Sesuaikan data keuangan yang sudah tercatat sebelumnya.</div>
            </div>
            <div class="form-card-body">
                <form action="{{ route('keuangans.update', $keuangan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="product_id" class="form-label">Nama Produk</label>
                        <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                            <option value="">Pilih Produk</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id', $keuangan->product_id) == $product->id ? 'selected' : '' }}>
                                    {{ $product->nama_produk }}{{ $product->umkm ? ' - ' . $product->umkm->nama_umkm : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis</label>
                        <select name="jenis" id="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                            <option value="pemasukan" {{ old('jenis', $keuangan->jenis) == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="pengeluaran" {{ old('jenis', $keuangan->jenis) == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                        @error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', $keuangan->jumlah) }}" min="0" required>
                        @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="4">{{ old('keterangan', $keuangan->keterangan) }}</textarea>
                        @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $keuangan->tanggal->format('Y-m-d')) }}" required>
                        @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn-save">Update Data</button>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection
