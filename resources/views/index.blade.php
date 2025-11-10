@extends('layout.app')

@section('title', 'KantinKu | Pesan Makanan Kampus Lebih Mudah')

@section('content')

  <!-- Hero Section -->
<section 
  class="relative pt-40 pb-32 text-center text-white fade-in bg-cover bg-center bg-no-repeat"
  style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}');">

  <!-- Overlay Transparan agar teks tetap terbaca -->
  <div class="absolute inset-0 bg-green-900 bg-opacity-60"></div>

  <!-- Konten Hero -->
  <div class="relative max-w-3xl mx-auto px-6 z-10">
    <h2 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">
      Selamat Datang di <span class="text-green-300">KantinKu</span>
    </h2>
    <p class="text-lg leading-relaxed text-gray-100 mb-8 drop-shadow">
      Pesan makanan kampus secara online — cepat, aman, dan tanpa antre!  
      Kini semua bisa dipesan dari genggaman tanganmu.
    </p>
    <div class="flex justify-center gap-4">
      <a href="{{ route('register') }}" 
         class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-full text-lg font-medium shadow-md transition">
         Daftar Sekarang
      </a>
      <a href="{{ route('login') }}" 
         class="border-2 border-white text-white px-8 py-3 rounded-full text-lg font-medium hover:bg-white hover:text-green-700 transition shadow-md">
         Masuk
      </a>
    </div>
  </div>
</section>

  <!-- Fitur Section -->
  <section id="fitur" class="bg-white py-16 fade-in">
    <h3 class="text-3xl font-bold text-center mb-10 text-green-700">Kenapa Pilih KantinKu?</h3>
    <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 text-center">
      <div class="bg-green-50 rounded-xl p-6 shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
        <i data-lucide="smartphone" class="w-10 h-10 mx-auto text-green-600 mb-3"></i>
        <h4 class="font-semibold mb-2">Mudah Digunakan</h4>
        <p class="text-gray-600 text-sm">Pesan makanan dari ponselmu kapan saja.</p>
      </div>
      <div class="bg-green-50 rounded-xl p-6 shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
        <i data-lucide="credit-card" class="w-10 h-10 mx-auto text-green-600 mb-3"></i>
        <h4 class="font-semibold mb-2">Pembayaran Digital</h4>
        <p class="text-gray-600 text-sm">Dukung OVO, DANA, dan transfer bank.</p>
      </div>
      <div class="bg-green-50 rounded-xl p-6 shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
        <i data-lucide="truck" class="w-10 h-10 mx-auto text-green-600 mb-3"></i>
        <h4 class="font-semibold mb-2">Tanpa Antre</h4>
        <p class="text-gray-600 text-sm">Pesan lebih cepat dan ambil saat siap.</p>
      </div>
      <div class="bg-green-50 rounded-xl p-6 shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
        <i data-lucide="bell" class="w-10 h-10 mx-auto text-green-600 mb-3"></i>
        <h4 class="font-semibold mb-2">Notifikasi Real-time</h4>
        <p class="text-gray-600 text-sm">Ketahui status pesananmu langsung dari dashboard.</p>
      </div>
    </div>
  </section>

  <!-- Menu Preview -->
<section id="menu" class="max-w-7xl mx-auto py-16 px-6 fade-in text-center">
  <h3 class="text-3xl font-bold mb-10 text-green-700">Menu Populer</h3>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
    @foreach ([
      ['nama'=>'Nasi Goreng','harga'=>15000,'img'=>'nasi goreng.jpg'],
      ['nama'=>'Ayam Geprek','harga'=>18000,'img'=>'geprek.jpg'],
      ['nama'=>'Mie Goreng','harga'=>14000,'img'=>'miegoreng.jpg'],
      ['nama'=>'Es Teh','harga'=>5000,'img'=>'esteh.jpg'],
    ] as $menu)
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition p-4">
      <!-- 📸 Gambar dibuat lebih tinggi agar terlihat panjang -->
      <img src="{{ asset('image/menu/'.$menu['img']) }}" class="w-full h-56 object-cover rounded-lg mb-4 mx-auto"alt="{{ $menu['nama'] }}">
      <h4 class="font-semibold text-lg text-green-700">{{ $menu['nama'] }}</h4>
      <p class="text-gray-600 mb-3">Rp {{ number_format($menu['harga'],0,',','.') }}</p>
      <a href="{{ route('login') }}"class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">Pesan Sekarang</a>
    </div>
    @endforeach
  </div>
</section>


  <!-- Tentang -->
  @include('landing.tentang')

@endsection
