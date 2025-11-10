<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KantinKu | Keranjang</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50 text-gray-800">

  {{-- Navbar --}}
  @include('landing.header-mhs')

  <main class="pt-32 pb-20 max-w-6xl mx-auto px-6">
    <h2 class="text-3xl font-bold text-green-700 mb-8 flex items-center gap-2">
      <i data-lucide="shopping-cart"></i> Keranjang Belanja
    </h2>

    {{-- Jika keranjang kosong --}}
    @if($keranjang->count() == 0)
      <div class="bg-white shadow-lg rounded-2xl p-12 text-center">
        <i data-lucide="shopping-bag" class="w-16 h-16 mx-auto text-gray-400 mb-4"></i>
        <p class="text-gray-600 text-lg mb-6">Keranjang kamu masih kosong.</p>
        <a href="{{ route('mahasiswa.menu-mhs') }}"
           class="inline-block bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-3 rounded-xl transition">
          Lihat Menu
        </a>
      </div>

    @else
      {{-- Daftar item --}}
      <div class="space-y-5">
        @foreach ($keranjang as $item)
          @if($item->menu)
          <div class="bg-white shadow-md hover:shadow-lg transition rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center gap-5">

            {{-- Gambar Menu --}}
            <div class="w-full sm:w-28 h-28 rounded-xl overflow-hidden flex-shrink-0">
              <img src="{{ $item->menu->gambar_url ?? asset('image/menu/default.png') }}"
                   alt="{{ $item->menu->nama }}"
                   class="w-full h-full object-cover">
            </div>

            {{-- Info Menu --}}
            <div class="flex-1">
              <h3 class="text-xl font-semibold text-green-700">{{ $item->menu->nama }}</h3>
              <p class="text-gray-600 text-sm line-clamp-2">{{ $item->menu->deskripsi }}</p>
              <p class="text-lg font-bold text-green-800 mt-2">
                Rp {{ number_format($item->menu->harga, 0, ',', '.') }}
              </p>
            </div>

            {{-- Kontrol jumlah --}}
            <div class="flex items-center gap-3">
              {{-- Tombol Kurang --}}
              <form action="{{ route('mahasiswa.keranjang.kurang') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $item->id }}">
                <button type="submit"
                        class="bg-gray-200 hover:bg-gray-300 text-lg font-bold px-3 py-1.5 rounded-lg transition">
                  −
                </button>
              </form>

              <span class="font-semibold text-lg w-6 text-center">{{ $item->jumlah }}</span>

              {{-- Tombol Tambah --}}
              <form action="{{ route('mahasiswa.keranjang.tambah') }}" method="POST">
                @csrf
                <input type="hidden" name="id_menu" value="{{ $item->menu->id }}">
                <input type="hidden" name="jumlah" value="1">
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white text-lg font-bold px-3 py-1.5 rounded-lg transition">
                  +
                </button>
              </form>
            </div>

            {{-- Tombol Hapus --}}
            <form action="{{ route('mahasiswa.keranjang.hapus') }}" method="POST" class="ml-2">
              @csrf
              <input type="hidden" name="id" value="{{ $item->id }}">
              <button type="submit"
                      class="text-red-500 hover:text-red-700 p-2 rounded-full transition flex items-center gap-1">
                <i data-lucide="trash-2" class="w-5 h-5"></i>
                <span class="hidden sm:inline text-sm font-medium">Hapus</span>
              </button>
            </form>

          </div>
          @endif
        @endforeach
      </div>

      {{-- Total dan Checkout --}}
      <div class="mt-10 bg-white shadow-lg rounded-2xl p-8 border-t-4 border-green-600">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
          <h3 class="text-xl font-semibold text-gray-800">Total Belanja</h3>
          @php
            $total = 0;
            foreach ($keranjang as $item) {
                if ($item->menu) {
                    $total += $item->menu->harga * $item->jumlah;
                }
            }
          @endphp
          <p class="text-2xl font-bold text-green-700">
            Rp {{ number_format($total, 0, ',', '.') }}
          </p>
        </div>

        <button
          class="mt-6 bg-green-600 hover:bg-green-700 text-white text-lg font-semibold w-full py-4 rounded-xl transition">
          Checkout Sekarang
        </button>
      </div>
    @endif
  </main>

  @include('landing.fotter')

  <script>lucide.createIcons();</script>
</body>
</html>
