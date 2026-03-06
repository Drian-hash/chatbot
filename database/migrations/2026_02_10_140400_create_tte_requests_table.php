<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tte_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp')->nullable();
            $table->string('nama_lengkap', 255);
            $table->string('nip', 30)->nullable();
            $table->string('opd', 255)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('jenis_permohonan', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tte_requests');
    }
};
