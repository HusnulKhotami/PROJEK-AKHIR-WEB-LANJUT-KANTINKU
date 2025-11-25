# 📊 ARCHITECTURE & FLOW DIAGRAMS

## System Architecture Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                     KANTINKU ORDERING SYSTEM                     │
└─────────────────────────────────────────────────────────────────┘

┌──────────────────┐         ┌──────────────────┐      ┌──────────────┐
│   MAHASISWA      │         │     PENJUAL      │      │    ADMIN     │
│   (Student)      │         │    (Seller)      │      │   (Verif)    │
└────────┬─────────┘         └────────┬─────────┘      └──────┬───────┘
         │                           │                       │
         │ Browse Menu              │ View Orders           │ Verifikasi
         │ Add to Cart             │ Update Status         │ Transfer
         │ Checkout                │ Send Notes            │ Create Notif
         │                         │                       │
         └─────────────┬───────────┴──────────────────────┘
                       │
                ┌──────▼──────────────┐
                │   DATABASE LAYER    │
                ├────────────────────┤
                │ • Pesanan          │
                │ • ItemPesanan      │
                │ • Transaksi        │
                │ • Notifikasi       │
                │ • Menu             │
                │ • Users            │
                └────────────────────┘
```

---

## Complete Payment & Status Flow

```
MAHASISWA CHECKOUT FLOW:
═════════════════════════════════════════════════════════════

┌─ Start Checkout
│
├─ Browse Menu (GET /mahasiswa/menu)
│  └─ Add Items to Cart (POST /keranjang/tambah)
│
├─ View Cart (GET /mahasiswa/keranjang)
│  └─ Items grouped by Penjual
│
├─ Proceed to Checkout (GET /mahasiswa/checkout)
│  │
│  └─ Select Payment Method:
│     │
│     ├─ OPTION A: TUNAI (Cash)
│     │  ├─ POST /mahasiswa/checkout
│     │  ├─ Create Pesanan (status: 'diproses')
│     │  ├─ Create ItemPesanan (per item)
│     │  ├─ Create Transaksi (status: 'verified')
│     │  └─ Redirect to Status Page
│     │
│     └─ OPTION B: TRANSFER (Bank)
│        ├─ POST /mahasiswa/checkout + FILE
│        ├─ Create Pesanan (status: 'diproses')
│        ├─ Create ItemPesanan (per item)
│        ├─ Create Transaksi (status: 'pending')
│        ├─ Upload bukti_transfer file to storage
│        └─ Wait for Admin Verification
│
└─ End (Pesanan Created)


ADMIN VERIFICATION FLOW (Transfer Only):
═════════════════════════════════════════════════════════════

┌─ Admin Login (GET /admin/verifikasi-transfer)
│  └─ View all Transaksi with status='pending'
│
├─ Select Transfer to Verify
│  ├─ Preview bukti_transfer image (modal)
│  ├─ Check payment details
│  └─ Read notes if any
│
├─ Make Decision:
│  │
│  ├─ ACCEPT:
│  │  ├─ PUT /admin/verifikasi-transfer/{id}
│  │  ├─ Transaksi.status = 'verified'
│  │  ├─ Pesanan.status = 'diproses'
│  │  └─ Create Notifikasi for:
│  │     ├─ Mahasiswa: "Pembayaran Anda telah terverifikasi"
│  │     └─ Penjual: "Pembayaran transfer dari pembeli telah diverifikasi"
│  │
│  └─ REJECT:
│     ├─ PUT /admin/verifikasi-transfer/{id}
│     ├─ Transaksi.status = 'rejected'
│     ├─ Pesanan.status = 'dibatalkan'
│     └─ Create Notifikasi for:
│        ├─ Mahasiswa: "Pembayaran Anda ditolak"
│        └─ Penjual: "Pembayaran transfer ditolak"
│
└─ End (Status Updated + Notifikasi Sent)


PENJUAL PROCESS ORDER FLOW:
═════════════════════════════════════════════════════════════

