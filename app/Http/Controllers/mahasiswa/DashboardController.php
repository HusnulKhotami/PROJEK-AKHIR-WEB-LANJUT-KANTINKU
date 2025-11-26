<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\KategoriMenu;
use App\Models\Keranjang;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // MENU FAVORIT
        $menuFavorit = Menu::with('kategori')
            ->inRandomOrder()
            ->take(6)
            ->get();

        foreach ($menuFavorit as $m) {
            $m->full_url = asset('storage/menu/' . $m->gambar_url);
        }

        // KATEGORI MENU
        $kategoriList = KategoriMenu::all();

        // DEFAULT VALUE
        $countKeranjang = 0;
        $countNotif = 0;
        $notifList = [];

        // JIKA LOGIN
        if (Auth::check()) {
            $userId = Auth::id();

            // JUMLAH ITEM DI KERANJANG
            $countKeranjang = Keranjang::where('user_id', $userId)->sum('jumlah');

            // JUMLAH NOTIFIKASI BELUM DIBACA
            $countNotif = Notifikasi::where('user_id', $userId)
                ->where('status', 'belum_dibaca')
                ->count();

            // LIST 5 NOTIFIKASI TERBARU
            $notifList = Notifikasi::where('user_id', $userId)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('mahasiswa.dashboard', compact(
            'menuFavorit',
            'kategoriList',
            'countKeranjang',
            'countNotif',
            'notifList'
        ));
    }
}
