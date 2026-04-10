<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaturan_pmb', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_tutup')->default(false);
            $table->text('pesan_tutup')->nullable();
            $table->timestamps();
        });

        // Insert initial configuration
        DB::table('pengaturan_pmb')->insert([
            'is_tutup' => false,
            'pesan_tutup' => '<p>Pendaftaran Siswa Baru telah ditutup.</p>',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_pmb');
    }
};
