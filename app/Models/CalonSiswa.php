<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonSiswa extends Model
{
    use HasFactory;

    protected $table = 'calon_siswa';

    protected $fillable = [
        'user_id', 'nama_lengkap', 'nisn', 'nik', 'no_kk',
        'no_hp_siswa', 'no_hp_ortu', 'status', 'catatan_panitia',
        'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
        'anak_ke', 'dari_bersaudara', 'status_dalam_keluarga',
        'alamat_siswa', 'rt_rw_siswa', 'kode_pos_siswa', 'kota_siswa',
        'bahasa_harian', 'status_rumah', 'jarak_rumah_km', 'transportasi',
        'jurusan_pilihan', 'asal_sekolah', 'alamat_asal_sekolah', 'npsn', 'nsm',
        'hobi', 'cita_cita', 'golongan_darah', 'riwayat_sakit',
        'tinggi_badan', 'berat_badan',
        // Ayah
        'nama_ayah', 'nik_ayah', 'tempat_lahir_ayah', 'tanggal_lahir_ayah',
        'pendidikan_ayah', 'pekerjaan_ayah', 'penghasilan_ayah',
        'alamat_ayah', 'rt_rw_ayah', 'kode_pos_ayah', 'kota_ayah', 'no_hp_ayah',
        // Ibu
        'nama_ibu', 'nik_ibu', 'tempat_lahir_ibu', 'tanggal_lahir_ibu',
        'pendidikan_ibu', 'pekerjaan_ibu', 'penghasilan_ibu',
        'alamat_ibu', 'rt_rw_ibu', 'kode_pos_ibu', 'kota_ibu', 'no_hp_ibu',
        // Wali
        'nama_wali', 'nik_wali', 'tempat_lahir_wali', 'tanggal_lahir_wali',
        'pendidikan_wali', 'pekerjaan_wali', 'penghasilan_wali',
        'alamat_wali', 'rt_rw_wali', 'kode_pos_wali', 'kota_wali', 'no_hp_wali',
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
