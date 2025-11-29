<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Transaksi | KantinKu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-100 font-sans text-gray-800">

<div class="flex min-h-screen">

  <!-- SIDEBAR -->
  <aside class="bg-green-700 text-white w-64 flex flex-col shadow-xl">
    <div class="p-6 text-center border-b border-green-600">
      <h1 class="text-3xl font-bold tracking-wide">KantinKu</h1>
      <p class="text-sm opacity-80 mt-1">Dashboard Admin</p>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-3">

      <x-sidebar-item icon="home" text="Dashboard" url="/admin/dashboard" />
      <x-sidebar-item icon="users" text="Data Pengguna" url="/admin/pengguna" />
      <x-sidebar-item icon="shopping-bag" text="Transaksi" url="/admin/transaksi" active="true" />
      <x-sidebar-item icon="bar-chart-2" text="Laporan" url="/admin/laporan" />
      <x-sidebar-item icon="activity" text="Monitoring" url="/admin/monitoring" />

    </nav>

    <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-green-600">
      @csrf
      <button type="submit"
        class="flex items-center gap-2 w-full justify-center bg-green-800 hover:bg-green-900 rounded-lg py-2 transition font-medium">
        <i data-lucide="log-out" class="w-4 h-4"></i> Logout
      </button>
    </form>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="flex-1 p-10">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-10">
      <div>
        <h2 class="text-4xl font-extrabold text-green-700">Detail Transaksi</h2>
        <p class="text-gray-600 mt-1">Informasi lengkap transaksi pemesanan makanan</p>
      </div>
      <a href="/admin/transaksi"
        class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">
        <i data-lucide="arrow-left" class="w-5 h-5"></i>
        Kembali
      </a>
    </div>

    <!-- CARD DETAIL -->
    <div class="bg-white p-10 rounded-3xl shadow-xl space-y-10 border border-gray-100">

      <!-- INFORMASI TRANSAKSI -->
      <section>
        <h3 class="text-2xl font-bold text-gray-800 mb-5">Informasi Transaksi</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-lg">
          <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
            <p class="text-gray-500 text-sm">ID Transaksi</p>
            <p class="text-gray-900 font-semibold text-xl">TRX001</p>
          </div>

          <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
            <p class="text-gray-500 text-sm">Pemesan</p>
            <p class="text-gray-900 font-semibold text-xl">Elena Oktaviani</p>
          </div>

          <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
            <p class="text-gray-500 text-sm">Total Pembayaran</p>
            <p class="text-green-700 font-bold text-xl">Rp 15.000</p>
          </div>

          <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
            <p class="text-gray-500 text-sm">Status</p>
            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 font-semibold text-sm rounded-full">
              <i data-lucide="check-circle" class="w-4 h-4 mr-1"></i> Berhasil
            </span>
          </div>
        </div>
      </section>

      <!-- DETAIL PESANAN -->
      <section>
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Detail Pesanan</h3>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
          <table class="w-full">
            <thead class="bg-gray-50">
              <tr>
                <th class="p-4 text-left text-gray-600 font-medium">Nama Menu</th>
                <th class="p-4 text-right text-gray-600 font-medium">Harga</th>
              </tr>
            </thead>

            <tbody>
              <tr class="border-t hover:bg-gray-50">
                <td class="p-4 font-semibold text-gray-800">Nasi Goreng</td>
                <td class="p-4 text-right text-gray-900">Rp 15.000</td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

    </div>

  </main>
</div>

<script>
  lucide.createIcons();
</script>

</body>
</html>
