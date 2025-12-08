<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }
        h2 {
            margin: 0 0 4px 0;
        }
        small {
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: left;
        }
        th {
            background: #e5e5e5;
        }
    </style>
</head>
<body>

    <h2>Laporan Transaksi KantinKu</h2>
    <small>Dicetak: {{ now()->format('d-m-Y H:i') }}</small>

    <table>
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Nama Pemesan</th>
                <th>Item</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $t)
                <tr>
                    <td>{{ $t->id_transaksi }}</td>
                    <td>{{ $t->nama_pemesan }}</td>
                    <td>{{ $t->item }}</td>
                    <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                    <td>{{ $t->status }}</td>
                    <td>
                        {{ optional($t->tanggal)->format('d-m-Y H:i') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
