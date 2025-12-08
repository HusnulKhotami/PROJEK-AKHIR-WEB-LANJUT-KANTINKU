<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Transaksi; // ⬅️ Tambahkan ini
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        // Validasi signature
        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $pesanan = Pesanan::find($request->order_id);

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        // ============================
        //  UPDATE STATUS PESANAN
        // ============================

        if ($request->transaction_status === 'capture' || $request->transaction_status === 'settlement') {
            $pesanan->update([
                'status_pembayaran' => 'success',
                'status' => 'siap'
            ]);

            $statusTransaksi = 'paid';
        }

        elseif ($request->transaction_status === 'pending') {
            $pesanan->update([
                'status_pembayaran' => 'pending'
            ]);

            $statusTransaksi = 'pending';
        }

        else { // deny, expire, cancel
            $pesanan->update([
                'status_pembayaran' => 'failed',
                'status' => 'dibatalkan'
            ]);

            $statusTransaksi = 'failed';
        }

        // ============================
        //  INSERT KE TABEL TRANSAKSI
        // ============================

        Transaksi::create([
            'id_pesanan'        => $pesanan->id,
            'jumlah'            => $request->gross_amount,
            'metode_pembayaran' => $request->payment_type ?? 'midtrans',
            'status'            => $statusTransaksi,
            'payment_date'      => now(),
            'created_at'        => now(),
            'updated_at'        => now()
        ]);

        return response()->json(['message' => 'Callback processed and transaction saved']);
    }
}