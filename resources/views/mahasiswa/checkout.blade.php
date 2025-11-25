<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KantinKu | Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .fade-in { animation: fadeIn 0.7s ease-in-out; }
        @keyframes fadeIn { from {opacity:0; transform:translateY(10px)} to {opacity:1; transform:translateY(0)} }
        .payment-option:hover { transform: translateY(-2px); }
        .payment-option.active { border-color: #16a34a; background-color: #f0fdf4; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

    @include('landing.header-mhs')

    <section class="relative pt-40 pb-32 text-center text-white fade-in bg-cover bg-center"
        style="background-image: url('{{ asset('image/kantin-kampus.jpg') }}')">
        <div class="absolute inset-0 bg-green-900 bg-opacity-60"></div>
        <div class="relative max-w-3xl mx-auto px-6">
            <h2 class="text-4xl md:text-5xl font-bold mb-4 flex items-center justify-center gap-2">
                <i data-lucide="credit-card" class="w-8 h-8"></i>
                Checkout
            </h2>
            <p class="text-gray-200 text-lg">Selesaikan pemesanan Anda dengan memilih metode pembayaran</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto py-16 px-6 fade-in">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- LEFT: RINGKASAN PESANAN -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <h3 class="text-2xl font-bold text-green-700 mb-6 flex items-center gap-2">
                        <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                        Ringkasan Pesanan
                    </h3>

                    @foreach($grouped as $pedagang_id => $items)
                    <div class="mb-6 pb-6 border-b last:border-b-0">
                        <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i data-lucide="store" class="w-5 h-5 text-gray-500"></i>
                            Penjual #{{ $pedagang_id }}
                        </h4>

                        <div class="space-y-3">
                            @foreach($items as $item)
                            <div class="flex justify-between items-start gap-3 bg-gray-50 p-3 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $item->menu->nama }}</p>
                                    <p class="text-sm text-gray-500">{{ $item->jumlah }}x @ Rp {{ number_format($item->menu->harga, 0, ',', '.') }}</p>
                                </div>
                                <p class="font-semibold text-green-700">
                                    Rp {{ number_format($item->menu->harga * $item->jumlah, 0, ',', '.') }}
                                </p>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-4 text-right pt-3 border-t">
                            <p class="text-gray-600">Subtotal: <span class="font-bold text-gray-900">
                                Rp {{ number_format($items->sum(fn($i) => $i->menu->harga * $i->jumlah), 0, ',', '.') }}
                            </span></p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- RIGHT: FORM CHECKOUT -->
            <div class="lg:col-span-1">
                <!-- TOTAL HARGA -->
                <div class="bg-green-50 rounded-xl shadow-lg p-6 mb-6 sticky top-32">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Total Pembayaran</h4>
                    <div class="text-3xl font-bold text-green-700 mb-6">
                        Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}
                    </div>

                    <!-- FORM CHECKOUT -->
                    <form action="{{ route('mahasiswa.checkout.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- PILIHAN METODE PEMBAYARAN -->
                        <div class="space-y-3 mb-6">
                            <label class="block font-semibold text-gray-800 mb-3">Metode Pembayaran</label>

                            <!-- CASH -->
                            <label class="payment-option cursor-pointer border-2 border-gray-200 rounded-lg p-4 transition"
                                onclick="selectPayment('cash')">
                                <input type="radio" name="metode_pembayaran" value="cash" class="mr-3" required>
                                <span class="font-semibold text-gray-800">
                                    <i data-lucide="coins" class="w-5 h-5 inline mr-2"></i>
                                    Tunai (Cash)
                                </span>
                                <p class="text-sm text-gray-600 mt-1">Bayar langsung ke kasir saat mengambil pesanan</p>
                            </label>

                            <!-- TRANSFER -->
                            <label class="payment-option cursor-pointer border-2 border-gray-200 rounded-lg p-4 transition"
                                onclick="selectPayment('transfer')">
                                <input type="radio" name="metode_pembayaran" value="transfer" class="mr-3" required>
                                <span class="font-semibold text-gray-800">
                                    <i data-lucide="send" class="w-5 h-5 inline mr-2"></i>
                                    Transfer Bank
                                </span>
                                <p class="text-sm text-gray-600 mt-1">Upload bukti transfer untuk verifikasi admin</p>
                            </label>
                        </div>

                        <!-- UPLOAD BUKTI TRANSFER (Hidden by default) -->
                        <div id="transfer-section" class="hidden mb-6">
                            <label class="block font-semibold text-gray-800 mb-2">Bukti Transfer</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-green-500 transition">
                                <input type="file" name="bukti_transfer" id="bukti_transfer" class="hidden"
                                    accept="image/*" onchange="displayFileName(this)">
                                <label for="bukti_transfer" class="cursor-pointer">
                                    <i data-lucide="upload" class="w-8 h-8 text-gray-400 mx-auto mb-2"></i>
                                    <p class="text-sm text-gray-600">Klik atau drag gambar bukti transfer</p>
                                    <p class="text-xs text-gray-500">Max 2MB (JPG, PNG, GIF)</p>
                                </label>
                            </div>
                            <p id="file-name" class="text-sm text-gray-600 mt-2 hidden">File: <span id="file-text"></span></p>

                            @error('bukti_transfer')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- TOMBOL CHECKOUT -->
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition flex items-center justify-center gap-2">
                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                            Konfirmasi Pesanan
                        </button>

                        <a href="{{ route('mahasiswa.keranjang') }}"
                            class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 rounded-lg text-center transition mt-3 flex items-center justify-center gap-2">
                            <i data-lucide="arrow-left" class="w-5 h-5"></i>
                            Kembali
                        </a>
                    </form>

                    <!-- INFO -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mt-6">
                        <p class="text-sm text-blue-800">
                            <strong>Info:</strong> Pesanan Anda akan segera diproses oleh penjual setelah konfirmasi.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    @include('landing.fotter')

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        function selectPayment(method) {
            document.querySelectorAll('.payment-option').forEach(el => {
                el.classList.remove('active');
            });

            const selected = document.querySelector(`input[value="${method}"]`).parentElement.parentElement;
            selected.classList.add('active');

            // Toggle transfer section
            const transferSection = document.getElementById('transfer-section');
            const buktiTransferInput = document.getElementById('bukti_transfer');

            if (method === 'transfer') {
                transferSection.classList.remove('hidden');
                buktiTransferInput.required = true;
            } else {
                transferSection.classList.add('hidden');
                buktiTransferInput.required = false;
                buktiTransferInput.value = '';
                document.getElementById('file-name').classList.add('hidden');
            }
        }

        function displayFileName(input) {
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                const fileText = document.getElementById('file-text');
                fileText.textContent = fileName;
                document.getElementById('file-name').classList.remove('hidden');
            }
        }

        // Validate form sebelum submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const method = document.querySelector('input[name="metode_pembayaran"]:checked').value;
            if (method === 'transfer' && !document.getElementById('bukti_transfer').files[0]) {
                e.preventDefault();
                alert('Silakan upload bukti transfer terlebih dahulu!');
            }
        });
    </script>

</body>

</html>
