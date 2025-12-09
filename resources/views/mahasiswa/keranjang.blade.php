<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KantinKu | Keranjang</title>

  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>

  <script>
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.check-item:checked').forEach(cb => {
            let harga = parseInt(cb.dataset.harga);
            let jumlah = parseInt(document.getElementById("jumlah-" + cb.value).value);
            total += harga * jumlah;
        });
        document.getElementById("total-belanja").innerText = "Rp " + total.toLocaleString('id-ID');
    }
  </script>
</head>

<body class="bg-gray-50 text-gray-800">

@include('landing.header-mhs')

<main class="pt-32 pb-20 max-w-7xl mx-auto px-6">

<h2 class="text-3xl font-bold text-green-700 mb-8 flex items-center gap-2">
    <i data-lucide="shopping-cart"></i> Keranjang Belanja
</h2>

@if($keranjang->count() == 0)

<div class="bg-white shadow-xl rounded-2xl p-14 text-center">
    <i data-lucide="shopping-bag" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
    <p class="text-gray-600 text-lg mb-4">Keranjang kamu masih kosong.</p>

    <a href="{{ route('mahasiswa.menu-mhs') }}"
       class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl inline-block">
       Lihat Menu
    </a>
</div>

@else

{{-- ================= FORM CHECKOUT BESAR ================= --}}
<form action="{{ route('mahasiswa.keranjang.checkout') }}" method="POST">
@csrf

<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

{{-- ================= LIST ITEM ================= --}}
<div class="lg:col-span-2 space-y-5">

@foreach ($keranjang as $item)
@if($item->menu)

<div class="bg-white shadow-md rounded-xl p-5 flex gap-5 items-center">

    {{-- Checkbox --}}
    <input type="checkbox" class="check-item w-5 h-5"
           name="selected[]" value="{{ $item->id }}"
           data-harga="{{ $item->menu->harga }}"
           onchange="updateTotal()">

    {{-- Gambar --}}
    <img src="{{ $item->menu->gambar_url ?? asset('image/menu/default.png') }}"
         class="w-24 h-24 rounded-xl object-cover">

    <div class="flex-1">
        <h3 class="text-xl font-semibold text-green-700">{{ $item->menu->nama }}</h3>
        <p class="text-gray-600 text-sm">{{ $item->menu->deskripsi }}</p>
        <p class="text-lg font-bold text-green-800">Rp {{ number_format($item->menu->harga) }}</p>
    </div>

    {{-- BUTTON KURANG --}}
    <button type="button"
        onclick="document.getElementById('form-kurang-{{ $item->id }}').submit()"
        class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-lg font-bold">
        −
    </button>

    {{-- INPUT JUMLAH --}}
    <input id="jumlah-{{ $item->id }}" 
           type="number" min="1"
           value="{{ $item->jumlah }}"
           name="jumlah[{{ $item->id }}]"
           class="w-16 text-center border rounded-lg"
           oninput="updateTotal()">

    {{-- BUTTON TAMBAH --}}
    <button type="button"
        onclick="document.getElementById('form-tambah-{{ $item->id }}').submit()"
        class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg font-bold">
        +
    </button>

    {{-- BUTTON HAPUS --}}
    <button type="button"
        onclick="document.getElementById('form-hapus-{{ $item->id }}').submit()"
        class="text-red-500 hover:text-red-700 p-2">
        <i data-lucide="trash-2" class="w-5 h-5"></i>
    </button>

</div>

@endif
@endforeach

</div>

{{-- ================= RINGKASAN ================= --}}
<div class="bg-white shadow-xl rounded-2xl p-8 border-t-4 border-green-600 h-fit">

    <h3 class="text-xl font-bold mb-4">Ringkasan Belanja</h3>

    <p id="total-belanja" class="text-2xl font-bold text-green-700 mb-6">Rp 0</p>

    <textarea name="catatan" class="w-full border rounded-xl p-3 mb-4"
              rows="3" placeholder="Catatan..."></textarea>

    <select name="metode_pembayaran" class="w-full border rounded-xl p-3 mb-6" required>
        <option value="">-- Pilih Metode --</option>
        <option value="cash">Cash</option>
        <option value="transfer">Transfer Bank</option>
    </select>

    <button type="submit"
            class="bg-green-600 hover:bg-green-700 w-full py-4 rounded-xl text-white font-semibold text-lg">
        Checkout
    </button>

</div>

</div>
</form>

@endif

{{-- ======== FORM-FORM YANG DIPINDAHKAN KE LUAR (FIX) ======== --}}
@foreach ($keranjang as $item)
@if($item->menu)

{{-- FORM KURANG --}}
<form id="form-kurang-{{ $item->id }}" action="{{ route('mahasiswa.keranjang.kurang') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="id" value="{{ $item->id }}">
</form>

{{-- FORM TAMBAH --}}
<form id="form-tambah-{{ $item->id }}" action="{{ route('mahasiswa.keranjang.tambah') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="id_menu" value="{{ $item->menu->id }}">
    <input type="hidden" name="jumlah" value="1">
</form>

{{-- FORM HAPUS --}}
<form id="form-hapus-{{ $item->id }}" action="{{ route('mahasiswa.keranjang.hapus') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="id" value="{{ $item->id }}">
</form>

@endif
@endforeach

</main>

@include('landing.fotter')
<script>lucide.createIcons();</script>

</body>
</html>
