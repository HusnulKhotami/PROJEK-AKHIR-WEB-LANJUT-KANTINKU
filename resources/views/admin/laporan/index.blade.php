@extends('layout.admin')

@section('title', 'Laporan Keuangan | KantinKu')

@section('content')

<main class="flex-1 p-8">

    <!-- Judul -->
    <h2 class="text-3xl font-bold text-green-700 mb-8">
        Laporan Keuangan & Rekap Pesanan
    </h2>

    <!-- FILTER LAPORAN -->
    <div class="bg-white p-6 rounded-2xl shadow mb-8">
        <h3 class="text-xl font-semibold mb-4">Filter Laporan</h3>

        <form class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <label class="block mb-1 font-medium">Tanggal Mulai</label>
                <input type="date"
                       class="w-full border rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-green-400 focus:outline-none">
            </div>

            <div>
                <label class="block mb-1 font-medium">Tanggal Akhir</label>
                <input type="date"
                       class="w-full border rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-green-400 focus:outline-none">
            </div>

            <div class="flex items-end">
                <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg shadow transition">
                    Terapkan Filter
                </button>
            </div>

        </form>
    </div>

    <!-- RINGKASAN KEUANGAN -->
    <div class="bg-white p-6 rounded-2xl shadow mb-8">
        <h3 class="text-xl font-semibold mb-4">Ringkasan Keuangan</h3>

        <div class="space-y-2">
            <p class="text-lg">
                <strong>Total Transaksi:</strong>
                {{ $totalTransaksi }} transaksi
            </p>

            <p class="text-lg">
                <strong>Total Pendapatan:</strong>
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </p>

            <p class="text-lg">
                <strong>Tanggal Laporan:</strong>
                1 Januari – 10 Januari
                {{-- Nantinya bisa diganti sesuai filter --}}
            </p>
        </div>
    </div>

    <!-- DETAIL TRANSAKSI -->
    <div class="bg-white p-6 rounded-2xl shadow mb-8">

        <h3 class="text-xl font-semibold mb-4">Detail Transaksi</h3>

        <table class="w-full border-collapse rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-green-600 text-white">
                    <th class="py-3 px-4 text-left">ID</th>
                    <th class="py-3 px-4 text-left">Pemesan</th>
                    <th class="py-3 px-4 text-left">Total</th>
                    <th class="py-3 px-4 text-left">Tanggal</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">
                @forelse($transaksiTerbaru as $trx)
                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="py-3 px-4">
                        TRX{{ str_pad($trx->id, 3, '0', STR_PAD_LEFT) }}
                    </td>

                    <td class="py-3 px-4">
                        {{ optional(optional($trx->pesanan)->mahasiswa)->nama ?? '-' }}
                    </td>

                    <td class="py-3 px-4">
                        Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                    </td>

                    <td class="py-3 px-4">
                        {{ optional($trx->created_at)->format('d-m-Y') }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-3 px-4 text-center text-gray-500">
                        Belum ada transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <!-- DOWNLOAD BUTTONS -->
    <div class="flex gap-4">

        <a href="{{ route('admin.laporan.pdf') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
            <i data-lucide="file-text" class="w-4 h-4"></i>
            Download PDF
        </a>

        <a href="{{ route('admin.laporan.excel') }}"
           class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow transition">
            <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
            Download Excel
        </a>

    </div>

</main>

@endsection