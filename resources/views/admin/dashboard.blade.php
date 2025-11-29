<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin | KantinKu</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50 font-sans text-gray-800">

  <div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="bg-green-700 text-white w-64 flex flex-col shadow-xl">
      <div class="p-6 text-center border-b border-green-600">
        <h1 class="text-2xl font-bold tracking-wide">KantinKu</h1>
        <p class="text-sm opacity-80 mt-1">Dashboard Admin</p>
      </div>

      <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
          <i data-lucide="users" class="w-5 h-5"></i> Data Pengguna
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
          <i data-lucide="shopping-bag" class="w-5 h-5"></i> Transaksi
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
          <i data-lucide="bar-chart-2" class="w-5 h-5"></i> Laporan
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
          <i data-lucide="activity" class="w-5 h-5"></i> Monitoring
        </a>
      </nav>

      <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-green-600">
        @csrf
        <button type="submit" class="flex items-center gap-2 justify-center w-full bg-green-800 hover:bg-green-900 rounded-lg py-2 transition">
          <i data-lucide="log-out" class="w-4 h-4"></i> Logout
        </button>
      </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">

      <!-- Header -->
      <div class="flex items-center justify-between mb-10">
        <h2 class="text-3xl font-bold text-green-700">Selamat Datang, {{ Auth::user()->nama }}</h2>
        <p class="text-gray-600">
          Role : <span class="font-semibold capitalize">{{ Auth::user()->role }}</span>
        </p>
      </div>

      <!-- Statistik -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
          <div class="flex justify-between items-center">
            <div>
              <h3 class="text-gray-600 text-sm font-medium">Total Mahasiswa</h3>
              <p class="text-3xl font-bold text-green-600 mt-1">128</p>
            </div>
            <i data-lucide="user-graduate" class="w-10 h-10 text-green-500"></i>
          </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
          <div class="flex justify-between items-center">
            <div>
              <h3 class="text-gray-600 text-sm font-medium">Total Penjual</h3>
              <p class="text-3xl font-bold text-green-600 mt-1">24</p>
            </div>
            <i data-lucide="store" class="w-10 h-10 text-green-500"></i>
          </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
          <div class="flex justify-between items-center">
            <div>
              <h3 class="text-gray-600 text-sm font-medium">Total Transaksi</h3>
              <p class="text-3xl font-bold text-green-600 mt-1">564</p>
            </div>
            <i data-lucide="credit-card" class="w-10 h-10 text-green-500"></i>
          </div>
        </div>
      </div>

      <!-- Fitur -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition flex flex-col justify-between">
          <div>
            <i data-lucide="users" class="w-10 h-10 text-green-600 mb-4"></i>
            <h3 class="text-lg font-bold mb-2">Manajemen Data Pengguna</h3>
            <p class="text-gray-600 text-sm">
              Kelola data mahasiswa dan penjual (tambah, ubah, hapus).
            </p>
          </div>
          <button class="mt-4 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg transition">Kelola</button>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition flex flex-col justify-between">
          <div>
            <i data-lucide="shopping-bag" class="w-10 h-10 text-green-600 mb-4"></i>
            <h3 class="text-lg font-bold mb-2">Manajemen Transaksi</h3>
            <p class="text-gray-600 text-sm">
              Lihat dan pantau seluruh transaksi dan status pembayaran.
            </p>
          </div>
          <button class="mt-4 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg transition">Lihat Transaksi</button>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition flex flex-col justify-between">
          <div>
            <i data-lucide="bar-chart-2" class="w-10 h-10 text-green-600 mb-4"></i>
            <h3 class="text-lg font-bold mb-2">Laporan Keuangan & Pesanan</h3>
            <p class="text-gray-600 text-sm">
              Rekap data transaksi, ekspor ke PDF atau Excel.
            </p>
          </div>
          <button class="mt-4 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg transition">Unduh Laporan</button>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition flex flex-col justify-between">
          <div>
            <i data-lucide="activity" class="w-10 h-10 text-green-600 mb-4"></i>
            <h3 class="text-lg font-bold mb-2">Monitoring Aktivitas Sistem</h3>
            <p class="text-gray-600 text-sm">
              Pantau aktivitas mahasiswa dan penjual secara real-time.
            </p>
          </div>
          <button class="mt-4 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg transition">Pantau Sekarang</button>
        </div>

      </div>
    </main>
  </div>

  <script>
    lucide.createIcons();
  </script>

</body>
</html>
