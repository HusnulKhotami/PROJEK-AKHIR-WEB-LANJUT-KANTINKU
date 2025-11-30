@extends('layout.penjual', ['header' => 'Kelola Menu'])

@section('content')

<form action="{{ route('penjual.menu.store') }}" method="POST" enctype="multipart/form-data"
      class="bg-white p-6 rounded-xl shadow space-y-4">
    @csrf

    <div>
        <label class="font-semibold">Nama Menu</label>
        <input type="text" name="nama" class="w-full px-4 py-2 border rounded-lg">
    </div>

    <div>
        <label class="font-semibold">Kategori</label>
        <select name="kategori_id" class="w-full px-4 py-2 border rounded-lg">
            @foreach($kategori as $k)
                <option value="{{ $k->id }}">{{ $k->nama }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="font-semibold">Deskripsi</label>
        <textarea name="deskripsi" class="w-full px-4 py-2 border rounded-lg"></textarea>
    </div>

    <div>
        <label class="font-semibold">Harga</label>
        <input type="number" name="harga" class="w-full px-4 py-2 border rounded-lg">
    </div>

    <div>
        <label class="font-semibold">Stok</label>
        <input type="number" name="stok" class="w-full px-4 py-2 border rounded-lg">
    </div>

    <div>
        <label class="font-semibold">Gambar Menu</label>
        <input type="file" name="gambar" class="w-full px-4 py-2 border rounded-lg">
    </div>

    <div class="flex gap-3 pt-3">
        <a href="{{ route('penjual.menu.index') }}"
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
            Batal
        </a>

        <button type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            Simpan
        </button>
    </div>

</form>

@endsection
