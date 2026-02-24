<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            // Biodata Siswa
            $table->string('nik')->nullable()->after('nisn');
            $table->string('no_kk')->nullable()->after('nik');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->integer('anak_ke')->nullable();
            $table->integer('dari_bersaudara')->nullable();
            $table->string('status_dalam_keluarga')->nullable();
            $table->text('alamat_siswa')->nullable();
            $table->string('rt_rw_siswa')->nullable();
            $table->string('kode_pos_siswa')->nullable();
            $table->string('kota_siswa')->nullable();
            $table->string('bahasa_harian')->nullable();
            $table->string('status_rumah')->nullable();
            $table->decimal('jarak_rumah_km', 5, 1)->nullable();
            $table->string('transportasi')->nullable();
            $table->string('jurusan_pilihan')->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->text('alamat_asal_sekolah')->nullable();
            $table->string('npsn')->nullable();
            $table->string('nsm')->nullable();
            $table->string('hobi')->nullable();
            $table->string('cita_cita')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->text('riwayat_sakit')->nullable();
            $table->string('tinggi_badan')->nullable();
            $table->string('berat_badan')->nullable();

            // Biodata Ayah
            $table->string('nama_ayah')->nullable();
            $table->string('nik_ayah')->nullable();
            $table->string('tempat_lahir_ayah')->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('penghasilan_ayah')->nullable();
            $table->text('alamat_ayah')->nullable();
            $table->string('rt_rw_ayah')->nullable();
            $table->string('kode_pos_ayah')->nullable();
            $table->string('kota_ayah')->nullable();
            $table->string('no_hp_ayah')->nullable();

            // Biodata Ibu
            $table->string('nama_ibu')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->string('tempat_lahir_ibu')->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('penghasilan_ibu')->nullable();
            $table->text('alamat_ibu')->nullable();
            $table->string('rt_rw_ibu')->nullable();
            $table->string('kode_pos_ibu')->nullable();
            $table->string('kota_ibu')->nullable();
            $table->string('no_hp_ibu')->nullable();

            // Biodata Wali
            $table->string('nama_wali')->nullable();
            $table->string('nik_wali')->nullable();
            $table->string('tempat_lahir_wali')->nullable();
            $table->date('tanggal_lahir_wali')->nullable();
            $table->string('pendidikan_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('penghasilan_wali')->nullable();
            $table->text('alamat_wali')->nullable();
            $table->string('rt_rw_wali')->nullable();
            $table->string('kode_pos_wali')->nullable();
            $table->string('kota_wali')->nullable();
            $table->string('no_hp_wali')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->dropColumn([
                'nik','no_kk','tempat_lahir','tanggal_lahir','jenis_kelamin',
                'anak_ke','dari_bersaudara','status_dalam_keluarga','alamat_siswa',
                'rt_rw_siswa','kode_pos_siswa','kota_siswa','bahasa_harian',
                'status_rumah','jarak_rumah_km','transportasi','jurusan_pilihan',
                'asal_sekolah','alamat_asal_sekolah','npsn','nsm','hobi',
                'cita_cita','golongan_darah','riwayat_sakit','tinggi_badan','berat_badan',
                'nama_ayah','nik_ayah','tempat_lahir_ayah','tanggal_lahir_ayah',
                'pendidikan_ayah','pekerjaan_ayah','penghasilan_ayah','alamat_ayah',
                'rt_rw_ayah','kode_pos_ayah','kota_ayah','no_hp_ayah',
                'nama_ibu','nik_ibu','tempat_lahir_ibu','tanggal_lahir_ibu',
                'pendidikan_ibu','pekerjaan_ibu','penghasilan_ibu','alamat_ibu',
                'rt_rw_ibu','kode_pos_ibu','kota_ibu','no_hp_ibu',
                'nama_wali','nik_wali','tempat_lahir_wali','tanggal_lahir_wali',
                'pendidikan_wali','pekerjaan_wali','penghasilan_wali','alamat_wali',
                'rt_rw_wali','kode_pos_wali','kota_wali','no_hp_wali',
            ]);
        });
    }
};
