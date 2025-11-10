<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\mahasiswa\MenuController;
use App\Http\Controllers\mahasiswa\KeranjangController;
use App\Http\Controllers\mahasiswa\PesananController;
use App\Http\Controllers\mahasiswa\Keranjangtroller;



// Landing Page

Route::get('/', fn() => view('index'))->name('home');
Route::get('/fitur', fn() => view('landing.fitur'))->name('fitur');
Route::get('/menu', fn() => view('landing.menu'))->name('menu');
Route::get('/tentang', fn() => view('landing.tentang-kantin'))->name('tentang');



// AUTH

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



// DASHBOARD SESUAI ROLE

Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))
        ->name('admin.dashboard');

    Route::get('/penjual/dashboard', fn() => view('penjual.dashboard'))
        ->name('penjual.dashboard');
});



//  MAHASISWA ROUTES
Route::middleware('auth')
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {

        // Dashboard mahasiswa
        Route::get('/dashboard', fn() => view('mahasiswa.dashboard'))
            ->name('dashboard');

        // Menu mahasiswa (menggunakan MenuController)
        Route::get('/menu', [MenuController::class, 'index'])
            ->name('menu-mhs');

        // Status pesanan
        Route::get('/status', [PesananController::class, 'index'])
            ->name('status');

        // Riwayat pesanan
        Route::get('/riwayat', [PesananController::class, 'riwayat'])
            ->name('riwayat');

        // Keranjang
        Route::get('/keranjang', [KeranjangController::class, 'index'])
            ->name('keranjang');

        Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])
            ->name('keranjang.tambah');

        Route::post('/keranjang/kurang', [KeranjangController::class, 'kurang'])
            ->name('keranjang.kurang');

        Route::post('/keranjang/hapus', [KeranjangController::class, 'hapus'])
            ->name('keranjang.hapus');
    });

