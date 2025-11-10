@extends('layout.app')

@section('title', 'Fitur | KantinKu')

@section('content')

{{-- Hero Section --}}
<section class="pt-28 pb-20 bg-gradient-to-br from-green-50 to-green-100 text-center fade-in">
  <div class="max-w-3xl mx-auto">
    <h2 class="text-4xl font-bold text-green-700 mb-4">Fitur Unggulan <span class="text-green-600">KantinKu</span></h2>
    <p class="text-gray-600 text-lg mb-10">
      Semua yang kamu butuhkan untuk menikmati makanan kampus tanpa antre dan tanpa repot.
    </p>
  </div>

  {{-- Grid Fitur --}}
  <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 px-6">
    {{-- Fitur 1 --}}
    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 border border-green-100">
      <i data-lucide="smartphone" class="w-12 h-12 text-green-600 mx-auto mb-4"></i>
      <h3 class="font-bold text-lg mb-2 text-green-700">Pemesanan Online</h3>
      <p class="text-gray-600 text-sm">Pesan makanan kampus tanpa antre. Pilih menu favorit dan bayar langsung dari ponselmu.</p>
    </div>

    {{-- Fitur 2 --}}
    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 border border-green-100">
      <i data-lucide="credit-card" class="w-12 h-12 text-green-600 mx-auto mb-4"></i>
      <h3 class="font-bold text-lg mb-2 text-green-700">Pembayaran Digital</h3>
      <p class="text-gray-600 text-sm">Dukung pembayaran via OVO, DANA, dan transfer bank untuk kemudahan transaksi.</p>
    </div>

    {{-- Fitur 3 --}}
    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 border border-green-100">
      <i data-lucide="truck" class="w-12 h-12 text-green-600 mx-auto mb-4"></i>
      <h3 class="font-bold text-lg mb-2 text-green-700">Tanpa Antre</h3>
      <p class="text-gray-600 text-sm">Ambil pesananmu saat siap, tanpa perlu berdiri lama di depan loket kantin.</p>
    </div>

    {{-- Fitur 4 --}}
    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 border border-green-100">
      <i data-lucide="bell" class="w-12 h-12 text-green-600 mx-auto mb-4"></i>
      <h3 class="font-bold text-lg mb-2 text-green-700">Notifikasi Real-time</h3>
      <p class="text-gray-600 text-sm">Dapatkan pemberitahuan langsung saat pesananmu siap diambil.</p>
    </div>

    {{-- Fitur 5 --}}
    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 border border-green-100">
      <i data-lucide="activity" class="w-12 h-12 text-green-600 mx-auto mb-4"></i>
      <h3 class="font-bold text-lg mb-2 text-green-700">Monitoring Pesanan</h3>
      <p class="text-gray-600 text-sm">Pantau status pesananmu secara langsung dari dashboard pengguna.</p>
    </div>

    {{-- Fitur 6 --}}
    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 border border-green-100">
      <i data-lucide="clipboard-list" class="w-12 h-12 text-green-600 mx-auto mb-4"></i>
      <h3 class="font-bold text-lg mb-2 text-green-700">Riwayat Transaksi</h3>
      <p class="text-gray-600 text-sm">Lihat semua transaksi dan pesananmu sebelumnya dengan mudah.</p>
    </div>

    {{-- Fitur 7 --}}
    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 border border-green-100">
      <i data-lucide="message-square" class="w-12 h-12 text-green-600 mx-auto mb-4"></i>
      <h3 class="font-bold text-lg mb-2 text-green-700">Ulasan Pengguna</h3>
      <p class="text-gray-600 text-sm">Berikan ulasan untuk kantin favoritmu dan bantu tingkatkan layanan mereka.</p>
    </div>

    {{-- Fitur 8 --}}
    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 border border-green-100">
      <i data-lucide="bar-chart-3" class="w-12 h-12 text-green-600 mx-auto mb-4"></i>
      <h3 class="font-bold text-lg mb-2 text-green-700">Laporan Penjualan</h3>
      <p class="text-gray-600 text-sm">Untuk penjual, dapatkan laporan penjualan harian dan statistik transaksi otomatis.</p>
    </div>
  </div>
</section>

{{-- Section Penutup --}}
<section class="bg-green-600 text-white py-16 mt-12 text-center fade-in">
  <h3 class="text-3xl font-bold mb-4">Nikmati Kemudahan Pesan Makanan di Kampus</h3>
  <p class="max-w-2xl mx-auto mb-8 text-lg">KantinKu membuat pengalaman makan siang di kampus jadi lebih cepat, praktis, dan menyenangkan!</p>
  <a href="{{ route('register') }}" class="bg-white text-green-700 px-8 py-3 rounded-full font-semibold hover:bg-green-100 transition">
    Coba Sekarang
  </a>
</section>

@endsection
