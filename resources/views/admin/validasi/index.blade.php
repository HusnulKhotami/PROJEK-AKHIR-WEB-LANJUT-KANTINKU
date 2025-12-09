@extends('layout.admin')

@section('title', 'Validasi Pembayaran | KantinKu')

@section('content')

<main class="flex-1 p-8">

    <h2 class="text-3xl font-bold text-green-700 mb-6">Validasi Pembayaran Cash</h2>

    <p class="text-gray-600 mb-6">
        Daftar pesanan dengan metode pembayaran <strong>Cash</strong> yang status pembayarannya masih <strong>Pending</strong>.
    </p>

    {{-- Success Alert --}}
    @if (session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tidak Ada Data --}}
    @if ($pesanan->isEmpty())
        <div class="bg-white p-6 rounded-2xl shadow text-center text-gray-600">
            Tidak ada pesanan cash yang perlu divalidasi.
        </div>

    @else

    {{-- TABEL PESANAN --}}
    <div class="bg-white p-6 rounded-2xl shadow overflow-x-auto">

        <table class="w-full border-collapse rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-green-600 text-white">
                    <th class="py-3 px-4 text-left">ID</th>
                    <th class="py-3 px-4 text-left">Nama Pemesan</th>
                    <th class="py-3 px-4 text-left">Pedagang</th>
                    <th class="py-3 px-4 text-left">Total</th>
                    <th class="py-3 px-4 text-left">Status</th>
                    <th class="py-3 px-4 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @foreach($pesanan as $p)
                <tr class="border-b hover:bg-gray-50 transition">

                    {{-- ID Pesanan --}}
                    <td class="px-4 py-3">#{{ $p->id }}</td>

                    {{-- Nama Pemesan --}}
                    <td class="px-4 py-3">{{ $p->mahasiswa->nama ?? '-' }}</td>

                    {{-- Pedagang --}}
                    <td class="px-4 py-3">{{ $p->pedagang->nama_toko ?? '-' }}</td>

                    {{-- Total Harga --}}
                    <td class="px-4 py-3">
                        Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                    </td>

                    {{-- Status Pembayaran --}}
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-sm rounded-lg font-semibold">
                            Pending
                        </span>
                    </td>

                    {{-- Tombol Aksi --}}
                    <td class="px-4 py-3">

                        {{-- VALIDASI BUTTON --}}
                        <form action="{{ route('admin.validasi.konfirmasi', $p) }}" 
                              method="POST"
                              onsubmit="return confirm('Konfirmasi bahwa pembayaran cash sudah diterima?');">
                            @csrf

                            <button type="submit"
                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-600 hover:bg-green-700
                                       text-white text-sm rounded-lg shadow-sm transition">
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                Validasi
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

    @endif

</main>

@endsection