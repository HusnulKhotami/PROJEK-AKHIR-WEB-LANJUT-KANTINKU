<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Pengguna | KantinKu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50 text-gray-800">

  <div class="max-w-3xl mx-auto mt-10">

    <!-- Notifikasi BERHASIL -->
    @if(session('success'))
      <div class="mb-6 bg-green-100 text-green-700 px-4 py-3 rounded-lg border border-green-300 flex items-center gap-2">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <span>{{ session('success') }}</span>
      </div>
    @endif

    <!-- Notifikasi GAGAL UMUM -->
    @if(session('error'))
      <div class="mb-6 bg-red-100 text-red-700 px-4 py-3 rounded-lg border border-red-300 flex items-center gap-2">
        <i data-lucide="x-circle" class="w-5 h-5"></i>
        <span>{{ session('error') }}</span>
      </div>
    @endif

    <!-- Notifikasi Validasi -->
    @if ($errors->any())
      <div class="mb-6 bg-red-100 text-red-700 px-4 py-3 rounded-lg border border-red-300">
        <div class="flex items-center gap-2 mb-2">
          <i data-lucide="alert-triangle" class="w-5 h-5"></i>
          <span><strong>Terjadi kesalahan:</strong></span>
        </div>
        <ul class="list-disc ml-6">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <h2 class="text-3xl font-bold text-green-700 mb-6">Tambah Pengguna</h2>

    <div class="bg-white shadow-lg rounded-2xl p-6">

      <form action="{{ route('admin.pengguna.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
          <label class="block mb-1 font-semibold">Nama Lengkap</label>
          <input 
            type="text" 
            name="nama"
            value="{{ old('nama') }}"
            required
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400"
            placeholder="Masukkan nama pengguna">
        </div>

        <div>
          <label class="block mb-1 font-semibold">Email</label>
          <input 
            type="email" 
            name="email"
            value="{{ old('email') }}"
            required
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400"
            placeholder="Masukkan email">
        </div>

        <div>
          <label class="block mb-1 font-semibold">Role</label>
          <select 
            name="role"
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400">
            <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
            <option value="penjual" {{ old('role') == 'penjual' ? 'selected' : '' }}>Penjual</option>
          </select>
        </div>

        <div class="flex items-center gap-3 mt-6">
          <button 
            type="submit"
            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 flex items-center gap-2">
            <i data-lucide="save" class="w-5 h-5"></i>
            Simpan Pengguna
          </button>

          <a 
            href="{{ route('admin.pengguna') }}"
            class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-300 flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
            Kembali
          </a>
        </div>

      </form>

    </div>

  </div>

  <script>lucide.createIcons();</script>
</body>
</html>
