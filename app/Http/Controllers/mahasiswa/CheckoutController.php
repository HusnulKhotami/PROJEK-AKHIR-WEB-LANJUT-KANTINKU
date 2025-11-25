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
    /**
     * Tampilkan form checkout dengan pilihan pembayaran
     */
    public function index()
    {
        $keranjang = Keranjang::where('user_id', auth()->id())
            ->with('menu')
            ->get();

        if ($keranjang->isEmpty()) {
            return redirect()->route('mahasiswa.keranjang')
                ->with('error', 'Keranjang masih kosong!');
        }

        // Filter item yang menu-nya masih ada
        $keranjang = $keranjang->filter(function ($item) {
            return $item->menu !== null;
        });

        if ($keranjang->isEmpty()) {
            return redirect()->route('mahasiswa.keranjang')
                ->with('error', 'Menu tidak tersedia!');
        }

        // Hitung total per pedagang
        $grouped = $keranjang->groupBy(fn($item) => $item->menu->id_pedagang);
        $totalKeseluruhan = $keranjang->sum(fn($item) => $item->menu->harga * $item->jumlah);

        return view('mahasiswa.checkout', compact('keranjang', 'grouped', 'totalKeseluruhan'));
    }

    /**
     * Proses checkout dan buat pesanan
     */
    public function store(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:cash,transfer',
            'bukti_transfer' => 'nullable|image|max:2048|required_if:metode_pembayaran,transfer'
        ]);

        $keranjang = Keranjang::where('user_id', auth()->id())
            ->with('menu')
            ->get();

        if ($keranjang->isEmpty()) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        // Filter item yang menu-nya sudah hilang
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
                    'status' => 'diproses',
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
                $buktiTransfer = null;
                if ($request->hasFile('bukti_transfer')) {
                    $buktiTransfer = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
                }

                Transaksi::create([
                    'id_pesanan' => $pesanan->id,
                    'jumlah' => $total_harga,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'status' => $request->metode_pembayaran === 'cash' ? 'verified' : 'pending',
                    'payment_date' => now(),
                    'bukti_transfer' => $buktiTransfer
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
                ->with('success', 'Checkout berhasil! Pesanan Anda sedang diproses.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }
}
