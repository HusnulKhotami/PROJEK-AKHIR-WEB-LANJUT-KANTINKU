<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KantinKu | Notifikasi</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

  @include('landing.header-mhs')

  <!-- Banner -->
  <section class="relative pt-40 pb-28 text-center text-white bg-cover bg-center"
    style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}')">
    <div class="absolute inset-0 bg-green-900 bg-opacity-60"></div>

    <div class="relative max-w-3xl mx-auto px-6">
      <h2 class="text-4xl md:text-5xl font-bold mb-4">Notifikasi Anda</h2>
      <p class="text-lg text-gray-200 mb-4">Pantau informasi terbaru dari pesanan & aktivitas akun Anda.</p>
    </div>
  </section>

  <!-- Konten Notifikasi -->
  <section class="max-w-3xl mx-auto py-16 px-6">

    <h3 class="text-3xl font-bold text-green-700 mb-10 flex items-center gap-2">
      <i data-lucide="bell" class="w-8 h-8"></i> Daftar Notifikasi
    </h3>

    @forelse ($notif as $n)
      <div class="bg-white p-5 rounded-xl shadow-md border border-gray-200 mb-4">
        
        <div class="flex items-start gap-3">
          <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
            <i data-lucide="bell-ring" class="w-5 h-5 text-green-700"></i>
          </div>

          <div class="flex-1">
            <p class="text-sm {{ $n->status == 'belum_dibaca' ? 'font-bold' : '' }}">
              {{ $n->pesan }}
            </p>

            <p class="text-xs text-gray-500 mt-1">
              {{ $n->created_at->diffForHumans() }}
            </p>

            <div class="flex gap-3 mt-3">

              @if($n->status == 'belum_dibaca')
              <form method="POST" action="{{ route('mahasiswa.notifikasi.read', $n->id) }}">
                @csrf
                <button class="text-blue-600 text-sm hover:underline">
                  Tandai dibaca
                </button>
              </form>
              @endif

              <form method="POST" action="{{ route('mahasiswa.notifikasi.hapus', $n->id) }}">
                @csrf
                @method('DELETE')
                <button class="text-red-600 text-sm hover:underline">
                  Hapus
                </button>
              </form>

            </div>
          </div>

        </div>
      </div>

    @empty
      <p class="text-gray-500 text-center py-10 text-lg">
        Tidak ada notifikasi.
      </p>
    @endforelse

  </section>

  @include('landing.fotter')

  <script>
    lucide.createIcons();
  </script>

</body>
</html>
