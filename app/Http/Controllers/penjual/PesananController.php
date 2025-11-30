<?php

namespace App\Http\Controllers\penjual;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Pedagang;
use App\Models\Notifikasi;
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

        // oesanan dibatalkan diapus
        if ($request->status == 'dibatalkan') {

            $pesanan->items()->delete();
            $pesanan->delete();

            return redirect()->route('penjual.pesanan.index')
                ->with('success', 'Pesanan berhasil dibatalkan & dihapus!');
        }

        $pesanan->update([
            'status' => $request->status
        ]);
   
        $pesanNotif = match ($request->status) {
            'proses'  => 'Pesanan kamu sedang diproses penjual.',
            'siap'    => 'Pesanan kamu sudah siap diambil!',
            'selesai' => 'Pesanan kamu sudah selesai.',
            default   => 'Pesanan diperbarui.'
        };

         Notifikasi::create([
            'user_id' => $pesanan->user_id,
            'pesan' => $pesanNotif,
            'status' => 'belum_dibaca'
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

        return redirect()->route('penjual.pesanan.index')
            ->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
