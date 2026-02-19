<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('syarat_daftar_ulang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_syarat');
            $table->enum('tipe_file', ['image', 'pdf', 'image_pdf']);
            $table->boolean('is_wajib')->default(true);
            $table->boolean('is_multiple')->default(false);
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('syarat_daftar_ulang');
    }
};
