<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KantinKu | Riwayat Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

  @include('landing.header-mhs')

  <section class="relative pt-40 pb-28 text-center text-white bg-cover bg-center"
    style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}')">
    <div class="absolute inset-0 bg-green-900 bg-opacity-60"></div>
    <div class="relative max-w-3xl mx-auto px-6">
      <h2 class="text-4xl md:text-5xl font-bold mb-4">Riwayat Pesanan Anda</h2>
      <p class="text-lg text-gray-200 mb-4">Pantau pesanan yang sudah pernah Anda lakukan sebelumnya.</p>
    </div>
  </section>

  <section class="max-w-7xl mx-auto py-16 px-6">

    <h3 class="text-3xl font-bold text-green-700 mb-10 flex items-center gap-2">
      <i data-lucide="history" class="w-8 h-8"></i> Riwayat Pesanan
    </h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

      @forelse ($pesanan as $p)
        <div class="bg-white rounded-xl shadow-md border border-gray-200 transition overflow-hidden">

          <div class="p-5 border-b flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center">
              <i data-lucide="store" class="w-7 h-7 text-green-700"></i>
            </div>

            <div>
              <h4 class="font-bold text-xl">{{ $p->pedagang->nama_kantin }}</h4>
              <p class="text-gray-500 text-sm">Lokasi: {{ $p->pedagang->lokasi }}</p>
            </div>
          </div>

          <div class="p-5 space-y-2">
            <p class="text-gray-700">
              Total Harga:<br>
              <span class="font-bold text-lg text-green-700">
                Rp {{ number_format($p->total_harga, 0, ',', '.') }}
              </span>
            </p>

            <p class="text-gray-600 text-sm">
              Metode Pembayaran: <strong>{{ ucfirst($p->metode_pembayaran) }}</strong>
            </p>

            <span class="inline-block px-4 py-1 text-white text-sm rounded-full
              {{ $p->status == 'selesai' ? 'bg-green-600' : 'bg-red-600' }}">
              {{ ucfirst($p->status) }}
            </span>

            <p class="text-sm text-gray-500 pt-1">
              Tanggal: {{ $p->created_at->format('d M Y, H:i') }}
            </p>
          </div>

          <div class="p-5 border-t flex items-center justify-between">

            <a href="{{ route('mahasiswa.detail-pesanan', $p->id) }}"
              class="text-green-600 hover:text-green-700 flex items-center gap-2 text-sm font-medium">
              <i data-lucide="receipt" class="w-4 h-4"></i> Detail
            </a>

            <button onclick="openDeleteModal({{ $p->id }})"
              class="text-red-600 hover:text-red-700 flex items-center gap-1 text-sm font-medium">
              <i data-lucide="trash" class="w-4 h-4"></i> Hapus
            </button>

          </div>

        </div>

      @empty
        <p class="col-span-full text-center text-gray-500 py-10 text-lg">
          Belum ada riwayat pesanan.
        </p>
      @endforelse

    </div>

  </section>

  <div id="deleteModal"
       class="fixed inset-0 hidden bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50">

    <form id="deleteForm" method="POST"
          class="bg-white p-6 rounded-xl shadow-lg w-80 text-center">

      @csrf
      @method('DELETE')

      <h3 class="text-lg font-bold mb-3">Hapus Pesanan?</h3>
      <p class="text-gray-600 text-sm mb-6">
        Riwayat pesanan ini akan dihapus secara permanen.
      </p>

      <div class="flex justify-center gap-3">
        <button type="button" onclick="closeDeleteModal()"
                class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400">
          Batal
        </button>

        <button type="submit"
                class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
          Hapus
        </button>
      </div>
    </form>
  </div>

  @include('landing.fotter')

  <script>
    lucide.createIcons();

    function openDeleteModal(id) {
      document.getElementById("deleteModal").classList.remove("hidden");
      document.getElementById("deleteForm").action =
        `/mahasiswa/pesanan/${id}/hapus`; 
    }

    function closeDeleteModal() {
      document.getElementById("deleteModal").classList.add("hidden");
    }
  </script>

</body>
</html>
