<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;

class LogAktvitasController extends Controller
{
    /**
     * Tampilkan daftar log aktivitas sistem.
     */
    public function index()
    {
        // Ambil log aktivitas terbaru beserta relasi user
        $activities = LogAktivitas::with('user')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.monitoring', compact('activities'));
    }
}
