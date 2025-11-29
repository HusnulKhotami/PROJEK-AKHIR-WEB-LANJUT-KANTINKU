<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan KantinKu</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        th { background: #16a34a; color: #fff; }
        h2 { margin-bottom: 10px; }
    </style>
</head>
<body>

    <h2>Laporan Keuangan KantinKu</h2>

    <p><strong>Total Transaksi:</strong> {{ $totalTransaksi }}</p>
    <p><strong>Total Pendapatan:</strong> Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Pemesan</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>

        <tbody>
        @foreach($transaksiTerbaru as $trx)
            <tr>
                <td>TRX{{ str_pad($trx->id, 3, '0', STR_PAD_LEFT) }}</td>
                <td>{{ optional(optional($trx->pesanan)->mahasiswa)->nama ?? '-' }}</td>
                <td>Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                <td>{{ optional($trx->created_at)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</body>
</html>