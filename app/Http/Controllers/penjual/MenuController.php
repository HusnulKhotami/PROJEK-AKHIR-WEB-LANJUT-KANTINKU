<?php

namespace App\Http\Controllers\penjual;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\KategoriMenu;
use App\Models\Pedagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    private function pedagangId()
    {
        $pedagang = Pedagang::where('user_id', Auth::id())->first();

        return $pedagang->id;
    }

    public function index()
    {
        $pedagangId = $this->pedagangId();

        $menu = Menu::where('id_pedagang', $pedagangId)
                    ->with('kategori')
                    ->latest()
                    ->get();

        return view('penjual.menu.index', compact('menu'));
    }

    public function create()
    {
        $kategori = KategoriMenu::all();
        return view('penjual.menu.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'kategori_id' => 'required|integer',
            'deskripsi' => 'nullable|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('image/menu', 'public');
        }

        Menu::create([
            'id_pedagang' => $this->pedagangId(),
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar_url' => $path,
        ]);

        return redirect()->route('penjual.menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $pedagangId = $this->pedagangId();

        $menu = Menu::where('id_pedagang', $pedagangId)->findOrFail($id);
        $kategori = KategoriMenu::all();

        return view('penjual.menu.edit', compact('menu', 'kategori'));
    }

    public function update(Request $request, string $id)
    {
        $pedagangId = $this->pedagangId();

        $menu = Menu::where('id_pedagang', $pedagangId)->findOrFail($id);

        $request->validate([
            'nama' => 'required|max:100',
            'kategori_id' => 'required|integer',
            'deskripsi' => 'nullable|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $menu->gambar_url = $request->file('gambar')->store('image/menu', 'public');
        }

        $menu->update([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar_url' => $menu->gambar_url,
        ]);

        return redirect()->route('penjual.menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pedagangId = $this->pedagangId();

        $menu = Menu::where('id_pedagang', $pedagangId)->findOrFail($id);
        $menu->delete();

        return redirect()->route('penjual.menu.index')->with('success', 'Menu berhasil dihapus.');
    }
}
