<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $pesanan->id }}</title>
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
            background: white;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
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

        .header .order-id {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .header .date {
            font-size: 12px;
            color: #999;
        }

        /* Info Section */
        .info-section {
            margin-bottom: 30px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-box {
            padding: 15px;
            background: #f0fdf4;
            border: 1px solid #d1fae5;
            border-radius: 8px;
        }

        .info-label {
            font-size: 12px;
            color: #666;
            font-weight: 600;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .info-value {
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
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
            padding: 12px;
            font-size: 12px;
            border: 1px solid #e5e7eb;
        }

        tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        /* Summary Section */
        .summary {
            margin: 30px 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .summary-item {
            padding: 15px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
        }

        .summary-item.header {
            background: #f0fdf4;
            font-weight: 600;
            border-top: 2px solid #059669;
            border-bottom: 2px solid #059669;
        }

        .summary-item.total {
            background: #059669;
            color: white;
            font-size: 14px;
            font-weight: bold;
        }

        /* Notes Section */
        .notes-section {
            margin: 30px 0;
            padding: 15px;
            background: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 8px;
        }

        .notes-label {
            font-weight: 600;
            color: #92400e;
            margin-bottom: 8px;
            font-size: 12px;
        }

        .notes-content {
            color: #78350f;
            font-size: 12px;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-processing {
            background: #fef3c7;
            color: #92400e;
        }

        .status-ready {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-completed {
            background: #dcfce7;
            color: #166534;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #999;
        }

        .footer p {
            margin: 5px 0;
        }

        @media print {
            body {
                background: white;
            }
            .container {
                padding: 20px;
            }
        }

        /* Empty state */
        .empty {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .col-name { width: 35%; }
        .col-qty { width: 15%; }
        .col-price { width: 25%; }
        .col-subtotal { width: 25%; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🍽️ KantinKu - Detail Pesanan</h1>
            <p class="order-id">Nomor Pesanan: <strong>#{{ $pesanan->id }}</strong></p>
            <p class="date">Dicetak pada: {{ now()->format('d M Y H:i:s') }}</p>
        </div>

        <!-- Info Section -->
        <div class="info-section">
            <div class="info-box">
                <div class="info-label">Pedagang</div>
                <div class="info-value">{{ $pesanan->pedagang->nama_kantin }}</div>
            </div>
            <div class="info-box">
                <div class="info-label">Metode Pembayaran</div>
                <div class="info-value">{{ str_replace('_', ' ', ucfirst($pesanan->metode_pembayaran)) }}</div>
            </div>
            <div class="info-box">
                <div class="info-label">Status Pesanan</div>
                <div class="info-value">
                    @if($pesanan->status == 'proses')
                        <span class="status-badge status-processing">Diproses</span>
                    @elseif($pesanan->status == 'siap')
                        <span class="status-badge status-ready">Siap Diambil</span>
                    @elseif($pesanan->status == 'selesai')
                        <span class="status-badge status-completed">Selesai</span>
                    @elseif($pesanan->status == 'dibatalkan')
                        <span class="status-badge status-cancelled">Dibatalkan</span>
                    @else
                        <span class="status-badge">{{ ucfirst($pesanan->status) }}</span>
                    @endif
                </div>
            </div>
            <div class="info-box">
                <div class="info-label">Tanggal Pesanan</div>
                <div class="info-value">{{ $pesanan->created_at->format('d M Y H:i') }}</div>
            </div>
        </div>

        <!-- Items Table -->
        @if($pesanan->items->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th class="col-name">Nama Menu</th>
                        <th class="col-qty text-right">Jumlah</th>
                        <th class="col-price text-right">Harga Satuan</th>
                        <th class="col-subtotal text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan->items as $item)
                    <tr>
                        <td class="col-name">{{ $item->menu->nama }}</td>
                        <td class="col-qty text-right">{{ $item->jumlah }}</td>
                        <td class="col-price text-right">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="col-subtotal text-right font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty">Tidak ada item pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        @else
            <div class="empty">
                <p>Tidak ada item dalam pesanan ini</p>
            </div>
        @endif

        <!-- Summary Section -->
        <div class="summary">
            <div>
                <div class="summary-item header">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="summary-item">
                    <span>Pajak (0%)</span>
                    <span>Rp 0</span>
                </div>
                <div class="summary-item total">
                    <span>TOTAL YANG HARUS DIBAYAR</span>
                    <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        @if($pesanan->catatan)
        <div class="notes-section">
            <div class="notes-label">Catatan Pembeli:</div>
            <div class="notes-content">{{ $pesanan->catatan }}</div>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ now()->year }} KantinKu - Sistem Manajemen Kantin</p>
            <p>Untuk pertanyaan, silakan hubungi penjual melalui aplikasi</p>
        </div>
    </div>
</body>
</html>
