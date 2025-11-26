<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\ItemPesanan;
use App\Models\Menu; 

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required',
            'catatan' => 'nullable|string|max:255'
        ]);

        $user = Auth::user();

        if (!$user || !\App\Models\User::find($user->id)) {
            return back()->with('error', 'User tidak ditemukan dalam database!');
        }

        $keranjang = Keranjang::with('menu')
            ->where('user_id', $user->id)
            ->get();

        if ($keranjang->count() === 0) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        // Hitung total harga
        $total = 0;
        foreach ($keranjang as $item) {
            $total += $item->menu->harga * $item->jumlah;
        }

        // Buat pesanan
         $pesanan = Pesanan::create([
                'user_id' => $user->id,
                'id_pedagang' => $keranjang->first()->menu->id_pedagang,
                'status' => 'proses',
                'total_harga' => $total,
                'metode_pembayaran' => $request->metode_pembayaran,
                'catatan' => $request->catatan,
        ]);


        // menyimpen item menu dan mengurangi stok
        foreach ($keranjang as $item) {

            $menu = Menu::find($item->id_menu);

            if ($menu->stok < $item->jumlah) {
                return back()->with('error', 'Stok menu "' . $menu->nama . '" tidak mencukupi!');
            }

            // kurangi stok
            $menu->stok -= $item->jumlah;
            $menu->save();

            //menyimpan item pesanan
            ItemPesanan::create([
                'id_pesanan' => $pesanan->id,
                'id_menu'    => $item->id_menu,
                'jumlah'     => $item->jumlah,
                'harga'      => $item->menu->harga,
                'subtotal'   => $item->menu->harga * $item->jumlah,
            ]);
        }

        Keranjang::where('user_id', $user->id)->delete();

        return redirect()
            ->route('mahasiswa.detail-pesanan', $pesanan->id)
            ->with('success', 'Pesanan berhasil dibuat dan stok diperbarui!');
    }
}
