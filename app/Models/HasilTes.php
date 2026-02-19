<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilTes extends Model
{
    use HasFactory;

    protected $table = 'hasil_tes';

    protected $fillable = [
        'calon_siswa_id',
        'jenis_tes',
        'nilai',
        'status',
        'catatan',
        'tanggal_tes',
    ];

    protected $casts = [
        'tanggal_tes' => 'date',
        'nilai' => 'decimal:2',
    ];

    public function calonSiswa()
    {
        return $this->belongsTo(CalonSiswa::class);
    }
}
