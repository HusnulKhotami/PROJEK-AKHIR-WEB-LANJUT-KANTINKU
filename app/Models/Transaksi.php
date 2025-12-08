<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'id_pesanan',
        'jumlah',
        'metode_pembayaran',
        'status',
        'payment_date',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    public function pesanan()
    {
        return $this->belongsTo(\App\Models\Pesanan::class, 'id_pesanan');
    }
}