┌─ Penjual View Pesanan List (GET /penjual/pesanan)
│  └─ See all pesanan with status='diproses'
│
├─ Select Pesanan to Process
│  └─ GET /penjual/pesanan/{id}/edit
│
├─ View Order Details
│  ├─ Customer name & items
│  ├─ Payment method & status
│  └─ Current status
│
├─ Update Status:
│  │
│  └─ PUT /penjual/pesanan/{id}
│     │
│     ├─ Status: diproses → siap_diambil
│     │  ├─ Pesanan.status = 'siap_diambil'
│     │  └─ Create Notifikasi:
│     │     └─ "Pesanan Anda sudah siap diambil!"
│     │
│     ├─ Status: siap_diambil → selesai
│     │  ├─ Pesanan.status = 'selesai'
│     │  └─ Create Notifikasi:
│     │     └─ "Pesanan Anda telah selesai"
│     │
│     └─ OR: diproses → dibatalkan (cancel)
│        ├─ Pesanan.status = 'dibatalkan'
│        └─ Create Notifikasi:
│           └─ "Pesanan Anda dibatalkan oleh penjual"
│
└─ End (Status Updated + Mahasiswa Notified)


MAHASISWA TRACKING FLOW:
═════════════════════════════════════════════════════════════

Option 1: View Status (GET /mahasiswa/status)
───────────────────────────────────────────────
├─ Show Active Orders (status: diproses, siap_diambil)
├─ Click "Lihat Detail"
│  └─ GET /mahasiswa/pesanan/{id}
│     ├─ Show Progress Bar:
│     │  └─ [■────────] Diproses
│     │     [■────────] Siap Diambil
│     │     [■────────] Selesai (if applicable)
│     │
│     ├─ Show Order Info:
│     │  ├─ Order ID, Date
│     │  ├─ Seller Name & Location
│     │  ├─ Items List with prices
│     │  ├─ Payment Status
│     │  └─ Admin Notes (if rejected)
│     │
│     └─ Auto-Refresh every 5 seconds


Option 2: View Riwayat (GET /mahasiswa/riwayat)
──────────────────────────────────────────────────
├─ Show Completed Orders (status: selesai, dibatalkan)
└─ Click "Lihat Detail"
   └─ GET /mahasiswa/pesanan/{id}
      └─ Show final order result


Option 3: View Notifikasi (GET /mahasiswa/notifikasi)
────────────────────────────────────────────────────────
├─ Show All Notifications:
│  ├─ Status Updates from Penjual
│  ├─ Transfer Verification from Admin
│  ├─ Admin Notes/Catatan
│  └─ Links to Order Detail
│
├─ Features:
│  ├─ Auto-read when viewing page
│  ├─ Delete notification
│  ├─ Show relative time (e.g., "5 menit lalu")
│  └─ Color-coded icons:
│     ├─ Blue = Status Update
│     └─ Green = Transfer Verified


Dashboard Access (GET /mahasiswa/dashboard)
────────────────────────────────────────────
├─ Widget 1: Pesanan Aktif
│  └─ Count: SELECT COUNT(*) FROM pesanan WHERE user_id=? AND status IN ('diproses','siap_diambil')
│
├─ Widget 2: Notifikasi Baru
│  └─ Count: SELECT COUNT(*) FROM notifikasi WHERE user_id=? AND dibaca=false
│
└─ Widget 3: Pesanan Selesai
   └─ Count: SELECT COUNT(*) FROM pesanan WHERE user_id=? AND status='selesai'


Navbar Notification Badge
──────────────────────────
├─ Bell Icon with Orange Badge
├─ Shows unread count
├─ Links to /mahasiswa/notifikasi
└─ Updates in real-time
```

---

## Database Relationship Diagram

```
┌─────────────┐
│   Users     │ (mahasiswa)
├─────────────┤
│ id (PK)     │
│ nama        │
│ email       │
│ role        │
│ ...         │
└────┬────────┘
     │
     │ 1
     │ ┌──────────────────────┐
     │ │                      │ N
     ├─┤      Pesanan        ├─────┐
     │ │                      │     │
     │ └──────────────────────┘     │
     │          │                   │
     │          │ 1                 │ N
     │          │                   │
     │          └───────┬───────────┘
     │                  │
     │                  │ Has
     │                  ▼
     │            ┌────────────┐
     │            │ItemPesanan │
     │            └────────────┘


┌──────────────────────────────┐
│        Pesanan               │ (order)
├──────────────────────────────┤
│ id (PK)                      │
│ user_id (FK → Users)         │
│ id_pedagang (FK → Pedagang)  │ ◄── Connected to Seller
│ status: diproses|siap_diambil│
│         |selesai|dibatalkan  │
│ total_harga                  │
│ metode_pembayaran            │
│ created_at, updated_at       │
└──────────────────────────────┘
     │
     │ 1 → N
     ▼
