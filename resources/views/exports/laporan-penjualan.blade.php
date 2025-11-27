<table>
    <thead>
        <tr>
            <th colspan="8" style="font-size: 14px; font-weight: bold; background-color: #10B981; color: white;">
                {{ $laporan_label }}
            </th>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="2">
                <strong>Total Pesanan:</strong> {{ $totalPesanan }}
            </th>
            <th colspan="2">
                <strong>Total Pendapatan:</strong> Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </th>
            <th colspan="2">
                <strong>Rata-rata per Pesanan:</strong> Rp {{ number_format($rataPendapatan, 0, ',', '.') }}
            </th>
        </tr>
        <tr></tr>
        <tr>
            <th>No</th>
            <th>Pemesan</th>
            <th>Item Menu</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Metode</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pesanan as $key => $p)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $p->mahasiswa->nama ?? 'Tidak diketahui' }} ({{ $p->mahasiswa->nomor_induk ?? '-' }})</td>
            <td>
                @foreach($p->items as $item)
                    • {{ $item->menu->nama ?? 'N/A' }}{{ !$loop->last ? "\n" : '' }}
                @endforeach
            </td>
            <td>{{ $p->items->sum('jumlah') ?? 0 }}</td>
            <td>{{ $p->total_harga }}</td>
            <td>{{ str_replace('_', ' ', ucfirst($p->metode_pembayaran)) }}</td>
            <td>
                @if($p->status == 'proses')
                    Diproses
                @elseif($p->status == 'siap')
                    Siap Diambil
                @elseif($p->status == 'selesai')
                    Selesai
                @else
                    {{ ucfirst($p->status) }}
                @endif
            </td>
            <td>{{ $p->created_at->format('d M Y H:i') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8">Tidak ada data pesanan</td>
        </tr>
        @endforelse
    </tbody>
</table>
