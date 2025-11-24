@extends('layout.penjual')

@section('content')

<form action="{{ route('penjual.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data"
      class="bg-white p-6 rounded-xl shadow space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="font-semibold">Nama Menu</label>
        <input type="text" name="nama" value="{{ $menu->nama }}" class="w-full px-4 py-2 border rounded-lg">
    </div>

    <div>
        <label class="font-semibold">Kategori</label>
        <select name="kategori_id" class="w-full px-4 py-2 border rounded-lg">
            @foreach($kategori as $k)
                <option value="{{ $k->id }}" {{ $menu->kategori_id == $k->id ? 'selected' : '' }}>
                    {{ $k->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="font-semibold">Deskripsi</label>
        <textarea name="deskripsi" class="w-full px-4 py-2 border rounded-lg">{{ $menu->deskripsi }}</textarea>
    </div>

    <div>
        <label class="font-semibold">Harga</label>
        <input type="number" name="harga" value="{{ $menu->harga }}" class="w-full px-4 py-2 border rounded-lg">
    </div>

    <div>
        <label class="font-semibold">Stok</label>
        <input type="number" name="stok" value="{{ $menu->stok }}" class="w-full px-4 py-2 border rounded-lg">
    </div>

    <div>
        <label class="font-semibold">Gambar Saat Ini</label>
        <img src="{{ asset('storage/' . $menu->gambar_url) }}" class="h-20 w-20 object-cover rounded mb-2">
        <input type="file" name="gambar" class="w-full px-4 py-2 border rounded-lg">
    </div>

    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        Update
    </button>
</form>

@endsection
