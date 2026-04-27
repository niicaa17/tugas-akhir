@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: #a0e29c;">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between rounded-top-4 px-4 py-3" style="background: #f5e87d; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 80px; height: 80px; background: #fff; box-shadow: 0 16px 32px rgba(0,0,0,0.08);">
                            <svg width="75" height="75" viewBox="0 0 250 250" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Tanah/Garis dekoratif coklat -->
                                <path d="M40 180Q100 200 180 170" stroke="#a0826d" stroke-width="12" stroke-linecap="round" fill="none"/>
                                <!-- Garis kuning dekoratif -->
                                <path d="M50 195Q110 210 200 185" stroke="#f8d84a" stroke-width="10" stroke-linecap="round" fill="none"/>

                                <!-- Rumah - bagian utama -->
                                <polygon points="60,130 125,70 190,130" fill="#3d7a2b" stroke="#2d5a1b" stroke-width="2"/>
                                <!-- Dinding rumah -->
                                <rect x="60" y="130" width="130" height="70" fill="#3d7a2b" stroke="#2d5a1b" stroke-width="2"/>

                                <!-- Pintu rumah -->
                                <rect x="108" y="155" width="34" height="45" fill="#f5e87d" stroke="#d4c542" stroke-width="2" rx="2"/>
                                <!-- Handle pintu -->
                                <circle cx="138" cy="177" r="3" fill="#d4c542"/>

                                <!-- Jendela kiri -->
                                <rect x="75" y="145" width="20" height="20" fill="#d4f0c8" stroke="#5f993f" stroke-width="1.5" rx="1"/>
                                <line x1="85" y1="145" x2="85" y2="165" stroke="#5f993f" stroke-width="1"/>
                                <line x1="75" y1="155" x2="95" y2="155" stroke="#5f993f" stroke-width="1"/>

                                <!-- Jendela kanan -->
                                <rect x="155" y="145" width="20" height="20" fill="#d4f0c8" stroke="#5f993f" stroke-width="1.5" rx="1"/>
                                <line x1="165" y1="145" x2="165" y2="165" stroke="#5f993f" stroke-width="1"/>
                                <line x1="155" y1="155" x2="175" y2="155" stroke="#5f993f" stroke-width="1"/>

                                <!-- Tanaman/Pohon -->
                                <!-- Pot tanaman -->
                                <path d="M110 90L115 105L105 105Z" fill="#8b6f47" stroke="#6d5939" stroke-width="1"/>
                                <!-- Daun 1 -->
                                <ellipse cx="105" cy="75" rx="6" ry="15" fill="#5f993f" transform="rotate(-25 105 75)"/>
                                <!-- Daun 2 -->
                                <ellipse cx="115" cy="72" rx="5" ry="14" fill="#7ab84f" transform="rotate(30 115 72)"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-uppercase text-secondary fw-semibold small">dashboard admin</div>
                            <h3 class="mb-0 fw-bold">Rumah Rimpang</h3>
                        </div>
                    </div>
                    <div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark btn-sm px-4" style="border-color: #1c2a16; color: #1c2a16; background: rgba(255,255,255,0.8);">Logout</button>
                        </form>
                    </div>
                </div>

                <div class="rounded-4 p-4" style="background: #9bdc80; box-shadow: 0 14px 30px rgba(0,0,0,0.08);">
                    <div class="rounded-4 p-4" style="background: #ffffff;">
                        <div class="text-center">
                            <h2 class="fw-bold">Selamat Datang, {{ auth()->user()->name }}! ☀️</h2>
                            <p class="mb-0 text-muted">Jadilah inspirasi di setiap langkah, karena manajemen yang hebat dimulai dari sini.</p>
                            <p class="text-muted">Harmoni dalam setiap klik menanti, jadi lakukan yang terbaik hari ini, karena informasi adalah kuncinya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-4">
            <div class="col-lg-6">
                <a href="{{ route('umkms.index') }}" style="text-decoration: none; cursor: pointer;">
                    <div class="card rounded-4 shadow-sm border-0" style="background: rgba(255,255,255,0.95); transition: all 0.3s ease; hover-effect">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="rounded-3" style="width: 54px; height: 54px; background: #e8f4e3; display:flex; align-items:center; justify-content:center;">
                                <span class="fs-4">👥</span>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Struktur Organisasi UMKM</h5>
                                <p class="mb-0 text-muted">Kelola Data Anggota</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-6">
                <a href="{{ route('keuangans.index') }}" style="text-decoration: none; cursor: pointer;">
                    <div class="card rounded-4 shadow-sm border-0" style="background: rgba(255,255,255,0.95); transition: all 0.3s ease;">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="rounded-3" style="width: 54px; height: 54px; background: #fff4dc; display:flex; align-items:center; justify-content:center;">
                                <span class="fs-4">📊</span>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Keuangan</h5>
                                <p class="mb-0 text-muted">Kelola Data Keuangan</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-6">
                <a href="{{ route('products.index') }}" style="text-decoration: none; cursor: pointer;">
                    <div class="card rounded-4 shadow-sm border-0" style="background: rgba(255,255,255,0.95); transition: all 0.3s ease;">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="rounded-3" style="width: 54px; height: 54px; background: #ffeed6; display:flex; align-items:center; justify-content:center;">
                                <span class="fs-4">📦</span>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Produk UMKM</h5>
                                <p class="mb-0 text-muted">Kelola Data Produk UMKM</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-6">
                <a href="{{ route('orders.index') }}" style="text-decoration: none; cursor: pointer;">
                    <div class="card rounded-4 shadow-sm border-0" style="background: rgba(255,255,255,0.95); transition: all 0.3s ease;">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="rounded-3" style="width: 54px; height: 54px; background: #e7f0ff; display:flex; align-items:center; justify-content:center;">
                                <span class="fs-4">💰</span>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Transaksi</h5>
                                <p class="mb-0 text-muted">Kelola Data Transaksi</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-12 text-center">
                <p class="mb-0 text-muted">© 2026 Admin Panel - Made with ❤️</p>
            </div>
        </div>
    </div>
</div>
@endsection
