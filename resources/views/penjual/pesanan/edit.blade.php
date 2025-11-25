<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Status Pesanan - KantinKu</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    .fade-in { animation: fadeIn 0.7s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .status-badge { display: inline-block; padding: 0.5rem 1rem; border-radius: 9999px; font-weight: 600; }
    .status-diproses { background-color: #fef3c7; color: #92400e; }
    .status-siap_diambil { background-color: #bfdbfe; color: #1e40af; }
    .status-selesai { background-color: #dcfce7; color: #166534; }
  </style>
</head>
<body class="bg-gray-50">

@include('landing.header-penjual')

<section class="relative pt-40 pb-32 text-center text-white fade-in bg-cover bg-center" style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}')">
  <div class="absolute inset-0 bg-green-900 bg-opacity-60"></div>
  <div class="relative max-w-3xl mx-auto px-6">
    <h2 class="text-4xl md:text-5xl font-bold mb-4 flex items-center justify-center gap-2">
      <i data-lucide="edit-3" class="w-8 h-8"></i>
      Update Status Pesanan
    </h2>
  </div>
</section>

<main class="max-w-2xl mx-auto py-16 px-6 fade-in">

  {{-- PESANAN INFO --}}
  <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <div class="grid grid-cols-2 gap-4 mb-6">
      <div>
        <p class="text-gray-600 text-sm">Nomor Pesanan</p>
        <p class="text-2xl font-bold text-green-700">#{{ $pesanan->id }}</p>
      </div>
      <div>
        <p class="text-gray-600 text-sm">Pembeli</p>
        <p class="text-lg font-semibold text-gray-800">{{ $pesanan->mahasiswa->nama }}</p>
      </div>
      <div>
        <p class="text-gray-600 text-sm">Total Harga</p>
        <p class="text-lg font-bold text-green-700">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
      </div>
      <div>
        <p class="text-gray-600 text-sm">Status Saat Ini</p>
        <p class="status-badge status-{{ $pesanan->status }} mt-1">
          @switch($pesanan->status)
            @case('diproses')
              ⏳ Diproses
            @break
            @case('siap_diambil')
              ✅ Siap Diambil
            @break
            @case('selesai')
              ✨ Selesai
            @break
            @default
              {{ ucfirst($pesanan->status) }}
          @endswitch
        </p>
      </div>
    </div>
  </div>

  {{-- ITEM PESANAN --}}
  <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
      <i data-lucide="shopping-bag" class="w-6 h-6 text-green-600"></i>
      Item Pesanan
    </h3>
    <div class="space-y-3">
      @foreach($pesanan->item as $item)
      <div class="flex justify-between items-center pb-3 border-b last:border-b-0">
        <div>
          <p class="font-semibold text-gray-800">{{ $item->menu->nama }}</p>
          <p class="text-sm text-gray-500">{{ $item->jumlah }}x @ Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
        </div>
        <p class="font-bold text-green-700">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
      </div>
      @endforeach
    </div>
  </div>

  {{-- FORM UPDATE STATUS --}}
  <div class="bg-white rounded-xl shadow-lg p-6">
    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
      <i data-lucide="git-branch" class="w-6 h-6 text-green-600"></i>
      Update Status Pesanan
    </h3>

    <form action="{{ route('penjual.pesanan.update', $pesanan->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-6">
        <label class="block text-gray-700 font-semibold mb-3">Pilih Status Baru</label>
        <div class="space-y-3">
          
          {{-- DIPROSES (hanya jika belum) --}}
          @if($pesanan->status === 'diproses')
            <div class="flex items-center p-4 border-2 border-yellow-300 rounded-lg bg-yellow-50">
              <input type="radio" name="status" value="diproses" checked disabled id="diproses"
                class="w-5 h-5 text-yellow-600">
              <label for="diproses" class="ml-3 cursor-pointer flex-1">
                <span class="font-semibold text-gray-800">⏳ Sedang Diproses</span>
                <p class="text-sm text-gray-600">Status pesanan saat ini</p>
              </label>
            </div>
          @endif

          {{-- SIAP DIAMBIL (dapat dari diproses atau sudah siap) --}}
          @if(in_array($pesanan->status, ['diproses', 'siap_diambil']))
            <div class="flex items-center p-4 border-2 border-blue-300 rounded-lg hover:bg-blue-50 transition">
              <input type="radio" name="status" value="siap_diambil"
                {{ $pesanan->status === 'siap_diambil' ? 'checked' : '' }}
                id="siap_diambil" class="w-5 h-5 text-blue-600">
              <label for="siap_diambil" class="ml-3 cursor-pointer flex-1">
                <span class="font-semibold text-gray-800">✅ Siap Diambil</span>
                <p class="text-sm text-gray-600">Pesanan sudah selesai dimasak dan siap diberikan ke pembeli</p>
              </label>
            </div>
          @endif

          {{-- SELESAI (dari siap_diambil) --}}
          @if(in_array($pesanan->status, ['siap_diambil', 'selesai']))
            <div class="flex items-center p-4 border-2 border-green-300 rounded-lg hover:bg-green-50 transition">
              <input type="radio" name="status" value="selesai"
                {{ $pesanan->status === 'selesai' ? 'checked' : '' }}
                id="selesai" class="w-5 h-5 text-green-600">
              <label for="selesai" class="ml-3 cursor-pointer flex-1">
                <span class="font-semibold text-gray-800">✨ Selesai</span>
                <p class="text-sm text-gray-600">Pesanan sudah diambil oleh pembeli, transaksi selesai</p>
              </label>
            </div>
          @endif

          {{-- DIBATALKAN (dari diproses atau siap) --}}
          @if(in_array($pesanan->status, ['diproses', 'siap_diambil']))
            <div class="flex items-center p-4 border-2 border-red-300 rounded-lg hover:bg-red-50 transition">
              <input type="radio" name="status" value="dibatalkan"
                id="dibatalkan" class="w-5 h-5 text-red-600">
              <label for="dibatalkan" class="ml-3 cursor-pointer flex-1">
                <span class="font-semibold text-gray-800">❌ Batalkan Pesanan</span>
                <p class="text-sm text-gray-600">Pesanan tidak dapat diproses (stok habis, dll)</p>
              </label>
            </div>
          @endif

        </div>
      </div>

      {{-- CATATAN (opsional) --}}
      <div class="mb-6">
        <label for="catatan" class="block text-gray-700 font-semibold mb-2">Catatan/Alasan Update (Opsional)</label>
        <textarea name="catatan" id="catatan" rows="3"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
          placeholder="Contoh: Pesanan sedang dimulai, akan selesai dalam 15 menit..."></textarea>
        <p class="text-sm text-gray-500 mt-1">Catatan ini akan dilihat oleh pembeli</p>
      </div>

      {{-- BUTTONS --}}
      <div class="flex gap-4">
        <a href="{{ route('penjual.pesanan.index') }}"
          class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-semibold px-6 py-3 rounded-lg transition text-center">
          Batal
        </a>
        <button type="submit"
          class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition flex items-center justify-center gap-2">
          <i data-lucide="check-circle" class="w-5 h-5"></i>
          Update Status
        </button>
      </div>
    </form>
  </div>

</main>

@include('landing.fotter')

<script src="https://unpkg.com/lucide@latest"></script>
<script>
  lucide.createIcons();

  // Show toast jika ada success
  @if(session('success'))
    showToast('{{ session("success") }}', 'success');
  @endif

  function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `fixed top-5 right-5 z-50 px-6 py-3 rounded-lg text-white font-semibold animate-bounce
      ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
  }
</script>

</body>

</html>

@endsection
