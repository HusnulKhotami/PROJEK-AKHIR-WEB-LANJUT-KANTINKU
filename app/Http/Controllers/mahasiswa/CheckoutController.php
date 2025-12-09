<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\ItemPesanan;
use App\Models\Notifikasi;
use App\Models\Menu;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    // public function checkout(Request $request)
    // {
    //     $request->validate([
    //         'metode_pembayaran' => 'required',
    //         'catatan' => 'nullable|string|max:255'
    //     ]);

    //     $user = Auth::user();

    //     if (!$user || !\App\Models\User::find($user->id)) {
    //         return back()->with('error', 'User tidak ditemukan dalam database!');
    //     }

    //     $keranjang = Keranjang::with('menu')
    //         ->where('user_id', $user->id)
    //         ->get();

    //     if ($keranjang->count() === 0) {
    //         return back()->with('error', 'Keranjang masih kosong!');
    //     }

    //     // Hitung total harga
    //     $total = 0;
    //     foreach ($keranjang as $item) {
    //         $total += $item->menu->harga * $item->jumlah;
    //     }

    //     // Buat pesanan
    //      $pesanan = Pesanan::create([
    //             'user_id' => $user->id,
    //             'id_pedagang' => $keranjang->first()->menu->id_pedagang,
    //             'status' => 'proses',
    //             'total_harga' => $total,
    //             'metode_pembayaran' => $request->metode_pembayaran,
    //             'catatan' => $request->catatan,
    //     ]);


    //     // buat notifikasi untuk user
    //     Notifikasi::create([
    //         'user_id' => $user->id,
    //         'pesan' => 'Pesanan baru berhasil dibuat. Menunggu proses dari penjual.',
    //         'status' => 'belum_dibaca'
    //     ]);



    //     // menyimpen item menu dan mengurangi stok
    //     foreach ($keranjang as $item) {

    //         $menu = Menu::find($item->id_menu);

    //         if ($menu->stok < $item->jumlah) {
    //             return back()->with('error', 'Stok menu "' . $menu->nama . '" tidak mencukupi!');
    //         }

    //         // kurangi stok
    //         $menu->stok -= $item->jumlah;
    //         $menu->save();

    //         //menyimpan item pesanan
    //         ItemPesanan::create([
    //             'id_pesanan' => $pesanan->id,
    //             'id_menu'    => $item->id_menu,
    //             'jumlah'     => $item->jumlah,
    //             'harga'      => $item->menu->harga,
    //             'subtotal'   => $item->menu->harga * $item->jumlah,
    //         ]);
    //     }

    //     Keranjang::where('user_id', $user->id)->delete();

    //     return redirect()
    //         ->route('mahasiswa.detail-pesanan', $pesanan->id)
    //         ->with('success', 'Pesanan berhasil dibuat dan stok diperbarui!');
    // }

    // midtrans
    public function checkout(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:cash,transfer',
            'catatan' => 'nullable|string|max:255'
        ]);

        $user = Auth::user();

        $keranjang = Keranjang::with('menu')
            ->where('user_id', $user->id)
            ->get();

        if ($keranjang->count() === 0) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        $total = $keranjang->sum(function ($item) {
            return $item->menu->harga * $item->jumlah;
        });

        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'id_pedagang' => $keranjang->first()->menu->id_pedagang,
            'status' => 'proses',
            'total_harga' => $total,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => 'pending', 
            'catatan' => $request->catatan,
        ]);

        foreach ($keranjang as $item) {
            $menu = Menu::find($item->id_menu);

            if ($menu->stok < $item->jumlah) {
                return back()->with('error', 'Stok menu "' . $menu->nama . '" tidak mencukupi!');
            }

            $menu->stok -= $item->jumlah;
            $menu->save();

            ItemPesanan::create([
                'id_pesanan' => $pesanan->id,
                'id_menu'    => $item->id_menu,
                'jumlah'     => $item->jumlah,
                'harga'      => $item->menu->harga,
                'subtotal'   => $item->menu->harga * $item->jumlah,
            ]);
        }

        Keranjang::where('user_id', $user->id)->delete();


        if ($request->metode_pembayaran === 'cash') {
            return redirect()
                ->route('mahasiswa.detail-pesanan', $pesanan->id)
                ->with('success', 'Pesanan berhasil dibuat!');
        }



        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $pesanan->id,
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $pesanan->update([
            'snap_token' => $snapToken
        ]);

        return view('mahasiswa.snap', compact('snapToken', 'pesanan'));
    }

}
