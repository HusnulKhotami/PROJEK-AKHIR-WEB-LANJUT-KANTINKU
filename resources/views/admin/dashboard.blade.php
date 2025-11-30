@extends('layout.admin')

@section('title', 'Dashboard Admin | KantinKu')

@section('content')

<main class="flex-1 p-8">

    <!-- Header -->
    <div class="flex items-center justify-between mb-10">
        <h2 class="text-3xl font-bold text-green-700">
            Selamat Datang, {{ Auth::user()->nama }}
        </h2>
        <p class="text-gray-600">
            Role : <span class="font-semibold capitalize">{{ Auth::user()->role }}</span>
        </p>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">

        <!-- Total Mahasiswa -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-gray-600 text-sm font-medium">Total Mahasiswa</h3>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $totalMahasiswa }}</p>
                </div>
                <i data-lucide="user-graduate" class="w-10 h-10 text-green-500"></i>
            </div>
        </div>

        <!-- Total Penjual -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-gray-600 text-sm font-medium">Total Penjual</h3>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $totalPenjual }}</p>
                </div>
                <i data-lucide="store" class="w-10 h-10 text-green-500"></i>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-gray-600 text-sm font-medium">Total Transaksi</h3>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $totalTransaksi }}</p>
                </div>
                <i data-lucide="credit-card" class="w-10 h-10 text-green-500"></i>
            </div>
        </div>

    </div>

    <!-- Fitur -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Data Pengguna -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition flex flex-col justify-between">
            <div>
                <i data-lucide="users" class="w-10 h-10 text-green-600 mb-4"></i>
                <h3 class="text-lg font-bold mb-2">Manajemen Data Pengguna</h3>
                <p class="text-gray-600 text-sm">
                    Kelola data mahasiswa dan penjual (tambah, ubah, hapus).
                </p>
            </div>
            <a href="{{ route('admin.pengguna') }}"
                class="mt-4 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg transition text-center">
                Kelola
            </a>
        </div>

        <!-- Transaksi -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition flex flex-col justify-between">
            <div>
                <i data-lucide="shopping-bag" class="w-10 h-10 text-green-600 mb-4"></i>
                <h3 class="text-lg font-bold mb-2">Manajemen Transaksi</h3>
                <p class="text-gray-600 text-sm">
                    Lihat dan pantau seluruh transaksi dan status pembayaran.
                </p>
            </div>
            <a href="{{ route('admin.transaksi') }}"
                class="mt-4 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg transition text-center">
                Lihat Transaksi
            </a>
        </div>

        <!-- Laporan -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition flex flex-col justify-between">
            <div>
                <i data-lucide="bar-chart-2" class="w-10 h-10 text-green-600 mb-4"></i>
                <h3 class="text-lg font-bold mb-2">Laporan Keuangan & Pesanan</h3>
                <p class="text-gray-600 text-sm">
                    Rekap data transaksi, ekspor ke PDF atau Excel.
                </p>
            </div>
            <a href="{{ route('admin.laporan') }}"
                class="mt-4 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg transition text-center">
                Unduh Laporan
            </a>
        </div>

        <!-- Monitoring -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition flex flex-col justify-between">
            <div>
                <i data-lucide="activity" class="w-10 h-10 text-green-600 mb-4"></i>
                <h3 class="text-lg font-bold mb-2">Monitoring Aktivitas Sistem</h3>
                <p class="text-gray-600 text-sm">
                    Pantau aktivitas mahasiswa dan penjual secara real-time.
                </p>
            </div>
            <a href="{{ route('admin.monitoring') }}"
                class="mt-4 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg transition text-center">
                Pantau Sekarang
            </a>
        </div>

    </div>

</main>

@endsection
