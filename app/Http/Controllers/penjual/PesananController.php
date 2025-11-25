<?php

namespace App\Http\Controllers\penjual;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Notifikasi;
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
        $pesanan = Pesanan::where('id_pedagang', Auth::id())
            ->with('item.menu', 'mahasiswa')
            ->findOrFail($id);

        return view('penjual.pesanan.edit', compact('pesanan'));
    }

    /**
     * Proses update status pesanan dengan notifikasi
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diproses,siap_diambil,selesai,dibatalkan',
            'catatan' => 'nullable|string|max:500'
        ]);

        $pesanan = Pesanan::where('id_pedagang', Auth::id())
            ->with('mahasiswa')
            ->findOrFail($id);

        $oldStatus = $pesanan->status;
        $newStatus = $request->status;

        // Update status pesanan
        $pesanan->update([
            'status' => $newStatus
        ]);

        // Buat notifikasi untuk pembeli
        $pesan = match($newStatus) {
            'diproses' => 'Pesanan Anda sedang diproses oleh penjual',
            'siap_diambil' => 'Pesanan Anda sudah siap diambil!',
            'selesai' => 'Pesanan Anda telah selesai',
            'dibatalkan' => 'Pesanan Anda dibatalkan oleh penjual',
            default => 'Status pesanan berubah'
        };

        Notifikasi::create([
            'user_id' => $pesanan->user_id,
            'pesanan_id' => $pesanan->id,
            'tipe' => 'status_update',
            'pesan' => $pesan,
            'catatan' => $request->catatan,
            'dibaca' => false
        ]);

        return redirect()->route('penjual.pesanan.index')
            ->with('success', "Status pesanan berhasil diperbarui menjadi {$newStatus}! Notifikasi dikirim ke pembeli.");
    }
}
