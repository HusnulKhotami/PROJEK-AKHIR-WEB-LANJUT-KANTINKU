<nav class="bg-white shadow-md fixed w-full z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">

        {{-- LOGO --}}
        <div class="flex items-center gap-2">
            <i data-lucide="utensils-crossed" class="w-6 h-6 text-green-600"></i>
            <h1 class="text-2xl font-bold text-green-600">KantinKu</h1>
        </div>

        {{-- MENU DESKTOP --}}
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

            {{-- NOTIFIKASI --}}
            <li class="relative">
                <button onclick="toggleNotifPopup()" class="relative">
                    <i data-lucide="bell-ring" class="w-6 h-6 hover:text-green-600 transition"></i>

                    {{-- BADGE --}}
                    <span id="notifCount"
                        class="absolute -top-2 -right-1 bg-red-600 text-white text-xs px-1.5 py-0.5 rounded-full {{ $countNotif > 0 ? '' : 'hidden' }}">
                        {{ $countNotif }}
                    </span>
                </button>

                {{-- POPUP NOTIF --}}
                <div id="notifPopup"
                    class="hidden absolute right-0 mt-3 w-80 bg-white shadow-lg rounded-lg border p-4 z-50 animate-fade">

                    <h3 class="text-lg font-semibold mb-2">Notifikasi</h3>

                    <ul id="notifList" class="space-y-3 max-h-64 overflow-y-auto">
                        @forelse ($notifList as $n)
                            <li class="border-b pb-2">
                                <p class="text-sm text-gray-700">{{ $n->pesan }}</p>
                                <div class="flex items-center justify-between mt-1">
                                    <small class="text-gray-400 text-xs">{{ $n->created_at->diffForHumans() }}</small>

                                    <div class="flex items-center gap-2">

                                        @if ($n->status == 'belum_dibaca')
                                            <form action="{{ route('mahasiswa.notifikasi.read', $n->id) }}" method="POST">
                                                @csrf
                                                <button class="text-blue-500 text-xs hover:underline">Tandai dibaca</button>
                                            </form>
                                        @endif

                                        <form action="{{ route('mahasiswa.notifikasi.hapus', $n->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-500 text-xs hover:underline">Hapus</button>
                                        </form>

                                    </div>
                                </div>
                            </li>
                        @empty
                            <p class="text-gray-500 text-sm">Tidak ada notifikasi.</p>
                        @endforelse
                    </ul>

                    <a href="{{ route('mahasiswa.notifikasi') }}"
                        class="block text-center text-green-600 mt-3 text-sm hover:underline">
                        Lihat semua notifikasi
                    </a>

                </div>
            </li>

            {{-- KERANJANG --}}
            <li class="relative">
                <a href="{{ route('mahasiswa.keranjang') }}"
                  class="flex items-center gap-1 {{ request()->routeIs('mahasiswa.keranjang')
                        ? 'text-green-600 font-semibold border-b-2 border-green-600 pb-1'
                        : 'hover:text-green-600 transition' }}">

                    <i data-lucide="shopping-cart" class="w-6 h-6"></i>

                    <span id="cartCount"
                        class="absolute -top-2 left-4 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full {{ $countKeranjang > 0 ? '' : 'hidden' }}">
                        {{ $countKeranjang }}
                    </span>
                </a>
            </li>

            {{-- LOGOUT --}}
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();"
                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition flex items-center gap-2">
                <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                </a>

                <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </li>

        </ul>

        {{-- MOBILE MENU BUTTON --}}
        <button class="md:hidden" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
            <i data-lucide="menu" class="w-6 h-6 text-green-600"></i>
        </button>
    </div>

    {{-- MOBILE MENU --}}
    <div id="mobileMenu" class="hidden md:hidden bg-white shadow-lg">
        <ul class="flex flex-col space-y-3 px-6 py-4 text-gray-700 font-medium">

            <li><a href="{{ route('mahasiswa.menu-mhs') }}">Menu</a></li>
            <li><a href="{{ route('mahasiswa.status') }}">Status Pesanan</a></li>
            <li><a href="{{ route('mahasiswa.riwayat') }}">Riwayat</a></li>

            {{-- NOTIF MOBILE --}}
            <li>
                <button onclick="document.getElementById('mobileNotif').classList.toggle('hidden')" class="flex items-center gap-2">
                    <i data-lucide="bell-ring" class="w-5 h-5 text-green-600"></i>
                    Notifikasi
                    <span id="notifCountMobile"
                          class="ml-2 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full {{ $countNotif > 0 ? '' : 'hidden' }}">
                          {{ $countNotif }}
                    </span>
                </button>

                <div id="mobileNotif" class="hidden mt-2 bg-white p-3 border rounded-lg shadow-sm">
                    <h4 class="font-semibold mb-2">Notifikasi</h4>

                    <ul id="notifListMobile" class="space-y-2 max-h-56 overflow-y-auto">
                        @forelse ($notifList as $n)
                            <li class="border-b pb-2">
                                <p class="text-sm">{{ $n->pesan }}</p>
                                <small class="text-gray-400 text-xs">{{ $n->created_at->diffForHumans() }}</small>
                            </li>
                        @empty
                            <p class="text-gray-400 text-sm">Tidak ada notifikasi.</p>
                        @endforelse
                    </ul>
                </div>
            </li>

            {{-- KERANJANG MOBILE --}}
            <li class="flex items-center gap-2">
                <i data-lucide="shopping-cart" class="w-5 h-5 text-green-600"></i>
                <a href="{{ route('mahasiswa.keranjang') }}">Keranjang ({{ $countKeranjang }})</a>
            </li>

            {{-- LOGOUT --}}
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

{{-- SCRIPT --}}
<script>
    function toggleNotifPopup() {
        const popup = document.getElementById('notifPopup');
        popup.classList.toggle('hidden');
    }

    document.addEventListener('click', function(e) {
        const popup = document.getElementById('notifPopup');
        const btn = document.querySelector('button[onclick="toggleNotifPopup()"]');

        if (popup && !popup.contains(e.target) && !btn.contains(e.target)) {
            popup.classList.add('hidden');
        }
    });
</script>

<style>
    .animate-fade {
        animation: fadeIn 0.2s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
