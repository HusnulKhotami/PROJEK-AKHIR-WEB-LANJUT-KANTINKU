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

    public function pedagang()
    {
        return $this->belongsTo(Pedagang::class, 'id_pedagang');
    }

    /**
     * Accessor untuk gambar_url agar otomatis mengarah ke /image/menu/
     * sesuai dengan struktur hosting kamu.
     */
    public function getGambarUrlAttribute($value)
    {
        // Jika tidak ada gambar → fallback default
        if (!$value) {
            return url('image/menu/default.png');
        }

        // Jika sudah URL lengkap (http/https), langsung kembalikan
        if (str_starts_with($value, 'http')) {
            return $value;
        }

        // Jika nama file saja → arahkan ke /image/menu/NAMA_FILE
        return url('image/menu/' . $value);
    }
}