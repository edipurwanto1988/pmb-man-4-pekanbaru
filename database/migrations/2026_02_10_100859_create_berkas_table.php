<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calon_siswa_id')->constrained('calon_siswa')->onDelete('cascade');
            $table->string('jenis_berkas'); // ijazah, kk, akta, foto, raport, dll
            $table->string('nama_file');
            $table->string('path');
            $table->enum('status', ['pending', 'diterima', 'ditolak', 'perlu_perbaikan'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas');
    }
};
