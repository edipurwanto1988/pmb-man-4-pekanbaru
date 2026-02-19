<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratDaftarUlang extends Model
{
    use HasFactory;

    protected $table = 'syarat_daftar_ulang';

    protected $fillable = [
        'nama_syarat',
        'tipe_file',
        'is_wajib',
        'is_multiple',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'is_wajib' => 'boolean',
        'is_multiple' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function berkas()
    {
        return $this->hasMany(BerkasDaftarUlang::class);
    }
}
