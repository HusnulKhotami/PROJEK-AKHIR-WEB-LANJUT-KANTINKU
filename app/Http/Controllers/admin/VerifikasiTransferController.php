<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class VerifikasiTransferController extends Controller
{
    /**
     * Tampilkan daftar transfer yang pending verifikasi
     */
    public function index()
    {
        $transaksi = Transaksi::where('status', 'pending')
            ->with(['pesanan.mahasiswa', 'pesanan.pedagang'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPending = $transaksi->count();
        $totalNominal = $transaksi->sum('total_harga');

        return view('admin.verifikasi-transfer', compact('transaksi', 'totalPending', 'totalNominal'));
    }

    /**
     * Verifikasi atau tolak transfer
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'catatan' => 'nullable|string|max:500'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $pesanan = $transaksi->pesanan;

        $oldStatus = $transaksi->status;
        $newStatus = $request->status;

        // Update transaksi status
        $transaksi->update([
            'status' => $newStatus,
            'catatan_admin' => $request->catatan
        ]);

        // Jika verified, update pesanan status menjadi diproses
        if ($newStatus === 'verified') {
            if ($pesanan->status === 'dibatalkan') {
                // Jangan update jika sudah dibatalkan
            } else {
                $pesanan->update(['status' => 'diproses']);
            }

            $notifikasiPesan = 'Pembayaran Anda telah terverifikasi. Pesanan sedang diproses.';
        } else {
            // Rejected
            $pesanan->update(['status' => 'dibatalkan']);
            $notifikasiPesan = 'Pembayaran Anda ditolak. Pesanan dibatalkan. Silakan hubungi penjual.';
        }

        // Create notifikasi untuk user (mahasiswa)
        Notifikasi::create([
            'user_id' => $pesanan->user_id,
            'pesanan_id' => $pesanan->id,
            'tipe' => 'verifikasi_transfer',
            'pesan' => $notifikasiPesan,
            'catatan' => $request->catatan,
            'dibaca' => false
        ]);

        // Create notifikasi untuk pedagang
        Notifikasi::create([
            'user_id' => $pesanan->pedagang_id,
            'pesanan_id' => $pesanan->id,
            'tipe' => 'verifikasi_transfer',
            'pesan' => $newStatus === 'verified' 
                ? 'Pembayaran transfer dari pembeli telah terverifikasi. Pesanan dapat diproses.'
                : 'Pembayaran transfer ditolak. Pesanan dibatalkan.',
            'catatan' => $request->catatan,
            'dibaca' => false
        ]);

        return redirect()->route('admin.verifikasi.index')
            ->with('success', "Transfer berhasil di-{$newStatus}! Notifikasi dikirim ke mahasiswa dan penjual.");
    }
}
