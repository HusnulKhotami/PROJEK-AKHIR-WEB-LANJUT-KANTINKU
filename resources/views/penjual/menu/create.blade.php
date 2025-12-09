@extends('layout.penjual', ['header' => 'Tambah Menu'])

@section('content')

<form action="{{ route('penjual.menu.store') }}" 
      method="POST" 
      enctype="multipart/form-data"
      class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200 space-y-6 transition">

    @csrf

    {{-- Nama Menu --}}
    <div>
        <label class="font-semibold text-gray-700 block mb-1">Nama Menu</label>
        <input type="text" 
               name="nama"
               required
               class="w-full px-4 py-3 border rounded-xl shadow-sm 
                      focus:ring-2 focus:ring-green-300 focus:border-green-500 transition"
               placeholder="Contoh: Nasi Goreng Spesial">
    </div>

    {{-- Kategori --}}
    <div>
        <label class="font-semibold text-gray-700 block mb-1">Kategori</label>
        <select name="kategori_id"
                required
                class="w-full px-4 py-3 border rounded-xl shadow-sm 
                       focus:ring-2 focus:ring-green-300 focus:border-green-500 transition">
            @foreach($kategori as $k)
                <option value="{{ $k->id }}">{{ $k->nama }}</option>
            @endforeach
        </select>
    </div>

    {{-- Deskripsi --}}
    <div>
        <label class="font-semibold text-gray-700 block mb-1">Deskripsi</label>
        <textarea name="deskripsi"
                  rows="3"
                  class="w-full px-4 py-3 border rounded-xl shadow-sm 
                         focus:ring-2 focus:ring-green-300 focus:border-green-500 transition"
                  placeholder="Contoh: Makanan favorit mahasiswa..."
                  required></textarea>
    </div>

    {{-- Harga & Stok --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <label class="font-semibold text-gray-700 block mb-1">Harga</label>
            <input type="number" 
                   name="harga" 
                   required
                   class="w-full px-4 py-3 border rounded-xl shadow-sm 
                          focus:ring-2 focus:ring-green-300 focus:border-green-500 transition"
                   placeholder="Contoh: 12000">
        </div>

        <div>
            <label class="font-semibold text-gray-700 block mb-1">Stok</label>
            <input type="number" 
                   name="stok" 
                   required
                   class="w-full px-4 py-3 border rounded-xl shadow-sm 
                          focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition"
                   placeholder="Jumlah stok">
        </div>

    </div>

    {{-- Upload Gambar --}}
    <div>
        <label class="font-semibold text-gray-700 block mb-2">Gambar Menu</label>

        <input type="file" 
               name="gambar"
               accept="image/*"
               class="w-full px-4 py-3 border rounded-xl bg-gray-50 shadow-sm cursor-pointer 
                      focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition">

        <p class="text-xs text-gray-500 mt-1">
            Format gambar: JPG, PNG, JPEG (maks 2MB)
        </p>
    </div>

    {{-- Tombol --}}
    <div class="flex justify-end gap-3 pt-4">

        <a href="{{ route('penjual.menu.index') }}"
           class="px-6 py-3 rounded-xl bg-gray-200 text-gray-700 hover:bg-gray-300 transition shadow-sm">
            Batal
        </a>

        <button type="submit"
                class="px-6 py-3 rounded-xl bg-green-600 text-white hover:bg-green-700 shadow-md transition">
            Simpan Menu
        </button>

    </div>

</form>

@endsection