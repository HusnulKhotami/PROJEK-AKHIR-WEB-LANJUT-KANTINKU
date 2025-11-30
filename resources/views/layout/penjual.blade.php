<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KantinKu - Penjual' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .sidebar-active {
            background-color: #22c55e;
            color: white;
            border-radius: 12px;
        }
    </style>
</head>

<body class="bg-gray-50">

<!-- WRAPPER UTAMA -->
<div class="min-h-screen">

    <!-- SIDEBAR (FIXED) -->
    <aside class="w-80 bg-white border-r border-gray-200 shadow-lg hidden lg:flex flex-col
                 fixed top-0 left-0 h-screen">

        <!-- Logo -->
        <div class="flex items-center justify-center h-24 border-b border-gray-200">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-green-600">KantinKu</h2>
                <p class="text-xs text-gray-500 mt-1">Penjual</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-8 space-y-3 overflow-y-auto">

            <a href="{{ route('penjual.dashboard') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all
               {{ request()->routeIs('penjual.dashboard') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-chart-line text-xl"></i>
                <div>
                    <p class="font-semibold">Dashboard</p>
                    <p class="text-xs">Ringkasan penjualan</p>
                </div>
            </a>

            <a href="{{ route('penjual.menu.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all
               {{ request()->routeIs('penjual.menu.*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-burger text-xl"></i>
                <div>
                    <p class="font-semibold">Kelola Menu</p>
                    <p class="text-xs">Produk tersedia</p>
                </div>
            </a>

            <a href="{{ route('penjual.pesanan.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all relative
               {{ request()->routeIs('penjual.pesanan.*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-inbox text-xl"></i>
                <div>
                    <p class="font-semibold">Pesanan Masuk</p>
                    <p class="text-xs">Pesanan baru</p>
                </div>

                @if(($notifikasiBaru ?? 0) > 0)
                    <span class="absolute top-2 right-4 w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse"></span>
                @endif
            </a>

            <a href="{{ route('penjual.aktivitas.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all
               {{ request()->routeIs('penjual.aktivitas.*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-chart-bar text-xl"></i>
                <div>
                    <p class="font-semibold">Aktivitas Penjualan</p>
                    <p class="text-xs">Laporan penjualan</p>
                </div>
            </a>

        </nav>

        <!-- Tombol Logout -->
        <form method="POST" action="{{ route('logout') }}" class="p-8">
            @csrf
            <button class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 shadow">
                Logout
            </button>
        </form>

    </aside>

    <!-- MAIN CONTENT (DIBUAT BERGESER KE KANAN 80) -->
    <main class="flex-1 flex flex-col ml-80">

        <!-- HEADER -->
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">
                {{ $header ?? 'Dashboard Penjual' }}
            </h1>

            <div class="flex items-center gap-6">
                <!-- Logout versi mobile -->
                <form method="POST" action="{{ route('logout') }}" class="lg:hidden">
                    @csrf
                    <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- KONTEN BISA DISCROLL -->
        <div class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </div>

    </main>

</div>

</body>
</html>
