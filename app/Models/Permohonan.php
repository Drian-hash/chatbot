<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    protected $fillable = [

        'kode_permohonan',

        'user_id',

        'layanan_id',

        'nama_pemohon',

        'nomor_hp',

        'email',

        'isi_permohonan',

        'lampiran',

        'status',

        'catatan_admin',

        'admin_id',

        'tanggal_selesai'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
