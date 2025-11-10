<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriMenuSeeder extends Seeder
{
    public function run()
    {
        DB::table('kategori_menu')->insert([
            ['nama' => 'Makanan','deskripsi' => 'Kategori untuk semua jenis makanan','created_at' => now(),'updated_at' => now(),],
            ['nama' => 'Minuman','deskripsi' => 'Kategori untuk semua jenis minuman','created_at' => now(),'updated_at' => now(),],
            ['nama' => 'Snack','deskripsi' => 'Kategori untuk makanan ringan','created_at' => now(),'updated_at' => now(),],
        ]);
    }
}
