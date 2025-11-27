@extends('layout.penjual', ['title'=>'Pesanan Masuk - Penjual','header'=>'Pesanan Masuk'])

@section('content')

<!-- Alerts -->
@foreach (['success'=>'green','error'=>'red'] as $key=>$color)
    @if(session($key))
        <div class="bg-{{ $color }}-100 border border-{{ $color }}-400 text-{{ $color }}-700 px-6 py-4 rounded-lg mb-6 flex items-center gap-3">
            <i class="fas fa-{{ $key === 'success' ? 'check-circle' : 'exclamation-circle' }} text-xl"></i>
            <span>{{ session($key) }}</span>
        </div>
    @endif
@endforeach

<!-- Header -->
<div class="mb-8">
    <p class="text-gray-600 text-sm">Kelola pesanan yang masuk dari pembeli</p>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    
    <!-- Table Header -->
    <div class="px-8 py-6 border-b border-gray-200 bg-gray-50">
        <h2 class="text-lg font-bold text-gray-800">Daftar Pesanan</h2>
    </div>

    <!-- Table Content -->
    <div class="overflow-x-auto">
        @forelse($pesanan as $p)
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Mahasiswa</th>
                    <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Menu</th>
                    <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Catatan</th>
                    <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Total</th>
                    <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-8 py-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanan as $p)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                    <td class="px-8 py-4">
                        <p class="font-medium text-gray-800">{{ $p->mahasiswa->nama ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $p->mahasiswa->nomor_induk ?? '-' }}</p>
                    </td>

                    <td class="px-8 py-4">
                        <div class="text-sm space-y-1">
                            @foreach ($p->items as $i)
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    {{ $i->menu->nama }} <span class="text-gray-500">(x{{ $i->jumlah }})</span>
                                </div>
                            @endforeach
                        </div>
                    </td>

                    <td class="px-8 py-4 text-sm">
                        <p class="text-gray-700">{{ $p->catatan ? $p->catatan : '-' }}</p>
                    </td>

                    <td class="px-8 py-4">
                        <p class="font-bold text-green-600">Rp {{ number_format($p->total_harga,0,',','.') }}</p>
                    </td>

                    <td class="px-8 py-4">
                        @if($p->status == 'proses')
                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full font-medium">
                                <span class="w-2 h-2 bg-yellow-600 rounded-full animate-pulse"></span>
                                Diproses
                            </span>
                        @elseif($p->status == 'siap')
                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full font-medium">
                                <span class="w-2 h-2 bg-blue-600"></span>
                                Siap Ambil
                            </span>
                        @elseif($p->status == 'selesai')
                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">
                                <span class="w-2 h-2 bg-green-600"></span>
                                Selesai
                            </span>
                        @elseif($p->status == 'dibatalkan')
                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full font-medium">
                                <span class="w-2 h-2 bg-red-600"></span>
                                Dibatalkan
                            </span>
                        @endif
                    </td>

                    <td class="px-8 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <button 
                                onclick="openModal('{{ $p->id }}','{{ $p->status }}')" 
                                class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition-colors text-sm flex items-center gap-1">
                                <i class="fas fa-edit"></i>
                                Update
                            </button>

                            @if(in_array($p->status,['selesai','dibatalkan']))
                            <button 
                                onclick="openDeleteModal('{{ $p->id }}')" 
                                class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition-colors text-sm flex items-center gap-1">
                                <i class="fas fa-trash"></i>
                                Hapus
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-12 text-center">
                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4 block"></i>
                        <p class="text-gray-600 font-semibold">Belum ada pesanan masuk</p>
                        <p class="text-gray-500 text-sm mt-1">Pesanan akan muncul di sini setelah pembeli melakukan pemesanan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @empty
        <div class="px-8 py-12 text-center">
            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-600 font-semibold">Belum ada pesanan masuk</p>
            <p class="text-gray-500 text-sm mt-1">Pesanan akan muncul di sini setelah pembeli melakukan pemesanan</p>
        </div>
        @endforelse
    </div>

</div>

<!-- Update Modal -->
<div id="modalUpdate" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4">
        
        <!-- Modal Header -->
        <div class="px-8 py-6 border-b border-gray-200 bg-blue-50">
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-edit text-blue-600"></i>
                Update Status Pesanan
            </h3>
        </div>

        <!-- Modal Content -->
        <form id="formUpdate" method="POST" class="p-8">
            @csrf @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-tasks text-blue-600 mr-2"></i>Status Pesanan
                </label>
                <select id="statusSelect" name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="proses">Diproses</option>
                    <option value="siap">Siap Diambil</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-colors">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-check"></i>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div id="modalDelete" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4">
        
        <!-- Modal Header -->
        <div class="px-8 py-6 border-b border-red-100 bg-red-50">
            <h3 class="text-xl font-bold text-red-600 flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                Hapus Pesanan?
            </h3>
        </div>

        <!-- Modal Content -->
        <div class="px-8 py-6">
            <p class="text-gray-700 mb-6">Pesanan yang dihapus tidak dapat dipulihkan. Apakah Anda yakin?</p>

            <form id="formDelete" method="POST" class="flex gap-3">
                @csrf @method('DELETE')

                <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-colors">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-trash"></i>
                    Hapus
                </button>
            </form>
        </div>
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
