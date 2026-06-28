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
        Schema::create('permohonans', function (Blueprint $table) {

            $table->id();

            // Nomor tiket / kode permohonan
            $table->string('kode_permohonan')->unique();

            // User chatbot
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Jenis layanan
            $table->foreignId('layanan_id')
                ->constrained('layanan')
                ->cascadeOnDelete();

            // Data permohonan
            $table->string('nama_pemohon');

            $table->string('nomor_hp');

            $table->string('email')->nullable();

            $table->text('isi_permohonan');

            // File pendukung
            $table->string('lampiran')->nullable();

            // Status
            $table->enum('status', [
                'Menunggu',
                'Diproses',
                'Selesai',
                'Ditolak'
            ])->default('Menunggu');

            // Catatan admin
            $table->text('catatan_admin')->nullable();

            // Admin yang memproses
            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete();

            // Tanggal selesai
            $table->timestamp('tanggal_selesai')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};
