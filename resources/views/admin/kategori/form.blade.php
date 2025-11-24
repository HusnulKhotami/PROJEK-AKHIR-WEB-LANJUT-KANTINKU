@extends('admin.layout')

@section('title', $mode == 'create' ? 'Tambah Kategori' : 'Edit Kategori')

@section('content')

<h1 class="text-xl font-semibold mb-6">
    {{ $mode == 'create' ? 'Tambah Kategori' : 'Edit Kategori' }}
</h1>

<div class="bg-white p-6 rounded-lg shadow w-full max-w-xl">

    <form action="{{ $mode == 'create' 
        ? route('admin.kategori.store') 
        : route('admin.kategori.update', $kategori->id) }}" 
        method="POST">

        @csrf

        @if($mode == 'edit')
            @method('PUT')
        @endif

        <div class="mb-4">
            <label class="block mb-2 font-medium">Nama Kategori</label>
            <input type="text" name="nama" 
                   value="{{ $kategori->nama ?? '' }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium">Deskripsi</label>
            <textarea name="deskripsi" 
                      class="w-full border px-3 py-2 rounded">{{ $kategori->deskripsi ?? '' }}</textarea>
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Simpan
        </button>

        <a href="{{ route('admin.kategori.index') }}" 
           class="ml-3 text-gray-600">
            Batal
        </a>
    </form>
</div>

@endsection
