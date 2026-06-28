<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Guard yang digunakan
     */
    protected $guard = 'web';

    /**
     * Kolom yang boleh diisi (mass assignment)
     */
    protected $fillable = [
        'name',
        'phone',
        'total_messages',
        'first_chat_at'
    ];


    /**
     * Kolom yang disembunyikan saat serialize
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function permohonans()
    {
        return $this->hasMany(Permohonan::class);
    }
}
