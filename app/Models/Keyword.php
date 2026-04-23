<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $table = 'keywords';

    protected $fillable = [
        'kata_kunci',
        'jawaban'
    ];

    /**
     * 🔗 Relasi ke ChatLog
     */
    public function chatLogs()
    {
        return $this->hasMany(ChatLog::class, 'keyword_id');
    }

    /**
     * 🔥 Hitung berapa kali keyword dipakai
     */
    public function getTotalDigunakanAttribute()
    {
        return $this->chatLogs()->count();
    }
}