┌──────────────────────┐
│   ItemPesanan        │
├──────────────────────┤
│ id (PK)              │
│ id_pesanan (FK)      │
│ id_menu (FK)         │
│ jumlah               │
│ harga                │
│ subtotal             │
└──────────────────────┘


┌──────────────────────────────┐
│      Transaksi               │ (payment)
├──────────────────────────────┤
│ id (PK)                      │
│ id_pesanan (FK → Pesanan)    │
│ total_harga                  │
│ metode_pembayaran            │
│ status: verified|pending|    │
│         rejected             │
│ bukti_transfer (file path)   │ ◄── For Transfer Method
│ catatan_admin                │
│ created_at, updated_at       │
└──────────────────────────────┘


┌──────────────────────────────┐
│      Notifikasi              │ (notifications)
├──────────────────────────────┤
│ id (PK)                      │
│ user_id (FK → Users)         │
│ pesanan_id (FK → Pesanan)    │
│ tipe: status_update|         │
│       verifikasi_transfer    │
│ pesan                        │
│ catatan                      │
│ dibaca: false|true           │
│ created_at, updated_at       │
└──────────────────────────────┘
```

---

## Component Interaction Map

```
┌──────────────────────────────────────────────────────┐
│              FRONTEND LAYER                          │
├──────────────────────────────────────────────────────┤
│                                                      │
│  Mahasiswa UI          Penjual UI       Admin UI    │
│  ┌─────────────┐      ┌─────────────┐  ┌────────┐ │
│  │ Dashboard   │      │ Dashboard   │  │Dashbrd│ │
│  │ Menu        │      │ Pesanan List│  │Verifik│ │
│  │ Keranjang   │      │ Edit Status │  │ Transf│ │
│  │ Checkout    │      │ Laporan     │  └────────┘ │
│  │ Status      │      └─────────────┘             │
│  │ Riwayat     │                                  │
│  │ Notifikasi  │                                  │
│  └─────────────┘                                  │
│                                                   │
└─────────────────────┬───────────────────────────────┘
                      │ HTTP Requests
                      ▼
┌──────────────────────────────────────────────────────┐
│              CONTROLLER LAYER                        │
├──────────────────────────────────────────────────────┤
│                                                      │
│ Mahasiswa Controllers      Penjual          Admin   │
│ ├─ MenuController         ├─ Dashboard      ├─Dash  │
│ ├─ KeranjangController    ├─ Menu           ├─Verif │
│ ├─ CheckoutController     ├─ Pesanan        │Transfer│
│ ├─ PesananController      └─ LogAktivitas   └───────┘
│ └─ NotifikasiController                           │
│                                                    │
└─────────────────────┬────────────────────────────────┘
                      │ Queries/Updates
                      ▼
┌──────────────────────────────────────────────────────┐
│              MODEL LAYER (Eloquent)                  │
├──────────────────────────────────────────────────────┤
│                                                      │
│ ├─ User          ├─ Pesanan      ├─ Notifikasi    │
│ ├─ Pedagang      ├─ ItemPesanan  ├─ Transaksi     │
│ ├─ Menu          ├─ Keranjang    ├─ LogAktivitas  │
│ └─ ...           └─ ...          └─ ...           │
│                                                   │
└─────────────────────┬────────────────────────────────┘
                      │ SQL Queries
                      ▼
┌──────────────────────────────────────────────────────┐
│          DATABASE LAYER (PostgreSQL)                │
├──────────────────────────────────────────────────────┤
│  users │ pesanan │ item_pesanan │ transaksi │       │
│  pedagang │ menu │ notifikasi │ keranjang │        │
│  kategori_menu │ ulasan │ log_aktivitas │          │
└──────────────────────────────────────────────────────┘
```

---

## Notification System Flow

```
NOTIFIKASI EVENT TRIGGER POINTS:
═════════════════════════════════════════════════════════

1. CHECKOUT CREATED
   ┌────────────────────────────────────────┐
   │ Mahasiswa submit checkout              │
   │ POST /mahasiswa/checkout               │
   └────────────────────────────────────────┘
              │
              ▼
   ┌────────────────────────────────────────┐
   │ CheckoutController::store()            │
   ├────────────────────────────────────────┤
   │ • Create Pesanan                       │
   │ • Create ItemPesanan (per item)        │
   │ • Create Transaksi                     │
   │ • If CASH: Transaksi.status='verified'│
   │ • If TRANSFER: Transaksi.status='pend'│
   └────────────────────────────────────────┘
              │
              ▼
   NOTIFICATION CREATED
   • Type: 'pesanan_baru'
   • Recipient: Penjual (pedagang_id)
   • Message: "Pesanan baru masuk!"


