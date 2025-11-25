<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notifikasi - KantinKu</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    .fade-in { animation: fadeIn 0.7s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .notification-item:hover { transform: translateX(4px); }
  </style>
</head>
<body class="bg-gray-50">

@include('landing.header-mhs')

<section class="relative pt-40 pb-32 text-center text-white fade-in bg-cover bg-center" style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}')">
  <div class="absolute inset-0 bg-green-900 bg-opacity-60"></div>
  <div class="relative max-w-3xl mx-auto px-6">
    <h2 class="text-4xl md:text-5xl font-bold mb-4 flex items-center justify-center gap-2">
      <i data-lucide="bell" class="w-8 h-8"></i>
      Notifikasi
    </h2>
    <p class="text-gray-200 text-lg">Pantau update pesanan Anda</p>
  </div>
</section>

<main class="max-w-3xl mx-auto py-16 px-6 fade-in">

  @if($notifikasi->isEmpty())
    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
      <i data-lucide="inbox" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
      <p class="text-gray-500 text-lg">Tidak ada notifikasi</p>
    </div>
  @else
    <div class="space-y-4">
      @foreach($notifikasi as $notif)
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition notification-item p-6 border-l-4 
          {{ $notif->tipe === 'status_update' ? 'border-blue-500' : 'border-green-500' }}">
          
          <div class="flex justify-between items-start mb-2">
            <div class="flex-1">
              <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                @switch($notif->tipe)
                  @case('status_update')
                    <i data-lucide="package" class="w-5 h-5 text-blue-600"></i>
                    Update Status Pesanan
                  @break
                  @case('verifikasi_transfer')
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                    Verifikasi Pembayaran
                  @break
                  @default
                    <i data-lucide="bell" class="w-5 h-5 text-gray-600"></i>
                    Notifikasi
                @endswitch
              </h3>
              
              <p class="text-gray-700 mt-1">{{ $notif->pesan }}</p>
              
              @if($notif->catatan)
                <p class="text-sm text-gray-600 bg-gray-50 mt-2 p-2 rounded border-l-2 border-yellow-400">
                  <strong>Catatan:</strong> {{ $notif->catatan }}
                </p>
              @endif

              @if($notif->pesanan)
                <p class="text-sm text-gray-500 mt-2">
                  Pesanan #{{ $notif->pesanan->id }} - 
                  <a href="{{ route('mahasiswa.detail-pesanan', $notif->pesanan->id) }}" class="text-green-600 hover:underline">
                    Lihat detail
                  </a>
                </p>
              @endif

              <p class="text-xs text-gray-400 mt-2">
                <i data-lucide="clock" class="w-3 h-3 inline"></i>
                {{ $notif->created_at->diffForHumans() }}
              </p>
            </div>

            <div class="ml-4">
              <form action="{{ route('mahasiswa.notifikasi.delete', $notif->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                  <i data-lucide="trash-2" class="w-5 h-5"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif

</main>

@include('landing.fotter')

<script src="https://unpkg.com/lucide@latest"></script>
<script>
  lucide.createIcons();
</script>

</body>
</html>
