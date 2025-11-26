@extends('layout.penjual')

@section('content')

<div class="max-w-3xl">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Update Status Pesanan</h2>
        <p class="text-gray-600">Ubah status pesanan untuk memberitahu pembeli tentang perkembangan pesanan mereka</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 space-y-6">

        <!-- Order Details Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-gray-200">
            <div>
                <p class="text-sm text-gray-600 font-semibold mb-1">Pemesan</p>
                <p class="text-lg font-bold text-gray-800">{{ $pesanan->mahasiswa->nama ?? 'Tidak diketahui' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 font-semibold mb-1">Total Pesanan</p>
                <p class="text-lg font-bold text-green-600">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Status Update Form -->
        <form action="{{ route('penjual.pesanan.update', $pesanan->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-tasks text-blue-600 mr-2"></i>Status Pesanan
                </label>
                <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="proses" {{ $pesanan->status == 'proses' ? 'selected' : '' }}>
                        <i class="fas fa-hourglass-half mr-2"></i>Diproses
                    </option>
                    <option value="siap" {{ $pesanan->status == 'siap' ? 'selected' : '' }}>
                        <i class="fas fa-check-circle mr-2"></i>Siap Diambil
                    </option>
                    <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>
                        <i class="fas fa-check-double mr-2"></i>Selesai
                    </option>
                    <option value="dibatalkan" {{ $pesanan->status == 'dibatalkan' ? 'selected' : '' }}>
                        <i class="fas fa-times-circle mr-2"></i>Dibatalkan
                    </option>
                </select>
            </div>

            <!-- Status Description -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-900">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Status saat ini:</strong>
                    @if($pesanan->status == 'proses')
                        Pesanan sedang diproses oleh dapur
                    @elseif($pesanan->status == 'siap')
                        Pesanan siap diambil oleh pembeli
                    @elseif($pesanan->status == 'selesai')
                        Pesanan telah selesai dan diambil
                    @elseif($pesanan->status == 'dibatalkan')
                        Pesanan telah dibatalkan
                    @endif
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('penjual.pesanan.index') }}"
                   class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-colors text-center">
                    Batal
                </a>
                <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
