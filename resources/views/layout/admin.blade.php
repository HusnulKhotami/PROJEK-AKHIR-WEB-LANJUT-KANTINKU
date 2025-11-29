<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-50 font-sans text-gray-800">

    <div class="flex min-h-screen">

        <!-- =============== SIDEBAR =============== -->
        <aside class="bg-green-700 text-white w-64 flex flex-col h-screen sticky top-0">

            <!-- Logo -->
            <div class="p-6 text-center border-b border-green-600">
                <h1 class="text-2xl font-bold tracking-wide">KantinKu</h1>
                <p class="text-sm opacity-80">Dashboard Admin</p>
            </div>

            <!-- MENU + LOGOUT WRAPPER -->
            <div class="flex flex-col justify-between h-full">

                <!-- MENU (scrollable) -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition
                        @if(request()->routeIs('admin.dashboard')) bg-green-600 @endif">
                        <i data-lucide="home" class="w-5 h-5"></i> Dashboard
                    </a>

                    <a href="{{ route('admin.pengguna') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition
                        @if(request()->routeIs('admin.pengguna*')) bg-green-600 @endif">
                        <i data-lucide="users" class="w-5 h-5"></i> Data Pengguna
                    </a>

                    <a href="{{ route('admin.transaksi') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition
                        @if(request()->routeIs('admin.transaksi*')) bg-green-600 @endif">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i> Transaksi
                    </a>

                    <a href="{{ route('admin.laporan') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition
                        @if(request()->routeIs('admin.laporan')) bg-green-600 @endif">
                        <i data-lucide="bar-chart-2" class="w-5 h-5"></i> Laporan
                    </a>

                    <a href="{{ route('admin.monitoring') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-600 transition
                        @if(request()->routeIs('admin.monitoring')) bg-green-600 @endif">
                        <i data-lucide="activity" class="w-5 h-5"></i> Monitoring
                    </a>

                </nav>

                <!-- LOGOUT (selalu di bawah) -->
                <div class="p-4 border-t border-green-600">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 
                                   text-white py-2 rounded-lg transition">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                            Logout
                        </button>
                    </form>
                </div>

            </div>
        </aside>
        <!-- =========== END SIDEBAR =========== -->

        <!-- KONTEN -->
        @yield('content')

    </div>

    <script>
        lucide.createIcons();
    </script>

</body>
</html>