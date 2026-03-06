<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();

            $table->string('kode', 50);
            $table->text('isi_ringkas');
            $table->string('tujuan_surat', 255);
            $table->string('nomor_surat', 100);
            $table->date('tanggal_surat');
            $table->text('keterangan')->nullable();
            $table->string('bukti_surat')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
