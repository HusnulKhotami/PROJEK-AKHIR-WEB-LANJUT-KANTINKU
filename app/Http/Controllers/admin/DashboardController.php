<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Pedagang;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalPenjual   = User::where('role', 'penjual')->count();
        $totalTransaksi = Pesanan::count();
        $totalKantin    = Pedagang::count();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalPenjual',
            'totalTransaksi',
            'totalKantin'
        ));
    }
}
