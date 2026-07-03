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
        --gold-pale: #FDF6E3;
        --ink: #1C2B24;
        --ink-mid: #2E4A3A;
        --ink-soft: #4A6858;
        --muted: #8A9E93;
        --surface: #FFFFFF;
        --border: rgba(124, 185, 154, 0.18);
        --border-strong: rgba(124, 185, 154, 0.35);
        --radius: 14px;
        --radius-sm: 8px;
        --radius-lg: 20px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', -apple-system, sans-serif; background: var(--cream); color: var(--ink); -webkit-font-smoothing: antialiased; }
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
    .topbar { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 26px; gap: 12px; }
    .page-eyebrow { font-size: 11px; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; color: var(--sage-deep); margin-bottom: 6px; }
    .page-title { font-family: 'Playfair Display', Georgia, serif; font-size: 30px; font-weight: 600; color: var(--ink); }
    .topbar-actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; justify-content: flex-end; }
    .btn-primary-soft { display: inline-flex; align-items: center; gap: 7px; padding: 10px 16px; border-radius: var(--radius-sm); border: none; text-decoration: none; font-size: 13px; font-weight: 600; color: #fff; background: var(--gold); box-shadow: 0 2px 10px rgba(201,168,76,0.3); }
    .btn-primary-soft:hover { background: #b8953e; color: #fff; }

    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 22px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 18px 20px; }
    .stat-label { font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); margin-bottom: 8px; font-weight: 700; }
    .stat-value { font-family: 'Playfair Display', Georgia, serif; font-size: 26px; color: var(--ink); }
    .stat-card.income { border-bottom: 3px solid var(--sage); }
    .stat-card.expense { border-bottom: 3px solid var(--gold); }
    .stat-card.balance { border-bottom: 3px solid var(--sage-deep); }

    .table-card { background: var(--surface); border-radius: var(--radius-lg); border: 1px solid var(--border); overflow: hidden; }
    .table-toolbar { padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
    .table-title { font-size: 15px; font-weight: 700; color: var(--ink); }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: var(--cream); border-bottom: 1px solid var(--border-strong); }
    th { padding: 13px 18px; text-align: left; font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted); }
    td { padding: 14px 18px; border-bottom: 1px solid var(--border); font-size: 13.5px; color: var(--ink-soft); }
    tbody tr:hover { background: var(--sage-pale); }
    .text-right { text-align: right; }
    .badge-type { display: inline-flex; padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; }
    .badge-type.income { background: var(--sage-pale); color: var(--sage-deep); border: 1px solid rgba(124,185,154,0.3); }
    .badge-type.expense { background: var(--gold-pale); color: #8B6914; border: 1px solid rgba(201,168,76,0.3); }
    .actions { display: inline-flex; gap: 8px; justify-content: flex-end; }
    .btn-action { padding: 6px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none; border: 1px solid transparent; }
    .btn-edit { background: var(--sage-pale); color: var(--sage-deep); border-color: rgba(124,185,154,0.24); }
    .btn-delete { background: var(--gold-pale); color: #8B6914; border-color: rgba(201,168,76,0.24); }
    .pagination-wrap { padding: 16px 24px; display: flex; justify-content: flex-end; }

    .month-filter-wrap { 
        display: none;
    }

    .month-filter-control {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .month-filter-label {
        font-size: 13px;
        font-weight: 700;
        color: var(--ink-mid);
        white-space: nowrap;
    }

    .month-select-wrapper {
        position: relative;
    }

    .month-select {
        padding: 10px 16px;
        border-radius: 8px;
        border: 2px solid var(--sage-light);
        background: linear-gradient(135deg, #ffffff 0%, #faf7f0 100%);
        color: var(--ink-mid);
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
        appearance: none;
        padding-right: 36px;
        box-shadow: 0 2px 8px rgba(124, 185, 154, 0.15);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%237CB99A' d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
    }

    .month-select:hover {
        border-color: var(--sage);
        box-shadow: 0 4px 12px rgba(124, 185, 154, 0.25);
    }

    .month-select:focus {
        outline: none;
        border-color: var(--sage-deep);
        box-shadow: 0 4px 16px rgba(124, 185, 154, 0.3);
    }

    .month-select option {
        padding: 10px;
        background: #ffffff;
        color: var(--ink-mid);
    }

    /* ===== Chart Section ===== */
    .chart-section {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 18px;
        margin-bottom: 22px;
        animation: fadeInUp 0.6s ease both;
        animation-delay: 0.15s;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .chart-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .chart-header {
        padding: 20px 24px 0;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        flex-wrap: wrap;
    }
    .chart-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 17px;
        font-weight: 700;
        color: var(--ink);
    }
    .chart-subtitle {
        font-size: 12px;
        color: var(--muted);
        margin-top: 2px;
    }
    .chart-legend {
        display: flex;
        align-items: center;
        font-size: 12px;
        font-weight: 600;
        color: var(--ink-soft);
    }
    .legend-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 3px;
        margin-right: 5px;
    }
    .legend-income { background: var(--sage); }
    .legend-expense { background: var(--gold); }
    .chart-body {
        padding: 16px 20px 20px;
        flex: 1;
        min-height: 260px;
        position: relative;
    }
    .chart-body-doughnut {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 200px;
        max-height: 220px;
    }
    .doughnut-stats {
        padding: 0 24px 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .doughnut-stat {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
    }
    .doughnut-stat-dot {
        width: 10px;
        height: 10px;
        border-radius: 3px;
        flex-shrink: 0;
    }
    .doughnut-stat-dot.income { background: var(--sage); }
    .doughnut-stat-dot.expense { background: var(--gold); }
    .doughnut-stat-label {
        color: var(--muted);
        font-weight: 500;
        flex: 1;
    }
    .doughnut-stat-value {
        font-weight: 700;
        font-size: 13px;
    }
    .doughnut-stat-value.income { color: var(--sage-deep); }
    .doughnut-stat-value.expense { color: #8B6914; }

    @media (max-width: 900px) {
        .sidebar { width: 220px; }
        .main { margin-left: 220px; padding: 24px 22px; }
        .stats-grid { grid-template-columns: 1fr; }
        .chart-section { grid-template-columns: 1fr; }
        .month-filter-wrap { max-width: 100%; }
    }
    @media (max-width: 680px) {
        .sidebar { display: none; }
        .main { margin-left: 0; padding: 20px 16px; }
        .topbar { flex-direction: column; }
        .page-title { font-size: 24px; }
        .chart-section { grid-template-columns: 1fr; }
        .month-filter-wrap { max-width: 100%; }
    }
</style>

@php
    if (!isset($month)) {
        $month = null;
    }
    if (!isset($year)) {
        $year = now()->year;
    }
    $totalPemasukan = $keuangans->where('jenis', 'pemasukan')->sum('jumlah');
    $totalPengeluaran = $keuangans->where('jenis', 'pengeluaran')->sum('jumlah');
@endphp

<div class="layout">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo-wrap"><img src="{{ asset('images/logo.png') }}" alt="Logo"></div>
            <div>
                <div class="sidebar-brand-name">UMKM Panel</div>
                <div class="sidebar-brand-role">Administrator</div>
            </div>
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
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="logout-btn"><span style="font-size:15px;">↩</span>Keluar</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <div class="page-eyebrow">Keuangan</div>
                <h1 class="page-title">Laporan Keuangan</h1>
            </div>
            <div class="topbar-actions">
                <div class="month-filter-control">
                    <span class="month-filter-label">📅 Bulan:</span>
                    <div class="month-select-wrapper">
                        @php
                            $months = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                        @endphp
                        <select class="month-select" onchange="filterByMonth(this.value)">
                            <option value="">Semua</option>
                            @foreach($months as $num => $name)
                                <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="button" class="btn-primary-soft" onclick="printKeuangan()">↓ Cetak Laporan</button>
                <a href="{{ route('keuangans.create') }}" class="btn-primary-soft">+ Tambah Data</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="month-filter-wrap">
            <div class="month-filter-title">📅 Filter Bulan:</div>
            <div class="month-select-wrapper">
                @php
                    $months = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];
                @endphp
                <select class="month-select" onchange="filterByMonth(this.value)">
                    <option value="">📊 Lihat Semua Data</option>
                    @foreach($months as $num => $name)
                        <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card income">
                <div class="stat-label">Total Pemasukan</div>
                <div class="stat-value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card expense">
                <div class="stat-label">Total Pengeluaran</div>
                <div class="stat-value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card balance">
                <div class="stat-label">Saldo</div>
                <div class="stat-value">Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}</div>
            </div>
        </div>

        {{-- ===== GRAFIK KEUANGAN ===== --}}
        <div class="chart-section">
            <div class="chart-card chart-card-bar">
                <div class="chart-header">
                    <div>
                        <div class="chart-title">Grafik Keuangan Bulanan</div>
                        <div class="chart-subtitle">Pemasukan vs Pengeluaran — {{ $month && isset($months[$month]) ? $months[$month] : 'Semua Bulan' }} {{ $year }}</div>
                    </div>
                    <div class="chart-legend">
                        <span class="legend-dot legend-income"></span> Pemasukan
                        <span class="legend-dot legend-expense" style="margin-left:14px;"></span> Pengeluaran
                    </div>
                </div>
                <div class="chart-body">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
            <div class="chart-card chart-card-doughnut">
                <div class="chart-header">
                    <div>
                        <div class="chart-title">Proporsi</div>
                        <div class="chart-subtitle">Pemasukan & Pengeluaran</div>
                    </div>
                </div>
                <div class="chart-body chart-body-doughnut">
                    <canvas id="doughnutChart"></canvas>
                </div>
                <div class="doughnut-stats">
                    <div class="doughnut-stat">
                        <span class="doughnut-stat-dot income"></span>
                        <span class="doughnut-stat-label">Pemasukan</span>
                        <span class="doughnut-stat-value income">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
                    </div>
                    <div class="doughnut-stat">
                        <span class="doughnut-stat-dot expense"></span>
                        <span class="doughnut-stat-label">Pengeluaran</span>
                        <span class="doughnut-stat-value expense">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="table-toolbar">
                <div class="table-title">Data Keuangan</div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($keuangans as $keuangan)
                            <tr>
                                <td>{{ $keuangan->product->nama_produk ?? '-' }}</td>
                                <td>
                                    <span class="badge-type {{ $keuangan->jenis === 'pemasukan' ? 'income' : 'expense' }}">{{ ucfirst($keuangan->jenis) }}</span>
                                </td>
                                <td>Rp {{ number_format($keuangan->jumlah, 0, ',', '.') }}</td>
                                <td>{{ $keuangan->keterangan }}</td>
                                <td>{{ $keuangan->tanggal->format('d M Y') }}</td>
                                <td class="text-right">
                                    <div class="actions">
                                        <a href="{{ route('keuangans.edit', $keuangan) }}" class="btn-action btn-edit">Edit</a>
                                        <form action="{{ route('keuangans.destroy', $keuangan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" onclick="return confirm('Hapus data ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data keuangan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                {{ $keuangans->links() }}
            </div>
        </div>
    </main>
</div>

<script>
    function printKeuangan() {
        const iframe = document.createElement('iframe');
        iframe.style.position = 'fixed';
        iframe.style.right = '0';
        iframe.style.bottom = '0';
        iframe.style.width = '0';
        iframe.style.height = '0';
        iframe.style.border = '0';
        iframe.src = "{{ route('keuangans.print') }}";

        iframe.onload = function () {
            try {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            } catch (error) {
                window.open("{{ route('keuangans.print') }}", '_blank');
            }

            setTimeout(() => {
                iframe.remove();
            }, 1500);
        };

        document.body.appendChild(iframe);
    }

    function filterByMonth(month) {
        const url = new URL(window.location);
        if (month === '' || month === null) {
            url.searchParams.delete('month');
        } else {
            url.searchParams.set('month', month);
        }
        window.location.href = url.toString();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const allLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
        const allPemasukan = @json($chartPemasukan);
        const allPengeluaran = @json($chartPengeluaran);
        const selectedMonth = @json($month);

        // If a specific month is selected, show only that month; otherwise show all 12
        let labels, pemasukan, pengeluaran;
        if (selectedMonth && selectedMonth >= 1 && selectedMonth <= 12) {
            const idx = selectedMonth - 1;
            labels = [allLabels[idx]];
            pemasukan = [allPemasukan[idx]];
            pengeluaran = [allPengeluaran[idx]];
        } else {
            labels = allLabels;
            pemasukan = allPemasukan;
            pengeluaran = allPengeluaran;
        }

        // ---- Bar Chart ----
        const barCtx = document.getElementById('barChart').getContext('2d');

        const incomeGradient = barCtx.createLinearGradient(0, 0, 0, 320);
        incomeGradient.addColorStop(0, '#7CB99A');
        incomeGradient.addColorStop(1, '#A8D4BC');

        const expenseGradient = barCtx.createLinearGradient(0, 0, 0, 320);
        expenseGradient.addColorStop(0, '#C9A84C');
        expenseGradient.addColorStop(1, '#E8C97A');

        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: pemasukan,
                        backgroundColor: incomeGradient,
                        borderRadius: 6,
                        borderSkipped: false,
                        barPercentage: 0.55,
                        categoryPercentage: 0.65
                    },
                    {
                        label: 'Pengeluaran',
                        data: pengeluaran,
                        backgroundColor: expenseGradient,
                        borderRadius: 6,
                        borderSkipped: false,
                        barPercentage: 0.55,
                        categoryPercentage: 0.65
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 900,
                    easing: 'easeOutQuart'
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1C2B24',
                        titleFont: { family: 'DM Sans', weight: '600', size: 13 },
                        bodyFont: { family: 'DM Sans', size: 12 },
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            label: function(ctx) {
                                return ctx.dataset.label + ': Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: 'DM Sans', size: 11, weight: '600' },
                            color: '#8A9E93'
                        },
                        border: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(124,185,154,0.10)', drawBorder: false },
                        ticks: {
                            font: { family: 'DM Sans', size: 11 },
                            color: '#8A9E93',
                            callback: function(v) {
                                if (v >= 1000000) return 'Rp ' + (v/1000000).toFixed(1) + ' jt';
                                if (v >= 1000) return 'Rp ' + (v/1000).toFixed(0) + ' rb';
                                return 'Rp ' + v;
                            }
                        },
                        border: { display: false }
                    }
                }
            }
        });

        // ---- Doughnut Chart ----
        const totalPemasukan = pemasukan.reduce((a, b) => a + b, 0);
        const totalPengeluaran = pengeluaran.reduce((a, b) => a + b, 0);

        new Chart(document.getElementById('doughnutChart'), {
            type: 'doughnut',
            data: {
                labels: ['Pemasukan', 'Pengeluaran'],
                datasets: [{
                    data: [totalPemasukan || 0, totalPengeluaran || 0],
                    backgroundColor: ['#7CB99A', '#C9A84C'],
                    hoverBackgroundColor: ['#4A8A6A', '#B8953E'],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    borderRadius: 4,
                    spacing: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '68%',
                animation: {
                    animateRotate: true,
                    duration: 1100,
                    easing: 'easeOutCirc'
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1C2B24',
                        titleFont: { family: 'DM Sans', weight: '600', size: 13 },
                        bodyFont: { family: 'DM Sans', size: 12 },
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            label: function(ctx) {
                                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = total > 0 ? ((ctx.parsed / total) * 100).toFixed(1) : 0;
                                return ctx.label + ': Rp ' + ctx.parsed.toLocaleString('id-ID') + ' (' + pct + '%)';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
