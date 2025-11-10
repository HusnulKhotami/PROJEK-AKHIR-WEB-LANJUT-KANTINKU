<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';

    protected $fillable = [
        'user_id',
        'id_menu',
        'jumlah'
    ];

    // ✅ Relasi ke Menu → PENTING! ini yang dibutuhkan line 45
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }

    // ✅ Relasi ke User → tabel kamu bernama 'user' bukan 'users'
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}