@extends('layout.penjual', [
    'title' => 'Menu KantinKu - Penjual',
    'header' => 'Kelola Menu'
])

@section('content')

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-6 flex items-center gap-3 shadow-sm">
    <i class="fas fa-check-circle text-xl"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<div class="flex items-center justify-between mb-6">
    <p class="text-gray-600 text-sm">Kelola semua menu yang tersedia di kantin Anda</p>

    <a href="{{ route('penjual.menu.create') }}"
        class="flex items-center gap-2 px-5 py-3 bg-green-600 text-white rounded-lg font-semibold shadow hover:bg-green-700 transition">
        <i class="fas fa-plus"></i>
        Tambah Menu
    </a>
</div>

<form method="GET" class="mb-6 bg-gray-50 p-4 rounded-xl border flex items-center gap-6">

    <div class="flex flex-col w-1/3">
        <label class="text-gray-600 text-sm mb-1 font-semibold">Cari Menu</label>
        <input type="text" name="search" value="{{ $search }}"
               placeholder="Cari nama menu..."
                class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-0 focus:border-gray-400">
    </div>

    <div class="flex flex-col w-1/3">
        <label class="text-gray-600 text-sm mb-1 font-semibold">Filter Kategori</label>
        <select name="kategori"
                 class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-0 focus:border-gray-400">
            <option value="">Semua Kategori</option>
            @foreach($kategori as $k)
                <option value="{{ $k->id }}" {{ $kategoriFilter == $k->id ? 'selected' : '' }}>
                    {{ $k->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex flex-col">
        <label class="opacity-0 mb-1">.</label> 
        <button class="px-5 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition w-fit">
            Terapkan
        </button>
    </div>
</form>

<div class="bg-white p-6 rounded-2xl shadow border border-gray-200 overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-100 text-gray-700 border-b text-sm">
                <th class="p-3 font-semibold">Gambar</th>
                <th class="p-3 font-semibold">Nama</th>
                <th class="p-3 font-semibold">Kategori</th>
                <th class="p-3 font-semibold">Harga</th>
                <th class="p-3 font-semibold">Stok</th>
                <th class="p-3 font-semibold text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($menu as $m)
            <tr class="border-b hover:bg-gray-50 transition">

                <td class="p-3">
                    <div class="h-16 w-16 rounded-lg overflow-hidden border shadow-sm bg-gray-100">
                        <img src="{{ $m->gambar_url }}"
                        alt="{{ $m->nama }}"
                        class="h-full w-full object-cover"
                        onerror="this.onerror=null;
                        this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 200 200%22%3E%3Crect width=%22200%22 height=%22200%22 fill=%22%23e5e7eb%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 fill=%22%239ca3af%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E';">
                    </div>
                </td>

                <td class="p-3 text-gray-800 font-semibold">{{ $m->nama }}</td>
                <td class="p-3 text-gray-600">{{ $m->kategori->nama }}</td>

                <td class="p-3 font-bold text-green-600">
                    Rp {{ number_format($m->harga, 0, ',', '.') }}
                </td>

                <td class="p-3">
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold shadow-sm">
                        {{ $m->stok }}
                    </span>
                </td>

                <td class="p-3">
                    <div class="flex items-center justify-center gap-3">

                        <a href="{{ route('penjual.menu.edit', $m->id) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition text-sm font-semibold flex items-center gap-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form method="POST" action="{{ route('penjual.menu.destroy', $m->id) }}"
                            onsubmit="return confirm('Hapus menu ini?');">
                            @csrf @method('DELETE')
                            <button
                                class="px-4 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition text-sm font-semibold flex items-center gap-2">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-6 text-center text-gray-500">
                    <div class="flex flex-col items-center py-6">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-600 font-semibold text-lg mb-2">Belum ada menu</p>
                        <p class="text-gray-500 text-sm mb-4">Tambahkan menu pertama Anda sekarang</p>
                        <a href="{{ route('penjual.menu.create') }}"
                            class="px-6 py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                            Tambah Menu
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>

    </table>
</div>
@endsection