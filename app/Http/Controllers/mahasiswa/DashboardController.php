<?php
namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\KategoriMenu;

class DashboardController extends Controller
{
    public function index()
    {
        $menuFavorit = Menu::with('kategori')
            ->inRandomOrder()
            ->take(6)
            ->get();

        // Buat URL gambar yang benar
        foreach ($menuFavorit as $m) {
            $m->full_url = asset('storage/menu/' . $m->gambar_url);
        }

        $kategoriList = KategoriMenu::all();

        return view('mahasiswa.dashboard', compact('menuFavorit', 'kategoriList'));
    }
}
