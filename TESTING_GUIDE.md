# 🧪 Testing Payment Flow - Kantinku App

## Test Scenario: Complete Checkout → Payment → Status Update Cycle

### Prerequisites:
- ✅ Mahasiswa (Student) sudah login
- ✅ Menu tersedia di database
- ✅ Penjual (Seller) sudah terdaftar

---

## 📋 STEP 1: Browse Menu & Add to Cart

**Route:** `GET /mahasiswa/menu`

### Actions:
1. Klik menu yang ingin dipesan
2. Input jumlah item
3. Klik "Tambah ke Keranjang"

**Expected Result:**
- ✅ Item muncul di keranjang
- ✅ Badge di navbar berubah (keranjang count)
- ✅ Sistem auto-refresh keranjang count

---

## 🛒 STEP 2: View Cart & Checkout

**Route:** `GET /mahasiswa/keranjang` → `GET /mahasiswa/checkout`

### Actions:
1. Klik icon keranjang di navbar
2. Verifikasi item & total harga
3. Klik "Checkout"
4. Pilih metode pembayaran:
   - **Option A: Tunai (Cash)** → Langsung submit
   - **Option B: Transfer Bank** → Upload bukti transfer

**Expected Result for CASH:**
- ✅ Pesanan created dengan status `diproses`
- ✅ Transaksi created dengan status `verified`
- ✅ Redirect ke status pesanan
- ✅ Notifikasi dikirim ke penjual

**Expected Result for TRANSFER:**
- ✅ Pesanan created dengan status `diproses`
- ✅ Transaksi created dengan status `pending` 
- ✅ Bukti transfer file terupload ke storage
- ✅ Status masih pending sampai admin verifikasi

---

## ✅ STEP 3: Admin Verify Transfer (Jika pilih Transfer)

**Route:** `GET /admin/verifikasi-transfer` → `PUT /admin/verifikasi-transfer/{id}`

### Actions:
1. Login sebagai Admin
2. Ke `/admin/verifikasi-transfer`
3. Lihat pending transfers
4. Klik image untuk preview bukti transfer
5. Pilih: **Terima Transfer** atau **Tolak Transfer**
6. Add optional catatan (notes)
7. Submit

**Expected Result for ACCEPTED:**
- ✅ Transaksi status → `verified`
- ✅ Pesanan status → `diproses`
- ✅ Notifikasi dibuat untuk mahasiswa & penjual
- ✅ Pesan: "Pembayaran Anda telah terverifikasi"

**Expected Result for REJECTED:**
- ✅ Transaksi status → `rejected`
- ✅ Pesanan status → `dibatalkan`
- ✅ Notifikasi dibuat untuk mahasiswa & penjual
- ✅ Pesan: "Pembayaran Anda ditolak"

---

## 🍳 STEP 4: Penjual Process Order

**Route:** `GET /penjual/pesanan` → `GET /penjual/pesanan/{id}/edit` → `PUT /penjual/pesanan/{id}`

### Actions:
1. Login sebagai Penjual
2. Ke `/penjual/pesanan` (atau lihat di dashboard "Pesanan Masuk")
3. Klik order untuk edit status
4. Update status:
   - `diproses` → `siap_diambil` (pesanan ready)
   - `siap_diambil` → `selesai` (customer picked up)
5. Add optional catatan (will be shown to customer)
6. Submit

**Expected Result per Status:**
- ✅ Status diubah di database
- ✅ Notifikasi otomatis dibuat untuk mahasiswa:
  - "Pesanan Anda sedang diproses oleh penjual"
  - "Pesanan Anda sudah siap diambil!"
  - "Pesanan Anda telah selesai"

---

## 📱 STEP 5: Mahasiswa Track Order

**Routes:** 
- `GET /mahasiswa/status` (Active Orders)
- `GET /mahasiswa/riwayat` (Order History)
- `GET /mahasiswa/pesanan/{id}` (Order Detail)
- `GET /mahasiswa/notifikasi` (Notifications)

