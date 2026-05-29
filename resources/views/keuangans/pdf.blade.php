<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan PDF</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color: #222; margin: 20px; }
        .header { margin-bottom: 16px; }
        .title { font-size: 20px; font-weight: 700; }
        .meta { font-size: 12px; color: #555; margin-top: 6px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #d8d8d8; padding: 8px; font-size: 12px; }
        th { background: #f3f3f3; text-align: left; }
        .text-right { text-align: right; }
        .totals { margin-top: 16px; width: 100%; }
        .totals td { border: none; padding: 4px 0; font-size: 12px; }
        .totals .label { color: #555; }
        .totals .value { text-align: right; font-weight: 700; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Laporan Keuangan</div>
        <div class="meta">Tanggal cetak: {{ now()->format('Y-m-d H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 36px;">#</th>
                <th>Jenis</th>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Keterangan</th>
                <th class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($keuangans as $index => $k)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ ucfirst($k->jenis) }}</td>
                    <td>{{ \Carbon\Carbon::parse($k->tanggal)->format('Y-m-d') }}</td>
                    <td>{{ optional($k->product)->nama_produk ?? '-' }}</td>
                    <td>{{ $k->keterangan }}</td>
                    <td class="text-right">Rp {{ number_format($k->jumlah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td class="label">Total Pemasukan</td>
            <td class="value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Total Pengeluaran</td>
            <td class="value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Saldo</td>
            <td class="value">Rp {{ number_format($saldo, 0, ',', '.') }}</td>
        </tr>
    </table>
</body>
</html>
