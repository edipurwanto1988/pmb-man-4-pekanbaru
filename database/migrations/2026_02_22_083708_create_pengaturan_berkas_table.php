<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_berkas', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();           // ijazah, kk, akta, foto, raport
            $table->string('label');                    // Ijazah / SKHUN, dst
            $table->boolean('wajib')->default(true);    // wajib atau opsional
            $table->boolean('aktif')->default(true);    // tampil atau tidak
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // Seed data default
        DB::table('pengaturan_berkas')->insert([
            ['kode' => 'ijazah', 'label' => 'Ijazah / SKHUN',   'wajib' => true,  'aktif' => true, 'urutan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'kk',     'label' => 'Kartu Keluarga',    'wajib' => true,  'aktif' => true, 'urutan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'akta',   'label' => 'Akta Kelahiran',    'wajib' => true,  'aktif' => true, 'urutan' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'foto',   'label' => 'Pas Foto 3x4',      'wajib' => true,  'aktif' => true, 'urutan' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'raport', 'label' => 'Raport Terakhir',   'wajib' => false, 'aktif' => true, 'urutan' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_berkas');
    }
};
