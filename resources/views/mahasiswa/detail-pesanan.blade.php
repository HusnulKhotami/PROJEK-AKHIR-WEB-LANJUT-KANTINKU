<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Pesanan - KantinKu</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    .status-badge { display: inline-block; padding: 0.5rem 1rem; border-radius: 9999px; font-weight: 600; font-size: 0.875rem; }
    .status-diproses { background-color: #fef3c7; color: #92400e; }
    .status-siap_diambil { background-color: #bfdbfe; color: #1e40af; }
    .status-selesai { background-color: #dcfce7; color: #166534; }
    .status-dibatalkan { background-color: #fee2e2; color: #991b1b; }
    .fade-in { animation: fadeIn 0.7s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
  </style>
</head>

<body class="bg-gray-50">

@include('landing.header-mhs')

<section class="relative pt-40 pb-32 text-center text-white fade-in bg-cover bg-center" style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}')">
  <div class="absolute inset-0 bg-green-900 bg-opacity-60"></div>
  <div class="relative max-w-3xl mx-auto px-6">
    <h2 class="text-4xl md:text-5xl font-bold mb-4 flex items-center justify-center gap-2">
      <i data-lucide="package" class="w-8 h-8"></i>
      Detail Pesanan
    </h2>
    <p class="text-gray-200 text-lg">Pantau status pesanan Anda secara real-time</p>
  </div>
</section>

<main class="max-w-4xl mx-auto py-16 px-6 fade-in">

  {{-- HEADER INFO --}}
  <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
      <div>
        <p class="text-gray-600 text-sm">Nomor Pesanan</p>
        <p class="text-2xl font-bold text-green-700">#{{ $pesanan->id }}</p>
      </div>
      <div>
        <p class="text-gray-600 text-sm">Tanggal Pesanan</p>
        <p class="text-xl font-semibold text-gray-800">{{ $pesanan->created_at->format('d M Y H:i') }}</p>
      </div>
      <div>
        <p class="text-gray-600 text-sm">Status Pesanan</p>
        <p class="status-badge status-{{ $pesanan->status }} mt-1">
          @switch($pesanan->status)
            @case('diproses')
              ⏳ Diproses
            @break
            @case('siap_diambil')
              ✅ Siap Diambil
            @break
            @case('selesai')
              ✨ Selesai
            @break
            @case('dibatalkan')
              ❌ Dibatalkan
            @break
            @default
              {{ ucfirst($pesanan->status) }}
          @endswitch
        </p>
      </div>
    </div>

    {{-- PROGRESS BAR --}}
    <div class="mt-8">
      <p class="text-sm font-semibold text-gray-700 mb-3">Progress Pesanan</p>
      <div class="flex justify-between items-center mb-2">
        <span class="text-xs text-gray-600">Pesanan dibuat</span>
        <span class="text-xs text-gray-600">Diproses</span>
        <span class="text-xs text-gray-600">Siap Diambil</span>
        <span class="text-xs text-gray-600">Selesai</span>
      </div>
      <div class="flex gap-2">
        <div class="flex-1 h-2 bg-green-500 rounded-full"></div>
        <div class="flex-1 h-2 {{ in_array($pesanan->status, ['siap_diambil', 'selesai']) ? 'bg-green-500' : 'bg-gray-300' }} rounded-full"></div>
        <div class="flex-1 h-2 {{ $pesanan->status === 'selesai' ? 'bg-green-500' : 'bg-gray-300' }} rounded-full"></div>
      </div>
    </div>
  </div>

  {{-- INFORMASI PENJUAL --}}
  <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
      <i data-lucide="store" class="w-6 h-6 text-green-600"></i>
      Informasi Penjual
    </h3>
    <div class="border-l-4 border-green-500 pl-4">
      <p class="font-semibold text-gray-800">{{ $pesanan->pedagang->nama_toko ?? 'Nama Toko' }}</p>
      <p class="text-gray-600 text-sm">Pemilik: {{ $pesanan->pedagang->user->nama ?? 'Nama Pemilik' }}</p>
    </div>
  </div>

  {{-- DETAIL ITEM PESANAN --}}
  <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
      <i data-lucide="shopping-bag" class="w-6 h-6 text-green-600"></i>
      Item Pesanan
    </h3>

    <div class="space-y-4">
      @foreach($pesanan->item as $i)
      <div class="flex justify-between items-start gap-4 pb-4 border-b last:border-b-0">
        <div class="flex-1">
          <p class="font-semibold text-gray-800">{{ $i->menu->nama }}</p>
          <p class="text-sm text-gray-600">{{ $i->menu->deskripsi }}</p>
          <p class="text-sm text-gray-500 mt-1">
            {{ $i->jumlah }}x @ Rp {{ number_format($i->harga, 0, ',', '.') }}
          </p>
        </div>
        <div class="text-right">
          <p class="font-bold text-green-700">Rp {{ number_format($i->subtotal, 0, ',', '.') }}</p>
        </div>
      </div>
      @endforeach
    </div>

    {{-- TOTAL --}}
    <div class="mt-6 pt-4 border-t-2 border-gray-200">
      <div class="flex justify-between items-center">
        <p class="text-lg font-bold text-gray-800">Total Pembayaran</p>
        <p class="text-3xl font-bold text-green-700">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
      </div>
    </div>
  </div>

  {{-- INFORMASI PEMBAYARAN --}}
  <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
      <i data-lucide="credit-card" class="w-6 h-6 text-green-600"></i>
      Informasi Pembayaran
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <p class="text-gray-600 text-sm mb-1">Metode Pembayaran</p>
        @if($pesanan->metode_pembayaran === 'cash')
        <p class="text-lg font-semibold text-gray-800">
          <i data-lucide="coins" class="w-5 h-5 inline mr-2 text-yellow-600"></i>
          Tunai (Cash)
        </p>
        @elseif($pesanan->metode_pembayaran === 'transfer')
        <p class="text-lg font-semibold text-gray-800">
          <i data-lucide="send" class="w-5 h-5 inline mr-2 text-blue-600"></i>
          Transfer Bank
        </p>
        @endif
      </div>
      <div>
        <p class="text-gray-600 text-sm mb-1">Status Pembayaran</p>
        @if($pesanan->transaksi)
          @switch($pesanan->transaksi->status)
            @case('verified')
            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
              ✅ Terverifikasi
            </span>
            @break
            @case('pending')
            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
              ⏳ Menunggu Verifikasi
            </span>
            @break
            @case('paid')
            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
              ✅ Sudah Dibayar
            </span>
            @break
            @case('failed')
            <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">
              ❌ Gagal
            </span>
            @break
          @endswitch
        @endif
      </div>
    </div>

    {{-- BUKTI TRANSFER (jika ada) --}}
    @if($pesanan->metode_pembayaran === 'transfer' && $pesanan->transaksi && $pesanan->transaksi->bukti_transfer)
    <div class="mt-6 pt-6 border-t">
      <p class="text-gray-600 text-sm mb-3 font-semibold">Bukti Transfer</p>
      <img src="{{ asset('storage/' . $pesanan->transaksi->bukti_transfer) }}"
        alt="Bukti Transfer" class="max-w-sm rounded-lg border border-gray-300">
    </div>
    @endif
  </div>

  {{-- CATATAN ADMIN (jika ada) --}}
  @if($pesanan->transaksi && $pesanan->transaksi->catatan_admin)
  <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6 mb-8">
    <p class="font-semibold text-blue-900 mb-2 flex items-center gap-2">
      <i data-lucide="info" class="w-5 h-5"></i>
      Catatan dari Admin
    </p>
    <p class="text-blue-800">{{ $pesanan->transaksi->catatan_admin }}</p>
  </div>
  @endif

  {{-- AKSI --}}
  <div class="flex gap-4 justify-between">
    <a href="{{ route('mahasiswa.status') }}"
      class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg transition flex items-center gap-2">
      <i data-lucide="arrow-left" class="w-5 h-5"></i>
      Kembali ke Status Pesanan
    </a>

    @if($pesanan->status === 'selesai')
    <a href="{{ route('mahasiswa.menu-mhs') }}"
      class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition flex items-center gap-2">
      <i data-lucide="shopping-cart" class="w-5 h-5"></i>
      Pesan Lagi
    </a>
    @endif
  </div>

</main>

@include('landing.fotter')

<script src="https://unpkg.com/lucide@latest"></script>
<script>
  lucide.createIcons();

  // Auto-refresh setiap 5 detik untuk cek status terbaru
  setTimeout(() => {
    location.reload();
  }, 5000);
</script>

</body>

</html>
</div>
<script>
  setTimeout(() => {
    const toast = document.getElementById('toast-success');
    if (toast) toast.remove();
  }, 3000);
</script>
@endif

<script>lucide.createIcons();</script>
</body>
</html>
