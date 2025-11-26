<?php

namespace App\Http\Controllers\penjual;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Pedagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        $pedagang = Pedagang::where('user_id', Auth::id())->firstOrFail();

        $pesanan = Pesanan::where('id_pedagang', $pedagang->id)
            ->with(['mahasiswa', 'items.menu'])
            ->latest()
            ->get();

        return view('penjual.pesanan.index', compact('pesanan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:proses,siap,selesai,dibatalkan'
        ]);

        $pedagang = Pedagang::where('user_id', Auth::id())->firstOrFail();

        $pesanan = Pesanan::where('id_pedagang', $pedagang->id)
            ->findOrFail($id);

        // Jika dibatalkan → hapus pesanan
        if ($request->status == 'dibatalkan') {

            // Hapus item di pesanan
            $pesanan->items()->delete();

            // Hapus pesanan
            $pesanan->delete();

            return redirect()->route('penjual.pesanan.index')
                ->with('success', 'Pesanan berhasil dibatalkan & dihapus!');
        }

        // Update status lainnya
        $pesanan->update([
            'status' => $request->status
        ]);

        return redirect()->route('penjual.pesanan.index')
            ->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pedagang = Pedagang::where('user_id', Auth::id())->firstOrFail();

        $pesanan = Pesanan::where('id_pedagang', $pedagang->id)
            ->findOrFail($id);

        if (!in_array($pesanan->status, ['selesai', 'dibatalkan'])) {
            return back()->with('error', 'Hanya pesanan selesai atau dibatalkan yang dapat dihapus.');
        }

        $pesanan->items()->delete();
        $pesanan->delete();

        return back()->with('success', 'Pesanan berhasil dihapus!');
    }
}
