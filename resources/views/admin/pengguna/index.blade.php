<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pengguna | KantinKu</title>

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

        <a href="/admin/dashboard"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
          <i data-lucide="home" class="w-5 h-5"></i> Dashboard
        </a>

        <a href="/admin/pengguna"
           class="flex items-center gap-3 px-3 py-2 bg-green-600 rounded-lg">
          <i data-lucide="users" class="w-5 h-5"></i> Data Pengguna
        </a>

        <a href="/admin/transaksi"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
          <i data-lucide="shopping-bag" class="w-5 h-5"></i> Transaksi
        </a>

        <a href="/admin/laporan"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
          <i data-lucide="bar-chart-2" class="w-5 h-5"></i> Laporan
        </a>

        <a href="/admin/monitoring"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
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

      <h2 class="text-3xl font-bold text-green-700 mb-8">
        Manajemen Data Pengguna
      </h2>

      <!-- Tabs Mahasiswa / Penjual -->
      <div class="flex gap-4 mb-6">
        <a href="/admin/pengguna?type=mahasiswa"
           class="px-4 py-2 rounded-lg bg-green-600 text-white">
          Mahasiswa
        </a>

        <a href="/admin/pengguna?type=penjual"
           class="px-4 py-2 rounded-lg bg-green-500 text-white hover:bg-green-600">
          Penjual
        </a>
      </div>

      <!-- Tombol Tambah -->
      <a href="/admin/pengguna/create"
         class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg mb-6">
        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Pengguna
      </a>

      <!-- Tabel Pengguna -->
      <div class="bg-white rounded-2xl shadow p-6">
        <table class="w-full border-collapse">
          <thead>
            <tr class="bg-green-600 text-white">
              <th class="py-3 px-4 text-left">Nama</th>
              <th class="py-3 px-4 text-left">Email</th>
              <th class="py-3 px-4 text-left">Role</th>
              <th class="py-3 px-4 text-left">Aksi</th>
            </tr>
          </thead>

          <tbody class="text-gray-700">

            <tr class="border-b">
              <td class="px-4 py-3">Elena Oktaviani</td>
              <td class="px-4 py-3">elena@example.com</td>
              <td class="px-4 py-3 capitalize">mahasiswa</td>
              <td class="px-4 py-3 flex gap-3">
                <a href="/admin/pengguna/1/edit" class="text-blue-600 hover:underline">Edit</a>
                <a href="#" class="text-red-600 hover:underline">Hapus</a>
              </td>
            </tr>

            <tr class="border-b">
              <td class="px-4 py-3">Budi Santoso</td>
              <td class="px-4 py-3">budi@kantin.com</td>
              <td class="px-4 py-3 capitalize">penjual</td>
              <td class="px-4 py-3 flex gap-3">
                <a href="/admin/pengguna/2/edit" class="text-blue-600 hover:underline">Edit</a>
                <a href="#" class="text-red-600 hover:underline">Hapus</a>
              </td>
            </tr>

          </tbody>
        </table>
      </div>

    </main>

  </div>

  <script>
    lucide.createIcons();
  </script>

</body>

</html>
