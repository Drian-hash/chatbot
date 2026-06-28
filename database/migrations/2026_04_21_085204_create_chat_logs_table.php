<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run Migration
     */
    public function up(): void
    {
        Schema::create('chat_logs', function (Blueprint $table) {

            $table->id();

            /**
             * USER
             */
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /**
             * LAYANAN
             */
            $table->foreignId('layanan_id')
                ->nullable()
                ->constrained('layanan')
                ->nullOnDelete();

            /**
             * FAQ
             */
            $table->foreignId('faq_id')
                ->nullable()
                ->constrained('faq')
                ->nullOnDelete();

            
            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete();

            /**
             * SIAPA YANG MENGIRIM PESAN
             */
            $table->enum('sender', [

                'user',

                'bot',

                'admin'

            ]);

            /**
             * ISI PESAN
             */
            $table->longText('message');

            /**
             * STATUS PERCAKAPAN
             */
            $table->enum('status', [

                'Bot',
                'Menunggu Admin',
                'Sedang Dilayani',
                'Selesai'

            ])->default('Bot');

            /**
             * GPT MENJAWAB?
             */
            $table->boolean('is_llm')
                ->default(false);

            /**
             * WAKTU
             */
            $table->timestamps();
        });
    }

    /**
     * Reverse Migration
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_logs');
    }
};
