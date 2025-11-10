<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Verifikasi Email | KantinKu</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-50 flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-lg rounded-xl p-10 text-center max-w-md">
    <h2 class="text-2xl font-bold text-green-700 mb-4">Verifikasi Email Kamu</h2>
    <p class="text-gray-600 mb-6">
      Kami sudah mengirim link verifikasi ke email kamu.<br>
      Silakan cek email untuk mengaktifkan akun.
    </p>

    @if (session('message'))
      <div class="text-green-600 mb-4 font-medium">{{ session('message') }}</div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
      @csrf
      <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition">
        Kirim Ulang Link Verifikasi
      </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-4">
      @csrf
      <button type="submit" class="text-gray-500 text-sm hover:underline">Keluar</button>
    </form>
  </div>
</body>
</html>
