@extends('layout.penjual', [
    'title' => 'Menu KantinKu - Penjual',
    'header' => 'Kelola Menu'
])

@section('content')

<!-- Success Alert -->
@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-6 flex items-center gap-3">
    <i class="fas fa-check-circle text-xl"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- Header with Add Button -->
<div class="flex items-center justify-between mb-8">
    <div>
        <p class="text-gray-600 text-sm">Kelola semua menu yang tersedia di kantin Anda</p>
    </div>
    <a href="{{ route('penjual.menu.create') }}"
        class="flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition-colors shadow-sm">
        <i class="fas fa-plus"></i>
        Tambah Menu
    </a>
</div>

<!-- Menu Grid Display -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($menu as $m)
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300 group">
        
        <!-- Image Container -->
        <div class="relative h-48 bg-gray-100 overflow-hidden">
            <img src="{{ $m->gambar_url }}" 
                 alt="{{ $m->nama }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                 onerror="if(this.src.startsWith('data:')) return; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 400 300%22%3E%3Crect fill=%22%23f3f4f6%22 width=%22400%22 height=%22300%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2220%22 fill=%22%239ca3af%22 text-anchor=%22middle%22 dy=%22.3em%22%3EImage Not Found%3C/text%3E%3C/svg%3E';">
            <div class="absolute top-3 right-3">
                <span class="px-3 py-1 bg-green-600 text-white text-xs font-semibold rounded-full">
                    Stok: {{ $m->stok }}
                </span>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4">
            <!-- Category -->
            <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-2">{{ $m->kategori->nama }}</p>
            
            <!-- Name -->
            <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">{{ $m->nama }}</h3>
            
            <!-- Price -->
            <p class="text-2xl font-bold text-green-600 mb-4">Rp {{ number_format($m->harga, 0, ',', '.') }}</p>
            
            <!-- Actions -->
            <div class="flex gap-2">
                <a href="{{ route('penjual.menu.edit', $m->id) }}"
                   class="flex-1 flex items-center justify-center gap-2 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition-colors text-sm">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>

                <form method="POST" action="{{ route('penjual.menu.destroy', $m->id) }}"
                    class="flex-1"
                    onsubmit="return confirm('Hapus menu ini?');">
                    @csrf @method('DELETE')
                    <button class="w-full flex items-center justify-center gap-2 px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 font-semibold transition-colors text-sm">
                        <i class="fas fa-trash"></i>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full">
        <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center">
            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-600 font-semibold mb-2">Belum ada menu</p>
            <p class="text-gray-500 text-sm mb-6">Mulai dengan menambahkan menu pertama Anda</p>
            <a href="{{ route('penjual.menu.create') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition-colors">
                <i class="fas fa-plus"></i>
                Tambah Menu Pertama
            </a>
        </div>
    </div>
    @endforelse
</div>

@endsection
