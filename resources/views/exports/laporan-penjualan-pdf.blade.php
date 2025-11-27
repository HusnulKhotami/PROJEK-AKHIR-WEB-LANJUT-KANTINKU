<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $laporan_label }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 100%;
            padding: 40px;
            background: white;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #10B981;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #059669;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 12px;
            color: #666;
        }

        .header .date {
            font-size: 11px;
            color: #999;
            margin-top: 10px;
        }

        /* Statistics Section */
        .statistics {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            justify-content: space-between;
        }

        .stat-box {
            flex: 1;
            padding: 15px;
            background: #f0fdf4;
            border: 1px solid #d1fae5;
            border-radius: 8px;
        }

        .stat-label {
            font-size: 11px;
            color: #666;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 18px;
            color: #059669;
            font-weight: bold;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background: #059669;
            color: white;
        }

        th {
            padding: 12px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #ccc;
        }

        td {
            padding: 10px 12px;
            font-size: 11px;
            border: 1px solid #e5e7eb;
        }

        tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        tbody tr:hover {
            background: #f3f4f6;
        }

        /* Status badges */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }

        .badge-processing {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-ready {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-completed {
            background: #dcfce7;
            color: #166534;
        }

        .badge-payment {
            background: #e0e7ff;
            color: #3730a3;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: right;
            font-size: 10px;
            color: #999;
        }

        @media print {
            body {
                background: white;
            }
            .container {
                padding: 20px;
            }
        }

        /* Column widths */
        .col-no { width: 5%; }
        .col-name { width: 15%; }
        .col-items { width: 25%; }
        .col-qty { width: 8%; }
        .col-price { width: 15%; }
        .col-method { width: 12%; }
        .col-status { width: 10%; }
        .col-date { width: 10%; }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🍽️ KantinKu - Laporan Penjualan</h1>
            <p>{{ $laporan_label }}</p>
            <p class="date">Dicetak pada: {{ now()->format('d M Y H:i:s') }}</p>
        </div>

        <!-- Statistics -->
        <div class="statistics">
            <div class="stat-box">
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-value">{{ $totalPesanan }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Rata-rata per Pesanan</div>
                <div class="stat-value">Rp {{ number_format($rataPendapatan, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Table -->
        @if($pesanan->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th class="col-name">Pemesan</th>
                        <th class="col-items">Item Menu</th>
                        <th class="col-qty text-right">Jumlah</th>
                        <th class="col-price text-right">Total Harga</th>
                        <th class="col-method">Metode</th>
                        <th class="col-status">Status</th>
                        <th class="col-date">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $key => $p)
                    <tr>
                        <td class="col-no text-right">{{ $key + 1 }}</td>
                        <td class="col-name">
                            <div class="font-bold">{{ $p->mahasiswa->nama ?? 'Tidak diketahui' }}</div>
                            <div style="font-size: 9px; color: #666;">{{ $p->mahasiswa->nomor_induk ?? '-' }}</div>
                        </td>
                        <td class="col-items">
                            @foreach($p->items as $item)
                                <div>• {{ $item->menu->nama ?? 'N/A' }}</div>
                            @endforeach
                        </td>
                        <td class="col-qty text-right">{{ $p->items->sum('jumlah') ?? 0 }}</td>
                        <td class="col-price text-right font-bold">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                        <td class="col-method">
                            <span class="badge badge-payment">
                                {{ str_replace('_', ' ', ucfirst($p->metode_pembayaran)) }}
                            </span>
                        </td>
                        <td class="col-status">
                            @if($p->status == 'proses')
                                <span class="badge badge-processing">Diproses</span>
                            @elseif($p->status == 'siap')
                                <span class="badge badge-ready">Siap Diambil</span>
                            @elseif($p->status == 'selesai')
                                <span class="badge badge-completed">Selesai</span>
                            @else
                                <span class="badge">{{ ucfirst($p->status) }}</span>
                            @endif
                        </td>
                        <td class="col-date">{{ $p->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="empty-state">Tidak ada data pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <p>Tidak ada pesanan untuk periode ini</p>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ now()->year }} KantinKu - Sistem Manajemen Kantin</p>
        </div>
    </div>
</body>
</html>
