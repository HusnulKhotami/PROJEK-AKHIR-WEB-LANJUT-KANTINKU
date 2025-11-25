# 🛒 Complete Checkout Flow Guide - KantinKu

## 📋 Analisis & Solusi Masalah Checkout

### Masalah: Setelah klik "Konfirmasi Pesanan", halaman tetap di `/mahasiswa/checkout`

---

## ✅ Checklist Diagnosis

### 1. ✅ Form Action (sudah benar)
```html
<form action="{{ route('mahasiswa.checkout.store') }}" method="POST" enctype="multipart/form-data">
```
**Status**: ✅ Correct
- Menggunakan `route()` helper (tidak hardcoded)
- Method: `POST` (bukan GET)
- Enctype: `multipart/form-data` (untuk file upload)

### 2. ✅ Route Definition (sudah benar)
```php
// routes/web.php
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
```
**Status**: ✅ Correct
- GET route untuk menampilkan form
- POST route untuk memproses form
- Kedua route terpisah (tidak akan conflict)

### 3. ✅ Controller - store() Method (sudah benar)
```php
// Redirect setelah sukses
return redirect()
    ->route('mahasiswa.detail-pesanan', $pesananPertama)
    ->with('success', 'Checkout berhasil!');

// Jika ada error
return back()->with('error', 'Checkout gagal: ...');
```
**Status**: ✅ Correct
- Redirect ke `detail-pesanan` (bukan kembali ke checkout)
- Membawa success message

### 4. ⚠️ Kemungkinan Masalah

#### Masalah A: Validation Error Tidak Ditampilkan
**Gejala**: Form di-submit, tapi halaman tetap di checkout tanpa error message

**Solusi**: 
- Tambahkan error display di view (sudah dilakukan ✅)
- Periksa browser console untuk error JavaScript
- Check Laravel log file

#### Masalah B: Form Data Tidak Ter-kirim
**Gejala**: Form ter-submit tapi `metode_pembayaran` tidak terdeteksi

**Penyebab**:
- Radio button tidak ter-select saat submit
- JavaScript `selectPayment()` event tidak trigger
- Form submit terpicu sebelum radio button ter-set

**Solusi**: Lihat poin 5 di bawah

#### Masalah C: Button Submit Tidak Trigger Form Submit
**Gejala**: Klik tombol tapi form tidak ter-submit ke server

**Solusi**: Pastikan button type = "submit"
```html
<button type="submit" ...>Konfirmasi Pesanan</button>
```

---

## 🔧 Complete Checkout Alur (Form + Controller + Redirect)

### Step 1: View - Tampilkan Form Checkout
**File**: `resources/views/mahasiswa/checkout.blade.php`

```html
<!-- Error Display -->
@if ($errors->any())
<div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
    <h4 class="font-bold text-red-800 mb-3">Terjadi Kesalahan:</h4>
    <ul class="text-red-700 space-y-1 text-sm">
        @foreach ($errors->all() as $error)
        <li>• {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Form -->
<form action="{{ route('mahasiswa.checkout.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <!-- Pilihan Pembayaran -->
    <div class="space-y-3 mb-6">
        <label class="block font-semibold text-gray-800 mb-3">Metode Pembayaran</label>
        
        <!-- CASH Option -->
        <label class="payment-option cursor-pointer border-2 border-gray-200 rounded-lg p-4 transition"
            onclick="selectPayment('cash')">
            <input type="radio" name="metode_pembayaran" value="cash" class="mr-3" required>
            <span class="font-semibold">Tunai (Cash)</span>
        </label>
        
        <!-- TRANSFER Option -->
        <label class="payment-option cursor-pointer border-2 border-gray-200 rounded-lg p-4 transition"
            onclick="selectPayment('transfer')">
            <input type="radio" name="metode_pembayaran" value="transfer" class="mr-3" required>
            <span class="font-semibold">Transfer Bank</span>
        </label>
    </div>
    
    <!-- File Upload (Hidden by default) -->
    <div id="transfer-section" class="hidden mb-6">
        <label class="block font-semibold text-gray-800 mb-2">Bukti Transfer</label>
        <input type="file" name="bukti_transfer" id="bukti_transfer" accept="image/*" required>
        
        @error('bukti_transfer')
        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>
    
    <!-- Submit Button -->
    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg"
        id="checkout-btn">
        <span id="btn-text">Konfirmasi Pesanan</span>
    </button>
</form>
```

