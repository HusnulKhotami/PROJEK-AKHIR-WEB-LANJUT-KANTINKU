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
        $pedagang = Pedagang::where('user_id', Auth::id())->first();

        if (!$pedagang) {
            return "Data pedagang tidak ditemukan";
        }

        $pedagangId = $pedagang->id;

        // Total menu
        $totalMenu = Menu::where('id_pedagang', $pedagangId)->count();

        // Pesanan hari ini (semua status)
        $pesananHariIni = Pesanan::where('id_pedagang', $pedagangId)
            ->whereDate('created_at', now())
            ->count();

        // Pendapatan hari ini — hanya pesanan selesai
        $pendapatan = Pesanan::where('id_pedagang', $pedagangId)
            ->where('status', 'selesai')
            ->whereDate('created_at', now())
            ->sum('total_harga');

        // Notifikasi baru
        $notifikasiBaru = Pesanan::where('id_pedagang', $pedagangId)
            ->where('status', 'proses')
            ->count();

        // Pesanan terbaru
        $pesanan = Pesanan::where('id_pedagang', $pedagangId)
            ->with('mahasiswa')
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
