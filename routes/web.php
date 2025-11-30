<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;

use App\Http\Controllers\mahasiswa\MenuController as MahasiswaMenuController;
use App\Http\Controllers\mahasiswa\KeranjangController;
use App\Http\Controllers\mahasiswa\PesananController as MahasiswaPesananController;
use App\Http\Controllers\mahasiswa\CheckoutController;
use App\Http\Controllers\mahasiswa\NotifikasiController;

use App\Http\Controllers\penjual\DashboardController;
use App\Http\Controllers\penjual\MenuController as PenjualMenuController;
use App\Http\Controllers\penjual\PesananController as PenjualPesananController;
use App\Http\Controllers\penjual\LaporanController;
use App\Http\Controllers\penjual\LogAktivitasController;

// ADMIN CONTROLLERS
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\admin\LogAktvitasController as AdminLogAktivitasController;
use App\Http\Controllers\admin\UserController as AdminUserController;
use App\Http\Controllers\admin\TransaksiController as AdminTransaksiController;

Route::get('/', fn() => view('index'))->name('home');
Route::get('/fitur', fn() => view('landing.fitur'))->name('fitur');
Route::get('/menu', fn() => view('landing.menu'))->name('menu');
Route::get('/tentang', fn() => view('landing.tentang-kantin'))->name('tentang');

// AUTENTIKASI LOGIN / REGISTER
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Verifikasi Email
Route::get('/email/verify', [VerificationController::class, 'notice'])
    ->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [VerificationController::class, 'send'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// HANYA UNTUK USER LOGIN DAN VERIFIED
Route::middleware(['auth', 'verified'])->group(function () {

    /* ================== ADMIN ================== */
    Route::prefix('admin')->middleware(['auth'])->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // LAPORAN KEUANGAN + DOWNLOAD PDF / EXCEL (BARU DITAMBAHKAN)
        Route::get('/laporan',        [AdminLaporanController::class, 'index'])->name('admin.laporan');
        Route::get('/laporan/pdf',    [AdminLaporanController::class, 'downloadPdf'])->name('admin.laporan.pdf');
        Route::get('/laporan/excel',  [AdminLaporanController::class, 'downloadExcel'])->name('admin.laporan.excel');

        // MONITORING SISTEM
        Route::get('/monitoring', [AdminLogAktivitasController::class, 'index'])->name('admin.monitoring');

        // MANAJEMEN PENGGUNA
        Route::get('/pengguna', [AdminUserController::class, 'index'])->name('admin.pengguna');
        Route::get('/pengguna/create', [AdminUserController::class, 'create'])->name('admin.pengguna.create');
        Route::post('/pengguna', [AdminUserController::class, 'store'])->name('admin.pengguna.store');
        Route::get('/pengguna/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.pengguna.edit');
        Route::put('/pengguna/{id}', [AdminUserController::class, 'update'])->name('admin.pengguna.update');
        Route::get('/pengguna/{id}/hapus', [AdminUserController::class, 'confirmDelete'])->name('admin.pengguna.hapus');
        Route::delete('/pengguna/{id}', [AdminUserController::class, 'destroy'])->name('admin.pengguna.destroy');

        // MANAJEMEN TRANSAKSI
        Route::get('/transaksi', [AdminTransaksiController::class, 'index'])->name('admin.transaksi');
        Route::get('/transaksi/{id}', [AdminTransaksiController::class, 'detail'])->name('admin.transaksi.detail');
    });

    /* ================== PENJUAL ================== */
    Route::prefix('penjual')->name('penjual.')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('/menu', PenjualMenuController::class);

        // PESANAN MASUK
        Route::get('/pesanan', [PenjualPesananController::class, 'index'])->name('pesanan.index');
        Route::get('/pesanan/{id}/edit', [PenjualPesananController::class, 'edit'])->name('pesanan.edit');
        Route::put('/pesanan/{id}', [PenjualPesananController::class, 'update'])->name('pesanan.update');
        Route::delete('/pesanan/{id}', [PenjualPesananController::class, 'destroy'])->name('pesanan.destroy');

        // Aktivitas (PDF + Excel)
        Route::get('/aktivitas', [LogAktivitasController::class, 'index'])->name('aktivitas.index');
        Route::get('/aktivitas/export-pdf', [LogAktivitasController::class, 'exportPdf'])->name('aktivitas.export-pdf');
        Route::get('/aktivitas/export-excel', [LogAktivitasController::class, 'exportExcel'])->name('aktivitas.export-excel');
    });

    /* ================== MAHASISWA ================== */
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {

        Route::get('/dashboard', fn() => view('mahasiswa.dashboard'))->name('dashboard');

        Route::get('/menu', [MahasiswaMenuController::class, 'index'])->name('menu-mhs');

        Route::get('/status', [MahasiswaPesananController::class, 'index'])->name('status');
        Route::get('/riwayat', [MahasiswaPesananController::class, 'riwayat'])->name('riwayat');

        Route::get('/notifikasi', [NotifikasiController::class, 'notifikasi'])->name('notifikasi');
        Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'read'])->name('notifikasi.read');
        Route::delete('/notifikasi/{id}/hapus', [NotifikasiController::class, 'destroy'])->name('notifikasi.hapus');
       // HAPUS SEMUA NOTIFIKASI
        Route::delete('/notifikasi/hapus-semua', [NotifikasiController::class, 'destroyAll'])->name('notifikasi.hapusAll');

        // Keranjang
        Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
        Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
        Route::post('/keranjang/kurang', [KeranjangController::class, 'kurang'])->name('keranjang.kurang');
        Route::post('/keranjang/hapus', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

        // Checkout
        Route::post('/keranjang/checkout', [CheckoutController::class, 'checkout'])->name('keranjang.checkout');

        // DETAIL PESANAN
        Route::get('/detail-pesanan/{id}', [MahasiswaPesananController::class, 'detail'])->name('detail-pesanan');
        Route::get('/detail-pesanan/{id}/export-pdf', [MahasiswaPesananController::class, 'exportPdf'])->name('detail-pesanan.export-pdf');
        Route::get('/detail-pesanan/{id}/export-excel', [MahasiswaPesananController::class, 'exportExcel'])->name('detail-pesanan.export-excel');
        Route::post('/pesanan/{id}/batal', [MahasiswaPesananController::class, 'batal'])->name('pesanan.batal');
        Route::delete('/pesanan/{id}/hapus', [MahasiswaPesananController::class, 'hapusRiwayat'])->name('pesanan.hapus');



    // MIDTRANS ROUTES
        Route::get('/pembayaran/{id}', 
            [CheckoutController::class, 'halamanPembayaran'])->name('pembayaran');

        Route::post('/midtrans/snap-token', 
            [CheckoutController::class, 'getSnapToken'])->name('midtrans.snap-token');  

        Route::post('/midtrans/callback', 
            [CheckoutController::class, 'callback'])->name('midtrans.callback');

            });
});
