<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calon_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('nisn')->unique();
            $table->string('no_hp_siswa');
            $table->string('no_hp_ortu');
            $table->enum('status', [
                'terdaftar',
                'menunggu_verifikasi',
                'lulus_administrasi',
                'tidak_lulus_administrasi',
                'lulus_tes',
                'tidak_lulus_tes',
                'lulus_pnbm',
                'tidak_lulus_pnbm',
                'daftar_ulang',
                'resmi_terdaftar'
            ])->default('terdaftar');
            $table->text('catatan_panitia')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calon_siswa');
    }
};
