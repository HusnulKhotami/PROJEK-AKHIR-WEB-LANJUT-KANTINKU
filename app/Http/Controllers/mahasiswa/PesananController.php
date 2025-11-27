<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DetailPesananExport;
use PDF;

class PesananController extends Controller
{
    // Halaman Status Pesanan (pesanan aktif)
    public function index()
    {
        $pesanan = Pesanan::where('user_id', Auth::id())
                          ->whereIn('status', ['proses', 'siap'])
                          ->with('pedagang')
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('mahasiswa.status', compact('pesanan'));
    }

    // Halaman Riwayat Pesanan
    public function riwayat()
    {
        $pesanan = Pesanan::where('user_id', Auth::id())
                          ->whereIn('status', ['selesai', 'dibatalkan'])
                          ->with('pedagang')
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('mahasiswa.riwayat', compact('pesanan'));
    }

    // Detail pesanan
    public function detail($id_pesanan)
    {
        $pesanan = Pesanan::with(['pedagang', 'items.menu'])
                    ->where('id', $id_pesanan)
                    ->where('user_id', auth()->id())
                    ->first();

        if (!$pesanan) {
            return redirect()->route('mahasiswa.status')
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        return view('mahasiswa.detail-pesanan', compact('pesanan'));
    }

    // Mahasiswa batalkan pesanan
    public function batal($id)
    {
        $pesanan = Pesanan::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->first();

        if (!$pesanan) {
            return back()->with('error', 'Pesanan tidak ditemukan.');
        }

        // Hanya bisa membatalkan jika status masih proses
        if ($pesanan->status !== 'proses') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses penjual.');
        }

        $pesanan->update([
            'status' => 'dibatalkan'
        ]);

        return redirect()->route('mahasiswa.status')
                ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function hapusRiwayat($id)
    {
        $pesanan = Pesanan::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->first();

        if (!$pesanan) {
            return back()->with('error', 'Pesanan tidak ditemukan.');
        }

        // hanya bisa dihapus jika selesai atau dibatalkan
        if (!in_array($pesanan->status, ['selesai', 'dibatalkan'])) {
            return back()->with('error', 'Pesanan belum bisa dihapus.');
        }

        $pesanan->items()->delete();
        $pesanan->delete();

        return back()->with('success', 'Riwayat pesanan berhasil dihapus.');
    }

    // Export Detail Pesanan ke PDF
    public function exportPdf($id)
    {
        $pesanan = Pesanan::with(['pedagang', 'items.menu'])
                    ->where('id', $id)
                    ->where('user_id', auth()->id())
                    ->first();

        if (!$pesanan) {
            return redirect()->route('mahasiswa.status')
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        $filename = 'Detail-Pesanan-' . $pesanan->id . '-' . now()->format('Y-m-d-H-i-s') . '.pdf';

        $pdf = PDF::loadView('exports.detail-pesanan-pdf', [
            'pesanan' => $pesanan,
        ]);
        
        return $pdf->download($filename);
    }

    // Export Detail Pesanan ke Excel
    public function exportExcel($id)
    {
        $pesanan = Pesanan::with(['pedagang', 'items.menu'])
                    ->where('id', $id)
                    ->where('user_id', auth()->id())
                    ->first();

        if (!$pesanan) {
            return redirect()->route('mahasiswa.status')
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        $filename = 'Detail-Pesanan-' . $pesanan->id . '-' . now()->format('Y-m-d-H-i-s') . '.xlsx';

        return Excel::download(new DetailPesananExport($pesanan), $filename);
    }

}
