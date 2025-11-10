<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // // Menu paling populer (berdasarkan pesanan terbanyak)
        // $menuPopuler = Menu::withCount('pesanan')
        //     ->orderBy('pesanan_count', 'desc')
        //     ->take(4)
        //     ->get();

        // // Total pesanan user
        // $totalPesanan = Pesanan::where('id_mahasiswa', Auth::id())->count();

        // // Pesanan terakhir user
        // $pesananTerakhir = Pesanan::where('id_mahasiswa', Auth::id())
        //     ->latest()
        //     ->first();

        return view('mahasiswa.dashboard', compact(
            'menuPopuler',
            'totalPesanan',
            'pesananTerakhir'
        ));
    }
}
