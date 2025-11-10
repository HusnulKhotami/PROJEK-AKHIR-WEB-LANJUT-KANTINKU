<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'KantinKu | Pesan Makanan Kampus Lebih Mudah')</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    .fade-in { animation: fadeIn 0.8s ease-in-out; }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

 @include('landing.header')

  {{-- Konten Halaman --}}
  <main class="pt-20">
    @yield('content')
  </main>

  {{-- Footer --}}
  @include('landing.fotter')

  <script> lucide.createIcons(); </script>
</body>
</html>
