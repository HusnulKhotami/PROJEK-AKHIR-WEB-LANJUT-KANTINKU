<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KantinKu | Dashboard Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    .fade-in { animation: fadeIn 0.8s ease-in-out; }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Navbar -->
  @include('landing.header-mhs')

  <!-- HERO -->
  <section class="relative pt-40 pb-32 text-center text-white bg-cover bg-center"
    style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}')">
    <div class="absolute inset-0 bg-green-900 bg-opacity-60"></div>

    <div class="relative max-w-3xl mx-auto px-6">
      <h2 class="text-4xl md:text-5xl font-bold mb-4">
        Selamat Datang,
        <span class="text-green-300">{{ Auth::user()->nama ?? 'Mahasiswa' }}</span>!
      </h2>

      <p class="text-lg text-gray-200 mb-6">
        Pesan makanan kampus kini lebih cepat, mudah, dan tanpa antre.
      </p>

      <a href="#menu-favorit" 
         class="bg-green-500 hover:bg-green-600 px-8 py-3 rounded-full text-lg shadow transition text-white">
         Mulai Jelajah
      </a>
    </div>
  </section>

  <!-- FITUR -->
  <section id="fitur" class="max-w-7xl mx-auto py-20 px-6 fade-in">
    
    {{-- DASHBOARD WIDGETS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
      
      {{-- PESANAN AKTIF --}}
      <a href="{{ route('mahasiswa.status') }}" class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-blue-100 text-sm">Pesanan Aktif</p>
            <p class="text-4xl font-bold">{{ \App\Models\Pesanan::where('user_id', Auth::id())->whereIn('status', ['diproses', 'siap_diambil'])->count() }}</p>
          </div>
          <i data-lucide="shopping-cart" class="w-12 h-12 text-blue-200 opacity-50"></i>
        </div>
      </a>

      {{-- NOTIFIKASI BELUM DIBACA --}}
      <a href="{{ route('mahasiswa.notifikasi.index') }}" class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-orange-100 text-sm">Notifikasi Baru</p>
            <p class="text-4xl font-bold unread-count">{{ \App\Models\Notifikasi::where('user_id', Auth::id())->where('dibaca', false)->count() }}</p>
          </div>
          <i data-lucide="bell" class="w-12 h-12 text-orange-200 opacity-50"></i>
        </div>
      </a>

      {{-- RIWAYAT PESANAN --}}
      <a href="{{ route('mahasiswa.riwayat') }}" class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-green-100 text-sm">Pesanan Selesai</p>
            <p class="text-4xl font-bold">{{ \App\Models\Pesanan::where('user_id', Auth::id())->where('status', 'selesai')->count() }}</p>
          </div>
          <i data-lucide="history" class="w-12 h-12 text-green-200 opacity-50"></i>
        </div>
      </a>

    </div>

    <h3 class="text-3xl font-bold text-center mb-14 text-green-700">Kenapa Memilih KantinKu?</h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
      <div class="bg-white p-8 rounded-xl shadow hover:shadow-md transform hover:-translate-y-1 transition text-center">
        <i data-lucide="rocket" class="w-12 h-12 mx-auto text-green-600 mb-4"></i>
        <h4 class="font-semibold text-xl mb-2">Proses Cepat</h4>
        <p class="text-gray-600">Pemesanan hanya beberapa detik tanpa antre panjang.</p>
      </div>

      <div class="bg-white p-8 rounded-xl shadow hover:shadow-md transform hover:-translate-y-1 transition text-center">
        <i data-lucide="shield-check" class="w-12 h-12 mx-auto text-green-600 mb-4"></i>
        <h4 class="font-semibold text-xl mb-2">Aman dan Terpercaya</h4>
        <p class="text-gray-600">Data dan transaksi terlindungi sepenuhnya.</p>
      </div>

      <div class="bg-white p-8 rounded-xl shadow hover:shadow-md transform hover:-translate-y-1 transition text-center">
        <i data-lucide="smartphone" class="w-12 h-12 mx-auto text-green-600 mb-4"></i>
        <h4 class="font-semibold text-xl mb-2">Desain Modern</h4>
        <p class="text-gray-600">Tampilan modern dan mudah digunakan di semua perangkat.</p>
      </div>
    </div>
  </section>


  <!-- MENU FAVORIT HARI INI -->
<section id="menu-favorit" class="py-16 bg-white fade-in">
  <div class="max-w-6xl mx-auto px-6 text-center">
    <div class="flex justify-between items-center mb-10">
      <h3 class="text-3xl font-bold text-green-700">Menu Favorit Hari Ini</h3>

      <a href="{{ route('mahasiswa.menu-mhs') }}" 
         class="text-green-600 hover:text-green-800 font-semibold flex items-center gap-2 transition">
        Lihat Semua Menu
        <i data-lucide="arrow-right" class="w-5 h-5"></i>
      </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
      @foreach ([
        ['name' => 'Nasi Goreng Spesial', 'price' => 'Rp 18.000', 'img' => 'nasgor.jpg'],
        ['name' => 'Ayam Geprek', 'price' => 'Rp 20.000', 'img' => 'geprek.jpg'],
        ['name' => 'Mie Ayam', 'price' => 'Rp 16.000', 'img' => 'mieayam.jpg'],
        ['name' => 'Soto Ayam', 'price' => 'Rp 17.000', 'img' => 'soto.jpg'],
        ['name' => 'Bakso Urat', 'price' => 'Rp 19.000', 'img' => 'bakso.jpg'],
        ['name' => 'Kopi Susu', 'price' => 'Rp 10.000', 'img' => 'kopi.jpg'],
        ['name' => 'Jus Alpukat', 'price' => 'Rp 12.000', 'img' => 'jus.jpg'],
        ['name' => 'Es Teh Manis', 'price' => 'Rp 6.000', 'img' => 'esteh.jpg'],
      ] as $menu)
      <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 overflow-hidden">
        <img src="{{ asset('image/menu/' . $menu['img']) }}" 
             alt="{{ $menu['name'] }}" 
             class="w-full h-48 object-cover rounded-t-xl">
        <div class="p-5">
          <h4 class="text-lg font-semibold text-green-700 mb-1">{{ $menu['name'] }}</h4>
          <p class="text-gray-600 mb-3">{{ $menu['price'] }}</p>
          <button 
            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition w-full flex justify-center items-center gap-2">
            <i data-lucide="shopping-cart" class="w-4 h-4"></i> Tambah ke Keranjang
          </button>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>


  <!-- CTA -->
  <section class="bg-green-700 text-white py-20 text-center fade-in">
    <h3 class="text-4xl font-extrabold mb-4">Siap Memesan?</h3>
    <p class="text-lg mb-6">Pesan sekarang dan rasakan kemudahannya!</p>

    <a href="{{ route('mahasiswa.menu-mhs') }}" 
       class="bg-white text-green-700 px-10 py-4 rounded-full text-lg font-semibold shadow hover:bg-gray-100 transition">
       Lihat Semua Menu
    </a>
  </section>

  <!-- STATISTIK / ACHIEVEMENTS -->
  <section class="bg-green-500 text-white py-20 fade-in">
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-10 text-center px-6">

      <div>
        <h4 class="text-4xl font-extrabold mb-2">+1200</h4>
        <p class="text-gray-200">Mahasiswa Aktif Menggunakan</p>
      </div>

      <div>
        <h4 class="text-4xl font-extrabold mb-2">+3200</h4>
        <p class="text-gray-200">Pesanan Selesai</p>
      </div>

      <div>
        <h4 class="text-4xl font-extrabold mb-2">+20</h4>
        <p class="text-gray-200">Tenant Kantin Bergabung</p>
      </div>

    </div>
  </section>

  <!-- FOOTER -->
  @include('landing.fotter')

  <script> lucide.createIcons(); </script>

</body>
</html>