---

### Step 2: JavaScript - Handle Form Validation
```javascript
function selectPayment(method) {
    // Update UI
    document.querySelectorAll('.payment-option').forEach(el => {
        el.classList.remove('active');
    });
    document.querySelector(`input[value="${method}"]`).parentElement.parentElement.classList.add('active');
    
    // Toggle transfer section
    const transferSection = document.getElementById('transfer-section');
    const buktiInput = document.getElementById('bukti_transfer');
    
    if (method === 'transfer') {
        transferSection.classList.remove('hidden');
        buktiInput.required = true;
    } else {
        transferSection.classList.add('hidden');
        buktiInput.required = false;
        buktiInput.value = '';
    }
}

// Form validation sebelum submit
document.querySelector('form').addEventListener('submit', function(e) {
    const method = document.querySelector('input[name="metode_pembayaran"]:checked');
    
    // Cek metode pembayaran dipilih
    if (!method) {
        e.preventDefault();
        alert('Silakan pilih metode pembayaran!');
        return;
    }
    
    // Cek file diupload untuk transfer
    if (method.value === 'transfer' && !document.getElementById('bukti_transfer').files[0]) {
        e.preventDefault();
        alert('Silakan upload bukti transfer!');
        return;
    }
    
    // Show loading state
    const btn = document.getElementById('checkout-btn');
    btn.disabled = true;
    document.getElementById('btn-text').textContent = 'Memproses...';
});
```

---

### Step 3: Controller - Process & Redirect
**File**: `app/Http/Controllers/mahasiswa/CheckoutController.php`

```php
public function store(Request $request)
{
    // Log for debugging
    \Log::info('Checkout store initiated', [
        'user_id' => auth()->id(),
        'method' => $request->get('metode_pembayaran'),
        'has_file' => $request->hasFile('bukti_transfer'),
        'all_data' => $request->all()
    ]);
    
    // STEP 1: Validate Input
    $validated = $request->validate([
        'metode_pembayaran' => 'required|in:cash,transfer',
        'bukti_transfer' => 'nullable|image|max:2048|required_if:metode_pembayaran,transfer'
    ], [
        'metode_pembayaran.required' => 'Silakan pilih metode pembayaran',
        'metode_pembayaran.in' => 'Metode pembayaran tidak valid',
        'bukti_transfer.required_if' => 'Bukti transfer harus diupload untuk metode transfer',
        'bukti_transfer.image' => 'File harus berupa gambar',
        'bukti_transfer.max' => 'Ukuran file maksimal 2MB'
    ]);
    
    \Log::info('Validation passed', $validated);
    
    // STEP 2: Check Cart
    $keranjang = Keranjang::where('user_id', auth()->id())
        ->with('menu')
        ->get();
    
    if ($keranjang->isEmpty()) {
        return back()->with('error', 'Keranjang masih kosong!');
    }
    
    // STEP 3: Filter Valid Items
    $keranjang = $keranjang->filter(fn($item) => $item->menu !== null);
    
    if ($keranjang->isEmpty()) {
        return back()->with('error', 'Menu tidak tersedia!');
    }
    
    // STEP 4: Begin Transaction
    DB::beginTransaction();
    
    try {
        $grouped = $keranjang->groupBy(fn($item) => $item->menu->id_pedagang);
        $pesananPertama = null;
        
        foreach ($grouped as $id_pedagang => $items) {
            // Calculate total
            $total_harga = $items->sum(fn($item) => $item->menu->harga * $item->jumlah);
            
            // Create Pesanan
            $pesanan = Pesanan::create([
                'user_id' => auth()->id(),
                'id_pedagang' => $id_pedagang,
                'status' => 'diproses',
                'total_harga' => $total_harga,
                'metode_pembayaran' => $request->metode_pembayaran
            ]);
            
            // Create ItemPesanan
            foreach ($items as $item) {
                ItemPesanan::create([
                    'id_pesanan' => $pesanan->id,
                    'id_menu' => $item->id_menu,
                    'jumlah' => $item->jumlah,
                    'harga' => $item->menu->harga,
                    'subtotal' => $item->menu->harga * $item->jumlah
                ]);
            }
            
            // Handle file upload if transfer
            $buktiTransfer = null;
            if ($request->hasFile('bukti_transfer')) {
                $buktiTransfer = $request->file('bukti_transfer')
                    ->store('bukti_transfer', 'public');
            }
            
            // Create Transaksi
            Transaksi::create([
                'id_pesanan' => $pesanan->id,
                'jumlah' => $total_harga,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => $request->metode_pembayaran === 'cash' ? 'verified' : 'pending',
                'payment_date' => now(),
                'bukti_transfer' => $buktiTransfer
            ]);
            
            if (!$pesananPertama) {
                $pesananPertama = $pesanan->id;
            }
        }
        
        // STEP 5: Delete Cart
        Keranjang::where('user_id', auth()->id())->delete();
        
        // STEP 6: Commit Transaction
        DB::commit();
        
        // STEP 7: REDIRECT TO SUCCESS PAGE
        \Log::info('Checkout successful', ['pesanan_id' => $pesananPertama]);
        
        return redirect()
            ->route('mahasiswa.detail-pesanan', $pesananPertama)
            ->with('success', 'Checkout berhasil! Pesanan Anda sedang diproses.');
            
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Checkout failed', ['error' => $e->getMessage()]);
        
        return back()->with('error', 'Checkout gagal: ' . $e->getMessage());
    }
}
```

