<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    /**
     * Tampilkan daftar transaksi di halaman admin.
     */
    public function index()
    {
        // Ambil semua transaksi beserta relasi pesanan dan mahasiswa (user)
        $rawTransaksi = Transaksi::with(['pesanan.mahasiswa', 'pesanan.items'])
            ->orderByDesc('created_at')
            ->get();

        // Bentuk objek yang lebih mudah dipakai di Blade (sesuai yang sudah ada di view)
        $transaksi = $rawTransaksi->map(function ($trx) {
            $pesanan   = $trx->pesanan;
            $mahasiswa = optional($pesanan)->mahasiswa;
            $items     = optional($pesanan)->items ?? collect();

            $dto              = new \stdClass();
            $dto->id          = $trx->id;
            $dto->id_transaksi = 'TRX' . str_pad($trx->id, 3, '0', STR_PAD_LEFT);
            $dto->nama_pemesan = $mahasiswa->nama ?? '-';
            $dto->item         = $items->count() . ' item';
            $dto->total        = $trx->jumlah;

            // Mapping status untuk tampilan
            $status = $trx->status;
            if ($status === 'paid') {
                $dto->status = 'Berhasil';
            } elseif ($status === 'pending') {
                $dto->status = 'Pending';
            } elseif ($status === 'failed') {
                $dto->status = 'Gagal';
            } else {
                $dto->status = ucfirst($status);
            }

            $dto->status_raw   = $status;
            $dto->payment_date = $trx->payment_date;
            $dto->created_at   = $trx->created_at;

            return $dto;
        });

        return view('admin.transaksi.index', compact('transaksi'));
    }

    /**
     * Detail transaksi tertentu.
     */
    public function detail($id)
    {
        $trx = Transaksi::with(['pesanan.mahasiswa', 'pesanan.items.menu', 'pesanan.pedagang'])
            ->findOrFail($id);

        $pesanan   = $trx->pesanan;
        $mahasiswa = optional($pesanan)->mahasiswa;
        $items     = optional($pesanan)->items ?? collect();
        $pedagang  = optional($pesanan)->pedagang;

        return view('admin.transaksi.detail', compact(
            'trx',
            'pesanan',
            'mahasiswa',
            'items',
            'pedagang'
        ));
    }
}
