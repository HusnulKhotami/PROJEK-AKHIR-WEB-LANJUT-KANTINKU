@extends('layout.penjual', [
    'title' => 'Laporan Penjualan KantinKu - Penjual',
    'header' => 'Laporan Penjualan'
])

@section('content')

<!-- Header -->
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $laporan_label }}</h2>
    <p class="text-gray-600">Ringkasan transaksi penjualan Anda</p>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 mb-8">
    <div class="mb-4">
        <p class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <i class="fas fa-filter text-green-600"></i>
            Filter Laporan
        </p>
    </div>
    
    <form method="GET" action="{{ route('penjual.aktivitas.index') }}" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <!-- Filter Periode -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Periode</label>
            <select name="periode" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="harian" {{ $periode === 'harian' ? 'selected' : '' }}>Harian</option>
                <option value="mingguan" {{ $periode === 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                <option value="bulanan" {{ $periode === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
            </select>
        </div>

        <!-- Tanggal (Harian) -->
        @if($periode === 'harian')
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
            <input type="date" name="tanggal" value="{{ request('tanggal', \Carbon\Carbon::now()->format('Y-m-d')) }}" 
                   onchange="this.form.submit()" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        @endif

        <!-- Minggu (Mingguan) -->
        @if($periode === 'mingguan')
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Minggu ke-</label>
            <select name="minggu" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                @for($i = 1; $i <= 4; $i++)
                    <option value="{{ $i }}" {{ request('minggu', 1) == $i ? 'selected' : '' }}>Minggu {{ $i }}</option>
                @endfor
            </select>
        </div>
        @endif

        <!-- Bulan (Mingguan & Bulanan) -->
        @if($periode === 'mingguan' || $periode === 'bulanan')
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
            <select name="bulan" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
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
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
            <select name="tahun" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                @for($i = 2023; $i <= now()->year; $i++)
                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
        @endif

        <!-- Reset Button -->
        <div class="flex items-end">
            <a href="{{ route('penjual.aktivitas.index') }}" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg text-center font-semibold transition-colors flex items-center justify-center gap-2">
                <i class="fas fa-redo"></i>
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Pesanan</p>
                <p class="text-4xl font-bold text-green-600 mt-3">{{ $totalPesanan }}</p>
            </div>
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-shopping-bag text-3xl text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Pendapatan</p>
                <p class="text-3xl font-bold text-blue-600 mt-3">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </div>
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-coins text-3xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Rata-rata per Pesanan</p>
                <p class="text-3xl font-bold text-yellow-600 mt-3">Rp {{ number_format($rataPendapatan, 0, ',', '.') }}</p>
            </div>
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                <i class="fas fa-chart-line text-3xl text-yellow-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Status Pesanan</p>
                <div class="mt-3 space-y-2 text-sm">
                    <p class="text-yellow-600 font-medium">
                        <span class="w-2 h-2 bg-yellow-600 rounded-full inline-block mr-2"></span>
                        Proses: {{ $statusBreakdown->get('diproses', 0) ?? 0 }}
                    </p>
                    <p class="text-green-600 font-medium">
                        <span class="w-2 h-2 bg-green-600 rounded-full inline-block mr-2"></span>
                        Selesai: {{ $statusBreakdown->get('selesai', 0) ?? 0 }}
                    </p>
                </div>
            </div>
            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-tasks text-3xl text-purple-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Details Table -->
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    
    <!-- Table Header -->
    <div class="px-8 py-6 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-800">Detail Pesanan</h2>
            <p class="text-sm text-gray-500 mt-1">Daftar semua pesanan untuk periode yang dipilih</p>
        </div>
    </div>

    <!-- Table Content -->
    <div class="overflow-x-auto">
        @if($pesanan->count() == 0)
            <div class="px-8 py-12 text-center">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-600 font-semibold">Tidak ada pesanan untuk periode ini</p>
                <p class="text-gray-500 text-sm mt-1">Pilih periode lain untuk melihat laporan penjualan</p>
            </div>
        @else
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">No</th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Pemesan</th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Item Menu</th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Total Harga</th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Metode</th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $key => $p)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                        <td class="px-8 py-4 font-medium text-gray-800">{{ $key + 1 }}</td>
                        <td class="px-8 py-4">
                            <p class="font-medium text-gray-800">{{ $p->mahasiswa->nama ?? 'Tidak diketahui' }}</p>
                            <p class="text-xs text-gray-500">{{ $p->mahasiswa->nomor_induk ?? '-' }}</p>
                        </td>
                        <td class="px-8 py-4">
                            <div class="text-sm space-y-1">
                                @foreach($p->items as $item)
                                    <div class="flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                        {{ $item->menu->nama ?? 'N/A' }}
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-8 py-4 font-semibold text-gray-800">
                            {{ $p->items->sum('jumlah') ?? 0 }}
                        </td>
                        <td class="px-8 py-4 font-bold text-green-600">
                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full font-medium">
                                {{ str_replace('_', ' ', ucfirst($p->metode_pembayaran)) }}
                            </span>
                        </td>
                        <td class="px-8 py-4">
                            @if($p->status == 'proses')
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full font-medium">
                                    <span class="w-2 h-2 bg-yellow-600 rounded-full animate-pulse"></span>
                                    Diproses
                                </span>
                            @elseif($p->status == 'siap')
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full font-medium">
                                    <span class="w-2 h-2 bg-blue-600"></span>
                                    Siap Diambil
                                </span>
                            @elseif($p->status == 'selesai')
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">
                                    <span class="w-2 h-2 bg-green-600"></span>
                                    Selesai
                                </span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs rounded-full font-medium">
                                    {{ ucfirst($p->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-4 text-sm">
                            <p class="text-gray-800 font-medium">{{ $p->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $p->created_at->format('H:i') }}</p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-8 py-6 text-center text-gray-500">Tidak ada data pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>
</div>

<!-- Export Buttons -->
<div class="flex gap-3 mt-8 justify-end flex-wrap">
    <button onclick="window.print()" class="flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition-colors shadow-sm">
        <i class="fas fa-print"></i>
        Print
    </button>
    <a href="{{ route('penjual.aktivitas.export-pdf', ['periode' => $periode, 'bulan' => $bulan, 'tahun' => $tahun, 'tanggal' => request('tanggal')]) }}" 
       class="flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition-colors shadow-sm">
        <i class="fas fa-file-pdf"></i>
        Export PDF
    </a>
    <a href="{{ route('penjual.aktivitas.export-excel', ['periode' => $periode, 'bulan' => $bulan, 'tahun' => $tahun, 'tanggal' => request('tanggal')]) }}" 
       class="flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition-colors shadow-sm">
        <i class="fas fa-file-excel"></i>
        Export Excel
    </a>
</div>

<style media="print">
    body { background: white; }
    .p-8 { padding: 0; }
    button, a { display: none; }
    .overflow-x-auto { overflow: visible; }
    table { margin-top: 20px; }
</style>

@endsection