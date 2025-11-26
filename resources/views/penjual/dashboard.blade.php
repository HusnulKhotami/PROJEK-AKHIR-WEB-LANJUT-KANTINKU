@extends('layout.penjual')

@section('content')

<!-- Welcome Section -->
<div class="mb-10">
    <p class="text-gray-600 text-lg">Selamat datang kembali, <span class="font-bold text-gray-800">{{ Auth::user()->nama }}</span></p>
    <p class="text-sm text-gray-500 mt-1">{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
</div>

<!-- Stats Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

    <!-- Total Menu Card -->
    <div class="stat-card bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Total Menu</p>
                <p class="text-4xl font-bold text-green-600 mt-3">{{ $totalMenu }}</p>
                <p class="text-xs text-gray-500 mt-2">Menu aktif</p>
            </div>
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-burger text-3xl text-green-600"></i>
            </div>
        </div>
    </div>

    <!-- Pesanan Hari Ini Card -->
    <div class="stat-card bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Pesanan Hari Ini</p>
                <p class="text-4xl font-bold text-blue-600 mt-3">{{ $pesananHariIni }}</p>
                <p class="text-xs text-gray-500 mt-2">Total pesanan</p>
            </div>
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-inbox text-3xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <!-- Pendapatan Hari Ini Card -->
    <div class="stat-card bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Pendapatan Hari Ini</p>
                <p class="text-3xl font-bold text-yellow-600 mt-3">Rp {{ number_format($pendapatan, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-2">Dari pesanan selesai</p>
            </div>
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                <i class="fas fa-coins text-3xl text-yellow-600"></i>
            </div>
        </div>
    </div>

    <!-- Notifikasi Baru Card -->
    <div class="stat-card bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Pesanan Diproses</p>
                <p class="text-4xl font-bold text-red-600 mt-3">{{ $notifikasiBaru }}</p>
                <p class="text-xs text-gray-500 mt-2">Menunggu diproses</p>
            </div>
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-bell text-3xl text-red-600"></i>
            </div>
        </div>
    </div>

</div>

<!-- Recent Orders Section -->
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    
    <!-- Header -->
    <div class="px-8 py-6 border-b border-gray-200 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Pesanan Terbaru</h2>
            <p class="text-sm text-gray-500 mt-1">5 pesanan terbaru Anda</p>
        </div>
        <a href="{{ route('penjual.pesanan.index') }}" class="text-green-600 font-semibold hover:text-green-700 text-sm flex items-center gap-2">
            Lihat Semua
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <!-- Content -->
    <div class="overflow-x-auto">
        @if($pesanan->count() == 0)
            <div class="p-12 text-center">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 font-medium">Belum ada pesanan</p>
                <p class="text-sm text-gray-400 mt-1">Pesanan akan muncul di sini setelah pembeli melakukan pemesanan</p>
            </div>
        @else
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Pemesan</th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Total Harga</th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Metode Pembayaran</th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanan as $p)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                        <td class="px-8 py-4">
                            <p class="font-medium text-gray-800">{{ $p->mahasiswa->nama ?? 'Tidak diketahui' }}</p>
                            <p class="text-sm text-gray-500">{{ $p->mahasiswa->nomor_induk ?? '-' }}</p>
                        </td>
                        <td class="px-8 py-4">
                            <p class="font-semibold text-gray-800">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-8 py-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full capitalize">
                                {{ str_replace('_', ' ', $p->metode_pembayaran) }}
                            </span>
                        </td>
                        <td class="px-8 py-4">
                            @if($p->status == 'proses')
                                <span class="inline-flex items-center gap-2 px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full font-medium">
                                    <span class="w-2 h-2 bg-yellow-600 rounded-full animate-pulse"></span>
                                    Diproses
                                </span>
                            @elseif($p->status == 'siap')
                                <span class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full font-medium">
                                    <span class="w-2 h-2 bg-blue-600"></span>
                                    Siap Ambil
                                </span>
                            @elseif($p->status == 'selesai')
                                <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">
                                    <span class="w-2 h-2 bg-green-600"></span>
                                    Selesai
                                </span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm rounded-full capitalize">
                                    {{ $p->status }}
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-4">
                            <p class="text-gray-800 font-medium">{{ $p->created_at->format('d M Y') }}</p>
                            <p class="text-sm text-gray-500">{{ $p->created_at->format('H:i') }}</p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>

@endsection
