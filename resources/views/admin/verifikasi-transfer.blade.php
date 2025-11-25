<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verifikasi Transfer - KantinKu Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    .fade-in { animation: fadeIn 0.7s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
  </style>
</head>
<body class="bg-gray-50">

<header class="bg-green-700 text-white shadow-lg sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
    <h1 class="text-2xl font-bold flex items-center gap-2">
      <i data-lucide="shield-check" class="w-6 h-6"></i>
      KantinKu Admin
    </h1>
    <nav class="flex gap-4">
      <a href="{{ route('admin.dashboard') }}" class="hover:text-green-200 transition">Dashboard</a>
      <a href="{{ route('admin.verifikasi.index') }}" class="text-green-200 font-semibold">Verifikasi Transfer</a>
      <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="hover:text-red-300 transition">Logout</button>
      </form>
    </nav>
  </div>
</header>

<section class="max-w-7xl mx-auto py-12 px-6 fade-in">

  <div class="mb-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-4 flex items-center gap-2">
      <i data-lucide="check-square" class="w-8 h-8 text-green-600"></i>
      Verifikasi Transfer Pembayaran
    </h2>
    <p class="text-gray-600">Verifikasi bukti transfer untuk aktivasi pesanan</p>
  </div>

  {{-- SUMMARY CARD --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-yellow-50 border-2 border-yellow-300 rounded-xl p-6">
      <p class="text-yellow-700 font-semibold text-lg">Transfer Pending</p>
      <p class="text-3xl font-bold text-yellow-600">{{ $totalPending }}</p>
    </div>
    <div class="bg-blue-50 border-2 border-blue-300 rounded-xl p-6">
      <p class="text-blue-700 font-semibold text-lg">Total Nominal</p>
      <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
    </div>
  </div>

  {{-- TOAST SUCCESS --}}
  @if(session('success'))
    <div class="mb-6 bg-green-100 border-l-4 border-green-600 text-green-800 p-4 rounded" id="toast">
      <p class="font-semibold">✅ {{ session('success') }}</p>
    </div>
  @endif

  {{-- LIST TRANSFER PENDING --}}
  @if($transaksi->isEmpty())
    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
      <i data-lucide="check-circle" class="w-16 h-16 text-green-300 mx-auto mb-4"></i>
      <p class="text-gray-500 text-lg">Semua transfer sudah terverifikasi! 🎉</p>
    </div>
  @else
    <div class="space-y-6">
      @foreach($transaksi as $trx)
        <div class="bg-white rounded-xl shadow-md border-2 border-yellow-200 p-6">
          
          {{-- HEADER --}}
          <div class="flex justify-between items-start mb-4">
            <div>
              <h3 class="text-xl font-bold text-gray-800">Pesanan #{{ $trx->pesanan->id }}</h3>
              <p class="text-gray-600">
                <strong>Pembeli:</strong> {{ $trx->pesanan->mahasiswa->nama }}
              </p>
              <p class="text-gray-600">
                <strong>Penjual:</strong> {{ $trx->pesanan->pedagang->nama_toko }}
              </p>
            </div>
            <div class="text-right">
              <p class="text-3xl font-bold text-green-700">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</p>
              <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold mt-2">
                ⏳ Pending
              </span>
            </div>
          </div>

          {{-- BUKTI TRANSFER --}}
          @if($trx->bukti_transfer)
          <div class="mb-6 pb-6 border-b">
            <p class="font-semibold text-gray-800 mb-3">Bukti Transfer</p>
            <img src="{{ asset('storage/' . $trx->bukti_transfer) }}" alt="Bukti Transfer" 
              class="max-w-md rounded-lg border border-gray-300 cursor-pointer hover:opacity-75"
              onclick="openImageModal(this.src)">
          </div>
          @endif

          {{-- FORM VERIFIKASI --}}
          <form action="{{ route('admin.verifikasi.update', $trx->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
              <label class="block text-gray-700 font-semibold mb-2">Status Verifikasi</label>
              <div class="flex gap-4">
                <label class="flex items-center gap-2 cursor-pointer p-3 border-2 border-green-300 rounded-lg hover:bg-green-50">
                  <input type="radio" name="status" value="verified" class="w-5 h-5 text-green-600">
                  <span>✅ Terima Transfer</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer p-3 border-2 border-red-300 rounded-lg hover:bg-red-50">
                  <input type="radio" name="status" value="rejected" class="w-5 h-5 text-red-600">
                  <span>❌ Tolak Transfer</span>
                </label>
              </div>
            </div>

            <div class="mb-4">
              <label for="catatan" class="block text-gray-700 font-semibold mb-2">Catatan Admin (Opsional)</label>
              <textarea name="catatan" id="catatan" rows="3" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                placeholder="Contoh: Transfer sudah terverifikasi di rekening tujuan..."></textarea>
            </div>

            <div class="flex gap-4">
              <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition flex items-center justify-center gap-2">
                <i data-lucide="save" class="w-5 h-5"></i>
                Proses Verifikasi
              </button>
            </div>
          </form>

        </div>
      @endforeach
    </div>
  @endif

</section>

<!-- IMAGE MODAL -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-6" onclick="closeImageModal()">
  <div class="relative max-w-2xl" onclick="event.stopPropagation()">
    <img id="modalImage" src="" alt="Bukti Transfer" class="rounded-lg max-h-[90vh]">
    <button onclick="closeImageModal()" class="absolute top-2 right-2 bg-white rounded-full p-2 hover:bg-gray-200">
      <i data-lucide="x" class="w-6 h-6"></i>
    </button>
  </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
  lucide.createIcons();

  function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
  }

  function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
  }

  // Auto-hide toast
  const toast = document.getElementById('toast');
  if (toast) {
    setTimeout(() => toast.remove(), 3000);
  }
</script>

</body>
</html>
