@extends('admin.layout')

@section('title', 'Manajemen Kategori')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Manajemen Kategori</h1>

    <a href="{{ route('admin.kategori.create') }}" 
       class="px-4 py-2 bg-blue-600 text-white rounded-lg">
        Tambah Kategori
    </a>
</div>

<div class="bg-white p-6 rounded-lg shadow">
    <table class="w-full border-collapse text-left">
        <thead>
            <tr class="border-b">
                <th class="py-3">Nama Kategori</th>
                <th class="py-3">Deskripsi</th>
                <th class="py-3">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($kategori as $k)
            <tr class="border-b">
                <td class="py-3">{{ $k->nama }}</td>
                <td class="py-3 text-gray-600">{{ $k->deskripsi ?? '-' }}</td>

                <td class="py-3 flex gap-3">
                    <a href="{{ route('admin.kategori.edit', $k->id) }}" class="text-blue-600">
                        Edit
                    </a>

                    <form action="{{ route('admin.kategori.delete', $k->id) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus kategori ini?')" 
                                class="text-red-600">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="py-4 text-center text-gray-600">
                    Belum ada kategori.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
