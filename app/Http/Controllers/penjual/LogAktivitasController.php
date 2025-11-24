<?php

namespace App\Http\Controllers\penjual;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\Pedagang;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil pedagang berdasarkan user login
        $pedagang = Pedagang::where('user_id', Auth::id())->first();

        if (!$pedagang) {
            return redirect()->back()->with('error', 'Data pedagang tidak ditemukan');
        }

        $pedagangId = $pedagang->id;
        $periode = $request->get('periode', 'harian'); // harian, mingguan, bulanan
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);

        $query = Pesanan::where('id_pedagang', $pedagangId)
                    ->with(['mahasiswa', 'item.menu']);

        // Filter berdasarkan periode
        if ($periode === 'harian') {
            $tanggal = $request->get('tanggal', Carbon::now()->format('Y-m-d'));
            $query->whereDate('created_at', $tanggal);
            $laporan_label = 'Laporan Penjualan - ' . Carbon::parse($tanggal)->format('d M Y');
        } elseif ($periode === 'mingguan') {
            $minggu_ke = $request->get('minggu', 1);
            $startDate = Carbon::createFromFormat('Y-m', "$tahun-$bulan")->startOfMonth();
            $startDate = $startDate->copy()->addDays(($minggu_ke - 1) * 7);
            $endDate = $startDate->copy()->addDays(6);
            
            $query->whereBetween('created_at', [$startDate, $endDate]);
            $laporan_label = "Laporan Penjualan - Minggu ke-$minggu_ke, $tahun-$bulan";
        } else { // bulanan
            $query->whereMonth('created_at', $bulan)
                  ->whereYear('created_at', $tahun);
            $laporan_label = 'Laporan Penjualan - ' . Carbon::createFromFormat('m-Y', "$bulan-$tahun")->format('F Y');
        }

        $pesanan = $query->latest()->get();

        // Hitung statistik
        $totalPesanan = $pesanan->count();
        $totalPendapatan = $pesanan->sum('total_harga');
        $rataPendapatan = $totalPesanan > 0 ? $totalPendapatan / $totalPesanan : 0;
        
        // Status breakdown
        $statusBreakdown = $pesanan->groupBy('status')->map->count();

        return view('penjual.aktivitas.index', compact(
            'pesanan',
            'totalPesanan',
            'totalPendapatan',
            'rataPendapatan',
            'statusBreakdown',
            'laporan_label',
            'periode',
            'bulan',
            'tahun'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Export laporan penjualan ke PDF
     */
    public function exportPdf(Request $request)
    {
        // TODO: Implementasi export PDF menggunakan library seperti DomPDF atau TCPDF
        // Untuk sekarang redirect ke halaman laporan dengan print mode
        return redirect()->route('penjual.aktivitas.index', $request->query())->with('info', 'Gunakan fitur Print dari browser untuk export PDF');
    }

    /**
     * Export laporan penjualan ke Excel
     */
    public function exportExcel(Request $request)
    {
        // TODO: Implementasi export Excel menggunakan library seperti Maatwebsite Excel
        // Untuk sekarang redirect ke halaman laporan
        return redirect()->route('penjual.aktivitas.index', $request->query())->with('info', 'Fitur export Excel akan segera diimplementasikan');
    }
}
