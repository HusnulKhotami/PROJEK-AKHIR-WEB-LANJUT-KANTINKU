<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    // Tampilan halaman notifikasi penuh
    public function notifikasi(Request $request)
    {
        $notif = Notifikasi::where('user_id', Auth::id())
            ->latest()
            ->get();

        // untuk AJAX (popup navbar)
        if ($request->ajax()) {
            return response()->json([
                'count' => Notifikasi::where('user_id', Auth::id())
                            ->where('status', 'belum_dibaca')
                            ->count(),
                'list' => $notif->take(5)->map(function($n) {
                    return [
                        'id' => $n->id,
                        'pesan' => $n->pesan,
                        'waktu' => $n->created_at->diffForHumans(),
                    ];
                })
            ]);
        }

        // untuk halaman notifikasi penuh
        return view('mahasiswa.notifikasi', compact('notif'));
    }


    public function read($id)
    {
        Notifikasi::where('id', $id)
            ->where('user_id', Auth::id())
            ->update(['status' => 'dibaca']);

        return back();
    }

    public function destroy($id)
    {
        Notifikasi::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back();
    }
}
