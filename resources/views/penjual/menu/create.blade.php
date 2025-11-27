@extends('layout.penjual')

@section('content')

<div class="max-w-3xl">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Tambah Menu Baru</h2>
        <p class="text-gray-600">Isi informasi lengkap untuk menu baru Anda</p>
    </div>

    <form action="{{ route('penjual.menu.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 space-y-6">
        @csrf

        <!-- Nama Menu -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                <i class="fas fa-tag text-green-600 mr-2"></i>Nama Menu
            </label>
            <input type="text" name="nama" placeholder="Contoh: Nasi Goreng Spesial"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                   required>
        </div>

        <!-- Kategori & Harga (2 columns) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-list text-green-600 mr-2"></i>Kategori
                </label>
                <select name="kategori_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                        required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-coins text-green-600 mr-2"></i>Harga (Rp)
                </label>
                <input type="number" name="harga" placeholder="0"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                       required>
            </div>
        </div>

        <!-- Stok & Gambar (2 columns) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-box text-green-600 mr-2"></i>Stok Awal
                </label>
                <input type="number" name="stok" placeholder="0"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                       required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-image text-green-600 mr-2"></i>Gambar Menu
                </label>
                <input type="file" name="gambar" accept="image/*"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 file:bg-green-50 file:border-0 file:rounded file:px-3 file:py-2 file:text-green-600 file:font-semibold"
                       required>
            </div>
        </div>

        <!-- Deskripsi -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                <i class="fas fa-align-left text-green-600 mr-2"></i>Deskripsi
            </label>
            <textarea name="deskripsi" placeholder="Jelaskan bahan dan keunggulan menu ini..."
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"
                      rows="4"></textarea>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3 pt-6 border-t border-gray-200">
            <a href="{{ route('penjual.menu.index') }}"
               class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-colors text-center">
                Batal
            </a>
            <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition-colors flex items-center justify-center gap-2">
                <i class="fas fa-check"></i>
                Simpan Menu
            </button>
        </div>
    </form>
</div>

@endsection
