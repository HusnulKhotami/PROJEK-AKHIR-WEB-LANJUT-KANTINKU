<nav class="bg-white shadow-md fixed w-full z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">

        <!-- Logo -->
        <div class="flex items-center gap-2">
            <i data-lucide="utensils-crossed" class="w-6 h-6 text-green-600"></i>
            <h1 class="text-2xl font-bold text-green-600">KantinKu</h1>
        </div>

        @php
            $countKeranjang = Auth::check()
                ? \App\Models\Keranjang::where('user_id', Auth::id())->sum('jumlah')
                : 0;
        @endphp

        <!-- Menu Desktop -->
        <ul class="hidden md:flex space-x-8 text-gray-700 font-medium">

            <li>
                <a href="{{ route('mahasiswa.menu-mhs') }}"
                   class="{{ request()->routeIs('mahasiswa.menu-mhs') ? 'text-green-600 font-semibold border-b-2 border-green-600 pb-1' : 'hover:text-green-600 transition' }}">
                    Menu
                </a>
            </li>

            <li>
                <a href="{{ route('mahasiswa.status') }}"
                   class="{{ request()->routeIs('mahasiswa.status') ? 'text-green-600 font-semibold border-b-2 border-green-600 pb-1' : 'hover:text-green-600 transition' }}">
                    Status Pesanan
                </a>
            </li>

            <li>
                <a href="{{ route('mahasiswa.riwayat') }}"
                   class="{{ request()->routeIs('mahasiswa.riwayat') ? 'text-green-600 font-semibold border-b-2 border-green-600 pb-1' : 'hover:text-green-600 transition' }}">
                    Riwayat
                </a>
            </li>

            <!-- Keranjang -->
            <li class="relative">
                <a href="{{ route('mahasiswa.keranjang') }}"
                  class="flex items-center gap-1 {{ request()->routeIs('mahasiswa.keranjang') 
                        ? 'text-green-600 font-semibold border-b-2 border-green-600 pb-1' 
                        : 'hover:text-green-600 transition' }}">
                    <i data-lucide="shopping-cart" class="w-6 h-6"></i>

                    @if ($countKeranjang > 0)
                        <span class="absolute -top-2 left-4 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
                            {{ $countKeranjang }}
                        </span>
                    @endif
                </a>
            </li>

            <!-- Logout -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition flex items-center gap-2">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                    </button>
                </form>
            </li>

        </ul>

        <!-- Toggle Mobile -->
        <button class="md:hidden" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
            <i data-lucide="menu" class="w-6 h-6 text-green-600"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-white shadow-lg">
        <ul class="flex flex-col space-y-2 px-6 py-4 text-gray-700 font-medium">

            <li><a href="{{ route('mahasiswa.menu-mhs') }}">Menu</a></li>
            <li><a href="{{ route('mahasiswa.status') }}">Status Pesanan</a></li>
            <li><a href="{{ route('mahasiswa.riwayat') }}">Riwayat</a></li>

            <!-- Keranjang Mobile -->
            <li class="flex items-center gap-2">
                <i data-lucide="shopping-cart" class="w-5 h-5 text-green-600"></i>
                <a href="{{ route('mahasiswa.keranjang') }}">Keranjang ({{ $countKeranjang }})</a>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-green-600 text-white px-4 py-2 rounded-md w-full">
                        Logout
                    </button>
                </form>
            </li>

        </ul>
    </div>
</nav>
