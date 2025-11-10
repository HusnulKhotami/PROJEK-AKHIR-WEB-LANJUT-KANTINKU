<footer class="bg-green-800 text-white pt-12 pb-8 mt-16 fade-in">
  <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10">

    {{-- Kolom 1 - Tentang KantinKu --}}
    <div>
      <div class="flex items-center gap-2 mb-3">
        <i data-lucide="utensils-crossed" class="w-6 h-6 text-green-300"></i>
        <h2 class="text-2xl font-bold text-green-300">KantinKu</h2>
      </div>
      <p class="text-gray-200 text-sm leading-relaxed">
        KantinKu adalah platform pemesanan makanan online untuk mahasiswa dan staf kampus.
        Dengan KantinKu, kamu bisa pesan makanan tanpa antre dan bayar secara digital.
      </p>
    </div>

    {{-- Kolom 2 - Navigasi Cepat --}}
    <div>
      <h3 class="text-lg font-semibold mb-3 text-green-200">Navigasi Cepat</h3>
      <ul class="space-y-2 text-gray-200 text-sm">
        <li><a href="{{ route('home') }}" class="hover:text-green-300 transition">Beranda</a></li>
        <li><a href="{{ route('fitur') }}" class="hover:text-green-300 transition">Fitur</a></li>
        <li><a href="{{ route('menu') }}" class="hover:text-green-300 transition">Menu</a></li>
        <li><a href="{{ route('tentang') }}" class="hover:text-green-300 transition">Tentang</a></li>
        <li><a href="{{ route('login') }}" class="hover:text-green-300 transition">Masuk</a></li>
      </ul>
    </div>

    {{-- Kolom 3 - Kontak & Sosial Media --}}
    <div>
      <h3 class="text-lg font-semibold mb-3 text-green-200">Hubungi Kami</h3>
      <p class="text-gray-200 text-sm">
        Universitas Lampung<br>
        <a href="mailto:kantinku@unila.ac.id" class="underline hover:text-green-300">kantinku@unila.ac.id</a>
      </p>

      <div class="flex space-x-4 mt-4">
        <a href="#" class="p-2 rounded-full bg-green-700 hover:bg-green-600 transition">
          <i data-lucide="instagram" class="w-5 h-5 text-white"></i>
        </a>
        <a href="#" class="p-2 rounded-full bg-green-700 hover:bg-green-600 transition">
          <i data-lucide="facebook" class="w-5 h-5 text-white"></i>
        </a>
        <a href="#" class="p-2 rounded-full bg-green-700 hover:bg-green-600 transition">
          <i data-lucide="twitter" class="w-5 h-5 text-white"></i>
        </a>
      </div>
    </div>
  </div>

  {{-- Garis Pembatas --}}
  <div class="border-t border-green-600 mt-5 pt-4 text-center text-sm text-gray-300">
    <p>&copy; 2025 <span class="font-semibold text-white">KantinKu</span> | Universitas Lampung</p>
  </div>
</footer>
