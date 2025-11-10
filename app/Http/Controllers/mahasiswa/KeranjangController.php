<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ✅ Tampilkan keranjang
    public function index()
    {
        $keranjang = Keranjang::with('menu')
            ->where('user_id', Auth::id())
            ->get();

        return view('mahasiswa.keranjang', compact('keranjang'));
    }

    // ✅ Tambah item
    public function tambah(Request $request)
    {
        $request->validate([
            'id_menu' => 'required|exists:menu,id',
            'jumlah' => 'nullable|integer|min:1'
        ]);

        $jumlah = $request->jumlah ?? 1;

        $existing = Keranjang::where('user_id', Auth::id())
            ->where('id_menu', $request->id_menu)
            ->first();

        if ($existing) {
            $existing->jumlah += $jumlah;
            $existing->save();
        } else {
            Keranjang::create([
                'user_id' => Auth::id(),
                'id_menu' => $request->id_menu,
                'jumlah' => $jumlah,
            ]);
        }

        return back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    // ✅ Kurangi item (-)
    public function kurang(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:keranjang,id'
        ]);

        $item = Keranjang::findOrFail($request->id);

        if ($item->jumlah > 1) {
            $item->jumlah -= 1;
            $item->save();
        } else {
            $item->delete();
        }

        return back();
    }

    // ✅ Hapus item
    public function hapus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:keranjang,id'
        ]);

        Keranjang::where('id', $request->id)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Item dihapus dari keranjang');
    }
}
