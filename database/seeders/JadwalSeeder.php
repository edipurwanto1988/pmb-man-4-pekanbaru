<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $jadwal = [
            [
                'nama_kegiatan' => 'Pendaftaran Online Gelombang 1',
                'jenis' => 'pendaftaran',
                'waktu_mulai' => '2026-02-10 08:00:00',
                'waktu_selesai' => '2026-03-31 23:59:00',
                'keterangan' => 'Pendaftaran online melalui website PMB. Calon siswa melakukan registrasi akun dan mengisi formulir pendaftaran.',
                'aktif' => true,
            ],
            [
                'nama_kegiatan' => 'Pendaftaran Online Gelombang 2',
                'jenis' => 'pendaftaran',
                'waktu_mulai' => '2026-04-01 08:00:00',
                'waktu_selesai' => '2026-04-30 23:59:00',
                'keterangan' => 'Pendaftaran gelombang 2 untuk calon siswa yang belum mendaftar di gelombang 1.',
                'aktif' => true,
            ],
            [
                'nama_kegiatan' => 'Verifikasi Berkas Gelombang 1',
                'jenis' => 'verifikasi',
                'waktu_mulai' => '2026-04-01 08:00:00',
                'waktu_selesai' => '2026-04-10 17:00:00',
                'keterangan' => 'Pemeriksaan kelengkapan dan keabsahan berkas yang telah diupload oleh calon siswa gelombang 1.',
                'aktif' => true,
            ],
            [
                'nama_kegiatan' => 'Verifikasi Berkas Gelombang 2',
                'jenis' => 'verifikasi',
                'waktu_mulai' => '2026-05-01 08:00:00',
                'waktu_selesai' => '2026-05-10 17:00:00',
                'keterangan' => 'Pemeriksaan kelengkapan dan keabsahan berkas calon siswa gelombang 2.',
                'aktif' => true,
            ],
            [
                'nama_kegiatan' => 'Tes Akademik (Matematika, IPA, B. Indonesia, B. Inggris)',
                'jenis' => 'tes_akademik',
                'waktu_mulai' => '2026-04-15 08:00:00',
                'waktu_selesai' => '2026-04-15 12:00:00',
                'keterangan' => 'Tes tertulis meliputi Matematika, IPA, Bahasa Indonesia, dan Bahasa Inggris. Hadir 30 menit sebelum tes dimulai.',
                'aktif' => true,
            ],
            [
                'nama_kegiatan' => 'Tes Baca Tulis Al-Quran (BTQ)',
                'jenis' => 'tes_ibadah',
                'waktu_mulai' => '2026-04-16 08:00:00',
                'waktu_selesai' => '2026-04-16 15:00:00',
                'keterangan' => 'Tes kemampuan membaca Al-Quran, tajwid, dan hafalan surat-surat pendek. Bawa Al-Quran pribadi.',
                'aktif' => true,
            ],
            [
                'nama_kegiatan' => 'Pengumuman Hasil Seleksi Gelombang 1',
                'jenis' => 'pengumuman',
                'waktu_mulai' => '2026-04-25 10:00:00',
                'waktu_selesai' => '2026-04-25 23:59:00',
                'keterangan' => 'Pengumuman hasil seleksi dapat dilihat melalui dashboard siswa dan website resmi PMB.',
                'aktif' => true,
            ],
            [
                'nama_kegiatan' => 'Daftar Ulang Gelombang 1',
                'jenis' => 'daftar_ulang',
                'waktu_mulai' => '2026-04-28 08:00:00',
                'waktu_selesai' => '2026-05-05 16:00:00',
                'keterangan' => 'Calon siswa yang dinyatakan lulus wajib melakukan daftar ulang dengan membawa berkas asli dan membayar biaya pendaftaran.',
                'aktif' => true,
            ],
        ];

        foreach ($jadwal as $item) {
            DB::table('jadwal')->updateOrInsert(
                ['nama_kegiatan' => $item['nama_kegiatan']],
                array_merge($item, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
