@extends('layout.app')

@section('title', 'Tentang | KantinKu')

@section('content')

<section 
  class="relative pt-32 pb-28 text-center text-white fade-in bg-cover bg-center bg-no-repeat"
  style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}');">
  
  <div class="absolute inset-0 bg-green-900 bg-opacity-60"></div>

  <div class="relative max-w-3xl mx-auto px-6 z-10">
    <h2 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">
      Tentang <span class="text-green-300">KantinKu</span>
    </h2>
    <p class="text-lg leading-relaxed text-gray-100 mb-8">
      <strong>KantinKu</strong> hadir untuk mengubah cara mahasiswa dan staf kampus memesan makanan.  
      Tanpa antre, tanpa ribet — cukup pesan lewat web dan ambil saat siap!
    </p>
    <a href="{{ route('menu') }}" 
       class="bg-green-500 hover:bg-green-600 text-white font-semibold px-8 py-3 rounded-full shadow-md transition">
       Lihat Menu Kami
    </a>
  </div>
</section>

<section class="py-16 max-w-6xl mx-auto px-6 fade-in">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
    <div>
      <h3 class="text-3xl font-bold text-green-700 mb-4">Visi Kami</h3>
      <p class="text-gray-700 leading-relaxed">
        Menjadi solusi digital terbaik untuk layanan pemesanan makanan kampus yang cepat, efisien, dan nyaman,
        dengan memanfaatkan teknologi agar pengalaman makan di kampus menjadi lebih menyenangkan.
      </p>
    </div>
    <div>
      <h3 class="text-3xl font-bold text-green-700 mb-4">Misi Kami</h3>
      <ul class="list-disc list-inside text-gray-700 space-y-2">
        <li>Mengurangi antrean di kantin kampus melalui sistem pemesanan online.</li>
        <li>Memberikan kemudahan pembayaran digital yang cepat dan aman.</li>
        <li>Mendukung digitalisasi usaha kantin lokal di lingkungan universitas.</li>
        <li>Meningkatkan efisiensi pelayanan bagi mahasiswa dan penjual.</li>
      </ul>
    </div>
  </div>
</section>

<section class="bg-white py-16 border-t border-gray-200 fade-in">
  <div class="max-w-6xl mx-auto px-6 text-center">
    <h3 class="text-3xl font-bold text-green-700 mb-10">Tim di Balik KantinKu</h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
      @foreach ([
        ['name' => 'Husnul', 'role' => 'Pengembang 1', 'img' => 'husnul.jpg'],
        ['name' => 'Elena', 'role' => 'Pengembang 2', 'img' => 'elena.jpg'],
        ['name' => 'Adin', 'role' => 'Pengembang 3', 'img' => 'adin.jpg'],
        ['name' => 'Kania', 'role' => 'Pengembang 4', 'img' => 'kania.jpg']
      ] as $member)
      <div class="bg-green-50 rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 p-6">
        <img src="{{ asset('image/team/' . $member['img']) }}" 
             class="w-24 h-24 mx-auto rounded-full mb-4 object-cover border-2 border-green-600 shadow-md" 
             alt="{{ $member['name'] }}">
        <h4 class="font-semibold text-green-700">{{ $member['name'] }}</h4>
        <p class="text-gray-600 text-sm">{{ $member['role'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section class="bg-green-600 text-white text-center py-16 fade-in">
  <h3 class="text-3xl font-bold mb-4">Bergabung Bersama Kami</h3>
  <p class="max-w-2xl mx-auto mb-8 text-lg">
    Kami percaya bahwa kemudahan dalam memesan makanan bisa meningkatkan kenyamanan dan produktivitas mahasiswa.  
    Yuk, gunakan <strong>KantinKu</strong> sekarang!
  </p>
  <a href="{{ route('register') }}" class="bg-white text-green-700 px-8 py-3 rounded-full font-semibold hover:bg-green-100 transition">
    Mulai Sekarang
  </a>
</section>

@endsection
