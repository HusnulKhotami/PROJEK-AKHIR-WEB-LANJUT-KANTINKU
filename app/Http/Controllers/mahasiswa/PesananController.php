<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::where('user_id', Auth::id())
                          ->whereIn('status', ['proses', 'siap'])
                          ->with('pedagang')
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('mahasiswa.status', compact('pesanan'));
    }

    public function riwayat()
    {
        $pesanan = Pesanan::where('user_id', Auth::id())
                          ->whereIn('status', ['selesai', 'dibatalkan'])
                          ->with('pedagang')
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('mahasiswa.riwayat', compact('pesanan'));
    }

    // DETAIL PESANAN — ini yang tadi hilang
    public function detail($id_pesanan){
    $pesanan = Pesanan::with(['pedagang', 'item.menu'])
                ->where('id', $id_pesanan)
                ->where('user_id', auth()->id())
                ->first();

    if (!$pesanan) {
        return redirect()->route('mahasiswa.status')
            ->with('error', 'Pesanan tidak ditemukan.');
    }

    return view('mahasiswa.detail-pesanan', compact('pesanan'));
    }
}
