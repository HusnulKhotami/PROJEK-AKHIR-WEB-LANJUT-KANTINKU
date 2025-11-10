<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\KategoriMenu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search     = $request->search;
        $kategori   = $request->kategori;
        $harga_min  = $request->harga_min;
        $harga_max  = $request->harga_max;

        $query = Menu::with('kategori');

        // Search nama, kategori, deskripsi
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")
                ->orWhereHas('kategori', function ($cat) use ($search) {
                    $cat->where('nama', 'like', "%{$search}%");
                });
            });
        }

        // Filter kategori
        if ($kategori) {
            $query->whereHas('kategori', function ($q) use ($kategori) {
                $q->where('nama', $kategori);
            });
        }

        // Filter harga
        if ($harga_min !== null && $harga_min !== '') {
            $query->where('harga', '>=', (int)$harga_min);
        }

        if ($harga_max !== null && $harga_max !== '') {
            $query->where('harga', '<=', (int)$harga_max);
        }

        $menu = $query->get();
        $kategoriList = KategoriMenu::all();

        return view('mahasiswa.menu-mhs', compact('menu', 'kategoriList'));
    }
}