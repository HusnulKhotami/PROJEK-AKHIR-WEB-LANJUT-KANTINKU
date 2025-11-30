<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $pedagang1 = DB::table('pedagang')->first();
        $pedagang2 = DB::table('pedagang')->skip(1)->first();

        DB::table('menu')->insert([
            [
                'id_pedagang'  => $pedagang1->id,
                'kategori_id'  => 1,
                'nama'         => 'Nasi Goreng Spesial',
                'deskripsi'    => 'Nasi goreng dengan telur dan ayam.',
                'harga'        => 15000,
                'stok'         => 20,
                'gambar_url'   => 'menu/nasgor.jpg',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pedagang'  => $pedagang1->id,
                'kategori_id'  => 2,
                'nama'         => 'Es Teh Manis',
                'deskripsi'    => 'Teh manis dingin.',
                'harga'        => 5000,
                'stok'         => 50,
                'gambar_url'   => 'menu/esteh.jpg',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pedagang'  => $pedagang2->id,
                'kategori_id'  => 3,
                'nama'         => 'Risoles Mayo',
                'deskripsi'    => 'Risoles isi mayones dan smoked beef.',
                'harga'        => 7000,
                'stok'         => 30,
                'gambar_url'   => 'menu/risol.jpg',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pedagang'  => $pedagang2->id,
                'kategori_id'  => 2,
                'nama'         => 'Jus Alpukat',
                'deskripsi'    => 'Alpukat dihasilkan dari kebun sendiri.',
                'harga'        => 5000,
                'stok'         => 30,
                'gambar_url'   => 'menu/jus.jpg',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pedagang'  => $pedagang2->id,
                'kategori_id'  => 1,
                'nama'         => 'Mie Goreng',
                'deskripsi'    => 'Mie mengandung protein tinggi.',
                'harga'        => 5000,
                'stok'         => 30,
                'gambar_url'   => 'menu/miegoreng.jpg',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pedagang'  => $pedagang2->id,
                'kategori_id'  => 1,
                'nama'         => 'Bakso',
                'deskripsi'    => 'Bakso dibuat seperti anak sendiri.',
                'harga'        => 10000,
                'stok'         => 30,
                'gambar_url'   => 'menu/bakso.jpg',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pedagang'  => $pedagang2->id,
                'kategori_id'  => 1,
                'nama'         => 'Mie Ayam',
                'deskripsi'    => 'Mie yang dibuat dari anak sendiri',
                'harga'        => 5000,
                'stok'         => 30,
                'gambar_url'   => 'menu/mieayam.jpg',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pedagang'  => $pedagang2->id,
                'kategori_id'  => 2,
                'nama'         => 'Es teh pt 2',
                'deskripsi'    => 'Es dengan segala energi.',
                'harga'        => 5000,
                'stok'         => 30,
                'gambar_url'   => 'menu/esteh.jpg',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);

    }
}
