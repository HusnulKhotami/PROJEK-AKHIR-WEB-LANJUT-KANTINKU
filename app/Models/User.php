<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user'; // tabel kamu bernama 'user'

    protected $fillable = [
        'nama', 'email', 'password', 'role', 'phone',
    ];

    protected $hidden = ['password'];
}
