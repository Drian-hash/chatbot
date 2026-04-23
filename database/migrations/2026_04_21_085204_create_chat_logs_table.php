<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_logs', function (Blueprint $table) {
            $table->id();

            // 🔥 RELASI USER
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // 🔥 PESAN USER
            $table->text('message');

            // 🔥 BALASAN BOT
            $table->text('reply')->nullable();

            // 🔥 RELASI FAQ
            $table->foreignId('faq_id')
                ->nullable()
                ->constrained('faq')
                ->nullOnDelete();

            // 🔥 RELASI LAYANAN
            $table->foreignId('layanan_id')
                ->nullable()
                ->constrained('layanan')
                ->nullOnDelete();

            // 🔥 RELASI KEYWORD (TAMBAHAN)
            $table->foreignId('keyword_id')
                ->nullable()
                ->constrained('keywords')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_logs');
    }
};
