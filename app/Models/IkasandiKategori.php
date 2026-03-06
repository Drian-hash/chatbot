<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IkasandiKategori extends Model
{
    protected $table = 'ikasandi_kategori';

    protected $fillable = [
        'kode_kategori',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // 1 Kategori memiliki banyak pertanyaan
    public function pertanyaan()
    {
        return $this->hasMany(IkasandiPertanyaan::class, 'kategori_id');
    }
}
