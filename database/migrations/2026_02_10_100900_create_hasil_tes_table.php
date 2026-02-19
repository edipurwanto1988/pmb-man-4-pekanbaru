<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_tes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calon_siswa_id')->constrained('calon_siswa')->onDelete('cascade');
            $table->enum('jenis_tes', ['akademik', 'ibadah']);
            $table->decimal('nilai', 5, 2)->nullable();
            $table->enum('status', ['lulus', 'tidak_lulus', 'belum_dinilai'])->default('belum_dinilai');
            $table->text('catatan')->nullable();
            $table->date('tanggal_tes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_tes');
    }
};
