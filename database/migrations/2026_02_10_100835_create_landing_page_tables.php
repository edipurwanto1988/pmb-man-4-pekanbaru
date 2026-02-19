<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_page_modules', function (Blueprint $table) {
            $table->id();
            $table->string('nama_modul');
            $table->string('kode_modul')->unique();
            $table->string('view_path');
            $table->timestamps();
        });

        Schema::create('landing_page_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_module_id')->constrained('landing_page_modules')->onDelete('cascade');
            $table->integer('urutan')->default(0);
            $table->json('konten');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_page_sections');
        Schema::dropIfExists('landing_page_modules');
    }
};
