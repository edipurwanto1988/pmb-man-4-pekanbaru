<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanBerkas extends Model
{
    protected $table = 'pengaturan_berkas';

    protected $fillable = ['kode', 'label', 'wajib', 'aktif', 'urutan'];

    protected $casts = [
        'wajib' => 'boolean',
        'aktif' => 'boolean',
    ];
}
