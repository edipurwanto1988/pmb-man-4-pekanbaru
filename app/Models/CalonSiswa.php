<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonSiswa extends Model
{
    use HasFactory;

    protected $table = 'calon_siswa';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nisn',
        'no_hp_siswa',
        'no_hp_ortu',
        'status',
        'catatan_panitia',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function berkas()
    {
        return $this->hasMany(Berkas::class);
    }

    public function berkasDaftarUlang()
    {
        return $this->hasMany(BerkasDaftarUlang::class);
    }

    public function hasilTes()
    {
        return $this->hasMany(HasilTes::class);
    }

    public function getStatusLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'terdaftar' => 'gray',
            'menunggu_verifikasi' => 'yellow',
            'lulus_administrasi' => 'blue',
            'tidak_lulus_administrasi' => 'red',
            'lulus_tes' => 'indigo',
            'tidak_lulus_tes' => 'red',
            'lulus_pnbm' => 'green',
            'tidak_lulus_pnbm' => 'red',
            'daftar_ulang' => 'purple',
            'resmi_terdaftar' => 'emerald',
            default => 'gray',
        };
    }
}
