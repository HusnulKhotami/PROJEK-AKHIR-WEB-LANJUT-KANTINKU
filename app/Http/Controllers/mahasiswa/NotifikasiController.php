<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Tampilkan semua notifikasi mahasiswa
     */
    public function index()
    {
        $notifikasi = Notifikasi::where('user_id', Auth::id())
            ->with('pesanan')
            ->orderBy('created_at', 'desc')
            ->get();

        // Mark all as read when viewing
        Notifikasi::where('user_id', Auth::id())
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        return view('mahasiswa.notifikasi', compact('notifikasi'));
    }

    /**
     * Mark notifikasi as read
     */
    public function markAsRead($id)
    {
        $notifikasi = Notifikasi::where('user_id', Auth::id())->findOrFail($id);
        $notifikasi->update(['dibaca' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Delete notifikasi
     */
    public function delete($id)
    {
        $notifikasi = Notifikasi::where('user_id', Auth::id())->findOrFail($id);
        $notifikasi->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Get unread count (untuk badge)
     */
    public function getUnreadCount()
    {
        $count = Notifikasi::where('user_id', Auth::id())
            ->where('dibaca', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}
