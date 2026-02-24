<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengaturan_daftar_ulang', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // e.g. 'info_barang_bawaan'
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed default
        DB::table('pengaturan_daftar_ulang')->insert([
            'key'   => 'info_barang_bawaan',
            'value' => "1. Fotokopi KK (2 lembar)\n2. Fotokopi Akte Kelahiran (2 lembar)\n3. Fotokopi Ijazah/SKHUN yang dilegalisir (2 lembar)\n4. Pas foto 3x4 berwarna (4 lembar)\n5. Pas foto 4x6 berwarna (2 lembar)\n6. Surat keterangan sehat dari dokter",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_daftar_ulang');
    }
};
