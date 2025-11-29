<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Pengguna | KantinKu</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50 text-gray-800">

  <div class="max-w-3xl mx-auto mt-12">

  

    <h2 class="text-3xl font-bold text-green-700 mb-6">
      Edit Pengguna
    </h2>

    <div class="bg-white shadow-lg rounded-2xl p-6">

      <form action="{{ route('admin.pengguna.update', $user->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
          <label class="block mb-1 font-semibold">Nama Lengkap</label>
          <input 
            type="text"
            name="nama"
            value="{{ $user->name }}"
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400"
            required
          >
        </div>

        <div>
          <label class="block mb-1 font-semibold">Email</label>
          <input 
            type="email"
            name="email"
            value="{{ $user->email }}"
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400"
            required
          >
        </div>

        <div>
          <label class="block mb-1 font-semibold">Role</label>
          <select 
            name="role"
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400"
          >
            <option value="mahasiswa" {{ $user->role == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
            <option value="penjual" {{ $user->role == 'penjual' ? 'selected' : '' }}>Penjual</option>
          </select>
        </div>

        <div class="flex items-center gap-3 pt-4">

          <button 
            type="submit"
            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 flex items-center gap-2"
          >
            <i data-lucide="save" class="w-5 h-5"></i>
            Simpan Perubahan
          </button>

          <a 
            href="/admin/pengguna"
            class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-300 flex items-center gap-2"
          >
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
            Kembali
          </a>

        </div>

      </form>

    </div>

  </div>

  <script>
    lucide.createIcons();
  </script>

</body>
</html>
