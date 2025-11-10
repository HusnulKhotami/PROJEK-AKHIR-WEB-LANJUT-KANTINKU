<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KantinKu | Riwayat Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    .fade-in {
      animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px)
      }

      to {
        opacity: 1;
        transform: translateY(0)
      }
    }

    .card-hover:hover {
      transform: translateY(-4px);
    }
  </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

  @include('landing.header-mhs')

  {{-- ✅ Hero Section --}}
  <section class="relative pt-40 pb-28 text-center text-white fade-in bg-cover bg-center"
    style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}')">
    <div class="absolute inset-0 bg-green-900 bg-opacity-60"></div>
    <div class="relative max-w-3xl mx-auto px-6">
      <h2 class="text-4xl md:text-5xl font-bold mb-4">
        Riwayat Pesanan Anda
      </h2>
      <p class="text-lg text-gray-200 mb-4">Pantau pesanan yang sudah pernah Anda lakukan sebelumnya.</p>
    </div>
  </section>

  {{-- ✅ Riwayat Section --}}
  <section class="max-w-7xl mx-auto py-16 px-6 fade-in">

    <h3 class="text-3xl font-bold text-green-700 mb-10 flex items-center gap-2">
      <i data-lucide="history" class="w-8 h-8"></i> Riwayat Pesanan
    </h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

      @forelse ($pesanan as $p)
        <div class="bg-white rounded-xl shadow-md hover:shadow-xl border border-gray-200 transition card-hover overflow-hidden">

          {{-- Header Pedagang --}}
          <div class="p-5 border-b border-gray-100 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center">
              <i data-lucide="store" class="w-7 h-7 text-green-700"></i>
            </div>

            <div>
              <h4 class="font-bold text-xl text-gray-800">{{ $p->pedagang->nama_kantin }}</h4>
              <p class="text-gray-500 text-sm">Lokasi: {{ $p->pedagang->lokasi }}</p>
            </div>
          </div>

          {{-- Body --}}
          <div class="p-5 space-y-2">

            <p class="text-gray-700">
              Total Harga: <br>
              <span class="font-bold text-lg text-green-700">
                Rp {{ number_format($p->total_harga, 0, ',', '.') }}
              </span>
            </p>

            <p class="text-gray-600 text-sm">
              Metode Pembayaran:
              <strong>{{ ucfirst($p->metode_pembayaran) }}</strong>
            </p>

            <span class="inline-block px-4 py-1 text-white text-sm rounded-full
              {{ $p->status == 'selesai' ? 'bg-green-600' : 'bg-yellow-500' }}">
              {{ ucfirst($p->status) }}
            </span>

            <p class="text-sm text-gray-500 pt-1">
              Tanggal: {{ $p->created_at->format('d M Y, H:i') }}
            </p>

          </div>

          {{-- Footer --}}
          <div class="p-5 border-t border-gray-100">
            <a href="#"
              class="text-green-600 hover:text-green-700 flex items-center gap-2 text-sm font-medium">
              <i data-lucide="receipt" class="w-4 h-4"></i>
              Lihat Detail Pesanan
            </a>
          </div>
        </div>

      @empty
        <p class="col-span-full text-center text-gray-500 py-10 text-lg">
          Belum ada riwayat pesanan.
        </p>
      @endforelse
    </div>

  </section>

  @include('landing.fotter')

  <script>
    lucide.createIcons();
  </script>
</body>

</html>
