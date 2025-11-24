@extends('layout.penjual')

@section('content')

<h2 class="text-2xl font-bold mb-4">Update Status Pesanan</h2>

<div class="bg-white p-6 rounded-xl shadow w-full md:w-2/3">

    <form action="{{ route('penjual.pesanan.update', $pesanan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label class="block mb-3">
            <span class="text-gray-700 font-medium">Status Pesanan</span>
            <select name="status" class="w-full border p-3 rounded-lg">
                <option {{ $pesanan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option {{ $pesanan->status == 'Siap Diambil' ? 'selected' : '' }}>Siap Diambil</option>
                <option {{ $pesanan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </label>

        <button class="px-4 py-2 bg-green-600 text-white rounded-lg shadow">
            Simpan
        </button>

        <a href="{{ route('penjual.pesanan.index') }}" class="ml-2 text-gray-500">
            Batal
        </a>
    </form>
</div>

@endsection
