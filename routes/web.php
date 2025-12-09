<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Auth Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| Mahasiswa Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\mahasiswa\MenuController as MahasiswaMenuController;
use App\Http\Controllers\mahasiswa\KeranjangController;
use App\Http\Controllers\mahasiswa\PesananController as MahasiswaPesananController;
use App\Http\Controllers\mahasiswa\CheckoutController;
use App\Http\Controllers\mahasiswa\NotifikasiController;

/*
|--------------------------------------------------------------------------
| Penjual Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\penjual\DashboardController;
use App\Http\Controllers\penjual\MenuController as PenjualMenuController;
use App\Http\Controllers\penjual\PesananController as PenjualPesananController;
use App\Http\Controllers\penjual\LaporanController;
use App\Http\Controllers\penjual\LogAktivitasController;

/*
|--------------------------------------------------------------------------
| Admin Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\UserController as AdminUserController;
use App\Http\Controllers\admin\TransaksiController as AdminTransaksiController;

/*
|--------------------------------------------------------------------------
| Midtrans
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\MidtransController;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('index'))->name('home');
Route::get('/fitur', fn () => view('landing.fitur'))->name('fitur');
Route::get('/menu', fn () => view('landing.menu'))->name('menu');
Route::get('/tentang', fn () => view('landing.tentang-kantin'))->name('tentang');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Email Verification
|--------------------------------------------------------------------------
*/
Route::get('/email/verify', [VerificationController::class, 'notice'])
    ->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', [VerificationController::class, 'send'])
    ->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*
|--------------------------------------------------------------------------
| Routes for Authenticated & Verified Users
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    /* ==========================================================
 * ADMIN
 * ========================================================== */
Route::prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Manajemen Pengguna
    Route::get('/pengguna', [AdminUserController::class, 'index'])->name('admin.pengguna');
    Route::get('/pengguna/create', [AdminUserController::class, 'create'])->name('admin.pengguna.create');
    Route::post('/pengguna', [AdminUserController::class, 'store'])->name('admin.pengguna.store');
    Route::get('/pengguna/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.pengguna.edit');
    Route::put('/pengguna/{id}', [AdminUserController::class, 'update'])->name('admin.pengguna.update');
    Route::get('/pengguna/{id}/hapus', [AdminUserController::class, 'confirmDelete'])->name('admin.pengguna.hapus');
    Route::delete('/pengguna/{id}', [AdminUserController::class, 'destroy'])->name('admin.pengguna.destroy');

    /* ==========================================================
     * TRANSAKSI + EKSPOR
     * ========================================================== */

    // 🔥 Route index transaksi (mendukung filter)
    Route::get('/transaksi', [AdminTransaksiController::class, 'index'])
        ->name('admin.transaksi');

    // Detail transaksi
    Route::get('/transaksi/{id}', [AdminTransaksiController::class, 'detail'])
        ->name('admin.transaksi.detail');

    // Export PDF
    Route::get('/transaksi/export/pdf', [AdminTransaksiController::class, 'exportPdf'])
        ->name('admin.transaksi.export.pdf');

    // Export Excel / CSV
    Route::get('/transaksi/export/excel', [AdminTransaksiController::class, 'exportExcel'])
        ->name('admin.transaksi.export.excel');

    /* ==========================================================
     * VALIDASI PEMBAYARAN
     * ========================================================== */
    Route::get('/validasi-pembayaran',
        [\App\Http\Controllers\admin\ValidasiPembayaranController::class, 'index'])
        ->name('admin.validasi');

    Route::post('/validasi-pembayaran/{pesanan}',
        [\App\Http\Controllers\admin\ValidasiPembayaranController::class, 'konfirmasi'])
        ->name('admin.validasi.konfirmasi');
});

    /* ==========================================================
     * PENJUAL
     * ========================================================== */
    Route::prefix('penjual')->name('penjual.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Menu Penjual
        Route::resource('/menu', PenjualMenuController::class);

        // Pesanan Masuk
        Route::get('/pesanan', [PenjualPesananController::class, 'index'])->name('pesanan.index');
        Route::get('/pesanan/{id}/edit', [PenjualPesananController::class, 'edit'])->name('pesanan.edit');
        Route::put('/pesanan/{id}', [PenjualPesananController::class, 'update'])->name('pesanan.update');
        Route::delete('/pesanan/{id}', [PenjualPesananController::class, 'destroy'])->name('pesanan.destroy');

        // Aktivitas + Export
        Route::get('/aktivitas', [LogAktivitasController::class, 'index'])->name('aktivitas.index');
        Route::get('/aktivitas/export-pdf', [LogAktivitasController::class, 'exportPdf'])->name('aktivitas.export-pdf');

        // ✅ Export CSV (Pengganti Excel)
        Route::get('/aktivitas/export-csv', [LogAktivitasController::class, 'exportCsv'])
            ->name('aktivitas.export-csv');
    });

    /* ==========================================================
     * MAHASISWA
     * ========================================================== */
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {

        Route::get('/dashboard', fn () => view('mahasiswa.dashboard'))->name('dashboard');

        Route::get('/menu', [MahasiswaMenuController::class, 'index'])->name('menu-mhs');

        // Pesanan
        Route::get('/status', [MahasiswaPesananController::class, 'index'])->name('status');
        Route::get('/riwayat', [MahasiswaPesananController::class, 'riwayat'])->name('riwayat');

        // Notifikasi
        Route::get('/notifikasi', [NotifikasiController::class, 'notifikasi'])->name('notifikasi');
        Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'read'])->name('notifikasi.read');
        Route::delete('/notifikasi/{id}/hapus', [NotifikasiController::class, 'destroy'])->name('notifikasi.hapus');
        Route::delete('/notifikasi/hapus-semua', [NotifikasiController::class, 'destroyAll'])->name('notifikasi.hapusAll');

        // Keranjang
        Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
        Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
        Route::post('/keranjang/kurang', [KeranjangController::class, 'kurang'])->name('keranjang.kurang');
        Route::post('/keranjang/hapus', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

        // Checkout
        Route::post('/keranjang/checkout', [CheckoutController::class, 'checkout'])->name('keranjang.checkout');

        // Detail Pesanan
        Route::get('/detail-pesanan/{id}', [MahasiswaPesananController::class, 'detail'])->name('detail-pesanan');
        Route::get('/detail-pesanan/{id}/export-pdf', [MahasiswaPesananController::class, 'exportPdf'])->name('detail-pesanan.export-pdf');
        Route::get('/detail-pesanan/{id}/export-excel', [MahasiswaPesananController::class, 'exportExcel'])->name('detail-pesanan.export-excel');

        // Aksi Pesanan
        Route::post('/pesanan/{id}/batal', [MahasiswaPesananController::class, 'batal'])->name('pesanan.batal');
        Route::delete('/pesanan/{id}/hapus', [MahasiswaPesananController::class, 'hapusRiwayat'])->name('pesanan.hapus');

        // MIDTRANS
        Route::get('/pembayaran/{id}', [CheckoutController::class, 'halamanPembayaran'])->name('pembayaran');
        Route::post('/midtrans/snap-token', [CheckoutController::class, 'getSnapToken'])->name('midtrans.snap-token');
        Route::post('/midtrans/callback', [CheckoutController::class, 'callback'])->name('midtrans.callback');
    });
});
