<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanan';

    protected $fillable = [
        'nama_layanan',
        'deskripsi'
    ];

    public function faq()
    {
        return $this->hasMany(Faq::class);
    }

    // // 🔗 Relasi ke Pertanyaan chatbot
    // public function pertanyaan()
    // {
    //     return $this->hasMany(Pertanyaan::class);
    // }
}
