<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Keranjang;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class MahasiswaNavbarComposer
{
    public function compose(View $view)
    {
        $countKeranjang = 0;
        $countNotif = 0;
        $notifList = [];

        if (Auth::check()) {
            $userId = Auth::id();

            $countKeranjang = Keranjang::where('user_id', $userId)->sum('jumlah');

            $countNotif = Notifikasi::where('user_id', $userId)
                ->where('status', 'belum_dibaca')
                ->count();

            $notifList = Notifikasi::where('user_id', $userId)
                ->latest()
                ->take(5)
                ->get();
        }

        $view->with([
            'countKeranjang' => $countKeranjang,
            'countNotif'     => $countNotif,
            'notifList'      => $notifList,
        ]);
    }
}
