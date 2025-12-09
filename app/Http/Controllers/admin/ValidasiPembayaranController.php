<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidasiPembayaranController extends Controller
{
    /**
     * List pesanan yang perlu divalidasi (cash & pending).
     */
    public function index()
    {
        $pesanan = Pesanan::with(['mahasiswa', 'pedagang'])
            ->where('metode_pembayaran', 'cash')
            ->where('status_pembayaran', 'pending')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.validasi.index', compact('pesanan'));
    }

    /**
     * Konfirmasi bahwa pesanan sudah dibayar.
     */
    public function konfirmasi(Pesanan $pesanan)
    {
        // Safety: hanya untuk metode cash
        if ($pesanan->metode_pembayaran !== 'cash') {
            abort(404);
        }

        DB::transaction(function () use ($pesanan) {
            // 1. Update status pembayaran di tabel pesanan
            $pesanan->update([
                'status_pembayaran' => 'success',
            ]);

            // 2. Buat / update record transaksi-nya
            $pesanan->transaksi()->updateOrCreate(
                ['id_pesanan' => $pesanan->id],
                [
                    'jumlah'            => $pesanan->total_harga,
                    'metode_pembayaran' => 'cash',
                    'status'            => 'paid',
                    'payment_date'      => now(),
                ]
            );
        });

        return redirect()
            ->route('admin.validasi')
            ->with('success', 'Pembayaran pesanan berhasil divalidasi.');
    }
}