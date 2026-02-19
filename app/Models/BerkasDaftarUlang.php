<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasDaftarUlang extends Model
{
    use HasFactory;

    protected $table = 'berkas_daftar_ulang';

    protected $fillable = [
        'calon_siswa_id',
        'syarat_daftar_ulang_id',
        'nama_file',
        'path',
        'mime_type',
        'status',
        'catatan',
    ];

    public function syarat()
    {
        return $this->belongsTo(SyaratDaftarUlang::class, 'syarat_daftar_ulang_id');
    }

    public function calonSiswa()
    {
        return $this->belongsTo(CalonSiswa::class, 'calon_siswa_id');
    }
}