2. TRANSFER VERIFIED BY ADMIN
   ┌────────────────────────────────────────┐
   │ Admin review transfer                  │
   │ PUT /admin/verifikasi-transfer/{id}    │
   └────────────────────────────────────────┘
              │
              ▼
   ┌────────────────────────────────────────┐
   │ VerifikasiTransferController::update()│
   ├────────────────────────────────────────┤
   │ • Transaksi.status = 'verified'        │
   │ • Pesanan.status = 'diproses'          │
   └────────────────────────────────────────┘
              │
              ▼
   NOTIFICATIONS CREATED (x2)
   • For Mahasiswa:
     Type: 'verifikasi_transfer'
     Message: "Pembayaran Anda telah terverifikasi"
   
   • For Penjual:
     Type: 'verifikasi_transfer'
     Message: "Pembayaran transfer diverifikasi"


3. PENJUAL UPDATE ORDER STATUS
   ┌────────────────────────────────────────┐
   │ Penjual update status                  │
   │ PUT /penjual/pesanan/{id}              │
   └────────────────────────────────────────┘
              │
              ▼
   ┌────────────────────────────────────────┐
   │ PesananController::update()            │
   ├────────────────────────────────────────┤
   │ • Pesanan.status = new_status          │
   │ • Generate message based on status     │
   └────────────────────────────────────────┘
              │
              ▼
   NOTIFICATION CREATED
   • Recipient: Mahasiswa (user_id)
   • Type: 'status_update'
   • Messages:
     - diproses: "Pesanan Anda sedang diproses"
     - siap_diambil: "Pesanan Anda sudah siap diambil!"
     - selesai: "Pesanan Anda telah selesai"
     - dibatalkan: "Pesanan Anda dibatalkan"


NOTIFICATION LIFECYCLE:
═════════════════════════════════════════════════════════

CREATED
   └─ dibaca = false
      └─ Auto-create when event triggers
      └─ Store in database immediately

VIEWED
   └─ Mahasiswa opens /mahasiswa/notifikasi
      └─ Auto-set dibaca = true
      └─ Badge count decrements in navbar

DISPLAYED
   └─ Show in notification center with:
      ├─ Icon (status update or transfer verify)
      ├─ Message text
      ├─ Optional catatan (notes)
      ├─ Link to order detail
      ├─ Relative time
      └─ Delete button

DELETED
   └─ Mahasiswa clicks delete
      └─ Hard-delete from database
      └─ OR auto-archive after N days (optional)
```

---

## Status State Machine

```
PESANAN STATUS TRANSITIONS:
═════════════════════════════════════════════════════════

                    ┌─── CREATED (default: diproses)
                    │
                    ▼
            ┌───────────────┐
            │   DIPROSES    │  ◄─── Penjual receiving order
            │   ⏳ Processing  │  └─── Notif: "Sedang diproses"
            └───────┬───────┘
                    │
         ┌──────────┼──────────┐
         │          │          │
    Accept   Reject   Continue
         │          │          │
         ▼          ▼          ▼
    ┌────────┐  ┌──────────┐ ┌──────────┐
    │SELESAI │  │DIBATALKAN│ │SIAP AMBIL│
    │✨Done  │  │❌Cancelled│ │✅ Ready   │
    └────────┘  └──────────┘ └────┬─────┘
       │           │              │
       │           │         Ambil/Done
       │           │              │
       │           │              ▼
       │           │         ┌─────────────┐
       │           │         │    SELESAI   │
       │           │         │   ✨ Complete │
       │           │         └─────────────┘
       │           │              ▲
       └───────────┴──────────────┘

TRANSAKSI STATUS TRANSITIONS:
═════════════════════════════════════════════════════════

CASH PAYMENT:
   verified (immediate)
   └─ Ready to process

TRANSFER PAYMENT:
   pending ◄─── Waiting for admin verification
   │
   ├─ verified ◄─── Admin approved
   │  └─ Ready to process
   │
   └─ rejected ◄─── Admin rejected
      └─ Order cancelled

NOTIFIKASI STATUS:
═════════════════════════════════════════════════════════

   created (dibaca = false)
   │
   ├─ viewed ◄─── Mahasiswa opens notifikasi page
   │  └─ dibaca = true
   │
   └─ deleted ◄─── Mahasiswa clicks delete
      └─ removed from database
