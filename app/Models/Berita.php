<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'kode',
        'isi_ringkas',
        'tujuan_surat',
        'nomor_surat',
        'tanggal_surat',
        'keterangan',
        'bukti_surat',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR URL BUKTI (Sesuai Storage Laravel)
    |--------------------------------------------------------------------------
    */

    public function getBuktiUrlAttribute()
    {
        if ($this->bukti_surat) {
            return asset('storage/' . $this->bukti_surat);
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | FORMAT TANGGAL
    |--------------------------------------------------------------------------
    */

    public function getTanggalFormatAttribute()
    {
        return $this->tanggal_surat
            ? $this->tanggal_surat->format('d-m-Y')
            : '-';
    }
}
