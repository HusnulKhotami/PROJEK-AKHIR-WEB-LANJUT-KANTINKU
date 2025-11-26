<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50">

@include('landing.header-mhs')

<main class="pt-32 max-w-4xl mx-auto px-6 pb-20">

  <h2 class="text-3xl font-bold text-green-700 mb-8 flex items-center gap-2">
    <i data-lucide="receipt"></i> Detail Pesanan
  </h2>

  <div class="bg-white shadow-lg rounded-2xl p-6">

    <p class="text-lg mb-3">
      <strong>ID Pesanan:</strong> {{ $pesanan->id }}
    </p>

    <p class="text-lg mb-3">
      <strong>Pedagang:</strong> {{ $pesanan->pedagang->nama_kantin }}
    </p>

    <p class="text-lg mb-3">
      <strong>Status:</strong> 
      <span class="font-bold text-green-700">{{ ucfirst($pesanan->status) }}</span>
    </p>

    <p class="text-lg mb-3">
      <strong>Metode Pembayaran:</strong> {{ ucfirst($pesanan->metode_pembayaran) }}
    </p>

    {{-- ✔️ Tambahkan catatan pembeli di sini --}}
    @if ($pesanan->catatan)
    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-300 mb-4">
        <p class="font-semibold text-yellow-700">Catatan Pembeli:</p>
        <p class="text-gray-700 mt-1">{{ $pesanan->catatan }}</p>
    </div>
    @endif

    <hr class="my-4">

    <h3 class="text-xl font-bold mb-3">Item Pesanan</h3>

    <table class="w-full text-left border">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-2">Nama Menu</th>
          <th class="p-2">Jumlah</th>
          <th class="p-2">Harga</th>
          <th class="p-2">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($pesanan->items as $i)
        <tr class="border-b">
          <td class="p-2">{{ $i->menu->nama }}</td>
          <td class="p-2">{{ $i->jumlah }}</td>
          <td class="p-2">Rp {{ number_format($i->harga,0,',','.') }}</td>
          <td class="p-2 font-bold">Rp {{ number_format($i->subtotal,0,',','.') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <p class="text-xl font-bold text-right mt-5">
      Total: Rp {{ number_format($pesanan->total_harga,0,',','.') }}
    </p>

    <div class="mt-8">
      <a href="{{ route('mahasiswa.status') }}"
        class="bg-green-600 hover:bg-green-700 px-5 py-3 text-white rounded-xl">
        Lihat Status Pesanan
      </a>
    </div>

  </div>

</main>

@include('landing.fotter')

{{-- POPUP SUCCESS --}}
@if (session('success'))
<div id="toast-success"
     class="fixed top-5 right-5 z-50 flex items-center w-full max-w-sm p-4 mb-4 bg-white rounded-lg shadow-lg border-l-4 border-green-500 animate-slide-in"
     role="alert">
    <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mr-3"></i>
    <div class="text-sm font-medium text-gray-700">{{ session('success') }}</div>
    <button type="button" onclick="document.getElementById('toast-success').remove();"
      class="ml-auto text-gray-400 hover:text-gray-600 focus:ring-2 focus:ring-gray-300 rounded-lg p-1.5 inline-flex items-center">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>
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
