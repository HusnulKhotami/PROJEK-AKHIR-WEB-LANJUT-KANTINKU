@extends('layout.penjual', [
    'title' => 'Edit Menu - Penjual',
    'header' => 'Edit Menu'
])

@section('content')

@if($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-xl mb-6 shadow-sm">
    <ul class="list-disc pl-6">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('penjual.menu.update', $menu->id) }}" 
      method="POST" 
      enctype="multipart/form-data"
      class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200 space-y-6 transition">

    @csrf
    @method('PUT')

    <!-- Nama Menu -->
    <div>
        <label class="font-semibold text-gray-700 block mb-1">Nama Menu</label>
        <input type="text" 
               name="nama" 
               value="{{ $menu->nama }}"
               class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-green-300 focus:border-green-500 transition"
               placeholder="Masukkan nama menu"
               required>
    </div>

    <!-- Kategori -->
    <div>
        <label class="font-semibold text-gray-700 block mb-1">Kategori</label>
        <select name="kategori_id"
                class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-green-300 focus:border-green-500 transition"
                required>
            @foreach($kategori as $k)
                <option value="{{ $k->id }}" {{ $menu->kategori_id == $k->id ? 'selected' : '' }}>
                    {{ $k->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Deskripsi -->
    <div>
        <label class="font-semibold text-gray-700 block mb-1">Deskripsi</label>
        <textarea name="deskripsi"
                  rows="3"
                  class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-green-300 focus:border-green-500 transition"
                  placeholder="Masukkan deskripsi menu"
                  required>{{ $menu->deskripsi }}</textarea>
    </div>

    <!-- Harga & Stok -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="font-semibold text-gray-700 block mb-1">Harga</label>
            <input type="number" 
                   name="harga" 
                   value="{{ $menu->harga }}"
                   class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-green-300 focus:border-green-500 transition"
                   placeholder="Contoh: 12000"
                   required>
        </div>

        <div>
            <label class="font-semibold text-gray-700 block mb-1">Stok</label>
            <input type="number" 
                   name="stok" 
                   value="{{ $menu->stok }}"
                   class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition"
                   placeholder="Jumlah stok"
                   required>
        </div>
    </div>

    <!-- Gambar -->
    <div>
        <label class="font-semibold text-gray-700 block mb-2">Gambar Saat Ini</label>

        <div class="flex items-center gap-4 mb-3">
            <img src="{{ $menu->gambar_url }}"
                 alt="Gambar Menu"
                 class="h-24 w-24 rounded-xl object-cover border shadow-sm"
                 onerror="this.onerror=null; this.src='https://via.placeholder.com/100?text=No+Image';">
        </div>

        <input type="file" 
               name="gambar"
               class="w-full px-4 py-3 border rounded-xl bg-gray-50 shadow-sm cursor-pointer 
                      focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition">

        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah gambar</p>
    </div>

    <!-- Tombol -->
    <div class="flex justify-end gap-3 pt-4">
        <a href="{{ route('penjual.menu.index') }}"
           class="px-6 py-3 rounded-xl bg-gray-200 text-gray-700 hover:bg-gray-300 transition shadow-sm">
            Batal
        </a>

        <button class="px-6 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700 shadow-md transition">
            Update Menu
        </button>
    </div>

</form>

@endsection
