@extends('layout.penjual', [
    'title' => 'Laporan Penjualan KantinKu - Penjual',
    'header' => 'Laporan Penjualan'
])

@section('content')

<div class="p-6">
    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-700">{{ $laporan_label }}</h1>
        <p class="text-gray-500 mt-1">Ringkasan transaksi penjualan Anda</p>
    </div>

    <!-- FILTER PERIODE -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <form method="GET" action="{{ route('penjual.aktivitas.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Filter Periode -->
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Periode</label>
                <select name="periode" onchange="this.form.submit()" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="harian" {{ $periode === 'harian' ? 'selected' : '' }}>Harian</option>
                    <option value="mingguan" {{ $periode === 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                    <option value="bulanan" {{ $periode === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                </select>
            </div>

            <!-- Tanggal (Harian) -->
            @if($periode === 'harian')
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal', \Carbon\Carbon::now()->format('Y-m-d')) }}" 
                       onchange="this.form.submit()" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            @endif

            <!-- Minggu (Mingguan) -->
            @if($periode === 'mingguan')
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Minggu ke-</label>
                <select name="minggu" onchange="this.form.submit()" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    @for($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}" {{ request('minggu', 1) == $i ? 'selected' : '' }}>Minggu {{ $i }}</option>
                    @endfor
                </select>
            </div>
            @endif

            <!-- Bulan (Mingguan & Bulanan) -->
            @if($periode === 'mingguan' || $periode === 'bulanan')
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Bulan</label>
                <select name="bulan" onchange="this.form.submit()" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::createFromFormat('m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            @endif

            <!-- Tahun (Mingguan & Bulanan) -->
            @if($periode === 'mingguan' || $periode === 'bulanan')
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Tahun</label>
                <select name="tahun" onchange="this.form.submit()" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    @for($i = 2023; $i <= now()->year; $i++)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            @endif

            <!-- Reset Button -->
            <div class="flex items-end">
                <a href="{{ route('penjual.aktivitas.index') }}" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-center font-semibold transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- STATISTIK RINGKASAN -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-semibold">Total Pesanan</h3>
            <p class="text-3xl font-bold text-green-700 mt-2">{{ $totalPesanan }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-semibold">Total Pendapatan</h3>
            <p class="text-2xl font-bold text-blue-700 mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-semibold">Rata-rata per Pesanan</h3>
            <p class="text-2xl font-bold text-yellow-600 mt-2">Rp {{ number_format($rataPendapatan, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm font-semibold">Status Pesanan</h3>
            <div class="mt-3 space-y-1 text-sm">
                <p class="text-yellow-600">Proses: {{ $statusBreakdown->get('diproses', 0) ?? 0 }}</p>
                <p class="text-green-600">Selesai: {{ $statusBreakdown->get('selesai', 0) ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- TABEL DETAIL PESANAN -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Detail Pesanan</h2>

        @if($pesanan->count() == 0)
            <p class="text-gray-500 text-center py-6">Tidak ada pesanan untuk periode ini.</p>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="p-3">No</th>
                        <th class="p-3">Pemesan</th>
                        <th class="p-3">Item Menu</th>
                        <th class="p-3">Jumlah</th>
                        <th class="p-3">Total Harga</th>
                        <th class="p-3">Metode Pembayaran</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $key => $p)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $key + 1 }}</td>
                        <td class="p-3">{{ $p->mahasiswa->nama ?? 'Tidak diketahui' }}</td>
                        <td class="p-3">
                            <div class="text-sm">
                                @foreach($p->item as $item)
                                    <div>{{ $item->menu->nama ?? 'N/A' }} (x{{ $item->jumlah }})</div>
                                @endforeach
                            </div>
                        </td>
                        <td class="p-3">
                            <span class="font-semibold">{{ $p->item->sum('jumlah') ?? 0 }}</span>
                        </td>
                        <td class="p-3 font-bold text-green-700">
                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="p-3 capitalize">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                {{ $p->metode_pembayaran }}
                            </span>
                        </td>
                        <td class="p-3">
                            @if($p->status == 'diproses')
                                <span class="px-3 py-1 bg-yellow-200 text-yellow-800 rounded-full text-xs font-semibold">Diproses</span>
                            @elseif($p->status == 'siap_diambil')
                                <span class="px-3 py-1 bg-blue-200 text-blue-800 rounded-full text-xs font-semibold">Siap Diambil</span>
                            @elseif($p->status == 'selesai')
                                <span class="px-3 py-1 bg-green-200 text-green-800 rounded-full text-xs font-semibold">Selesai</span>
                            @else
                                <span class="px-3 py-1 bg-gray-200 text-gray-800 rounded-full text-xs font-semibold">{{ ucfirst($p->status) }}</span>
                            @endif
                        </td>
                        <td class="p-3 text-sm">{{ $p->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-3 text-center text-gray-500">Tidak ada data pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- TOMBOL EXPORT -->
        <div class="flex gap-3 mt-6 justify-end">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center gap-2 font-semibold transition">
                <i data-lucide="printer" class="w-4 h-4"></i> Print
            </button>
            <a href="{{ route('penjual.aktivitas.export-pdf', ['periode' => $periode, 'bulan' => $bulan, 'tahun' => $tahun, 'tanggal' => request('tanggal')]) }}" 
               class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center gap-2 font-semibold transition">
                <i data-lucide="download" class="w-4 h-4"></i> Export PDF
            </a>
            <a href="{{ route('penjual.aktivitas.export-excel', ['periode' => $periode, 'bulan' => $bulan, 'tahun' => $tahun, 'tanggal' => request('tanggal')]) }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg flex items-center gap-2 font-semibold transition">
                <i data-lucide="file" class="w-4 h-4"></i> Export Excel
            </a>
        </div>
        @endif
    </div>

</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>

<style media="print">
    body { background: white; }
    .p-6 { padding: 0; }
    button, a { display: none; }
    .overflow-x-auto { overflow: visible; }
    table { margin-top: 20px; }
</style>

@endsection