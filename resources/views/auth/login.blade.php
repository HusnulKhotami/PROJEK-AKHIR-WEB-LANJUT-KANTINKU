<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KantinKu | Login</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in {
      animation: slideDown 0.5s ease-in-out;
    }
  </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans relative">

  @if (session('success'))
    <div 
      x-data="{ show: true }"
      x-show="show"
      x-transition
      x-init="setTimeout(() => show = false, 3000)"
      class="fixed top-6 right-6 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-lg flex items-center px-5 py-3 fade-in z-50"
    >
      <i data-lucide="check-circle" class="w-6 h-6 text-green-600 mr-2"></i>
      <span class="font-medium">{{ session('success') }}</span>
    </div>
  @endif


  @if (session('status'))
    <div 
      x-data="{ show: true }"
      x-show="show"
      x-transition
      x-init="setTimeout(() => show = false, 3000)"
      class="fixed top-6 right-6 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-lg flex items-center px-5 py-3 fade-in z-50"
    >
      <i data-lucide="info" class="w-6 h-6 text-blue-600 mr-2"></i>
      <span class="font-medium">{{ session('status') }}</span>
    </div>
  @endif

  @if (session('error'))
    <div 
      x-data="{ show: true }"
      x-show="show"
      x-transition
      x-init="setTimeout(() => show = false, 3000)"
      class="fixed top-6 right-6 bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-lg flex items-center px-5 py-3 fade-in z-50"
    >
      <i data-lucide="alert-circle" class="w-6 h-6 text-red-600 mr-2"></i>
      <span class="font-medium">{{ session('error') }}</span>
    </div>
  @endif


  <div class="min-h-screen flex items-center justify-center p-4">
    <div class="flex w-full max-w-4xl bg-white rounded-2xl shadow-lg overflow-hidden fade-in">

      <!-- Bagian kiri (gambar) -->
      <div class="hidden md:flex flex-col justify-center items-center w-1/2 relative text-white p-10 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}');"></div>
        <div class="absolute inset-0 bg-green-800 bg-opacity-70"></div>
        <div class="relative z-10 text-center">
          <img src="https://cdn-icons-png.flaticon.com/512/3082/3082033.png" class="w-28 mb-6 mx-auto drop-shadow-lg">
          <h1 class="text-3xl font-bold mb-3">Selamat Datang di KantinKu</h1>
          <p class="text-white/90 text-sm max-w-sm leading-relaxed">
            Nikmati pengalaman memesan makanan kampus dengan mudah, cepat, dan nyaman.
          </p>
        </div>
      </div>

      <!-- Bagian kanan (form login) -->
      <div class="flex items-center justify-center w-full md:w-1/2 p-10">
        <div class="w-full max-w-sm">

          <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-green-600 flex justify-center items-center gap-2">
              <i data-lucide="log-in" class="w-5 h-5"></i> Masuk
            </h2>
            <p class="text-gray-500 text-sm mt-1">
              Masuk untuk melanjutkan ke <span class="text-green-600 font-medium">KantinKu</span>
            </p>
          </div>

          <form method="POST" action="{{ route('login') }}">
            @csrf

            @error('email')
              <p class="text-red-500 text-sm text-center mb-3">{{ $message }}</p>
            @enderror

            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-medium mb-1">Email</label>
              <input type="email" name="email" required
                     placeholder="Masukkan email"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-0 focus:border-gray-400">
            </div>

            <div class="mb-6">
              <label class="block text-gray-700 text-sm font-medium mb-1">Kata Sandi</label>
              <input type="password" name="password" required
                     placeholder="Masukkan kata sandi"
                     class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-0 focus:border-gray-400">
            </div>

            <button type="submit"
                    class="w-full bg-green-600 text-white font-medium py-2 rounded-lg hover:bg-green-700 transition">
              Masuk
            </button>
          </form>

          <p class="text-center text-sm text-gray-600 mt-5">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-green-600 font-semibold hover:underline">Daftar Sekarang</a>
          </p>

        </div>
      </div>

    </div>
  </div>

  <script>lucide.createIcons();</script>
</body>
</html>
