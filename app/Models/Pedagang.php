<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedagang extends Model
{
    use HasFactory;

    protected $table = "pedagang";
    protected $fillable = ['user_id', 'nama_kantin', 'lokasi'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function menu()
    {
        return $this->hasMany(Menu::class, 'id_pedagang');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_pedagang');
    }
}
