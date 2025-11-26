<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'id_pedagang',
        'status',
        'total_harga',
        'metode_pembayaran',
        'catatan'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pedagang()
    {
        return $this->belongsTo(Pedagang::class, 'id_pedagang');
    }

    public function items()
    {
        return $this->hasMany(ItemPesanan::class, 'id_pesanan');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'id_pesanan');
    }
}
