<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Transaksi | KantinKu</title>

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
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
                    <i data-lucide="home" class="w-5 h-5"></i> Dashboard
                </a>

                <a href="{{ route('admin.pengguna') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
                    <i data-lucide="users" class="w-5 h-5"></i> Data Pengguna
                </a>

                <a href="{{ route('admin.transaksi') }}"
                    class="flex items-center gap-3 px-3 py-2 bg-green-600 rounded-lg">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i> Transaksi
                </a>

                <a href="{{ route('admin.laporan') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
                    <i data-lucide="bar-chart-2" class="w-5 h-5"></i> Laporan
                </a>

                <a href="{{ route('admin.monitoring') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition">
                    <i data-lucide="activity" class="w-5 h-5"></i> Monitoring
                </a>
            </nav>

            <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-green-600">
                @csrf
                <button type="submit"
                    class="flex items-center gap-2 w-full justify-center bg-green-800 hover:bg-green-900 rounded-lg py-2 transition">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    Logout
                </button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">

            <h2 class="text-3xl font-bold text-green-700 mb-8">Manajemen Transaksi</h2>

            <!-- Filter -->
            <div class="mb-6 flex gap-4">
                <select class="border rounded-lg px-3 py-2">
                    <option>Status Pembayaran</option>
                    <option>Berhasil</option>
                    <option>Pending</option>
                    <option>Gagal</option>
                </select>

                <select class="border rounded-lg px-3 py-2">
                    <option>Metode Pembayaran</option>
                    <option>Cashless</option>
                    <option>COD</option>
                </select>

                <input type="date" class="border rounded-lg px-3 py-2">
            </div>

            <!-- Tabel -->
            <div class="bg-white rounded-2xl shadow p-6">
                <table class="w-full border-collapse">

                    <thead>
                        <tr class="bg-green-600 text-white">
                            <th class="py-3 px-4 text-left">ID</th>
                            <th class="py-3 px-4 text-left">Nama Pemesan</th>
                            <th class="py-3 px-4 text-left">Item</th>
                            <th class="py-3 px-4 text-left">Total</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700">

                        @foreach($transaksi as $trx)
                            <tr class="border-b">
                                <td class="px-4 py-3">{{ $trx->id_transaksi }}</td>
                                <td class="px-4 py-3">{{ $trx->nama_pemesan }}</td>
                                <td class="px-4 py-3">{{ $trx->item }}</td>
                                <td class="px-4 py-3">
                                    Rp {{ number_format($trx->total, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-3 font-semibold
                                    @if($trx->status == 'Berhasil') text-green-600
                                    @elseif($trx->status == 'Pending') text-yellow-600
                                    @else text-red-600
                                    @endif">
                                    {{ $trx->status }}
                                </td>

                                <td class="px-4 py-3 flex gap-3">
                                    <a href="{{ route('admin.transaksi.detail', $trx->id_transaksi) }}"
                                        class="text-blue-600 hover:underline">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach

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
