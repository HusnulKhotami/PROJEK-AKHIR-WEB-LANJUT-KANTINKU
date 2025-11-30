@extends('layout.admin')

@section('title', 'Data Pengguna | KantinKu')

@section('content')

<main class="flex-1 p-8" x-data="penggunaModal()">

    <h2 class="text-3xl font-bold text-green-700 mb-8">
        Manajemen Data Pengguna
    </h2>

    <!-- FILTER + TOMBOL TAMBAH -->
    <div class="flex justify-between items-center mb-6">

        <!-- Dropdown Filter -->
        <div x-data="{ open:false }" class="relative">
            <button @click="open = !open"
                class="px-4 py-2 bg-green-600 text-white rounded-lg shadow flex items-center gap-2 hover:bg-green-700 transition">

                {{ ucfirst($type ?? 'semua') }}

                <i data-lucide="chevron-down" class="w-4 h-4"></i>
            </button>

            <div x-show="open" @click.outside="open = false"
                class="absolute mt-2 w-40 bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden z-50">

                <a href="/admin/pengguna?type=semua"
                   class="block px-4 py-2 hover:bg-green-100 {{ $type=='semua' ? 'bg-green-200 font-semibold' : '' }}">
                    Semua
                </a>
                <a href="/admin/pengguna?type=mahasiswa"
                   class="block px-4 py-2 hover:bg-green-100 {{ $type=='mahasiswa' ? 'bg-green-200 font-semibold' : '' }}">
                    Mahasiswa
                </a>
                <a href="/admin/pengguna?type=penjual"
                   class="block px-4 py-2 hover:bg-green-100 {{ $type=='penjual' ? 'bg-green-200 font-semibold' : '' }}">
                    Penjual
                </a>

            </div>
        </div>

        <!-- Tombol Tambah (POPUP) -->
        <button @click="openCreateModal()"
           class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Pengguna
        </button>

    </div>

    <!-- TABEL -->
    <div class="bg-white rounded-2xl shadow p-6">

        <table class="w-full border-collapse rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-green-600 text-white">
                    <th class="py-3 px-4 text-left">Nama</th>
                    <th class="py-3 px-4 text-left">Email</th>
                    <th class="py-3 px-4 text-left">Role</th>
                    <th class="py-3 px-4 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($users as $user)
                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="px-4 py-3">{{ $user->nama }}</td>
                    <td class="px-4 py-3">{{ $user->email }}</td>
                    <td class="px-4 py-3 capitalize">{{ $user->role }}</td>

                    <td class="px-4 py-3 flex gap-2">

                        <button
                            @click="openEditModal({ id:'{{ $user->id }}', nama:'{{ $user->nama }}', email:'{{ $user->email }}', role:'{{ $user->role }}' })"
                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded-lg shadow">
                            <i data-lucide='pencil' class='w-4 h-4'></i> Edit
                        </button>

                        <button
                            @click="openDeleteModal({ id:'{{ $user->id }}', nama:'{{ $user->nama }}' })"
                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg shadow">
                            <i data-lucide='trash-2' class='w-4 h-4'></i> Hapus
                        </button>

                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-500 italic">
                        Belum ada data pengguna.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>

    </div>

    <!-- ======================= MODAL CREATE ======================= -->
    <div x-show="showCreate" class="modal-overlay">

        <div class="modal-box">

            <h2 class="modal-title">Tambah Pengguna</h2>

            <form action="{{ route('admin.pengguna.store') }}" method="POST">
                @csrf

                <div class="modal-field">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" required>
                </div>

                <div class="modal-field">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="modal-field">
                    <label>Role</label>
                    <select name="role">
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="penjual">Penjual</option>
                    </select>
                </div>

                <div class="modal-action">
                    <button type="button" @click="closeAll()" class="btn-cancel">Batal</button>
                    <button class="btn-save">Simpan</button>
                </div>

            </form>

        </div>

    </div>

    <!-- ======================= MODAL EDIT ======================= -->
    <div x-show="showEdit" class="modal-overlay">

        <div class="modal-box">

            <h2 class="modal-title">Edit Pengguna</h2>

            <form :action="'/admin/pengguna/update/' + formEdit.id" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-field">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" x-model="formEdit.nama" required>
                </div>

                <div class="modal-field">
                    <label>Email</label>
                    <input type="email" name="email" x-model="formEdit.email" required>
                </div>

                <div class="modal-field">
                    <label>Role</label>
                    <select name="role" x-model="formEdit.role">
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="penjual">Penjual</option>
                    </select>
                </div>

                <div class="modal-action">
                    <button type="button" @click="closeAll()" class="btn-cancel">Batal</button>
                    <button class="btn-save">Simpan Perubahan</button>
                </div>

            </form>

        </div>

    </div>

    <!-- ======================= MODAL DELETE ======================= -->
    <div x-show="showDelete" class="modal-overlay">

        <div class="modal-box">

            <h2 class="modal-title text-red-600">Hapus Pengguna</h2>

            <p class="text-gray-700 my-4">
                Yakin ingin menghapus
                <strong x-text="formDelete.nama"></strong>?
            </p>

            <form :action="'/admin/pengguna/destroy/' + formDelete.id" method="POST">
                @csrf @method('DELETE')

                <div class="modal-action">
                    <button type="button" @click="closeAll()" class="btn-cancel">Batal</button>
                    <button class="btn-delete">Hapus</button>
                </div>

            </form>

        </div>

    </div>

</main>


<!-- ======================== STYLE GLOBAL POPUP ======================== -->
<style>
.modal-overlay {
    position: fixed;
    inset: 0;
    background: #00000050;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 50;
}

.modal-box {
    background: white;
    width: 420px;
    max-width: 95%;
    padding: 24px;
    border-radius: 20px;
    box-shadow: 0 10px 25px #00000030;
    animation: fadeIn .25s ease;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #166534;
    margin-bottom: 16px;
}

.modal-field label {
    font-weight: 600;
    display: block;
    margin-bottom: 4px;
}

.modal-field input,
.modal-field select {
    width: 100%;
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    margin-bottom: 16px;
}

.modal-action {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 10px;
}

.btn-cancel {
    background: #e5e7eb;
    padding: 8px 16px;
    border-radius: 8px;
}

.btn-save {
    background: #16a34a;
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
}

.btn-delete {
    background: #dc2626;
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

<!-- ======================== SCRIPT ALPINE MODAL ======================== -->
<script>
function penggunaModal() {
    return {
        showCreate: false,
        showEdit: false,
        showDelete: false,

        formEdit: {},
        formDelete: {},

        openCreateModal() {
            this.closeAll();
            this.showCreate = true;
        },

        openEditModal(data) {
            this.closeAll();
            this.formEdit = data;
            this.showEdit = true;
        },

        openDeleteModal(data) {
            this.closeAll();
            this.formDelete = data;
            this.showDelete = true;
        },

        closeAll() {
            this.showCreate = false;
            this.showEdit = false;
            this.showDelete = false;
        }
    }
}
</script>

@endsection