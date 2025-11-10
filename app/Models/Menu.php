<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $fillable = [
        'id_pedagang',
        'kategori_id',
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'gambar_url'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriMenu::class, 'kategori_id');
    }

    // ✅ accessor gambar
    public function getGambarUrlAttribute($value)
    {
        if (!$value) {
            return asset('image/menu/default.png'); // fallback
        }

        if (str_starts_with($value, 'http')) {
            return $value;
        }

        return asset($value); // contoh: image/menu/nasi_goreng.png
    }
}
