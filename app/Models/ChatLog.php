<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatLog extends Model
{
    protected $table = 'chat_logs';

    protected $fillable = [

        'user_id',

        'layanan_id',

        'faq_id',

        'admin_id',

        'sender',

        'message',

        'status',

        'is_llm'

    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI USER
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI LAYANAN
    |--------------------------------------------------------------------------
    */

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI FAQ
    |--------------------------------------------------------------------------
    */

    public function faq()
    {
        return $this->belongsTo(Faq::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI ADMIN
    |--------------------------------------------------------------------------
    */

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
