@extends('layout.penjual', ['title'=>'Pesanan Masuk - Penjual','header'=>'Pesanan Masuk'])

@section('content')

{{-- ALERT --}}
@foreach (['success'=>'green','error'=>'red'] as $key=>$color)
    @if(session($key))
        <div class="bg-{{ $color }}-100 border border-{{ $color }}-400 text-{{ $color }}-700 px-4 py-2 rounded mb-4">
            {{ session($key) }}
        </div>
    @endif
@endforeach

<div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-100 text-gray-700 border-b">
                <th class="p-3">Mahasiswa</th>
                <th class="p-3">Menu</th>
                <th class="p-3">Catatan</th>
                <th class="p-3">Total</th>
                <th class="p-3">Status</th>
                <th class="p-3 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($pesanan as $p)
            <tr class="border-b hover:bg-gray-50">

                <td class="p-3">{{ $p->mahasiswa->nama ?? '-' }}</td>

                <td class="p-3">
                    @foreach ($p->items as $i)
                        • {{ $i->menu->nama }} ({{ $i->jumlah }}) <br>
                    @endforeach
                </td>

                <td class="p-3">{{ $p->catatan ? $p->catatan : '-' }}</td>

                <td class="p-3 font-semibold">
                    Rp {{ number_format($p->total_harga,0,',','.') }}
                </td>

                <td class="p-3">
                    <span class="
                        px-2 py-1 rounded text-white
                        {{ $p->status == 'proses' ? 'bg-yellow-500' : '' }}
                        {{ $p->status == 'siap' ? 'bg-blue-500' : '' }}
                        {{ $p->status == 'selesai' ? 'bg-green-600' : '' }}
                        {{ $p->status == 'dibatalkan' ? 'bg-red-600' : '' }}
                    ">
                        {{ ucfirst($p->status) }}
                    </span>
                </td>

                <td class="p-3 text-center">
                    <div class="flex justify-center gap-3">

                        <button 
                            onclick="openModal('{{ $p->id }}','{{ $p->status }}')" 
                            class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Update
                        </button>

                        @if(in_array($p->status,['selesai','dibatalkan']))
                        <button 
                            onclick="openDeleteModal('{{ $p->id }}')" 
                            class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Hapus
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-gray-600 p-4">Belum ada pesanan masuk</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="modalUpdate" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center">
    <div class="bg-white p-6 rounded-xl shadow w-96">
        <h3 class="text-xl font-semibold mb-4">Update Status</h3>

        <form id="formUpdate" method="POST">
            @csrf @method('PUT')

            <select id="statusSelect" name="status" class="w-full border p-3 rounded-lg mb-4">
                <option value="proses">Diproses</option>
                <option value="siap">Siap Diambil</option>
                <option value="selesai">Selesai</option>
                <option value="dibatalkan">Dibatalkan</option>
            </select>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalDelete" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center">
    <div class="bg-white p-6 rounded-xl shadow w-96">
        <h3 class="text-xl font-semibold text-red-600 mb-4">Hapus Pesanan?</h3>
        <p class="mb-4">Pesanan yang dihapus tidak dapat dipulihkan.</p>

        <form id="formDelete" method="POST">
            @csrf @method('DELETE')

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg">Hapus</button>
            </div>
        </form>
    </div>
</div>

<script>
    const show = (id) => document.getElementById(id).classList.replace('hidden','flex');
    const hide = (id) => document.getElementById(id).classList.add('hidden');

    function openModal(id, status){
        show('modalUpdate');
        document.getElementById('statusSelect').value = status;
        document.getElementById('formUpdate').action = "/penjual/pesanan/" + id;
    }
    const closeModal = () => hide('modalUpdate');

    function openDeleteModal(id){
        show('modalDelete');
        document.getElementById('formDelete').action = "/penjual/pesanan/" + id;
    }
    const closeDeleteModal = () => hide('modalDelete');
</script>

@endsection
