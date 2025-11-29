<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pesanan;

class LaporanController extends Controller
{
    /**
     * Tampilkan halaman laporan keuangan.
     */
    public function index()
    {
        // Total transaksi (berdasarkan pesanan)
        $totalTransaksi = Pesanan::count();

        // Total pendapatan dari transaksi yang sudah paid
        $totalPendapatan = Transaksi::where('status', 'paid')->sum('jumlah');

        // Ambil beberapa transaksi terbaru beserta relasi pesanan dan mahasiswa
        $transaksiTerbaru = Transaksi::with(['pesanan.mahasiswa'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('admin.laporan', compact(
            'totalTransaksi',
            'totalPendapatan',
            'transaksiTerbaru'
        ));
    }
}
