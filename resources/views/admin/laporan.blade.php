<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Keuangan | KantinKu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50 font-sans text-gray-800">
<div class="flex min-h-screen">

  <!-- Sidebar -->
  <aside class="bg-green-700 text-white w-64 flex flex-col">
    <div class="p-6 text-center border-b border-green-600">
      <h1 class="text-2xl font-bold">KantinKu</h1>
      <p class="text-sm opacity-80">Dashboard Admin</p>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2">

      <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
        <i data-lucide="home" class="w-5 h-5"></i> Dashboard
      </a>

      <a href="/admin/pengguna" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
        <i data-lucide="users" class="w-5 h-5"></i> Data Pengguna
      </a>

      <a href="/admin/transaksi" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
        <i data-lucide="shopping-bag" class="w-5 h-5"></i> Transaksi
      </a>

      <a href="/admin/laporan" class="flex items-center gap-3 px-3 py-2 bg-green-600 rounded-lg">
        <i data-lucide="bar-chart-2" class="w-5 h-5"></i> Laporan
      </a>

      <a href="/admin/override" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
        <i data-lucide="alert-triangle" class="w-5 h-5"></i> Override
      </a>

      <a href="/admin/monitoring" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
        <i data-lucide="activity" class="w-5 h-5"></i> Monitoring
      </a>

    </nav>

    <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-green-600">
      @csrf
      <button type="submit"
        class="flex items-center gap-2 w-full justify-center bg-green-800 hover:bg-green-900 rounded-lg py-2 transition">
        <i data-lucide="log-out" class="w-4 h-4"></i> Logout
      </button>
    </form>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-8">

    <h2 class="text-3xl font-bold text-green-700 mb-8">Laporan Keuangan & Rekap Pesanan</h2>

    <!-- Filter -->
    <div class="bg-white p-6 rounded-2xl shadow mb-8">
      <h3 class="text-xl font-semibold mb-4">Filter Laporan</h3>

      <form class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div>
          <label class="block mb-1 font-medium">Tanggal Mulai</label>
          <input type="date" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div>
          <label class="block mb-1 font-medium">Tanggal Akhir</label>
          <input type="date" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="flex items-end">
          <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg">
            Terapkan Filter
          </button>
        </div>

      </form>
    </div>

    <!-- Rekap Keuangan -->
    <div class="bg-white p-6 rounded-2xl shadow mb-8">
      <h3 class="text-xl font-semibold mb-4">Ringkasan Keuangan</h3>

      <p class="text-lg mb-2"><strong>Total Transaksi:</strong> Rp 120.000</p>
      <p class="text-lg mb-2"><strong>Jumlah Pesanan:</strong> 8 transaksi</p>
      <p class="text-lg mb-2"><strong>Tanggal Laporan:</strong> 1 Januari – 10 Januari</p>
    </div>

    <!-- Tabel Rekap Pesanan -->
    <div class="bg-white p-6 rounded-2xl shadow mb-8">
      <h3 class="text-xl font-semibold mb-4">Detail Transaksi</h3>

      <table class="w-full border-collapse">
        <thead>
          <tr class="bg-green-600 text-white">
            <th class="py-3 px-4 text-left">ID</th>
            <th class="py-3 px-4 text-left">Pemesan</th>
            <th class="py-3 px-4 text-left">Total</th>
            <th class="py-3 px-4 text-left">Tanggal</th>
          </tr>
        </thead>

        <tbody class="text-gray-700">
          <tr class="border-b">
            <td class="py-3 px-4">TRX001</td>
            <td class="py-3 px-4">Elena Oktaviani</td>
            <td class="py-3 px-4">Rp 15.000</td>
            <td class="py-3 px-4">01-01-2025</td>
          </tr>

          <tr class="border-b">
            <td class="py-3 px-4">TRX002</td>
            <td class="py-3 px-4">Budi Santoso</td>
            <td class="py-3 px-4">Rp 20.000</td>
            <td class="py-3 px-4">01-01-2025</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Tombol Download -->
    <div class="flex gap-4">
      <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
        Download PDF
      </a>

      <a href="#" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
        Download Excel
      </a>
    </div>

  </main>

</div>

<script>
  lucide.createIcons();
</script>
</body>
</html>
