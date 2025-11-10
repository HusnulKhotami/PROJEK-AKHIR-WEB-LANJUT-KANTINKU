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
                'gambar_url'   => 'image/menu/nasgor.jpg',
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
                'gambar_url'   => 'image/menu/este.jpg',
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
                'gambar_url'   => 'image/menu/risol.jpg',
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
                'gambar_url'   => 'image/menu/miegoreng.jpg',
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
                'gambar_url'   => 'image/menu/miegoreng.jpg',
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
                'gambar_url'   => 'image/menu/miegoreng.jpg',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pedagang'  => $pedagang2->id,
                'kategori_id'  => 1,
                'nama'         => 'Mie Goreng',
                'deskripsi'    => 'Mie mengandung zat besi.',
                'harga'        => 5000,
                'stok'         => 30,
                'gambar_url'   => 'image/menu/miegoreng.jpg',
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
                'gambar_url'   => 'image/menu/esteh.jpg',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);

    }
}
