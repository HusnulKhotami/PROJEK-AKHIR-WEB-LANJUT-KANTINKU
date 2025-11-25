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
     * Accessor gambar_url
     * Menghasilkan URL valid sesuai lokasi penyimpanan (storage atau public)
     */
    public function getGambarUrlAttribute($value)
    {
        // Jika kosong → default image
        if (!$value) {
            return asset('image/default-menu.svg');
        }

        // Jika berupa URL HTTP/HTTPS langsung kembalikan
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        /** ----------------------------------------------------------------
         * CASE 1: File dari upload pedagang 
         * Database menyimpan: image/menu/nama_file.jpg
         * Lokasi file fisik: storage/app/public/image/menu
         * URL akses: /storage/image/menu/nama_file.jpg
         * -----------------------------------------------------------------
         */
        if (str_starts_with($value, 'image/menu/')) {
            $storagePath = storage_path('app/public/' . $value);

            if (file_exists($storagePath)) {
                return asset('storage/' . $value);
            }
        }

        /** ----------------------------------------------------------------
         * CASE 2: File dari seeder 
         * Database menyimpan: menu/nama_file.jpg
         * Lokasi file fisik: public/menu
         * URL akses: /menu/nama_file.jpg
         * -----------------------------------------------------------------
         */
        if (str_starts_with($value, 'menu/')) {
            $publicPath = public_path($value);

            if (file_exists($publicPath)) {
                return asset($value);
            }
        }

        /** ----------------------------------------------------------------
         * FALLBACK: Cek kemungkinan nama file ada di public/image/menu
         * Contoh: DB cuma simpan `ayam.jpg`
         * -----------------------------------------------------------------
         */
        $fallbackPublic = public_path('image/menu/' . $value);
        if (file_exists($fallbackPublic)) {
            return asset('image/menu/' . $value);
        }

        // Jika semua gagal → pakai default
        return asset('image/default-menu.svg');
    }
}
