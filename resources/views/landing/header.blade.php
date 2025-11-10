{{-- Navbar --}}
  <nav class="bg-white shadow-md fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
      {{-- Logo --}}
      <div class="flex items-center gap-2">
        <i data-lucide="utensils-crossed" class="w-6 h-6 text-green-600"></i>
        <h1 class="text-2xl font-bold text-green-600">KantinKu</h1>
      </div>

      {{-- Menu Desktop --}}
      <ul class="hidden md:flex space-x-8 text-gray-700 font-medium">
        <li>
          <a href="{{ route('fitur') }}"
            class="{{ request()->routeIs('fitur') ? 'text-green-600 font-semibold border-b-2 border-green-600 pb-1' : 'hover:text-green-600 transition' }}">
            Fitur
          </a>
        </li>
        <li>
          <a href="{{ route('menu') }}"
            class="{{ request()->routeIs('menu') ? 'text-green-600 font-semibold border-b-2 border-green-600 pb-1' : 'hover:text-green-600 transition' }}">
            Menu
          </a>
        </li>
        <li>
          <a href="{{ route('tentang') }}"
            class="{{ request()->routeIs('tentang') ? 'text-green-600 font-semibold border-b-2 border-green-600 pb-1' : 'hover:text-green-600 transition' }}">
            Tentang
          </a>
        </li>
        <li>
          <a href="{{ route('login') }}"
            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition flex items-center gap-2">
            <i data-lucide="log-in" class="w-4 h-4"></i> Masuk
          </a>
        </li>
      </ul>

      {{-- Tombol Menu Mobile --}}
      <button class="md:hidden" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
        <i data-lucide="menu" class="w-6 h-6 text-green-600"></i>
      </button>
    </div>

    {{-- Menu Mobile --}}
    <div id="mobileMenu" class="hidden md:hidden bg-white shadow-lg">
      <ul class="flex flex-col space-y-3 px-6 py-4 text-gray-700 font-medium">
        <li>
          <a href="{{ route('fitur') }}"
            class="{{ request()->routeIs('fitur') ? 'text-green-600 font-semibold' : 'hover:text-green-600 transition' }}">
            Fitur
          </a>
        </li>
        <li>
          <a href="{{ route('menu') }}"
            class="{{ request()->routeIs('menu') ? 'text-green-600 font-semibold' : 'hover:text-green-600 transition' }}">
            Menu
          </a>
        </li>
        <li>
          <a href="{{ route('tentang') }}"
            class="{{ request()->routeIs('tentang') ? 'text-green-600 font-semibold' : 'hover:text-green-600 transition' }}">
            Tentang
          </a>
        </li>
        <li>
          <a href="{{ route('login') }}"
            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
            Masuk
          </a>
        </li>
      </ul>
    </div>
  </nav>