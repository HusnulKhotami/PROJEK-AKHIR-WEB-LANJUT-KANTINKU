<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PDF;

class TransaksiController extends Controller
{
    /**
     * Build koleksi DTO transaksi
     */
    protected function buildTransaksiCollection($rawTransaksi = null): Collection
    {
        if ($rawTransaksi === null) {
            $rawTransaksi = Transaksi::with(['pesanan.mahasiswa', 'pesanan.items', 'pesanan.pedagang'])
                ->orderByDesc('created_at')
                ->get();
        }

        return $rawTransaksi->map(function ($trx) {
            $pesanan   = $trx->pesanan;
            $mahasiswa = optional($pesanan)->mahasiswa;
            $items     = optional($pesanan)->items ?? collect();

            $dto               = new \stdClass();
            $dto->id           = $trx->id;
            $dto->id_transaksi = 'TRX' . str_pad($trx->id, 3, '0', STR_PAD_LEFT);
            $dto->nama_pemesan = $mahasiswa->nama ?? '-';
            $dto->item         = $items->count() . ' item';
            $dto->total        = $trx->jumlah;

            // Mapping status Midtrans -> label tampilan
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

            $dto->status_raw = $status;

            // ========== FIX TANGGAL AGAR MUNCUL DI PDF ==========
            $actualDate = $trx->payment_date ?? $trx->created_at;
            $dto->tanggal = optional($actualDate)->format('d-m-Y H:i');

            return $dto;
        });
    }

    /**
     * Halaman transaksi + FILTER status & tanggal
     */
    public function index(Request $request)
    {
        $filterStatus  = $request->status;   // Berhasil | Pending | Gagal
        $filterTanggal = $request->tanggal;  // yyyy-mm-dd

        // Query dasar ke DB (filter di level DB agar efisien)
        $query = Transaksi::with(['pesanan.mahasiswa', 'pesanan.items', 'pesanan.pedagang'])
            ->orderByDesc('created_at');

        // Filter status (pakai status raw Midtrans)
        if ($filterStatus) {
            $map = [
                'Berhasil' => 'paid',
                'Pending'  => 'pending',
                'Gagal'    => 'failed',
            ];

            $raw = $map[$filterStatus] ?? null;
            if ($raw) {
                $query->where('status', $raw);
            }
        }

        // Filter tanggal
        if ($filterTanggal) {
            $query->whereDate(\DB::raw('COALESCE(payment_date, created_at)'), $filterTanggal);
        }

        // Ambil hasil query
        $rawTransaksi = $query->get();

        // Bentuk DTO
        $transaksi = $this->buildTransaksiCollection($rawTransaksi);

        return view('admin.transaksi.index', [
            'transaksi' => $transaksi,
            'status'    => $filterStatus,
            'tanggal'   => $filterTanggal,
        ]);
    }

    /**
     * Detail transaksi
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

    /**
     * Export PDF
     */
    public function exportPdf()
    {
        $transaksi = $this->buildTransaksiCollection();

        $pdf = PDF::loadView('admin.transaksi.export-pdf', compact('transaksi'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-transaksi.pdf');
    }

    /**
     * Export CSV
     */
    public function exportExcel()
    {
        $transaksi = $this->buildTransaksiCollection();
        $fileName  = 'laporan-transaksi.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($transaksi) {
            $handle = fopen('php://output', 'w');

            // Header CSV
            fputcsv($handle, [
                'ID Transaksi', 'Nama Pemesan', 'Item', 'Total', 'Status', 'Tanggal',
            ]);

            // Isi data
            foreach ($transaksi as $t) {
                fputcsv($handle, [
                    $t->id_transaksi,
                    $t->nama_pemesan,
                    $t->item,
                    $t->total,
                    $t->status,
                    $t->tanggal,  // sudah dalam format siap tampil
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
