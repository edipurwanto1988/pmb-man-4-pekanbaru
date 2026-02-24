<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->string('no_hp_ortu')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->string('no_hp_ortu')->nullable(false)->change();
        });
    }
};
