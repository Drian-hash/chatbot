<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TteRequest extends Model
{
    use HasFactory;

    protected $table = 'tte_requests';

    protected $fillable = [
        'timestamp',
        'nama_lengkap',
        'nip',
        'opd',
        'no_hp',
        'jenis_permohonan'
    ];
}
