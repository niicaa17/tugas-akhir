<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Laporan Keuangan</title>
    <style>
        :root {
            --bg: #eef5e3;
            --panel: rgba(255, 255, 255, 0.86);
            --panel-strong: #ffffff;
            --panel-soft: #f7f1dc;
            --ink: #203126;
            --ink-soft: #586a5f;
            --brand: #6f9a5f;
            --brand-deep: #557a49;
            --back: #93a18d;
            --line: rgba(49, 78, 44, 0.12);
            --line-strong: rgba(49, 78, 44, 0.22);
            --shadow: 0 20px 42px rgba(32, 48, 30, 0.11);
            --radius: 18px;
        }

        * { box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: var(--ink);
            margin: 0;
            background:
                radial-gradient(900px 380px at 0% 0%, rgba(111, 154, 95, 0.16), transparent 65%),
                radial-gradient(700px 320px at 100% 0%, rgba(213, 167, 78, 0.14), transparent 60%),
                var(--bg);
        }

        .page {
            max-width: 1180px;
            margin: 0 auto;
            padding: 20px 20px 24px;
        }

        .hero-card,
        .report-card {
            background: #fff;
            border: 1px solid var(--line-strong);
            box-shadow: 0 2px 12px rgba(32, 48, 30, 0.08);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 12px;
        }

        .hero-top {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .title {
            font-size: 24px;
            font-weight: 800;
            margin: 0;
            color: var(--ink);
        }

        .meta {
            text-align: right;
            font-size: 12px;
            color: var(--ink-soft);
            white-space: nowrap;
            opacity: 0.8;
        }

        .choice-sub {
            font-size: 13px;
            color: var(--ink-soft);
            margin-top: 6px;
            line-height: 1.5;
        }

        .choice-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 14px;
        }

        .btn-choice {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 14px;
            border-radius: 10px;
            text-decoration: none;
            border: 0;
            cursor: pointer;
            font-weight: 700;
            font-size: 12px;
            color: #fff;
            width: 100%;
            transition: all 0.2s ease;
        }

        .btn-choice:hover {
            transform: translateY(-1px);
        }

        .month-selector {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 6px;
            margin-top: 14px;
            padding: 14px;
            background: #f9f8f6;
            border: 1px solid var(--line-strong);
            border-radius: 12px;
        }

        .month-selector-label {
            grid-column: 1 / -1;
            font-weight: 700;
            color: var(--ink-mid);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }

        .month-btn {
            padding: 8px 6px;
            border-radius: 8px;
            border: 1px solid var(--line-strong);
            background: #fff;
            color: var(--ink-mid);
            cursor: pointer;
            font-weight: 700;
            font-size: 11px;
            transition: all 0.2s ease;
            text-align: center;
        }

        .month-btn:hover {
            background: var(--brand);
            color: #fff;
            border-color: var(--brand);
        }

        .month-btn.active {
            background: var(--brand);
            color: #fff;
            border-color: var(--brand);
        }

        .month-btn-all {
            grid-column: 1 / -1;
        }

        .btn-print { 
            background: linear-gradient(180deg, #6f9a5f 0%, #557a49 100%); 
        }
        .btn-back { 
            background: linear-gradient(180deg, #8b9d93 0%, #6d8580 100%); 
        }
        
        .btn-print:hover {
            background: linear-gradient(180deg, #7aab6a 0%, #4a6b3e 100%);
        }
        
        .btn-back:hover {
            background: linear-gradient(180deg, #99afa5 0%, #5a7570 100%);
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin: 0 0 10px;
        }

        .report-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 14px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--line);
        }

        .report-subtitle {
            font-size: 12px;
            color: var(--ink-soft);
            margin-top: 4px;
            font-weight: 500;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        th { 
            background: #f8f7f5;
            padding: 8px 10px; 
            text-align: left; 
            font-size: 9px; 
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase; 
            color: var(--ink-soft);
            border-bottom: 2px solid var(--line-strong);
        }
        td { 
            padding: 8px 10px;
            border-bottom: 1px solid var(--line);
            font-size: 11px;
        }
        tbody tr:hover {
            background: #fafaf8;
        }
        .text-right { 
            text-align: right; 
            font-weight: 700;
        }
        
        .totals { 
            margin-top: 12px; 
            display: grid; 
            grid-template-columns: repeat(3, 1fr); 
            gap: 8px; 
        }
        .totals .box { 
            background: #f9f8f6;
            padding: 12px;
            border-radius: 10px; 
            border: 1px solid var(--line-strong);
            box-shadow: 0 2px 8px rgba(32, 48, 30, 0.04);
            text-align: center;
            position: relative;
        }
        .totals .box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            border-radius: 10px 10px 0 0;
        }
        .totals .box.income::before {
            background: #1a5a3a;
        }
        .totals .box.expense::before {
            background: #c41e3a;
        }
        .totals .box.balance::before {
            background: #1f2c20;
        }
        .totals .label { 
            font-size: 8px; 
            color: var(--ink-soft);
            margin-bottom: 3px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .totals .value { 
            font-weight: 800; 
            font-size: 14px;
            line-height: 1.1;
        }

        .signature-section {
            margin-top: 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
            padding-top: 20px;
            border-top: 1px solid var(--line);
        }

        .signature-box {
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 70px;
        }

        .signature-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--ink-soft);
            margin: 0;
        }

        .signature-name {
            font-size: 12px;
            font-weight: 700;
            color: var(--ink);
            margin: 0;
        }

        .signature-role {
            font-size: 9px;
            color: var(--ink-soft);
            margin: 0;
        }

        .report-title { 
            margin: 0 0 4px; 
            font-size: 18px; 
            font-weight: 800;
            color: var(--ink);
        }

        @media print {
            .no-print { display:none; }
            .month-selector { display: none !important; }
            body { margin: 12mm; background: #fff; }
            .page { padding: 0; max-width: none; }
            .hero-card, .report-card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
            table { box-shadow: none; }
        }

        @media (max-width: 860px) {
            .totals {
                grid-template-columns: 1fr;
            }

            .hero-top,
            .report-head {
                flex-direction: column;
            }

            .meta {
                text-align: left;
            }

            .month-selector {
                grid-template-columns: repeat(3, 1fr);
            }

            .choice-actions {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .month-selector {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="page">
        @php
            if (!isset($month)) {
                $month = null;
            }
            if (!isset($year)) {
                $year = now()->year;
            }
            if (!isset($availableYears)) {
                $availableYears = [now()->year];
            }
            $months = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
        @endphp
        <div class="no-print hero-card">
            <div class="hero-top">
                <div>
                    <div class="title">Laporan Keuangan</div>
                    <div class="choice-sub">Laporan siap dicetak langsung lewat browser.</div>
                </div>
                <div class="meta">Tanggal: {{ now()->format('Y-m-d H:i') }}</div>
            </div>

            <div class="choice-actions">
                <button type="button" class="btn-choice btn-print" onclick="window.print()">🖨 Cetak Sekarang</button>
                <a href="{{ route('keuangans.index') }}" class="btn-choice btn-back">← Kembali</a>
            </div>

            <div class="month-selector" id="yearSelector" style="margin-bottom: 10px;">
                <div class="month-selector-label">📅 Pilih Tahun:</div>
                <button type="button" class="month-btn {{ $year === 'all' ? 'active' : '' }}" onclick="filterPrint('year', 'all')">
                    Semua Tahun
                </button>
                @foreach($availableYears as $y)
                    <button type="button" class="month-btn {{ (string)$year === (string)$y ? 'active' : '' }}" onclick="filterPrint('year', '{{ $y }}')">
                        {{ $y }}
                    </button>
                @endforeach
            </div>

            <div class="month-selector" id="monthSelector">
                <div class="month-selector-label">📅 Pilih Bulan:</div>
                @foreach($months as $num => $name)
                    <button type="button" class="month-btn {{ $month == $num ? 'active' : '' }}" 
                            onclick="filterPrint('month', {{ $num }})">
                        {{ $name }}
                    </button>
                @endforeach
                <button type="button" class="month-btn month-btn-all {{ is_null($month) ? 'active' : '' }}" 
                        onclick="filterPrint('month', null)">
                    📊 Lihat Semua Bulan
                </button>
            </div>
        </div>

        <div class="report-card">
            <div class="report-head">
                <div>
                    <div class="report-title">Laporan Keuangan</div>
                    <div class="report-subtitle">
                        @if($month && isset($months[$month]))
                            Data bulan {{ $months[$month] }} {{ $year === 'all' ? '(Semua Tahun)' : 'tahun ' . $year }}
                        @elseif($year && $year !== 'all')
                            Data seluruh bulan tahun {{ $year }}
                        @else
                            Semua data keuangan
                        @endif
                    </div>
                </div>
                <div class="meta">Tanggal: {{ now()->format('Y-m-d H:i') }}</div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Kategori / Produk</th>
                        <th>Keterangan</th>
                        <th class="text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($keuangans as $index => $k)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($k->jenis === 'pemasukan')
                                    <span style="background: rgba(26, 90, 58, 0.12); color: #1a5a3a; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800;">Pemasukan</span>
                                @else
                                    <span style="background: rgba(196, 30, 58, 0.12); color: #c41e3a; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800;">Pengeluaran</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($k->tanggal)->format('d M Y') }}</td>
                            <td>{{ optional($k->product)->nama_produk ?? '-' }}</td>
                            <td>{{ $k->keterangan }}</td>
                            <td class="text-right">Rp {{ number_format($k->jumlah,0,',','.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:24px; color:var(--ink-soft);">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="totals">
                <div class="box income">
                    <div class="label">Total Pemasukan</div>
                    <div class="value" style="color:#1a5a3a">Rp {{ number_format($totalPemasukan,0,',','.') }}</div>
                </div>
                <div class="box expense">
                    <div class="label">Total Pengeluaran</div>
                    <div class="value" style="color:#c41e3a">Rp {{ number_format($totalPengeluaran,0,',','.') }}</div>
                </div>
                <div class="box balance">
                    <div class="label">Saldo</div>
                    <div class="value" style="color:#1f2c20">Rp {{ number_format($saldo,0,',','.') }}</div>
                </div>
            </div>

            <div class="signature-section">
                <div class="signature-box">
                    <div class="signature-title">Dibuat oleh</div>
                    <div style="height: 30px;"></div>
                    <div class="signature-name">Admin</div>
                </div>
                <div class="signature-box">
                    <div class="signature-title">Mengetahui</div>
                    <div class="signature-role">Ketua UMKM</div>
                    <div style="height: 30px;"></div>
                    <div class="signature-name">Siti Nurmala</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterPrint(type, value) {
            const url = new URL(window.location);
            if (type === 'year') {
                if (value === 'all') {
                    url.searchParams.set('year', 'all');
                } else if (value) {
                    url.searchParams.set('year', value);
                } else {
                    url.searchParams.delete('year');
                }
            } else if (type === 'month') {
                if (value === null || value === '') {
                    url.searchParams.delete('month');
                } else {
                    url.searchParams.set('month', value);
                }
            }
            window.location.href = url.toString();
        }
    </script>

</body>
</html>