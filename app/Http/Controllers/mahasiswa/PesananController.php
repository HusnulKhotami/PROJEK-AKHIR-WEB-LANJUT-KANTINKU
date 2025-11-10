<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    // ✅ Status Pesanan Berjalan (proses & siap)
    public function index()
    {
        $pesanan = Pesanan::where('user_id', Auth::id())
                          ->whereIn('status', ['proses', 'siap'])
                          ->with('pedagang')
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('mahasiswa.status', compact('pesanan'));
    }

    // ✅ Riwayat Pesanan (selesai & dibatalkan)
    public function riwayat()
    {
        $pesanan = Pesanan::where('user_id', Auth::id())
                          ->whereIn('status', ['selesai', 'dibatalkan'])
                          ->with('pedagang')
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('mahasiswa.riwayat', compact('pesanan'));
    }
}
