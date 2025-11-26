<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Status Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50 text-gray-800">

@include('landing.header-mhs')

<section class="relative pt-40 pb-28 text-center text-white bg-cover bg-center"
  style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}')">
  <div class="absolute inset-0 bg-green-900 bg-opacity-60"></div>

  <div class="relative max-w-3xl mx-auto px-6">
    <h2 class="text-4xl font-bold mb-4">Status Pesanan</h2>
    <p class="text-gray-200">Pantau pesanan aktif Anda.</p>
  </div>
</section>

{{-- list pesanan --}}
<section class="max-w-7xl mx-auto py-16 px-6">

<h3 class="text-3xl font-bold text-green-700 mb-10 flex items-center gap-2">
  <i data-lucide="clock" class="w-8 h-8"></i> Daftar Pesanan Aktif
</h3>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">

@forelse ($pesanan as $p)
<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 transition">

  <div class="flex items-start justify-between mb-4">
    <div>
      <h4 class="text-2xl font-bold">{{ $p->pedagang->nama_kantin }}</h4>
      <p class="text-gray-500 text-sm flex items-center gap-1">
        <i data-lucide="map-pin" class="w-4 h-4"></i> {{ $p->pedagang->lokasi }}
      </p>
    </div>

    <span class="px-4 py-1 text-sm rounded-full text-white font-semibold
      {{ $p->status == 'proses' ? 'bg-yellow-500' :
         ($p->status == 'siap' ? 'bg-green-600' : 'bg-gray-400') }}">
      {{ ucfirst($p->status) }}
    </span>
  </div>

  <div class="space-y-3 text-gray-700">
    <p class="flex gap-2">
      <i data-lucide="shopping-bag" class="w-5 h-5 text-green-600"></i>
      Total: <strong class="text-green-700">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</strong>
    </p>

    <p class="flex gap-2">
      <i data-lucide="wallet" class="w-5 h-5 text-green-600"></i>
      Metode: <strong>{{ ucfirst($p->metode_pembayaran) }}</strong>
    </p>

    <p class="flex gap-2 text-sm text-gray-500">
      <i data-lucide="clock" class="w-4 h-4"></i>
      {{ $p->created_at->format('d M Y, H:i') }}
    </p>
  </div>

  <div class="mt-6 flex justify-between items-center">

    <a href="{{ route('mahasiswa.detail-pesanan', $p->id) }}"
        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg flex items-center gap-2">
      <i data-lucide="eye" class="w-4 h-4"></i> Detail
    </a>

    @if($p->status == 'proses')
    <button onclick="openPopup('{{ $p->id }}')"
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
        <i data-lucide="x-circle" class="w-4 h-4"></i> Batalkan
    </button>
    @endif

  </div>
</div>

@empty
<p class="col-span-full text-center text-gray-500 py-20 text-lg">
  Tidak ada pesanan aktif.
</p>
@endforelse

</div>
</section>

@include('landing.fotter')


<div id="popupBatal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
  <div class="bg-white rounded-xl p-6 w-96 text-center shadow-xl">

    <h2 class="text-xl font-bold mb-3 text-red-600">Batalkan Pesanan?</h2>
    <p class="text-gray-600 mb-5">Apakah Anda yakin ingin membatalkan pesanan ini?</p>

    <form id="formBatal" method="POST">
        @csrf
        @method('POST')
        <button class="bg-red-600 text-white px-4 py-2 rounded-lg w-full mb-2">Ya, Batalkan</button>
    </form>

    <button onclick="closePopup()" 
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg w-full">
      Tidak
    </button>
  </div>
</div>

<script>
  lucide.createIcons();

  function openPopup(id) {
      document.getElementById('popupBatal').classList.remove('hidden');
      document.getElementById('popupBatal').classList.add('flex');
      document.getElementById('formBatal').action = "/mahasiswa/pesanan/" + id + "/batal";
  }

  function closePopup() {
      document.getElementById('popupBatal').classList.add('hidden');
  }
</script>

</body>
</html>
