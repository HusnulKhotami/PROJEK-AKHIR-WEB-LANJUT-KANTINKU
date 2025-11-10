<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KantinKu | Dashboard Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    .fade-in {
      animation: fadeIn 0.8s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Navbar -->
  @include('landing.header-mhs')

  <!-- ✅ Hero Section Dashboard -->
    <!-- Hero Section -->
    <section class="relative pt-40 pb-32 text-center text-white fade-in bg-cover bg-center" style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}')">
      <div class="absolute inset-0 bg-green-900 bg-opacity-60"></div>
      <div class="relative max-w-3xl mx-auto px-6">
        <h2 class="text-4xl md:text-5xl font-bold mb-4">Selamat Datang, <span class="text-green-300">{{ Auth::user()->nama ?? 'Mahasiswa' }}</span>!</h2>
        <p class="text-lg text-gray-200 mb-6">Temukan dan pesan makanan favoritmu di <span class="font-semibold text-green-300">KantinKu</span> — cepat, aman, dan praktis.</p>
        <a href="#menu" class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-full text-lg shadow transition"><i data-lucide="shopping-bag" class="inline w-5 h-5 mr-2"></i>Pesan Sekarang</a>
      </div>
    </section>

  <!-- Menu Section -->
  <section id="menu" class="max-w-7xl mx-auto py-16 px-6 fade-in">
    <div class="flex justify-between items-center mb-8">
      <h3 class="text-3xl font-bold text-green-700">Menu Hari Ini</h3>
      <div class="flex items-center gap-3">
        <input type="text" placeholder="Cari menu..." class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500">
        <select class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
          <option>Semua Kategori</option>
          <option>Makanan</option>
          <option>Minuman</option>
          <option>Snack</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
      <!-- Contoh Menu -->
      @foreach (['Nasi Goreng','Ayam Geprek','Mie Goreng','Es Teh','Kopi Hitam','Milkshake'] as $menu)
      <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 p-4 text-center">
        <img src="https://source.unsplash.com/300x200/?{{ urlencode($menu) }}" alt="{{ $menu }}" class="rounded-lg mb-4 mx-auto">
        <h4 class="font-semibold text-lg">{{ $menu }}</h4>
        <p class="text-gray-600 mb-2">Rp{{ rand(8000,20000) }}</p>
        <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition w-full flex justify-center items-center gap-2">
          <i data-lucide="shopping-cart" class="w-4 h-4"></i> Tambah ke Keranjang
        </button>
      </div>
      @endforeach
    </div>
  </section>

  <!-- Status Pesanan -->
  <section id="status" class="bg-green-100 py-16 fade-in">
    <div class="max-w-5xl mx-auto px-6">
      <h3 class="text-3xl font-bold text-center mb-10 text-green-700">Status Pesanan Anda</h3>

      <div class="bg-white rounded-xl shadow p-6 space-y-4">
        <div class="flex justify-between items-center border-b pb-3">
          <div>
            <h4 class="font-semibold text-lg">Ayam Geprek</h4>
            <p class="text-sm text-gray-500">Kode Pesanan: <span class="font-mono">#A12345</span></p>
          </div>
          <span class="bg-yellow-100 text-yellow-700 px-4 py-1 rounded-full text-sm font-medium">Diproses</span>
        </div>
        <div class="flex justify-between items-center border-b pb-3">
          <div>
            <h4 class="font-semibold text-lg">Es Teh Manis</h4>
            <p class="text-sm text-gray-500">Kode Pesanan: <span class="font-mono">#A12346</span></p>
          </div>
          <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-medium">Siap Diambil</span>
        </div>
        <div class="flex justify-between items-center">
          <div>
            <h4 class="font-semibold text-lg">Mie Goreng Pedas</h4>
            <p class="text-sm text-gray-500">Kode Pesanan: <span class="font-mono">#A12347</span></p>
          </div>
          <span class="bg-gray-100 text-gray-700 px-4 py-1 rounded-full text-sm font-medium">Selesai</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Riwayat Pesanan -->
  <section id="riwayat" class="max-w-7xl mx-auto py-16 px-6 fade-in">
    <h3 class="text-3xl font-bold text-center mb-10 text-green-700">Riwayat Pesanan</h3>

    <div class="overflow-x-auto">
      <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
        <thead class="bg-green-600 text-white">
          <tr>
            <th class="py-3 px-6 text-left">Tanggal</th>
            <th class="py-3 px-6 text-left">Menu</th>
            <th class="py-3 px-6 text-left">Total</th>
            <th class="py-3 px-6 text-left">Status</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <tr class="border-b hover:bg-green-50 transition">
            <td class="py-3 px-6">5 Nov 2025</td>
            <td class="py-3 px-6">Nasi Goreng Spesial</td>
            <td class="py-3 px-6">Rp15.000</td>
            <td class="py-3 px-6 text-green-600 font-medium">Selesai</td>
          </tr>
          <tr class="border-b hover:bg-green-50 transition">
            <td class="py-3 px-6">4 Nov 2025</td>
            <td class="py-3 px-6">Es Kopi Susu</td>
            <td class="py-3 px-6">Rp10.000</td>
            <td class="py-3 px-6 text-yellow-600 font-medium">Diproses</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <!-- Footer -->
  @include('landing.fotter')

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
