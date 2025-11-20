@extends('layout.penjual')

@section('content')

<div class="p-6">

    <h1 class="text-2xl font-bold text-gray-700">Dashboard Penjual</h1>
    <p class="text-gray-500">Selamat datang kembali, {{ Auth::user()->nama }} 👋</p>

    <!-- STATISTIK -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-gray-500">Total Menu</h3>
            <p class="text-3xl font-bold text-green-700 mt-2">{{ $totalMenu }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-gray-500">Pesanan Hari Ini</h3>
            <p class="text-3xl font-bold text-blue-700 mt-2">{{ $pesananHariIni }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-gray-500">Pendapatan Hari Ini</h3>
            <p class="text-3xl font-bold text-yellow-600 mt-2">Rp {{ number_format($pendapatan, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-gray-500">Notifikasi Baru</h3>
            <p class="text-3xl font-bold text-red-600 mt-2">{{ $notifikasiBaru }}</p>
        </div>

    </div>

    <!-- PESANAN TERBARU -->
    <div class="mt-10">
        <h2 class="text-xl font-semibold text-gray-700">Pesanan Terbaru</h2>

        @if($pesanan->count() == 0)
            <p class="text-gray-500 mt-2">Belum ada pesanan.</p>
        @else
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full bg-white rounded-lg shadow">

                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="p-3 text-left">Pemesan</th>
                        <th class="p-3 text-left">Total Harga</th>
                        <th class="p-3 text-left">Metode Pembayaran</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($pesanan as $p)
                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-3">{{ $p->user->name ?? 'Tidak diketahui' }}</td>

                        <td class="p-3">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>

                        <td class="p-3 capitalize">{{ $p->metode_pembayaran }}</td>

                        <td class="p-3">
                            @if($p->status == 'diproses')
                                <span class="px-3 py-1 bg-yellow-200 text-yellow-800 rounded-full text-sm">Diproses</span>
                            @elseif($p->status == 'selesai')
                                <span class="px-3 py-1 bg-green-200 text-green-800 rounded-full text-sm">Selesai</span>
                            @else
                                <span class="px-3 py-1 bg-gray-200 text-gray-800 rounded-full text-sm">{{ $p->status }}</span>
                            @endif
                        </td>

                        <td class="p-3">{{ $p->created_at->format('d M Y H:i') }}</td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        @endif
    </div>

</div>

@endsection
