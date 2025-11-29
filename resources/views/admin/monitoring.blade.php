<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monitoring Aktivitas | KantinKu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50 font-sans text-gray-800">

<div class="flex min-h-screen">

  <!-- Sidebar -->
  <aside class="bg-green-700 text-white w-64 flex flex-col shadow-xl">
    <div class="p-6 text-center border-b border-green-600">
      <h1 class="text-2xl font-bold tracking-wide">KantinKu</h1>
      <p class="text-sm opacity-80">Dashboard Admin</p>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2">

      <a href="/admin/dashboard"
         class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
        <i data-lucide="home" class="w-5 h-5"></i> Dashboard
      </a>

      <a href="/admin/pengguna"
         class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
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
         class="flex items-center gap-3 px-3 py-2 bg-green-600 rounded-lg">
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

    <h2 class="text-3xl font-bold text-green-700 mb-8">Monitoring Aktivitas Sistem</h2>

    <div class="bg-white rounded-2xl shadow p-6">

      <table class="w-full border-collapse">
        <thead>
          <tr class="bg-green-600 text-white">
            <th class="py-3 px-4 text-left">Waktu</th>
            <th class="py-3 px-4 text-left">Pengguna</th>
            <th class="py-3 px-4 text-left">Role</th>
            <th class="py-3 px-4 text-left">Aktivitas</th>
          </tr>
        </thead>

        <tbody class="text-gray-700">
          @foreach($activities as $activity)
          <tr class="border-b hover:bg-gray-100 transition">
            <td class="px-4 py-3">{{ $activity->created_at->format('d M Y H:i') }}</td>
            <td class="px-4 py-3">{{ $activity->user->nama }}</td>
            <td class="px-4 py-3 capitalize">{{ $activity->user->role }}</td>
            <td class="px-4 py-3">{{ $activity->description }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <div class="mt-6">
        {{ $activities->links() }}
      </div>

    </div>

  </main>

</div>

<script>
  lucide.createIcons();
</script>
</body>
</html>
