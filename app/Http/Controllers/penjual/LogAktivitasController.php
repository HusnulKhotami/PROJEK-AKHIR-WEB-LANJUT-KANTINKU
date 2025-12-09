<?php

namespace App\Http\Controllers\penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Pedagang;
use App\Models\Pesanan;
use Carbon\Carbon;
use PDF;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $pedagang = Pedagang::where('user_id', Auth::id())->firstOrFail();
        $pedagangId = $pedagang->id;

        // Parameter
        $periode = $request->periode ?? 'harian';
        $tanggal = $request->tanggal ?? Carbon::now()->format('Y-m-d');
        $bulan   = $request->bulan ?? Carbon::now()->month;
        $tahun   = $request->tahun ?? Carbon::now()->year;
        $minggu  = $request->minggu ?? 1;

        // Query dasar
        $query = Pesanan::where('id_pedagang', $pedagangId)
            ->where('status', '!=', 'dibatalkan');

        // Filter
        if ($periode === 'harian') {
            $query->whereDate('created_at', $tanggal);
            $laporan_label = 'Laporan Harian - ' . Carbon::parse($tanggal)->format('d M Y');

        } elseif ($periode === 'mingguan') {
            $startOfMonth = Carbon::create($tahun, $bulan, 1);
            $start = $startOfMonth->copy()->addWeeks($minggu - 1);
            $end   = $start->copy()->addWeek();

            $query->whereBetween('created_at', [$start, $end]);
            $laporan_label = "Laporan Mingguan - Minggu $minggu " . Carbon::create()->month($bulan)->format('F') . " $tahun";

        } elseif ($periode === 'bulanan') {
            $query->whereYear('created_at', $tahun)
                  ->whereMonth('created_at', $bulan);

            $laporan_label = 'Laporan Bulanan - ' . Carbon::create()->month($bulan)->format('F') . " $tahun";
        }

        // Eksekusi query
        $pesanan = $query->with(['mahasiswa', 'items.menu'])->get();

        $totalPesanan = $pesanan->count();
        $totalPendapatan = $pesanan->sum('total_harga');
        $rataPendapatan  = $totalPesanan > 0 ? $totalPendapatan / $totalPesanan : 0;

        // Breakdown status
        $statusBreakdown = $pesanan->groupBy('status')->map->count();

        return view('penjual.aktivitas.index', compact(
            'periode',
            'tanggal',
            'bulan',
            'tahun',
            'minggu',
            'laporan_label',
            'pesanan',
            'totalPesanan',
            'totalPendapatan',
            'rataPendapatan',
            'statusBreakdown'
        ));
    }

    // ======================================================
    // =============== EXPORT PDF ============================
    // ======================================================
    public function exportPdf(Request $request)
    {
        $pedagang = Pedagang::where('user_id', Auth::id())->firstOrFail();
        $pedagangId = $pedagang->id;

        // Parameter
        $periode = $request->periode ?? 'harian';
        $tanggal = $request->tanggal ?? Carbon::now()->format('Y-m-d');
        $bulan   = $request->bulan ?? Carbon::now()->month;
        $tahun   = $request->tahun ?? Carbon::now()->year;
        $minggu  = $request->minggu ?? 1;

        // Query dasar
        $query = Pesanan::where('id_pedagang', $pedagangId)
            ->where('status', '!=', 'dibatalkan');

        // Filter
        if ($periode === 'harian') {
            $query->whereDate('created_at', $tanggal);
            $laporan_label = 'Laporan Harian - ' . Carbon::parse($tanggal)->format('d M Y');

        } elseif ($periode === 'mingguan') {
            $startOfMonth = Carbon::create($tahun, $bulan, 1);
            $start = $startOfMonth->copy()->addWeeks($minggu - 1);
            $end   = $start->copy()->addWeek();

            $query->whereBetween('created_at', [$start, $end]);
            $laporan_label = "Laporan Mingguan - Minggu $minggu " . Carbon::create()->month($bulan)->format('F') . " $tahun";

        } elseif ($periode === 'bulanan') {
            $query->whereYear('created_at', $tahun)
                  ->whereMonth('created_at', $bulan);

            $laporan_label = 'Laporan Bulanan - ' . Carbon::create()->month($bulan)->format('F') . " $tahun";
        }

        $pesanan = $query->with(['mahasiswa', 'items.menu'])->get();

        $totalPesanan = $pesanan->count();
        $totalPendapatan = $pesanan->sum('total_harga');
        $rataPendapatan  = $totalPesanan > 0 ? $totalPendapatan / $totalPesanan : 0;

        $data = [
            'pesanan' => $pesanan,
            'totalPesanan' => $totalPesanan,
            'totalPendapatan' => $totalPendapatan,
            'rataPendapatan' => $rataPendapatan,
            'laporan_label' => $laporan_label,
        ];

        $filename = 'Laporan-Penjualan-' . Str::slug($laporan_label) . '-' . now()->format('Y-m-d-H-i-s') . '.pdf';

        $pdf = PDF::loadView('exports.laporan-penjualan-pdf', $data);
        return $pdf->download($filename);
    }

    // ======================================================
    // =============== EXPORT CSV ===========================
    // ======================================================
    public function exportCsv(Request $request)
    {
        $pedagang = Pedagang::where('user_id', Auth::id())->firstOrFail();
        $pedagangId = $pedagang->id;

        // Parameter
        $periode = $request->periode ?? 'harian';
        $tanggal = $request->tanggal ?? Carbon::now()->format('Y-m-d');
        $bulan   = $request->bulan ?? Carbon::now()->month;
        $tahun   = $request->tahun ?? Carbon::now()->year;
        $minggu  = $request->minggu ?? 1;

        // Query dasar
        $query = Pesanan::where('id_pedagang', $pedagangId)
            ->where('status', '!=', 'dibatalkan');

        // Filter
        if ($periode === 'harian') {
            $query->whereDate('created_at', $tanggal);
            $laporan_label = 'Laporan Harian - ' . Carbon::parse($tanggal)->format('d M Y');

        } elseif ($periode === 'mingguan') {
            $startOfMonth = Carbon::create($tahun, $bulan, 1);
            $start = $startOfMonth->copy()->addWeeks($minggu - 1);
            $end   = $start->copy()->addWeek();

            $query->whereBetween('created_at', [$start, $end]);
            $laporan_label = "Laporan Mingguan - Minggu $minggu " . Carbon::create()->month($bulan)->format('F') . " $tahun";

        } elseif ($periode === 'bulanan') {
            $query->whereYear('created_at', $tahun)
                  ->whereMonth('created_at', $bulan);

            $laporan_label = 'Laporan Bulanan - ' . Carbon::create()->month($bulan)->format('F') . " $tahun";
        }

        // Ambil data
        $pesanan = $query->with(['mahasiswa', 'items.menu'])->get();

        // Nama file
        $filename = 'Laporan-Penjualan-' . Str::slug($laporan_label) . '-' . now()->format('Y-m-d-H-i-s') . '.csv';

        // Header CSV
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'Tanggal',
            'Nama Mahasiswa',
            'Item Pesanan',
            'Jumlah Item',
            'Total Harga'
        ];

        // WRITE CSV
        $callback = function() use ($pesanan, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($pesanan as $row) {

                $itemList = $row->items->map(function ($i) {
                    return $i->menu->nama . ' (x' . $i->jumlah . ')';
                })->implode(', ');

                $jumlahItem = $row->items->sum('jumlah');

                fputcsv($file, [
                    $row->created_at->format('d-m-Y H:i'),
                    $row->mahasiswa->nama ?? '-',
                    $itemList,
                    $jumlahItem,
                    $row->total_harga
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