---

### Step 4: Routes - Define Both GET & POST
**File**: `routes/web.php`

```php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        
        // GET - Display checkout form
        Route::get('/checkout', [CheckoutController::class, 'index'])
            ->name('checkout');
        
        // POST - Process checkout & redirect
        Route::post('/checkout', [CheckoutController::class, 'store'])
            ->name('checkout.store');
            
        // Detail pesanan (redirect destination)
        Route::get('/pesanan/{id}', [PesananController::class, 'detail'])
            ->name('detail-pesanan');
    });
});
```

---

## 🧪 Testing Flow

### Test 1: Cash Payment
1. Add items to cart
2. Go to `/mahasiswa/checkout`
3. Select "Tunai (Cash)"
4. Click "Konfirmasi Pesanan"
5. ✅ Should redirect to `/mahasiswa/pesanan/{id}`
6. ✅ Should show success message

### Test 2: Transfer Payment (No File)
1. Add items to cart
2. Go to `/mahasiswa/checkout`
3. Select "Transfer Bank"
4. Click "Konfirmasi Pesanan" (tanpa upload)
5. ✅ Should show error: "Bukti transfer harus diupload"
6. ✅ Halaman tetap di checkout

### Test 3: Transfer Payment (With File)
1. Add items to cart
2. Go to `/mahasiswa/checkout`
3. Select "Transfer Bank"
4. Upload bukti transfer image
5. Click "Konfirmasi Pesanan"
6. ✅ Should redirect to `/mahasiswa/pesanan/{id}`
7. ✅ Should show success message

---

## 🐛 Debugging Tips

### 1. Check Browser Console
```javascript
// Open DevTools (F12) → Console tab
// Look for JavaScript errors
```

### 2. Check Laravel Log
```bash
tail -f storage/logs/laravel.log
```

### 3. Add Temporary Debug
```php
// In controller before redirect
dd([
    'pesananPertama' => $pesananPertama,
    'route' => route('mahasiswa.detail-pesanan', $pesananPertama)
]);
```

### 4. Check Network Tab
```
DevTools → Network tab
- POST /mahasiswa/checkout → Response should be redirect (301/302)
- Follow redirect should go to /mahasiswa/pesanan/{id}
```

---

## ✅ Verifikasi Semuanya Benar

- [x] Form action menggunakan `route('mahasiswa.checkout.store')`
- [x] Form method adalah `POST`
- [x] Button type adalah `submit`
- [x] Route GET dan POST terpisah
- [x] Controller `store()` memvalidasi input
- [x] Jika valid, redirect ke `detail-pesanan`
- [x] Jika error, return back dengan error message
- [x] Error message ditampilkan di view
- [x] Loading state saat submit

---

## 🎯 Quick Checklist untuk User

Jika checkout masih tidak bekerja:

1. ✅ Buka DevTools (F12)
2. ✅ Go to `/mahasiswa/checkout`
3. ✅ Pilih metode pembayaran (cash)
4. ✅ Click tombol "Konfirmasi Pesanan"
5. ✅ Lihat Network tab → POST request
6. ✅ Check response → should be redirect
7. ✅ Check Laravel log untuk error

---

**Last Updated**: 2025-11-25  
**Status**: Complete Testing Ready ✅

