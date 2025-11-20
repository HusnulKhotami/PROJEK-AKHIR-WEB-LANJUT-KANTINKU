<?php

namespace App\Http\Controllers\penjual;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    /**
     * Tampilkan daftar semua pesanan untuk pedagang yang login
     */
    public function index()
    {
        $pesanan = Pesanan::where('id_pedagang', Auth::id())
            ->with('mahasiswa')
            ->latest()
            ->get();

        return view('penjual.pesanan.index', compact('pesanan'));
    }

    /**
     * Form update status
     */
    public function edit($id)
    {
        $pesanan = Pesanan::where('id_pedagang', Auth::id())->findOrFail($id);

        return view('penjual.pesanan.edit', compact('pesanan'));
    }

    /**
     * Proses update status pesanan
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $pesanan = Pesanan::where('id_pedagang', Auth::id())->findOrFail($id);

        $pesanan->update([
            'status' => $request->status
        ]);

        return redirect()->route('penjual.pesanan.index')->with('success', 'Status berhasil diperbarui!');
    }
}
