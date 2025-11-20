@extends('layout.penjual', [
    'title' => 'Menu KantinKu - Penjual',
    'header' => 'Kelola Menu'
])

@section('content')

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<div class="flex justify-end mb-4">
    <a href="{{ route('penjual.menu.create') }}"
        class="px-4 py-2 bg-green-600 text-white rounded-lg shadow">+ Tambah Menu</a>
</div>

<div class="bg-white p-6 rounded-xl shadow overflow-x-auto">

    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-100 text-gray-700 border-b">
                <th class="p-3">Gambar</th>
                <th class="p-3">Nama</th>
                <th class="p-3">Kategori</th>
                <th class="p-3">Harga</th>
                <th class="p-3">Stok</th>
                <th class="p-3 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($menu as $m)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">
                   <img src="{{ $m->gambar_url }}" class="h-16 w-16 object-cover rounded">
                </td>
                <td class="p-3">{{ $m->nama }}</td>
                <td class="p-3">{{ $m->kategori->nama }}</td>
                <td class="p-3">Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
                <td class="p-3">{{ $m->stok }}</td>
                <td class="p-3 text-center">
                    <a href="{{ route('penjual.menu.edit', $m->id) }}"
                       class="px-3 py-1 bg-blue-600 text-white rounded-lg">Edit</a>

                    <form method="POST" action="{{ route('penjual.menu.destroy', $m->id) }}"
                        class="inline-block"
                        onsubmit="return confirm('Hapus menu ini?');">
                        @csrf @method('DELETE')
                        <button class="px-3 py-1 bg-red-500 text-white rounded-lg">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

</div>

@endsection
