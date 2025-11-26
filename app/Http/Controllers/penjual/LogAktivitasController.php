<?php

namespace App\Http\Controllers\penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedagang;
use App\Models\Pesanan;
use Carbon\Carbon;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $pedagang = Pedagang::where('user_id', Auth::id())->firstOrFail();
        $pedagangId = $pedagang->id;

        // Ambil parameter GET
        $periode = $request->periode ?? 'harian';
        $tanggal = $request->tanggal ?? Carbon::now()->format('Y-m-d');
        $bulan   = $request->bulan ?? Carbon::now()->month;
        $tahun   = $request->tahun ?? Carbon::now()->year;
        $minggu  = $request->minggu ?? 1;

        // Query dasar
        $query = Pesanan::where('id_pedagang', $pedagangId)
            ->where('status', '!=', 'dibatalkan'); 

        // ============================================
        //  FILTER PER PERIODE
        // ============================================
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

        // ============================================
        //  EKSEKUSI QUERY
        // ============================================
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

    public function exportPdf(Request $request)
    {
        // sementara kosong dulu
        return "Export PDF belum dibuat";
    }

    public function exportExcel(Request $request)
    {
        // sementara kosong dulu
        return "Export Excel belum dibuat";
    }
}
