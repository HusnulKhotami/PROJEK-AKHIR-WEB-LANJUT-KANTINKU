@extends('layout.penjual')

@section('content')

<div class="max-w-3xl">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Edit Menu</h2>
        <p class="text-gray-600">Perbarui informasi menu Anda</p>
    </div>

    <form action="{{ route('penjual.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 space-y-6">
        @csrf
        @method('PUT')

        <!-- Nama Menu -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                <i class="fas fa-tag text-blue-600 mr-2"></i>Nama Menu
            </label>
            <input type="text" name="nama" value="{{ $menu->nama }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                   required>
        </div>

        <!-- Kategori & Harga (2 columns) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-list text-blue-600 mr-2"></i>Kategori
                </label>
                <select name="kategori_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ $menu->kategori_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-coins text-blue-600 mr-2"></i>Harga (Rp)
                </label>
                <input type="number" name="harga" value="{{ $menu->harga }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
            </div>
        </div>

        <!-- Stok & Gambar (2 columns) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-box text-blue-600 mr-2"></i>Stok
                </label>
                <input type="number" name="stok" value="{{ $menu->stok }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-image text-blue-600 mr-2"></i>Gambar Menu
                </label>
                <input type="file" name="gambar" accept="image/*"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 file:bg-blue-50 file:border-0 file:rounded file:px-3 file:py-2 file:text-blue-600 file:font-semibold">
            </div>
        </div>

        <!-- Current Image Preview -->
        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
            <p class="text-sm font-semibold text-gray-700 mb-3">Gambar Saat Ini</p>
            <img src="{{ $menu->gambar_url }}" 
                 alt="{{ $menu->nama }}" 
                 class="h-32 w-32 object-cover rounded-lg"
                 onerror="if(this.src.startsWith('data:')) return; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 300 300%22%3E%3Crect fill=%22%23f3f4f6%22 width=%22300%22 height=%22300%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2216%22 fill=%22%239ca3af%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E';">
        </div>

        <!-- Deskripsi -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                <i class="fas fa-align-left text-blue-600 mr-2"></i>Deskripsi
            </label>
            <textarea name="deskripsi"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                      rows="4">{{ $menu->deskripsi }}</textarea>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3 pt-6 border-t border-gray-200">
            <a href="{{ route('penjual.menu.index') }}"
               class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-colors text-center">
                Batal
            </a>
            <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition-colors flex items-center justify-center gap-2">
                <i class="fas fa-sync"></i>
                Update Menu
            </button>
        </div>
    </form>
</div>

@endsection
