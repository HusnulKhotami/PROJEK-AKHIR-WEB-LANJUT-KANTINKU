@extends('layout.app')

@section('title', 'Menu | KantinKu')

@section('content')

<section 
  class="relative pt-32 pb-28 text-center text-white fade-in bg-cover bg-center bg-no-repeat"
  style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}');">
  
  <div class="absolute inset-0 bg-green-900 bg-opacity-60"></div>

  <div class="relative max-w-3xl mx-auto px-6 z-10">
    <h2 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">
      Menu <span class="text-green-300">KantinKu</span>
    </h2>
    <p class="text-lg leading-relaxed text-gray-100 mb-8">
      Temukan beragam pilihan makanan dan minuman favorit kampusmu.  
      Dipesan online, diambil tanpa antre!
    </p>
    <a href="#daftar-menu"
       class="bg-green-500 hover:bg-green-600 text-white font-semibold px-8 py-3 rounded-full shadow-md transition">
       Lihat Menu Kami
    </a>
  </div>
</section>

<section id="daftar-menu" class="py-16 bg-gray-50 fade-in">
  <div class="max-w-6xl mx-auto px-6 text-center">
    <h3 class="text-3xl font-bold text-green-700 mb-10">Pilihan Menu Populer</h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
      @foreach ([
        ['name' => 'Nasi Goreng Spesial', 'price' => 'Rp 18.000', 'img' => 'nasgor.jpg'],
        ['name' => 'Ayam Geprek', 'price' => 'Rp 20.000', 'img' => 'geprek.jpg'],
        ['name' => 'Mie Goreng Jawa', 'price' => 'Rp 15.000', 'img' => 'miegoreng.jpg'],
        ['name' => 'Sate Ayam', 'price' => 'Rp 22.000', 'img' => 'sate.jpg'],
        ['name' => 'Es Teh Manis', 'price' => 'Rp 6.000', 'img' => 'esteh.jpg'],
        ['name' => 'Jus Alpukat', 'price' => 'Rp 12.000', 'img' => 'jus.jpg'],
        ['name' => 'Kopi Susu', 'price' => 'Rp 10.000', 'img' => 'kopi.jpg'],
        ['name' => 'Roti Cokej', 'price' => 'Rp 9.000', 'img' => 'roti.jpg'],
      ] as $menu)
      <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2">
        <img src="{{ asset('image/menu/' . $menu['img']) }}" 
             alt="{{ $menu['name'] }}" 
             class="w-full h-48 object-cover rounded-t-xl">
        <div class="p-5">
          <h4 class="text-lg font-semibold text-green-700 mb-1">{{ $menu['name'] }}</h4>
          <p class="text-gray-600 mb-3">{{ $menu['price'] }}</p>
          <a href="{{ route('login') }}"class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">Pesan Sekarang</a>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section class="bg-green-600 text-white text-center py-16 fade-in">
  <h3 class="text-3xl font-bold mb-4">Pesan Sekarang, Nikmati Tanpa Antre!</h3>
  <p class="max-w-2xl mx-auto mb-8 text-lg">
    Nikmati kelezatan menu favorit kampusmu hanya dengan beberapa klik.  
    Praktis, cepat, dan tanpa ribet.
  </p>
  <a href="{{ route('login') }}" 
     class="bg-white text-green-700 px-8 py-3 rounded-full font-semibold hover:bg-green-100 transition">
     Mulai Pesan
  </a>
</section>

@endsection