```

---

## API Endpoints Reference

```
MAHASISWA ROUTES (Prefix: /mahasiswa, Auth Required)
═════════════════════════════════════════════════════════
GET    /dashboard                    Dashboard::index
GET    /menu                         MenuController@index
GET    /keranjang                    KeranjangController@index
POST   /keranjang/tambah             KeranjangController@tambah
POST   /keranjang/kurang             KeranjangController@kurang
POST   /keranjang/hapus              KeranjangController@hapus
GET    /checkout                     CheckoutController@index
POST   /checkout                     CheckoutController@store
GET    /status                       PesananController@index
GET    /riwayat                      PesananController@riwayat
GET    /pesanan/{id}                 PesananController@detail
GET    /notifikasi                   NotifikasiController@index
PUT    /notifikasi/{id}/baca         NotifikasiController@markAsRead
DELETE /notifikasi/{id}              NotifikasiController@delete


PENJUAL ROUTES (Prefix: /penjual, Auth Required)
═════════════════════════════════════════════════════════
GET    /dashboard                    DashboardController@index
GET    /menu                         MenuController@index
POST   /menu                         MenuController@store
GET    /menu/{id}/edit               MenuController@edit
PUT    /menu/{id}                    MenuController@update
DELETE /menu/{id}                    MenuController@destroy
GET    /pesanan                      PesananController@index
GET    /pesanan/{id}/edit            PesananController@edit
PUT    /pesanan/{id}                 PesananController@update
GET    /aktivitas                    LogAktivitasController@index
GET    /aktivitas/export-pdf         LogAktivitasController@exportPdf
GET    /aktivitas/export-excel       LogAktivitasController@exportExcel


ADMIN ROUTES (Auth Required, Before middleware)
═════════════════════════════════════════════════════════
GET    /admin/dashboard              AdminDashboardController@index
GET    /admin/verifikasi-transfer    VerifikasiTransferController@index
PUT    /admin/verifikasi-transfer/{id} VerifikasiTransferController@update
```

---

## File Structure

```
KANTINKU Project Structure
═════════════════════════════════════════════════════════

app/
├── Http/
│   └── Controllers/
│       ├── mahasiswa/
│       │   ├── MenuController.php
│       │   ├── KeranjangController.php
│       │   ├── CheckoutController.php
│       │   ├── PesananController.php
│       │   └── NotifikasiController.php ✨ NEW
│       ├── penjual/
│       │   ├── DashboardController.php
│       │   ├── MenuController.php
│       │   ├── PesananController.php (UPDATED)
│       │   ├── LaporanController.php
│       │   └── LogAktivitasController.php
│       └── admin/
│           ├── DashboardController.php ✨ NEW
│           └── VerifikasiTransferController.php ✨ NEW
├── Models/
│   ├── User.php
│   ├── Pesanan.php
│   ├── ItemPesanan.php
│   ├── Transaksi.php
│   ├── Notifikasi.php (UPDATED)
│   ├── Menu.php
│   ├── Pedagang.php
│   └── ...

database/
├── migrations/
│   ├── 2025_11_25_000000_add_bukti_transfer_to_transaksi_table.php
│   └── 2025_11_25_000001_add_columns_to_notifikasi_table.php ✨ NEW
└── seeders/

resources/
└── views/
    ├── mahasiswa/
    │   ├── dashboard.blade.php (UPDATED)
    │   ├── status.blade.php (UPDATED)
    │   ├── riwayat.blade.php (UPDATED)
    │   ├── detail-pesanan.blade.php (UPDATED)
    │   ├── checkout.blade.php
    │   └── notifikasi.blade.php ✨ NEW
    ├── penjual/
    │   ├── dashboard.blade.php
    │   └── pesanan/
    │       └── edit.blade.php (UPDATED)
    ├── admin/
    │   ├── dashboard.blade.php (UPDATED)
    │   └── verifikasi-transfer.blade.php ✨ NEW
    └── landing/
        └── header-mhs.blade.php (UPDATED)

routes/
└── web.php (UPDATED - Added routes)

Documentation/
├── TESTING_GUIDE.md ✨ NEW
├── IMPLEMENTATION_SUMMARY.md ✨ NEW
└── VERIFICATION_CHECKLIST.md ✨ NEW
```

---

**End of Architecture & Flow Diagrams**

*Generated: 2025-11-25*
*Status: Complete & Verified*

