<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedagangSeeder extends Seeder
{
    public function run(): void
    {
        $penjual1 = DB::table('user')->where('email', 'penjual1@kantinku.com')->first();
        $penjual2 = DB::table('user')->where('email', 'penjual2@kantinku.com')->first();

        DB::table('pedagang')->insert([
            [
                'user_id' => $penjual1->id,
                'nama_kantin' => 'Warung Bu Siti',
                'lokasi' => 'Jalan Cengkeh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $penjual2->id,
                'nama_kantin' => 'Kedai Pak Budi',
                'lokasi' => 'Kampung Baru',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
