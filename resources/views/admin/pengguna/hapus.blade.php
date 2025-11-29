<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hapus Pengguna | KantinKu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50 text-gray-800">
  <div class="max-w-lg mx-auto mt-20">

    <div class="bg-white shadow rounded-2xl p-8 text-center">

      <i data-lucide="alert-triangle" class="w-14 h-14 text-red-600 mx-auto mb-4"></i>

      <h2 class="text-2xl font-bold text-red-600 mb-4">Hapus Pengguna?</h2>

      <p class="text-gray-700 mb-8 leading-relaxed">
        Apakah Anda yakin ingin menghapus pengguna
        <strong>“Elena Oktaviani”</strong>?  
        Tindakan ini tidak dapat dibatalkan.
      </p>

      <div class="flex justify-center gap-4">
        <a href="/admin/pengguna"
           class="px-5 py-2 border border-gray-300 rounded-lg hover:bg-gray-100">
          Batal
        </a>

        <a href="/admin/pengguna?hapus=1"
           class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
          Hapus
        </a>
      </div>

    </div>

  </div>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
