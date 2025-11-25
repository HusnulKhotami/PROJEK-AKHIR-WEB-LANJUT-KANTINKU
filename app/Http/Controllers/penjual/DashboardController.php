<?php

namespace App\Http\Controllers\penjual;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Pedagang;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil pedagang berdasarkan user login
        $pedagang = Pedagang::where('user_id', Auth::id())->first();

        if (!$pedagang) {
            return "Data pedagang tidak ditemukan";
        }

        $pedagangId = $pedagang->id;

        // Total menu penjual
        $totalMenu = Menu::where('id_pedagang', $pedagangId)->count();

        // Pesanan hari ini
        $pesananHariIni = Pesanan::where('id_pedagang', $pedagangId)
            ->whereDate('created_at', now())
            ->count();

        // Total pendapatan hari ini
        $pendapatan = Pesanan::where('id_pedagang', $pedagangId)
            ->whereDate('created_at', now())
            ->sum('total_harga');
        
        // Notifikasi baru - pesanan yang belum diproses (status diproses)
        $notifikasiBaru = Pesanan::where('id_pedagang', $pedagangId)
            ->where('status', 'diproses')
            ->count();

        // Pesanan terbaru
        $pesanan = Pesanan::where('id_pedagang', $pedagangId)
            ->latest()
            ->take(5)
            ->get();

        // Pesanan masuk yang belum diproses - untuk notifikasi section
        $pesananMasuk = Pesanan::where('id_pedagang', $pedagangId)
            ->where('status', 'diproses')
            ->with(['mahasiswa', 'item.menu'])
            ->latest()
            ->take(10)
            ->get();
        return view('penjual.dashboard', compact(
            'totalMenu',
            'pesananHariIni',
            'pendapatan',
            'notifikasiBaru',
            'pesanan',
            'pesananMasuk'
        ));
    }
}
