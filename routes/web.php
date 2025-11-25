<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\auth\VerificationController;

use App\Http\Controllers\mahasiswa\MenuController as MahasiswaMenuController;
use App\Http\Controllers\mahasiswa\KeranjangController;
use App\Http\Controllers\mahasiswa\PesananController;
use App\Http\Controllers\mahasiswa\CheckoutController;
use App\Http\Controllers\mahasiswa\NotifikasiController as MahasiswaNotifikasiController;

use App\Http\Controllers\penjual\DashboardController;
use App\Http\Controllers\penjual\MenuController as PenjualMenuController;
use App\Http\Controllers\penjual\PesananController as PenjualPesananController;
use App\Http\Controllers\penjual\LaporanController;
use App\Http\Controllers\penjual\LogAktivitasController;

use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\VerifikasiTransferController;

Route::get('/', fn() => view('index'))->name('home');
Route::get('/fitur', fn() => view('landing.fitur'))->name('fitur');
Route::get('/menu', fn() => view('landing.menu'))->name('menu');
Route::get('/tentang', fn() => view('landing.tentang-kantin'))->name('tentang');

//auntifikasi register login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Email Verifikasi
Route::get('/email/verify', [VerificationController::class, 'notice'])
    ->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');
Route::post('/email/verification-notification', [VerificationController::class, 'send'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

//akses login dulu
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/verifikasi-transfer', [VerifikasiTransferController::class, 'index'])->name('admin.verifikasi.index');
    Route::put('/admin/verifikasi-transfer/{id}', [VerifikasiTransferController::class, 'update'])->name('admin.verifikasi.update');

    Route::prefix('penjual')->name('penjual.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('/menu', PenjualMenuController::class);
        
        // PESANAN MASUK
        Route::get('/pesanan', [PenjualPesananController::class, 'index'])->name('pesanan.index');
        Route::get('/pesanan/{id}/edit', [PenjualPesananController::class, 'edit'])->name('pesanan.edit');
        Route::put('/pesanan/{id}', [PenjualPesananController::class, 'update'])->name('pesanan.update');

        // LAPORAN PENJUALAN
        Route::get('/aktivitas', [LogAktivitasController::class, 'index'])->name('aktivitas.index');
        Route::get('/aktivitas/export-pdf', [LogAktivitasController::class, 'exportPdf'])->name('aktivitas.export-pdf');
        Route::get('/aktivitas/export-excel', [LogAktivitasController::class, 'exportExcel'])->name('aktivitas.export-excel');
    });

    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', fn() => view('mahasiswa.dashboard'))->name('dashboard');

        Route::get('/menu', [MahasiswaMenuController::class, 'index'])->name('menu-mhs');

        Route::get('/status', [PesananController::class, 'index'])->name('status');
        Route::get('/riwayat', [PesananController::class, 'riwayat'])->name('riwayat');
        Route::get('/pesanan/{id}', [PesananController::class, 'detail'])->name('detail-pesanan');

        // Notifikasi
        Route::get('/notifikasi', [MahasiswaNotifikasiController::class, 'index'])->name('notifikasi.index');
        Route::put('/notifikasi/{id}/baca', [MahasiswaNotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
        Route::delete('/notifikasi/{id}', [MahasiswaNotifikasiController::class, 'delete'])->name('notifikasi.delete');

        // Keranjang
        Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
        Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
        Route::post('/keranjang/kurang', [KeranjangController::class, 'kurang'])->name('keranjang.kurang');
        Route::post('/keranjang/hapus', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
        
        // Checkout
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    });
});
