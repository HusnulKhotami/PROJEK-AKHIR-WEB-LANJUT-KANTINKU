<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KantinKu - Penjual' }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white border-r shadow-xl p-6 hidden md:block">

        <h2 class="text-2xl font-bold text-green-700 mb-8">KantinKu</h2>

        <nav class="space-y-4">

            <a href="{{ route('penjual.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-200
                {{ request()->routeIs('penjual.dashboard') ? 'bg-green-600 text-white' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('penjual.menu.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-200
                {{ request()->routeIs('penjual.menu.*') ? 'bg-green-600 text-white' : '' }}">
                Kelola Menu
            </a>

            <a href="{{ route('penjual.pesanan.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-200 relative
                {{ request()->routeIs('penjual.pesanan.*') ? 'bg-green-600 text-white' : '' }}">
                Pesanan Masuk

                @if(($notifikasiBaru ?? 0) > 0)
                    <span class="absolute right-3 w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
                @endif
            </a>

            <a href="{{ route('penjual.aktivitas.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-200
                {{ request()->routeIs('penjual.aktivitas.*') ? 'bg-green-600 text-white' : '' }}">
                Aktivitas Penjualan
            </a>

        </nav>

        <!-- LOGOUT BUTTON -->
        <form method="POST" action="{{ route('logout') }}" class="mt-10">
            @csrf
            <button class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 shadow">
                Logout
            </button>
        </form>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-8">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                {{ $header ?? 'Dashboard Penjual' }}
            </h1>

            <!-- Logout Mobile -->
            <form method="POST" action="{{ route('logout') }}" class="md:hidden">
                @csrf
                <button class="px-4 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600">
                    Logout
                </button>
            </form>
        </div>

        {{-- CONTENT --}}
        @yield('content')

    </main>

</div>

</body>
</html>
