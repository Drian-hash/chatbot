<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ikasandi_pertanyaan', function (Blueprint $table) {

            $table->id();

            // DOMAIN IKASANDI
            $table->enum('domain', [
                'identifikasi',
                'proteksi',
                'deteksi',
                'gulih'
            ])->index();

            // RELASI KATEGORI
            $table->foreignId('kategori_id')
                ->constrained('ikasandi_kategori')
                ->cascadeOnDelete();

            // KODE SOAL
            $table->string('kode_soal')->unique();

            // PERTANYAAN
            $table->text('pertanyaan');

            // NILAI (0 - 5)
            $table->unsignedTinyInteger('nilai')
                ->default(0);

            // BUKTI DUKUNG
            $table->string('bukti_dukung')->nullable();

            // EXTENSION FILE
            $table->string('bukti_extension',10)->nullable();

            // ID USER / ADMIN YANG UPDATE
            $table->unsignedBigInteger('updated_by')->nullable();

            // TIPE USER YANG UPDATE (admin / user)
            $table->enum('updated_type',['admin','user'])->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ikasandi_pertanyaan');
    }
};