### Actions:
1. Mahasiswa view "Status Pesanan" page
2. Klik "Lihat Detail" untuk order detail
3. Lihat progress bar showing status progression
4. Buka notifikasi untuk alerts dari penjual
5. Lihat payment status & transfer bukti (if applicable)
6. Klik "Lihat Notifikasi" di navbar untuk notification center

**Expected Result:**
- ✅ Detail pesanan menampilkan:
  - Order ID, date, status dengan progress bar
  - Seller info (nama toko, pemilik)
  - Item list dengan harga & subtotal
  - Payment method & payment status
  - Transfer bukti (for transfer payments)
  - Admin notes (if any)
- ✅ Auto-refresh detail setiap 5 detik
- ✅ Notifikasi dari penjual muncul di notifikasi center
- ✅ Badge di navbar menunjukkan unread notifications

---

## 📊 STEP 6: Dashboard Updates

### Mahasiswa Dashboard (`GET /mahasiswa/dashboard`)
**Widgets yang ditampilkan:**
- ✅ Pesanan Aktif: Count pesanan dengan status `diproses` or `siap_diambil`
- ✅ Notifikasi Baru: Count notifikasi dengan `dibaca = false`
- ✅ Pesanan Selesai: Count pesanan dengan status `selesai`

### Penjual Dashboard (`GET /penjual/dashboard`)
**Widgets yang ditampilkan:**
- ✅ Total Menu: Count menu dari penjual tersebut
- ✅ Pesanan Hari Ini: Count pesanan bulan ini
- ✅ Pendapatan Hari Ini: Sum total_harga dari transaksi verified
- ✅ Notifikasi Baru: Count pesanan berstatus `diproses`

### Admin Dashboard (`GET /admin/dashboard`)
**Stats yang ditampilkan:**
- ✅ Total Transaksi: Count semua transaksi
- ✅ Transfer Pending: Count transaksi berstatus `pending`
- ✅ Total Pendapatan Verified: Sum total_harga dari transaksi `verified`

---

## 🔗 URL Mapping & Routes

### Mahasiswa Routes:
| Method | Route | Controller | View |
|--------|-------|-----------|------|
| GET | `/mahasiswa/menu` | MenuController@index | menu-mhs |
| POST | `/mahasiswa/keranjang/tambah` | KeranjangController@tambah | - |
| GET | `/mahasiswa/keranjang` | KeranjangController@index | keranjang |
| GET | `/mahasiswa/checkout` | CheckoutController@index | checkout |
| POST | `/mahasiswa/checkout` | CheckoutController@store | - |
| GET | `/mahasiswa/status` | PesananController@index | status |
| GET | `/mahasiswa/riwayat` | PesananController@riwayat | riwayat |
| GET | `/mahasiswa/pesanan/{id}` | PesananController@detail | detail-pesanan |
| GET | `/mahasiswa/notifikasi` | NotifikasiController@index | notifikasi |

### Penjual Routes:
| Method | Route | Controller | View |
|--------|-------|-----------|------|
| GET | `/penjual/dashboard` | DashboardController@index | dashboard |
| GET | `/penjual/pesanan` | PesananController@index | pesanan.index |
| GET | `/penjual/pesanan/{id}/edit` | PesananController@edit | pesanan.edit |
| PUT | `/penjual/pesanan/{id}` | PesananController@update | - |

### Admin Routes:
| Method | Route | Controller | View |
|--------|-------|-----------|------|
| GET | `/admin/dashboard` | DashboardController@index | admin.dashboard |
| GET | `/admin/verifikasi-transfer` | VerifikasiTransferController@index | admin.verifikasi-transfer |
| PUT | `/admin/verifikasi-transfer/{id}` | VerifikasiTransferController@update | - |

---

## 🔍 Database Flow

