<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class IkasandiPertanyaan extends Model
{
    use HasFactory;

    protected $table = 'ikasandi_pertanyaan';

    protected $fillable = [
        'domain',
        'kategori_id',
        'kode_soal',
        'pertanyaan',
        'nilai',
        'bukti_dukung',
        'updated_by',
        'updated_type'
    ];

    protected $casts = [
        'nilai' => 'integer',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function kategori()
    {
        return $this->belongsTo(IkasandiKategori::class, 'kategori_id');
    }


    // User yang update
    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


    // Admin yang update
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESSOR BUKTI
    |--------------------------------------------------------------------------
    */

    public function getBuktiUrlAttribute()
    {
        if (
            $this->bukti_dukung &&
            Storage::disk('public')->exists($this->bukti_dukung)
        ) {
            return asset('storage/' . $this->bukti_dukung);
        }

        return null;
    }


    public function getBuktiExtensionAttribute()
    {
        return $this->bukti_dukung
            ? strtolower(pathinfo($this->bukti_dukung, PATHINFO_EXTENSION))
            : null;
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESSOR TERAKHIR UPDATE
    |--------------------------------------------------------------------------
    */

    public function getUpdatedFormatAttribute()
    {

        $nama = 'System';

        if ($this->updated_type === 'admin') {
            $nama = $this->admin->name ?? 'Admin';
        }

        if ($this->updated_type === 'user') {
            $nama = $this->user->name ?? 'User';
        }

        $tanggal = $this->updated_at
            ? $this->updated_at->format('d-m-Y H:i')
            : '-';

        return $nama . "\n" . $tanggal;
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES DOMAIN
    |--------------------------------------------------------------------------
    */

    public function scopeIdentifikasi($query)
    {
        return $query->where('domain', 'identifikasi');
    }

    public function scopeProteksi($query)
    {
        return $query->where('domain', 'proteksi');
    }

    public function scopeDeteksi($query)
    {
        return $query->where('domain', 'deteksi');
    }

    public function scopeRespon($query)
    {
        return $query->where('domain', 'respon');
    }

    public function scopeGulih($query)
    {
        return $query->where('domain', 'gulih');
    }
}
