<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedagangSeeder extends Seeder
{
    public function run(): void
    {
        $penjual = DB::table('user')->where('role', 'penjual')->first();

        if (!$penjual) {
            return; // berhenti kalau user penjual belum ada
        }

        DB::table('pedagang')->insert([
            [
                'user_id' => $penjual->id,
                'nama_kantin' => 'Warung Bu Siti',
                'lokasi' => 'Jalan Cengkeh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $penjual->id,
                'nama_kantin' => 'Kedai Pak Budi',
                'lokasi' => 'Kampung Baru',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
