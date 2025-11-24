<<<<<<< Updated upstream
<h1>Selamat datang Penjual, {{ Auth::user()->nama }}!</h1>
<form method="POST" action="{{ route('logout') }}">
  @csrf
  <button type="submit">Logout</button>
</form>
=======
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

    <!-- NOTIFIKASI PESANAN BARU -->
    @if($pesananMasuk->count() > 0)
    <div class="mt-10">
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
            <div class="flex items-center gap-3">
                <div class="text-3xl font-bold text-red-600">{{ $notifikasiBaru }}</div>
                <div>
                    <h3 class="text-lg font-semibold text-red-700">Pesanan Masuk Baru!</h3>
                    <p class="text-red-600 text-sm">Ada {{ $notifikasiBaru }} pesanan yang menunggu untuk diproses</p>
                </div>
            </div>
        </div>

        <h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <i data-lucide="bell" class="w-6 h-6 text-red-600"></i>
            Pesanan Masuk (Belum Diproses)
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @foreach($pesananMasuk as $notif)
            <div class="bg-white p-5 rounded-lg shadow border-l-4 border-red-500 hover:shadow-lg transition">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800">{{ $notif->mahasiswa->nama ?? 'Mahasiswa' }}</h4>
                        <p class="text-sm text-gray-500">{{ $notif->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">BARU</span>
                </div>

                <div class="mb-4 bg-gray-50 p-3 rounded">
                    <h5 class="text-sm font-semibold text-gray-700 mb-2">Item Pesanan:</h5>
                    <ul class="space-y-1">
                        @foreach($notif->item as $item)
                        <li class="text-sm text-gray-600">
                            <span class="font-medium">{{ $item->menu->nama ?? 'N/A' }}</span>
                            <span class="text-gray-500">x{{ $item->jumlah }} = Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">Total:</p>
                        <p class="text-2xl font-bold text-green-700">Rp {{ number_format($notif->total_harga, 0, ',', '.') }}</p>
                    </div>
                    <a href="{{ route('penjual.pesanan.edit', $notif->id) }}" 
                       class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition">
                        Proses
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('penjual.pesanan.index') }}" class="text-green-600 hover:text-green-700 font-semibold">
                Lihat Semua Pesanan →
            </a>
        </div>
    </div>
    @endif

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

                        <td class="p-3">{{ $p->mahasiswa->nama ?? 'Tidak diketahui' }}</td>

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

<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>

@endsection
>>>>>>> Stashed changes
