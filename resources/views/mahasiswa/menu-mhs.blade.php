<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KantinKu | Menu Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    .fade-in { animation: fadeIn 0.8s ease-in-out; }
    @keyframes fadeIn { from {opacity:0; transform:translateY(10px)} to {opacity:1; transform:translateY(0)} }
    .menu-card:hover img { transform: scale(1.1); }
  </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">
  {{-- ✅ Navbar --}}
  @include('landing.header-mhs')

  {{-- Hero --}}
  <section class="relative pt-40 pb-32 text-center text-white fade-in bg-cover bg-center"
    style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}')">
    <div class="absolute inset-0 bg-green-900 bg-opacity-60"></div>
    <div class="relative max-w-3xl mx-auto px-6">
      <h2 class="text-4xl md:text-5xl font-bold mb-4">
        Selamat Datang, <span class="text-green-300">{{ Auth::user()->nama ?? 'Mahasiswa' }}</span>
      </h2>
      <p class="text-lg text-gray-200 mb-6">Pesan cepat, nyaman, tanpa antre!</p>
      <a href="#menu" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-full text-lg shadow">
        Lihat Menu Hari Ini
      </a>
    </div>
  </section>

  {{-- Menu Section --}}
  <section id="menu" class="max-w-7xl mx-auto py-16 px-6 fade-in">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
      <h3 class="text-3xl font-bold text-green-700 flex items-center gap-2">
        <i data-lucide="chef-hat" class="w-8 h-8"></i> Menu Hari Ini
      </h3>
    </div>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('mahasiswa.menu-mhs') }}" class="bg-white shadow-md rounded-xl p-6 mb-10">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        
        {{-- Search --}}
        <div>
          <label class="block text-gray-600 text-sm mb-2">Cari Menu</label>
          <input type="text" name="search" value="{{ request('search') }}" 
                 placeholder="Cari nama menu..." 
                 class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        {{-- Kategori --}}
        <div>
          <label class="block text-gray-600 text-sm mb-2">Kategori</label>
          <select name="kategori" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
              <option value="">Semua Kategori</option>
              @foreach ($kategoriList as $k)
                  <option value="{{ $k->nama }}" 
                      {{ request('kategori') == $k->nama ? 'selected' : '' }}>
                      {{ $k->nama }}
                  </option>
              @endforeach
          </select>
        </div>


        {{-- Harga Minimum --}}
        <div>
          <label class="block text-gray-600 text-sm mb-2">Harga Minimum</label>
          <input type="number" name="harga_min" value="{{ request('harga_min') }}" 
                 placeholder="Rp 0" 
                 class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        {{-- Harga Maksimum --}}
        <div>
          <label class="block text-gray-600 text-sm mb-2">Harga Maksimum</label>
          <input type="number" name="harga_max" value="{{ request('harga_max') }}" 
                 placeholder="Rp 100000" 
                 class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
      </div>

      <div class="flex justify-end gap-3 mt-6">
        <a href="{{ route('mahasiswa.menu-mhs') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-lg">Reset</a>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
          <i data-lucide="search" class="w-4 h-4"></i> Cari
        </button>
      </div>
    </form>

    {{--  Grid Menu --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
      @forelse ($menu as $m)
        <div class="menu-card bg-white rounded-xl shadow-md hover:shadow-xl transition overflow-hidden">
          {{-- Gambar menu --}}
          <img src="{{ $m->gambar_url }}" 
              alt="{{ $m->nama }}" 
              class="w-full h-56 object-cover transition-transform duration-500">

          {{-- Isi card --}}
          <div class="p-5">
            <h4 class="font-semibold text-xl text-green-700 mb-2">{{ $m->nama }}</h4>
            <p class="text-gray-600 text-sm mb-3">{{ $m->deskripsi }}</p>

            <div class="flex justify-between items-center mb-3">
              <span class="text-sm text-gray-500">{{ $m->kategori->nama ?? 'Tanpa kategori' }}</span>
              <span class="font-bold text-lg text-gray-900">
                Rp {{ number_format($m->harga, 0, ',', '.') }}
              </span>
            </div>

            {{-- Tombol keranjang --}}
            <form method="POST" action="{{ route('mahasiswa.keranjang.tambah') }}">
              @csrf
              <input type="hidden" name="id_menu" value="{{ $m->id }}">
              <input type="hidden" name="jumlah" value="1">
              <button class="bg-green-600 hover:bg-green-700 text-white w-full py-2 rounded-lg flex items-center justify-center gap-2">
                <i data-lucide="shopping-cart" class="w-4 h-4"></i> Tambah ke Keranjang
              </button>
            </form>
          </div>
        </div>
      @empty
        <p class="col-span-full text-center text-gray-500">Menu tidak ditemukan.</p>
      @endforelse
    </div>
  </section>

  {{-- Footer --}}
  @include('landing.fotter')

  <script>lucide.createIcons();</script>
</body>
</html>
