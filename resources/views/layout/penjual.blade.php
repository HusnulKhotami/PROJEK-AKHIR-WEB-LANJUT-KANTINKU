<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KantinKu - Penjual' }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .sidebar-active {
            background-color: #22c55e;
            color: white;
            border-radius: 12px;
        }
        
        .stat-card {
            border-radius: 16px;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body class="bg-gray-50">

<div class="min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-80 bg-white border-r border-gray-200 shadow-lg p-0 hidden lg:flex flex-col">
        
        <!-- Logo -->
        <div class="flex items-center justify-center h-24 border-b border-gray-200">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-green-600">KantinKu</h2>
                <p class="text-xs text-gray-500 mt-1">POS System</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-8 space-y-3">

            <a href="{{ route('penjual.dashboard') }}"
                class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all
                {{ request()->routeIs('penjual.dashboard') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-chart-line text-xl"></i>
                <div>
                    <p class="font-semibold">Dashboard</p>
                    <p class="text-xs {{ request()->routeIs('penjual.dashboard') ? 'text-green-100' : 'text-gray-500' }}">Ringkasan penjualan</p>
                </div>
            </a>

            <a href="{{ route('penjual.menu.index') }}"
                class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all
                {{ request()->routeIs('penjual.menu.*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-burger text-xl"></i>
                <div>
                    <p class="font-semibold">Kelola Menu</p>
                    <p class="text-xs {{ request()->routeIs('penjual.menu.*') ? 'text-green-100' : 'text-gray-500' }}">Produk tersedia</p>
                </div>
            </a>

            <a href="{{ route('penjual.pesanan.index') }}"
                class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all relative
                {{ request()->routeIs('penjual.pesanan.*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-inbox text-xl"></i>
                <div>
                    <p class="font-semibold">Pesanan Masuk</p>
                    <p class="text-xs {{ request()->routeIs('penjual.pesanan.*') ? 'text-green-100' : 'text-gray-500' }}">Pesanan baru</p>
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
                    <p class="text-xs {{ request()->routeIs('penjual.aktivitas.*') ? 'text-green-100' : 'text-gray-500' }}">Laporan penjualan</p>
                </div>
            </a>

        </nav>

        <!-- Logout Button -->
        <div class="border-t border-gray-200 p-8">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 font-semibold transition-colors">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col overflow-hidden">

        <!-- TOP NAV BAR -->
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4 flex-1">
                <h1 class="text-2xl font-bold text-gray-800">
                    {{ $header ?? 'Dashboard Penjual' }}
                </h1>
            </div>

            <div class="flex items-center gap-6">
                <!-- Search Bar (Hidden on mobile) -->
                <div class="hidden md:block relative">
                    <input type="text" placeholder="Cari..." 
                        class="px-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 w-48">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-500"></i>
                </div>

                <!-- Mobile Logout -->
                <form method="POST" action="{{ route('logout') }}" class="lg:hidden">
                    @csrf
                    <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <div class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </div>

    </main>

</div>

</body>
</html>
