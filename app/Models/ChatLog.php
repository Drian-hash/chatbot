<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatLog extends Model
{
    protected $table = 'chat_logs';

    protected $fillable = [
        'user_id',
        'message',
        'reply',
        'faq_id',
        'layanan_id',
        'keyword_id' // 🔥 tambahkan ini
    ];

    /**
     * 🔗 Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 🔗 Relasi ke FAQ
     */
    public function faq()
    {
        return $this->belongsTo(Faq::class);
    }

    /**
     * 🔗 Relasi ke Layanan
     */
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    /**
     * 🔗 Relasi ke Keyword
     */
    public function keyword()
    {
        return $this->belongsTo(Keyword::class);
    }
}
