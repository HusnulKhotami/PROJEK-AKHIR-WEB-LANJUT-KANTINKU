<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        $transaksi = Transaksi::create([
            'id_pesanan' => $request->id_pesanan,
            'jumlah' => $request->jumlah,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => $request->status,
            'payment_date' => now()
        ]);

        return response()->json(['message' => 'Transaksi berhasil disimpan', 'data' => $transaksi]);
    }

    public function index()
    {
        $data = Transaksi::orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }
}