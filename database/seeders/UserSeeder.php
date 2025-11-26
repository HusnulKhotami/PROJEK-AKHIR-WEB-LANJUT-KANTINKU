<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user')->insert([
            [
                'nama' => 'Admin Kantinku',
                'email' => 'admin@kantinku.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '081234567890',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Warung Bu Siti',
                'email' => 'penjual1@kantinku.com',
                'password' => Hash::make('penjual123'),
                'role' => 'penjual',
                'phone' => '081234567891',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kedai Pak Budi',
                'email' => 'penjual2@kantinku.com',
                'password' => Hash::make('penjual123'),
                'role' => 'penjual',
                'phone' => '081234567893',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Husnul',
                'email' => 'mahasiswa1@kantinku.com',
                'password' => Hash::make('mahasiswa123'),
                'role' => 'mahasiswa',
                'phone' => '081234567892',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
