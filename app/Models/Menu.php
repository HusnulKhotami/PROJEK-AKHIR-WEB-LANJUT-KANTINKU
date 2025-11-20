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

    /**
     * Accessor gambar_url → otomatis menghasilkan asset('storage/menu/...').
     */
    public function pedagang(){
        
        return $this->belongsTo(Pedagang::class, 'id_pedagang');
    }
    public function getGambarUrlAttribute($value)
    {
        // Jika tidak ada gambar → pakai default
        if (!$value) {
            return asset('storage/menu/default.png');
        }

        // Jika URL penuh sudah http
        if (str_starts_with($value, 'http')) {
            return $value;
        }

        // Pastikan path benar: storage/menu/namafile.jpg
        return asset('storage/' . $value);
    }
}
