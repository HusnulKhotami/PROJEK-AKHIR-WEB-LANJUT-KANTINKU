<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Admin dashboard
     */
    public function index()
    {
        // Get statistics
        $totalTransaksi = \App\Models\Transaksi::count();
        $totalTransferPending = \App\Models\Transaksi::where('status', 'pending')->count();
        $totalPendapatanVerified = \App\Models\Transaksi::where('status', 'verified')->sum('total_harga');
        
        return view('admin.dashboard', compact(
            'totalTransaksi',
            'totalTransferPending',
            'totalPendapatanVerified'
        ));
    }
}
