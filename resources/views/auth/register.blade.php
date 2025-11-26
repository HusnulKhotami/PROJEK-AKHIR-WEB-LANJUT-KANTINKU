<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KantinKu | Register</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">
  <div class="min-h-screen flex items-center justify-center p-4">
    <div class="flex w-full max-w-4xl bg-white rounded-2xl shadow-lg overflow-hidden">
      
    <div class="hidden md:flex flex-col justify-center items-center w-1/2 relative text-white p-10 overflow-hidden">
      <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}');"></div>
      <div class="absolute inset-0 bg-green-800 bg-opacity-70"></div>
      <div class="relative z-10 flex flex-col items-center text-center">
        <img src="https://cdn-icons-png.flaticon.com/512/3082/3082033.png" class="w-28 mb-6 mx-auto drop-shadow-lg">
        <h1 class="text-3xl font-bold mb-3">Selamat Datang di KantinKu</h1>
        <p class="text-white/90 text-sm max-w-sm leading-relaxed">
          Daftar sekarang dan nikmati pengalaman memesan makanan kampus dengan cepat, mudah, dan nyaman.
        </p>
      </div>
    </div>

      <div class="flex items-center justify-center w-full md:w-1/2 p-8">
        <div class="w-full max-w-sm">
          <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-green-600 flex justify-center items-center gap-2">
              <i data-lucide="user-plus" class="w-5 h-5"></i> Daftar Akun
            </h2>
            <p class="text-gray-500 text-sm mt-1">
              Bergabung dengan <span class="text-green-600 font-medium">KantinKu</span> sekarang juga
            </p>
          </div>

          @if (session('success'))
            <div class="mb-4 p-3 bg-green-500 text-white text-sm rounded-lg">
                {{ session('success') }}
            </div>
          @endif

          <form method="POST" action="{{ route('register') }}">
            @csrf

            @if ($errors->any())
              <div class="text-red-500 text-sm mb-3">
                @foreach ($errors->all() as $error)
                  <p>{{ $error }}</p>
                @endforeach
              </div>
            @endif

            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-medium mb-1">Nama Lengkap</label>
              <input type="text" name="nama" value="{{ old('nama') }}" required
                     placeholder="Masukkan nama lengkap"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-0 focus:border-gray-400">
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-medium mb-1">Email</label>
              <input type="email" name="email" value="{{ old('email') }}" required
                     placeholder="Masukkan email"
                     class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-0 focus:border-gray-400">
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-medium mb-1">Nomor HP</label>
              <input type="tel" name="phone" value="{{ old('phone') }}"
                     placeholder="Masukkan nomor handphone"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-0 focus:border-gray-400">
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-medium mb-1">Daftar Sebagai</label>
              <select name="role" required
                      class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-0 focus:border-gray-400">
                <option value="">-- Pilih Role --</option>
                <option value="mahasiswa" {{ old('role')=='mahasiswa'?'selected':'' }}>Mahasiswa</option>
                <option value="penjual" {{ old('role')=='penjual'?'selected':'' }}>Penjual</option>
              </select>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-medium mb-1">Kata Sandi</label>
              <input type="password" name="password" required
                     placeholder="Masukkan kata sandi"
                     class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-0 focus:border-gray-400">
            </div>

            <div class="mb-6">
              <label class="block text-gray-700 text-sm font-medium mb-1">Konfirmasi Kata Sandi</label>
              <input type="password" name="password_confirmation" required
                     placeholder="Ulangi kata sandi"
                     class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-0 focus:border-gray-400">
            </div>

            <button type="submit" class="w-full bg-green-600 text-white font-medium py-2 rounded-lg hover:bg-green-700 transition">
              Daftar
            </button>
          </form>

          <p class="text-center text-sm text-gray-600 mt-5">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-green-600 font-semibold hover:underline">Masuk Sekarang</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <script>lucide.createIcons();</script>
</body>
</html>
