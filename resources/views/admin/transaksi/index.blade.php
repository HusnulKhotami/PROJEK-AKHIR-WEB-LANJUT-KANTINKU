@extends('layout.admin')

@section('title', 'Manajemen Transaksi | KantinKu')

@section('content')

<main class="flex-1 p-8">

    <h2 class="text-3xl font-bold text-green-700 mb-8">Manajemen Transaksi</h2>

    <!-- ============================ FILTER BAR ============================ -->
    <div class="flex items-center gap-4 mb-6">

        <!-- ========== FILTER STATUS ========== -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="px-4 py-2 bg-green-600 text-white rounded-lg shadow flex items-center gap-2 hover:bg-green-700 transition">

                {{ $status ? ucfirst($status) : 'Status Pembayaran' }}

                <i data-lucide="chevron-down"
                   :class="open ? 'rotate-180' : ''"
                   class="w-4 h-4 transition"></i>
            </button>

            <div x-show="open"
                 @click.outside="open = false"
                 x-transition
                 class="absolute mt-2 w-48 bg-white rounded-lg shadow border border-gray-200 overflow-hidden z-50">

                <a href="{{ route('admin.transaksi', ['tanggal' => $tanggal]) }}"
                   class="block px-4 py-2 hover:bg-green-100">
                    Semua Status
                </a>

                <a href="{{ route('admin.transaksi', ['status' => 'Berhasil', 'tanggal' => $tanggal]) }}"
                   class="block px-4 py-2 hover:bg-green-100">
                    Berhasil
                </a>

                <a href="{{ route('admin.transaksi', ['status' => 'Pending', 'tanggal' => $tanggal]) }}"
                   class="block px-4 py-2 hover:bg-green-100">
                    Pending
                </a>

                <a href="{{ route('admin.transaksi', ['status' => 'Gagal', 'tanggal' => $tanggal]) }}"
                   class="block px-4 py-2 hover:bg-green-100">
                    Gagal
                </a>
            </div>
        </div>

        <!-- ========== FILTER TANGGAL ========== -->
        <form method="GET" action="{{ route('admin.transaksi') }}">
            @if($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif

            <input type="date"
                   name="tanggal"
                   value="{{ $tanggal }}"
                   onchange="this.form.submit()"
                   class="px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-green-400 focus:outline-none">
        </form>

        <!-- ========== EXPORT BUTTONS ========== -->
        <div class="ml-auto flex gap-3">

            <a href="{{ route('admin.transaksi.export.pdf') }}"
               class="px-4 py-2 bg-white border border-green-600 text-green-700 rounded-lg text-sm
                      hover:bg-green-50 flex items-center gap-2 shadow-sm transition">
                <i data-lucide="file-text" class="w-4 h-4"></i>
                Ekspor PDF
            </a>

            <a href="{{ route('admin.transaksi.export.excel') }}"
               class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm
                      hover:bg-green-700 flex items-center gap-2 shadow-sm transition">
                <i data-lucide="table" class="w-4 h-4"></i>
                Ekspor Excel
            </a>

        </div>

    </div>

    <!-- ============================ TABEL TRANSAKSI ============================ -->
    <div class="bg-white rounded-2xl shadow p-6">

        <table class="w-full border-collapse rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-green-600 text-white">
                    <th class="py-3 px-4 text-left">ID</th>
                    <th class="py-3 px-4 text-left">Nama Pemesan</th>
                    <th class="py-3 px-4 text-left">Item</th>
                    <th class="py-3 px-4 text-left">Total</th>
                    <th class="py-3 px-4 text-left">Status</th>
                    <th class="py-3 px-4 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @forelse($transaksi as $trx)
                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="px-4 py-3">{{ $trx->id_transaksi }}</td>
                    <td class="px-4 py-3">{{ $trx->nama_pemesan }}</td>
                    <td class="px-4 py-3">{{ $trx->item }}</td>

                    <td class="px-4 py-3">
                        Rp {{ number_format($trx->total, 0, ',', '.') }}
                    </td>

                    <td class="px-4 py-3">
                        @if($trx->status == 'Berhasil')
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-sm rounded-lg font-semibold">Berhasil</span>
                        @elseif($trx->status == 'Pending')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-sm rounded-lg font-semibold">Pending</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-sm rounded-lg font-semibold">Gagal</span>
                        @endif
                    </td>

                    <td class="px-4 py-3">
                        <a href="{{ route('admin.transaksi.detail', $trx->id) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-500 hover:bg-blue-600
                                  text-white text-sm rounded-lg shadow-sm transition">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-4 text-center text-gray-500 italic">
                        Tidak ada data transaksi.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>

    </div>

</main>

<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@endsection