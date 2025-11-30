<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pesanan;

// PDF & Excel
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;

class LaporanController extends Controller
{
    /**
     * Tampilkan halaman laporan keuangan.
     */
    public function index()
    {
        // Total transaksi (berdasarkan pesanan)
        $totalTransaksi = Pesanan::count();

        // Total pendapatan berdasarkan transaksi paid
        $totalPendapatan = Transaksi::where('status', 'paid')->sum('jumlah');

        // Transaksi terbaru untuk tabel laporan
        $transaksiTerbaru = Transaksi::with(['pesanan.mahasiswa'])
            ->orderByDesc('created_at')
            ->get();

        return view('admin.laporan.index', compact(
            'totalTransaksi',
            'totalPendapatan',
            'transaksiTerbaru'
        ));
    }


    /**
     * Download PDF laporan dengan timestamp.
     */
    public function downloadPdf()
    {
        $timestamp = now()->format('Y-m-d_H-i-s');

        $data = [
            'totalTransaksi'   => Pesanan::count(),
            'totalPendapatan'  => Transaksi::where('status', 'paid')->sum('jumlah'),
            'transaksiTerbaru' => Transaksi::with(['pesanan.mahasiswa'])
                                    ->orderByDesc('created_at')
                                    ->get(),
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf', $data);

        return $pdf->download("laporan-keuangan-kantinku_{$timestamp}.pdf");
    }


    /**
     * Download Excel laporan dengan timestamp.
     */
    public function downloadExcel()
    {
        $timestamp = now()->format('Y-m-d_H-i-s');

        return Excel::download(new TransaksiExport, "laporan-transaksi-kantinku_{$timestamp}.xlsx");
    }
}