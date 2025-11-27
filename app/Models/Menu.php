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
        // Jika tidak ada gambar → pakai default placeholder
        if (!$value) {
            return 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 400 300%22%3E%3Crect fill=%22%23e5e7eb%22 width=%22400%22 height=%22300%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2224%22 fill=%22%23999%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E';
        }

        // Jika URL penuh sudah http
        if (str_starts_with($value, 'http')) {
            return $value;
        }

        // Handle berbagai format path yang mungkin tersimpan:
        // 1. Seeder lama: "menu/nasi goreng.jpg" → ubah ke "image/menu/nasi goreng.jpg"
        // 2. Upload baru: "image/menu/filename.jpg" → biarkan apa adanya
        // 3. Dari storage: "image/menu/xyz.jpg" → sudah benar
        
        if (str_starts_with($value, 'image/menu/')) {
            // Sudah benar, langsung ke storage
            return asset('storage/' . $value);
        } elseif (str_starts_with($value, 'menu/')) {
            // Format lama seeder, tambahkan 'image/' di depan
            return asset('storage/image/' . $value);
        } else {
            // Format lain, coba di storage/image/menu
            return asset('storage/image/menu/' . $value);
        }
    }
}
