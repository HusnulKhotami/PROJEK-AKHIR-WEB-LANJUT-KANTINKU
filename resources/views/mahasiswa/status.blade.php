<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KantinKu | Status Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    .fade-in { animation: fadeIn 0.8s ease-in-out; }
    @keyframes fadeIn { 
      from { opacity:0; transform:translateY(10px); }
      to   { opacity:1; transform:translateY(0); }
    }
    .card-hover:hover { transform: translateY(-4px); }
  </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

  @include('landing.header-mhs')


  <section class="relative pt-40 pb-28 text-center text-white bg-cover bg-center fade-in"
    style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}')">

    <div class="absolute inset-0 bg-green-900 bg-opacity-60"></div>

    <div class="relative max-w-3xl mx-auto px-6">
      <h2 class="text-4xl md:text-5xl font-bold mb-4 flex items-center justify-center gap-2">
        Status Pesanan
      </h2>
      <p class="text-gray-200 text-lg">Pantau pesanan Anda secara real-time tanpa harus menunggu lama!</p>
    </div>
  </section>

  {{-- CONTENT --}}
  <section class="max-w-7xl mx-auto py-16 px-6 fade-in">

    <h3 class="text-3xl font-bold text-green-700 mb-10 flex items-center gap-2">
      <i data-lucide="clock" class="w-8 h-8"></i>
      Daftar Pesanan Aktif
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

      @forelse ($pesanan as $p)
        <div class="bg-white rounded-xl shadow-md hover:shadow-xl border border-gray-200 p-6 transition card-hover">

          {{-- HEADER PEDAGANG --}}
          <div class="flex items-start justify-between mb-4">
            <div>
              <h4 class="text-2xl font-bold text-gray-800">{{ $p->pedagang->nama_kantin }}</h4>
              <p class="text-gray-500 text-sm flex items-center gap-1 mt-1">
                <i data-lucide="map-pin" class="w-4 h-4"></i>
                {{ $p->pedagang->lokasi }}
              </p>
            </div>

            {{-- STATUS BADGE --}}
            <span class="px-4 py-1 text-sm rounded-full text-white font-semibold
              {{ $p->status == 'proses' ? 'bg-yellow-500' : 
                 ($p->status == 'siap' ? 'bg-green-600' : 'bg-gray-400') }}">
              {{ ucfirst($p->status) }}
            </span>
          </div>

          {{-- DETAIL --}}
          <div class="mt-2 space-y-3 text-gray-700">

            <p class="flex items-center gap-2">
              <i data-lucide="shopping-bag" class="w-5 h-5 text-green-600"></i>
              Total Harga:
              <strong class="text-green-700">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</strong>
            </p>

            <p class="flex items-center gap-2">
              <i data-lucide="wallet" class="w-5 h-5 text-green-600"></i>
              Pembayaran:
              <strong>{{ ucfirst($p->metode_pembayaran) }}</strong>
            </p>

            <p class="flex items-center gap-2 text-sm text-gray-500">
              <i data-lucide="clock" class="w-4 h-4"></i>
              Dipesan: {{ $p->created_at->format('d M Y, H:i') }}
            </p>
          </div>

          {{-- FOOTER BUTTON --}}
          <div class="mt-6 flex justify-end">
            <a href="{{ route('mahasiswa.detail-pesanan', $p->id) }}"
              class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg flex items-center gap-2">
              <i data-lucide="eye" class="w-4 h-4"></i> Lihat Detail
            </a>
          </div>

        </div>

      @empty
        <p class="col-span-full text-center text-gray-500 py-20 text-lg">
          Tidak ada pesanan aktif saat ini.
        </p>
      @endforelse

    </div>
  </section>

  @include('landing.fotter')

  <script>lucide.createIcons();</script>

</body>

</html>
