<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Daftar transaksi/pesanan.
     */
    public function index()
    {
        $transaksi = Pesanan::with(['mahasiswa', 'pedagang', 'transaksi'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.transaksi.index', compact('transaksi'));
    }

    /**
     * Detail satu transaksi/pesanan.
     */
    public function show($id)
    {
        $pesanan = Pesanan::with(['mahasiswa', 'pedagang', 'items.menu', 'transaksi'])
            ->findOrFail($id);

        return view('admin.transaksi.detail', compact('pesanan'));
    }
}
