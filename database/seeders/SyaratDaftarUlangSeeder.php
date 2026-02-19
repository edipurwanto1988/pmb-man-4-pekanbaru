<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SyaratDaftarUlangSeeder extends Seeder
{
    public function run(): void
    {
        $syarat = [
            [
                'nama_syarat' => 'Ijazah / Surat Keterangan Lulus (SKL)',
                'tipe_file' => 'image_pdf',
                'is_wajib' => true,
                'is_multiple' => false,
                'keterangan' => 'Upload scan/foto ijazah atau SKL yang sudah dilegalisir. Format: JPG, PNG, atau PDF. Maks 2MB.',
                'is_active' => true,
            ],
            [
                'nama_syarat' => 'Rapor Semester 1-5',
                'tipe_file' => 'pdf',
                'is_wajib' => true,
                'is_multiple' => true,
                'keterangan' => 'Upload scan rapor dari semester 1 hingga semester 5. Bisa upload terpisah per semester. Format PDF.',
                'is_active' => true,
            ],
            [
                'nama_syarat' => 'Akta Kelahiran',
                'tipe_file' => 'image_pdf',
                'is_wajib' => true,
                'is_multiple' => false,
                'keterangan' => 'Upload scan/foto akta kelahiran. Format: JPG, PNG, atau PDF. Maks 2MB.',
                'is_active' => true,
            ],
            [
                'nama_syarat' => 'Kartu Keluarga (KK)',
                'tipe_file' => 'image_pdf',
                'is_wajib' => true,
                'is_multiple' => false,
                'keterangan' => 'Upload scan/foto Kartu Keluarga terbaru. Format: JPG, PNG, atau PDF. Maks 2MB.',
                'is_active' => true,
            ],
            [
                'nama_syarat' => 'Pas Foto 3x4 Latar Merah',
                'tipe_file' => 'image',
                'is_wajib' => true,
                'is_multiple' => false,
                'keterangan' => 'Upload pas foto terbaru ukuran 3x4 dengan latar belakang merah. Format: JPG atau PNG. Maks 1MB.',
                'is_active' => true,
            ],
            [
                'nama_syarat' => 'Surat Keterangan Sehat',
                'tipe_file' => 'image_pdf',
                'is_wajib' => true,
                'is_multiple' => false,
                'keterangan' => 'Upload surat keterangan sehat dari dokter/puskesmas. Format: JPG, PNG, atau PDF. Maks 2MB.',
                'is_active' => true,
            ],
            [
                'nama_syarat' => 'Piagam / Sertifikat Prestasi',
                'tipe_file' => 'image_pdf',
                'is_wajib' => false,
                'is_multiple' => true,
                'keterangan' => 'Opsional. Upload piagam atau sertifikat prestasi akademik/non-akademik jika ada. Bisa upload beberapa file.',
                'is_active' => true,
            ],
            [
                'nama_syarat' => 'Bukti Pembayaran Daftar Ulang',
                'tipe_file' => 'image_pdf',
                'is_wajib' => true,
                'is_multiple' => false,
                'keterangan' => 'Upload bukti pembayaran daftar ulang (transfer bank atau kwitansi). Format: JPG, PNG, atau PDF.',
                'is_active' => true,
            ],
        ];

        foreach ($syarat as $item) {
            DB::table('syarat_daftar_ulang')->updateOrInsert(
                ['nama_syarat' => $item['nama_syarat']],
                array_merge($item, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
