<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faq';

    protected $fillable = [
        'layanan_id',
        'pertanyaan',
        'jawaban',
        'jumlah_ditanya' // 🔥 tambahkan ini
    ];

    /**
     * 🔗 Relasi ke Layanan
     */
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    /**
     * 🔗 Relasi ke ChatLog
     */
    public function chatLogs()
    {
        return $this->hasMany(ChatLog::class, 'faq_id');
    }

    /**
     * 🔥 Total ditanya (ambil dari database)
     */
    public function getTotalDitanyaAttribute()
    {
        return $this->jumlah_ditanya;
    }

    /**
     * 🔥 Alternatif: hitung dari chatlog (opsional)
     */
    public function getTotalDariChatAttribute()
    {
        return $this->chatLogs()->count();
    }
}
