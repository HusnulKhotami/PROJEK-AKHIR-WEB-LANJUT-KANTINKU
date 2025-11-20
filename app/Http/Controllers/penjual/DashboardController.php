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

        // Notifikasi baru
        $notifikasiBaru = Pesanan::where('id_pedagang', $pedagangId)
            ->where('status', 'proses')
            ->count();

        // Pesanan terbaru
        $pesanan = Pesanan::where('id_pedagang', $pedagangId)
            ->latest()
            ->take(5)
            ->get();

        return view('penjual.dashboard', compact(
            'totalMenu',
            'pesananHariIni',
            'pendapatan',
            'notifikasiBaru',
            'pesanan'
        ));
    }
}
