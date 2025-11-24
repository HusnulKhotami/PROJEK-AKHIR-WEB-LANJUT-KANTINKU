@extends('layout.penjual', [
    'title' => 'Pesanan Masuk - Penjual',
    'header' => 'Pesanan Masuk'
])

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-100 text-gray-700 border-b">
                <th class="p-3">Mahasiswa</th>
                <th class="p-3">Total Harga</th>
                <th class="p-3">Status</th>
                <th class="p-3 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($pesanan as $p)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $p->mahasiswa->name }}</td>
                    <td class="p-3 font-semibold">Rp {{ number_format($p->total_harga,0,',','.') }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-white
                            @if($p->status == 'Diproses') bg-yellow-500
                            @elseif($p->status == 'Siap Diambil') bg-blue-500
                            @else bg-green-600 @endif">
                            {{ $p->status }}
                        </span>
                    </td>
                    <td class="p-3 text-center">
                        <a href="{{ route('penjual.pesanan.edit', $p->id) }}"
                        class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Update Status
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-600 p-4">
                        Belum ada pesanan masuk
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