### Pesanan Lifecycle:
```
CREATE PESANAN
  ├─ user_id: from Auth
  ├─ id_pedagang: from item's menu
  ├─ status: 'diproses' (default)
  ├─ total_harga: sum of items
  └─ metode_pembayaran: 'cash' or 'transfer'
         ↓
CREATE ITEM_PESANAN (untuk setiap item di keranjang)
  ├─ id_pesanan: FK to pesanan
  ├─ id_menu: FK to menu
  ├─ jumlah: quantity
  ├─ harga: menu price
  └─ subtotal: jumlah * harga
         ↓
CREATE TRANSAKSI
  ├─ id_pesanan: FK to pesanan
  ├─ total_harga: from pesanan
  ├─ metode_pembayaran: 'cash' or 'transfer'
  ├─ status: 'verified' (cash) or 'pending' (transfer)
  ├─ bukti_transfer: file path (if transfer)
  └─ catatan_admin: nullable admin notes
         ↓
(IF TRANSFER) ADMIN VERIFY
  └─ Transaksi status: 'verified' or 'rejected'
     + Create Notifikasi to user & seller
         ↓
PENJUAL UPDATE STATUS
  ├─ diproses → siap_diambil → selesai
  ├─ atau: diproses → dibatalkan
  └─ Create Notifikasi untuk mahasiswa setiap update
```

### Notifikasi Creation Events:
1. **Checkout (Penjual Get Alert)**
   - Event: Pesanan dibuat
   - Recipient: Penjual
   - Tipe: 'pesanan_baru'

2. **Admin Verifikasi Transfer**
   - Event: Transfer diverifikasi/ditolak
   - Recipients: Mahasiswa + Penjual
   - Tipe: 'verifikasi_transfer'

3. **Penjual Update Status**
   - Event: Status diubah
   - Recipient: Mahasiswa
   - Tipe: 'status_update'

---

## ✨ Testing Checklist

### Frontend (UI):
- [ ] Menu page menampilkan items dengan gambar
- [ ] Keranjang update count badge saat add/remove
- [ ] Checkout form menampilkan payment options
- [ ] Transfer payment menampilkan upload field
- [ ] Status page menampilkan active orders dengan progress bar
- [ ] Detail pesanan menampilkan semua info dengan auto-refresh
- [ ] Notifikasi page menampilkan notifikasi dengan badges
- [ ] Dashboard widgets menampilkan correct counts

### Backend (Logic):
- [ ] Checkout create pesanan, item_pesanan, transaksi correctly
- [ ] Cash payment set transaksi status to 'verified'
- [ ] Transfer payment set transaksi status to 'pending'
- [ ] File upload untuk bukti_transfer working
- [ ] Admin verifikasi create notifikasi untuk user & seller
- [ ] Penjual update status create notifikasi untuk mahasiswa
- [ ] All FK relationships working (no errors)
- [ ] Auth checks preventing unauthorized access

### Database:
- [ ] Pesanan table has correct data
- [ ] ItemPesanan table linked to Pesanan
- [ ] Transaksi table has bukti_transfer file path
- [ ] Notifikasi table has correct user_id & pesanan_id
- [ ] All timestamps recorded correctly

---

## 🐛 Common Issues & Solutions

### Issue: "File not found" untuk bukti_transfer
**Solution:** Pastikan storage link sudah dibuat:
```bash
php artisan storage:link
```

### Issue: "Route not found"
**Solution:** Clear route cache:
```bash
php artisan route:cache --force
```

### Issue: "Method not allowed"
**Solution:** Check POST/PUT method di form:
```html
<form method="POST">
  @csrf
  @method('PUT')
</form>
```

### Issue: Notifikasi tidak muncul
**Solution:** Check `dibaca = false` di database query

---

## 📞 Support Info

**Database Structure Reference:**
- Users: id, nama, email, role, alamat, no_hp
- Pesanan: id, user_id, id_pedagang, status, total_harga, metode_pembayaran
- ItemPesanan: id, id_pesanan, id_menu, jumlah, harga, subtotal
- Transaksi: id, id_pesanan, total_harga, metode_pembayaran, status, bukti_transfer, catatan_admin
- Notifikasi: id, user_id, pesanan_id, tipe, pesan, catatan, dibaca

**Status Values:**
- Pesanan: diproses, siap_diambil, selesai, dibatalkan
- Transaksi: verified, pending, rejected

