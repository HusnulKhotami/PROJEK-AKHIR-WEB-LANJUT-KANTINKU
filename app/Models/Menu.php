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
<<<<<<< Updated upstream
        if (!$value) {
            return asset('image/menu/default.png'); // fallback
=======
        // Jika tidak ada gambar → pakai default placeholder
        if (!$value) {
            return asset('image/default-menu.svg');
>>>>>>> Stashed changes
        }

        if (str_starts_with($value, 'http')) {
            return $value;
        }

<<<<<<< Updated upstream
        return asset($value); // contoh: image/menu/nasi_goreng.png
=======
        // Jika path ada di storage (image/menu/...)
        if (file_exists(storage_path('app/public/' . $value))) {
            return asset('storage/' . $value);
        }

        // Cek di public/image/menu/ sebagai fallback
        $publicPath = str_replace('image/menu/', '', $value);
        if (file_exists(public_path('image/menu/' . $publicPath))) {
            return asset('image/menu/' . $publicPath);
        }

        // Fallback ke placeholder
        return asset('image/default-menu.svg');
>>>>>>> Stashed changes
    }
}
