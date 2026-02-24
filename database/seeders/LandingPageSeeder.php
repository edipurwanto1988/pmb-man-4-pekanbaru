<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandingPageModule;
use App\Models\LandingPageSection;

class LandingPageSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Modules
        $modules = [
            ['nama_modul' => 'Hero Section', 'kode_modul' => 'hero', 'view_path' => 'landing.modules.hero'],
            ['nama_modul' => 'Sambutan Kepala Madrasah', 'kode_modul' => 'sambutan', 'view_path' => 'landing.modules.sambutan'],
            ['nama_modul' => 'Info Jurusan', 'kode_modul' => 'jurusan', 'view_path' => 'landing.modules.jurusan'],
            ['nama_modul' => 'Alur Pendaftaran', 'kode_modul' => 'alur', 'view_path' => 'landing.modules.alur'],
            ['nama_modul' => 'Berita Terkini', 'kode_modul' => 'berita', 'view_path' => 'landing.modules.berita'],
            ['nama_modul' => 'Galeri', 'kode_modul' => 'galeri', 'view_path' => 'landing.modules.galeri'],
            ['nama_modul' => 'FAQ', 'kode_modul' => 'faq', 'view_path' => 'landing.modules.faq'],
            ['nama_modul' => 'Kontak & Peta', 'kode_modul' => 'kontak', 'view_path' => 'landing.modules.kontak'],
        ];

        foreach ($modules as $module) {
            LandingPageModule::firstOrCreate(['kode_modul' => $module['kode_modul']], $module);
        }

        // 2. Create All Sections with Dummy Data

        // ===================== HERO SECTION =====================
        $heroModule = LandingPageModule::where('kode_modul', 'hero')->first();
        if ($heroModule) {
            LandingPageSection::updateOrCreate(
                ['landing_page_module_id' => $heroModule->id],
                [
                    'urutan' => 1,
                    'konten' => json_encode([
                        'title' => 'Penerimaan Murid Baru Madrasah (PMBM) MAN 4 Kota Pekanbaru TAHUN PELAJARAN 2026–2027',
                        'subtitle' => 'Mewujudkan Generasi RELIGIUS – BERKUALITAS – BEBUDAYA',
                        'image' => 'images/hero-bg.jpg',
                        'cta_text' => 'Daftar Sekarang',
                        'cta_link' => '/register'
                    ]),
                    'is_active' => true,
                ]
            );
        }

        // ===================== SAMBUTAN =====================
        $sambutanModule = LandingPageModule::where('kode_modul', 'sambutan')->first();
        if ($sambutanModule) {
            LandingPageSection::updateOrCreate(
                ['landing_page_module_id' => $sambutanModule->id],
                [
                    'urutan' => 2,
                    'konten' => json_encode([
                        'title' => 'Sambutan Kepala Madrasah',
                        'content' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Puji syukur kehadirat Allah SWT, kami mengucapkan selamat datang kepada calon peserta didik baru MAN 4 Kota Pekanbaru. Madrasah kami berkomitmen untuk mencetak generasi yang unggul dalam ilmu pengetahuan, teknologi, dan keagamaan. Dengan tenaga pendidik profesional dan fasilitas yang memadai, kami siap membimbing putra-putri terbaik bangsa menuju masa depan gemilang. Mari bergabung bersama kami dalam perjalanan meraih prestasi akademik dan spiritual yang luar biasa.',
                        'image' => 'images/kepsek.jpg',
                        'nama_kepsek' => 'Dr. Irwan Efendi, M.Pd.I'
                    ]),
                    'is_active' => true,
                ]
            );
        }

        // ===================== JURUSAN =====================
        $jurusanModule = LandingPageModule::where('kode_modul', 'jurusan')->first();
        if ($jurusanModule) {
            LandingPageSection::updateOrCreate(
                ['landing_page_module_id' => $jurusanModule->id],
                [
                    'urutan' => 3,
                    'konten' => json_encode([
                        'title' => 'Program Studi Unggulan',
                        'items' => [
                            [
                                'nama' => 'SAINTEK',
                                'desc' => 'Program unggulan dengan fokus pada Matematika, Fisika, Kimia, dan Biologi. Dilengkapi laboratorium modern dan bimbingan olimpiade sains tingkat nasional.'
                            ],
                            [
                                'nama' => 'SOSHUM',
                                'desc' => 'Program studi yang mengembangkan kemampuan analisis sosial, ekonomi, geografi, dan sosiologi. Mempersiapkan siswa untuk karier di bidang hukum, bisnis, dan pemerintahan.'
                            ],
                            [
                                'nama' => 'Keagamaan (MAK)',
                                'desc' => 'Program keagamaan dengan pendalaman ilmu Al-Quran, Hadits, Fiqih, dan Bahasa Arab. Lulusan siap melanjutkan ke perguruan tinggi Islam terkemuka.'
                            ]
                        ]
                    ]),
                    'is_active' => true,
                ]
            );
        }

        // ===================== ALUR PENDAFTARAN =====================
        $alurModule = LandingPageModule::where('kode_modul', 'alur')->first();
        if ($alurModule) {
            LandingPageSection::updateOrCreate(
                ['landing_page_module_id' => $alurModule->id],
                [
                    'urutan' => 4,
                    'konten' => json_encode([
                        'title' => 'Alur Pendaftaran PMBM',
                        'subtitle' => 'Ikuti langkah-langkah mudah berikut untuk mendaftar sebagai calon peserta didik baru',
                        'items' => [
                            [
                                'title' => 'SOSIALISASI',
                                'desc' => '19 Januari – 28 Februari 2026'
                            ],
                            [
                                'title' => 'PENDAFTARAN',
                                'desc' => '1 Maret – 10 April 2026'
                            ],
                            [
                                'title' => 'PENGUMUMAN KELULUSAN ADMINISTRASI',
                                'desc' => '11 April 2026'
                            ],
                            [
                                'title' => 'TES AKADEMIK, IBADAH & BACA AL-QUR\'AN',
                                'desc' => '13 April 2026'
                            ],
                            [
                                'title' => 'PENGUMUMAN HASIL TES',
                                'desc' => '14 April 2026'
                            ],
                            [
                                'title' => 'RAPAT KOMITE',
                                'desc' => '16 April 2026'
                            ],
                            [
                                'title' => 'DAFTAR ULANG',
                                'desc' => '16–17 April 2026'
                            ]
                        ]
                    ]),
                    'is_active' => true,
                ]
            );
        }

        // ===================== BERITA TERKINI =====================
        $beritaModule = LandingPageModule::where('kode_modul', 'berita')->first();
        if ($beritaModule) {
            LandingPageSection::updateOrCreate(
                ['landing_page_module_id' => $beritaModule->id],
                [
                    'urutan' => 5,
                    'konten' => json_encode([
                        'title' => 'Berita & Informasi Terkini',
                        'items' => [
                            [
                                'title' => 'Pendaftaran PMBM 2026/2027 Resmi Dibuka!',
                                'excerpt' => 'MAN 4 Kota Pekanbaru resmi membuka pendaftaran peserta didik baru untuk tahun ajaran 2026/2027. Segera daftarkan diri Anda melalui portal online kami.',
                                'date' => '10 Februari 2026'
                            ],
                            [
                                'title' => 'MAN 4 Raih Juara Umum Olimpiade Sains Kota',
                                'excerpt' => 'Tim olimpiade MAN 4 Kota Pekanbaru berhasil meraih juara umum dalam Kompetisi Sains Madrasah (KSM) tingkat Kota Pekanbaru tahun 2025.',
                                'date' => '5 Desember 2025'
                            ],
                            [
                                'title' => 'Workshop Persiapan UTBK untuk Siswa Kelas XII',
                                'excerpt' => 'MAN 4 mengadakan workshop intensif persiapan UTBK-SNBT bekerja sama dengan bimbel terkemuka untuk mempersiapkan siswa memasuki perguruan tinggi favorit.',
                                'date' => '20 Januari 2026'
                            ]
                        ]
                    ]),
                    'is_active' => true,
                ]
            );
        }

        // ===================== GALERI =====================
        $galeriModule = LandingPageModule::where('kode_modul', 'galeri')->first();
        if ($galeriModule) {
            LandingPageSection::updateOrCreate(
                ['landing_page_module_id' => $galeriModule->id],
                [
                    'urutan' => 6,
                    'konten' => json_encode([
                        'title' => 'Galeri Kegiatan MAN 4 Pekanbaru',
                        'items' => [
                            ['image' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg', 'caption' => 'Upacara Bendera'],
                            ['image' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg', 'caption' => 'Pembelajaran di Kelas'],
                            ['image' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg', 'caption' => 'Kegiatan Olahraga'],
                            ['image' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg', 'caption' => 'Lomba Sains'],
                            ['image' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg', 'caption' => 'Ekstrakulikuler Pramuka'],
                            ['image' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-6.jpg', 'caption' => 'Wisuda Tahfidz'],
                            ['image' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-7.jpg', 'caption' => 'Kunjungan Industri'],
                            ['image' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-8.jpg', 'caption' => 'Peringatan Maulid Nabi'],
                        ]
                    ]),
                    'is_active' => true,
                ]
            );
        }

        // ===================== FAQ =====================
        $faqModule = LandingPageModule::where('kode_modul', 'faq')->first();
        if ($faqModule) {
            LandingPageSection::updateOrCreate(
                ['landing_page_module_id' => $faqModule->id],
                [
                    'urutan' => 7,
                    'konten' => json_encode([
                        'title' => 'Pertanyaan yang Sering Diajukan (FAQ)',
                        'items' => [
                            [
                                'question' => 'Kapan pendaftaran PMBM MAN 4 dibuka?',
                                'answer' => 'Pendaftaran PMBM MAN 4 Kota Pekanbaru untuk tahun ajaran 2026/2027 dibuka mulai 10 Februari 2026 hingga 30 April 2026. Segera daftar sebelum kuota terpenuhi.'
                            ],
                            [
                                'question' => 'Apa saja berkas yang diperlukan untuk mendaftar?',
                                'answer' => 'Berkas yang diperlukan antara lain: Fotocopy Ijazah/SKL yang dilegalisir, Fotocopy Rapor semester 1-5, Fotocopy Akta Kelahiran, Fotocopy Kartu Keluarga, Pas foto 3x4 (4 lembar), dan Fotocopy NISN.'
                            ],
                            [
                                'question' => 'Apakah ada tes masuk? Apa saja materinya?',
                                'answer' => 'Ya, calon siswa harus mengikuti tes masuk yang terdiri dari: Tes Akademik (Matematika, IPA, Bahasa Indonesia, Bahasa Inggris), dan Tes Baca Al-Quran (BTQ). Jadwal tes akan diinformasikan setelah verifikasi berkas.'
                            ],
                            [
                                'question' => 'Berapa biaya pendaftaran?',
                                'answer' => 'Biaya pendaftaran PMBM MAN 4 Kota Pekanbaru bersifat terjangkau. Informasi detail mengenai biaya dapat dilihat pada saat proses daftar ulang atau hubungi panitia PMBM.'
                            ],
                            [
                                'question' => 'Bagaimana cara memantau status pendaftaran?',
                                'answer' => 'Anda dapat memantau status pendaftaran melalui dashboard siswa setelah login ke akun yang sudah didaftarkan. Status akan diperbarui secara otomatis oleh panitia.'
                            ],
                            [
                                'question' => 'Apakah tersedia asrama untuk siswa?',
                                'answer' => 'Saat ini MAN 4 Kota Pekanbaru belum menyediakan fasilitas asrama. Namun, informasi tentang tempat kost terdekat dapat dibantu oleh pihak madrasah.'
                            ]
                        ]
                    ]),
                    'is_active' => true,
                ]
            );
        }

        // ===================== KONTAK =====================
        $kontakModule = LandingPageModule::where('kode_modul', 'kontak')->first();
        if ($kontakModule) {
            LandingPageSection::updateOrCreate(
                ['landing_page_module_id' => $kontakModule->id],
                [
                    'urutan' => 8,
                    'konten' => json_encode([
                        'title' => 'Hubungi Kami',
                        'subtitle' => 'Silakan hubungi panitia PMBM MAN 4 Kota Pekanbaru untuk informasi lebih lanjut',
                        'address' => 'Jl. Yos Sudarso KM. 15, Muara Fajar, Kec. Rumbai, Kota Pekanbaru, Riau 28264',
                        'phone' => '081268713026 (HUMAS)',
                        'whatsapp' => '081268713026',
                    ]),
                    'is_active' => true,
                ]
            );
        }
    }
}
