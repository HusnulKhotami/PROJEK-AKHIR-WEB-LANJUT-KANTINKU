<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\ItemPesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:cash,ewallet,transfer'
        ]);

        $keranjang = Keranjang::where('user_id', auth()->id())
            ->with('menu')
            ->get();

        if ($keranjang->isEmpty()) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        // FILTER item yang menu-nya sudah hilang
        $keranjang = $keranjang->filter(function ($item) {
            return $item->menu !== null;
        });

        if ($keranjang->isEmpty()) {
            return back()->with('error', 'Menu tidak tersedia!');
        }

        DB::beginTransaction();

        try {
            // Kelompokkan berdasarkan pedagang
            $grouped = $keranjang->groupBy(fn($item) => $item->menu->id_pedagang);

            $pesananPertama = null;

            foreach ($grouped as $id_pedagang => $items) {

                // Hitung total harga
                $total_harga = $items->sum(
                    fn($item) => $item->menu->harga * $item->jumlah
                );

                // Buat pesanan
                $pesanan = Pesanan::create([
                    'user_id' => auth()->id(),
                    'id_pedagang' => $id_pedagang,
                    'status' => 'proses',
                    'total_harga' => $total_harga,
                    'metode_pembayaran' => $request->metode_pembayaran
                ]);

                // Buat item pesanan
                foreach ($items as $item) {
                    ItemPesanan::create([
                        'id_pesanan' => $pesanan->id,
                        'id_menu' => $item->id_menu,
                        'jumlah' => $item->jumlah,
                        'harga' => $item->menu->harga,
                        'subtotal' => $item->menu->harga * $item->jumlah
                    ]);
                }

                // Buat transaksi
                Transaksi::create([
                    'id_pesanan' => $pesanan->id,
                    'jumlah' => $total_harga,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'status' => 'pending'
                ]);

                if (!$pesananPertama) {
                    $pesananPertama = $pesanan->id;
                }
            }

            // Hapus keranjang user
            Keranjang::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()
                ->route('mahasiswa.detail-pesanan', $pesananPertama)
                ->with('success', 'Checkout berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }
}
