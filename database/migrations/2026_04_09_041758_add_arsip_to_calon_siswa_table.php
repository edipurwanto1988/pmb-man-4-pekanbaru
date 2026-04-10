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
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->foreignId('tahun_pmb_id')->nullable()->constrained('tahun_pmb')->nullOnDelete();
            $table->foreignId('gelombang_id')->nullable()->constrained('gelombang')->nullOnDelete();
            $table->boolean('is_arsip')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->dropForeign(['tahun_pmb_id']);
            $table->dropForeign(['gelombang_id']);
            $table->dropColumn(['tahun_pmb_id', 'gelombang_id', 'is_arsip']);
        });
    }
};
