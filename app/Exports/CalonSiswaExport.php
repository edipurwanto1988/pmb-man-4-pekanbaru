<?php

namespace App\Exports;

use App\Models\CalonSiswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Http\Request;

class CalonSiswaExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $request;
    protected $no = 0;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = CalonSiswa::with(['user', 'berkas', 'hasilTes'])
            ->orderBy('created_at', 'asc');

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($this->request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $this->request->dari_tanggal);
        }

        if ($this->request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $this->request->sampai_tanggal);
        }

        if ($this->request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $this->request->jenis_kelamin);
        }

        if ($this->request->filled('jurusan')) {
            $query->where('jurusan_pilihan', $this->request->jurusan);
        }

        return $query;
    }

    public function title(): string
    {
        return 'Data Calon Siswa';
    }

    public function headings(): array
    {
        return [
            'No',
            // Biodata Siswa
            'Nama Lengkap',
            'NISN',
            'NIK',
            'No KK',
            'Email',
            'No HP Siswa',
            'No HP Ortu',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Anak Ke',
            'Dari Bersaudara',
            'Status Dalam Keluarga',
            'Alamat Siswa',
            'RT/RW',
            'Kode Pos',
            'Kota',
            'Bahasa Harian',
            'Status Rumah',
            'Jarak Rumah (km)',
            'Transportasi',
            'Jurusan Pilihan',
            'Asal Sekolah',
            'Alamat Asal Sekolah',
            'NPSN',
            'NSM',
            'Hobi',
            'Cita-Cita',
            'Golongan Darah',
            'Riwayat Sakit',
            'Tinggi Badan',
            'Berat Badan',
            // Biodata Ayah
            'Nama Ayah',
            'NIK Ayah',
            'Tempat Lahir Ayah',
            'Tanggal Lahir Ayah',
            'Pendidikan Ayah',
            'Pekerjaan Ayah',
            'Penghasilan Ayah',
            'Alamat Ayah',
            'RT/RW Ayah',
            'Kode Pos Ayah',
            'Kota Ayah',
            'No HP Ayah',
            // Biodata Ibu
            'Nama Ibu',
            'NIK Ibu',
            'Tempat Lahir Ibu',
            'Tanggal Lahir Ibu',
            'Pendidikan Ibu',
            'Pekerjaan Ibu',
            'Penghasilan Ibu',
            'Alamat Ibu',
            'RT/RW Ibu',
            'Kode Pos Ibu',
            'Kota Ibu',
            'No HP Ibu',
            // Biodata Wali
            'Nama Wali',
            'NIK Wali',
            'Tempat Lahir Wali',
            'Tanggal Lahir Wali',
            'Pendidikan Wali',
            'Pekerjaan Wali',
            'Penghasilan Wali',
            'Alamat Wali',
            'RT/RW Wali',
            'Kode Pos Wali',
            'Kota Wali',
            'No HP Wali',
            // Berkas (Status saja, tanpa link)
            'Berkas Ijazah',
            'Status Berkas Ijazah',
            'Berkas KK',
            'Status Berkas KK',
            'Berkas Akta',
            'Status Berkas Akta',
            'Berkas Foto',
            'Status Berkas Foto',
            'Berkas Raport',
            'Status Berkas Raport',
            // Hasil Tes
            'Hasil Tes (Ringkasan)',
            // Status
            'Status',
            'Keterangan Status',
            'Catatan Panitia',
            'Tanggal Daftar',
        ];
    }

    public function map($row): array
    {
        $this->no++;

        $statusLabel = match($row->status) {
            'terdaftar'                => 'Terdaftar',
            'menunggu_verifikasi'      => 'Menunggu Verifikasi Berkas',
            'lulus_administrasi'       => 'Lulus Verifikasi Administrasi',
            'tidak_lulus_administrasi' => 'Tidak Lulus Administrasi',
            'lulus_tes'                => 'Lulus Tes Seleksi',
            'tidak_lulus_tes'          => 'Tidak Lulus Tes Seleksi',
            'lulus_pnbm'               => 'Lulus PMB - Perlu Daftar Ulang',
            'tidak_lulus_pnbm'         => 'Tidak Diterima',
            'daftar_ulang'             => 'Proses Daftar Ulang',
            'resmi_terdaftar'          => 'Resmi Diterima sebagai Siswa',
            default                    => ucfirst(str_replace('_', ' ', $row->status)),
        };

        $tahap = match($row->status) {
            'terdaftar'                => '1 - Baru Mendaftar',
            'menunggu_verifikasi'      => '2 - Upload Berkas',
            'lulus_administrasi'       => '3 - Lulus Administrasi',
            'tidak_lulus_administrasi' => '3 - Gagal Administrasi',
            'lulus_tes'                => '4 - Lulus Tes',
            'tidak_lulus_tes'          => '4 - Gagal Tes',
            'lulus_pnbm'               => '5 - Lulus Seleksi',
            'tidak_lulus_pnbm'         => '5 - Tidak Diterima',
            'daftar_ulang'             => '6 - Daftar Ulang',
            'resmi_terdaftar'          => '7 - Selesai / Diterima',
            default                    => '-',
        };

        // Berkas status per jenis (tanpa link file)
        $berkasMap = $row->berkas->keyBy('jenis_berkas');

        $getBerkasInfo = function ($jenis) use ($berkasMap) {
            $berkas = $berkasMap->get($jenis);
            if (!$berkas) {
                return ['Belum Upload', '-'];
            }
            $statusBerkas = match($berkas->status) {
                'pending'           => 'Menunggu Verifikasi',
                'diterima'          => 'Diterima',
                'ditolak'           => 'Ditolak',
                'perlu_perbaikan'   => 'Perlu Perbaikan',
                default             => ucfirst($berkas->status),
            };
            return ['Sudah Upload', $statusBerkas];
        };

        $ijazah = $getBerkasInfo('ijazah');
        $kk     = $getBerkasInfo('kk');
        $akta   = $getBerkasInfo('akta');
        $foto   = $getBerkasInfo('foto');
        $raport = $getBerkasInfo('raport');

        // Hasil Tes ringkasan
        $hasilTesRingkasan = '-';
        if ($row->hasilTes && $row->hasilTes->count() > 0) {
            $hasilTesRingkasan = $row->hasilTes->map(function ($tes) {
                $statusTes = match($tes->status) {
                    'lulus'       => 'Lulus',
                    'tidak_lulus' => 'Tidak Lulus',
                    default       => ucfirst($tes->status ?? '-'),
                };
                return ucfirst(str_replace('_', ' ', $tes->jenis_tes)) . ': ' . $tes->nilai . ' (' . $statusTes . ')';
            })->implode(' | ');
        }

        return [
            $this->no,
            // Biodata Siswa
            $row->nama_lengkap,
            "'" . ($row->nisn ?? '-'),
            "'" . ($row->nik ?? '-'),
            "'" . ($row->no_kk ?? '-'),
            $row->user->email ?? '-',
            "'" . ($row->no_hp_siswa ?? '-'),
            "'" . ($row->no_hp_ortu ?? '-'),
            $row->jenis_kelamin == 'L' ? 'Laki-laki' : ($row->jenis_kelamin == 'P' ? 'Perempuan' : '-'),
            $row->tempat_lahir ?? '-',
            $row->tanggal_lahir ? \Carbon\Carbon::parse($row->tanggal_lahir)->format('d/m/Y') : '-',
            $row->anak_ke ?? '-',
            $row->dari_bersaudara ?? '-',
            $row->status_dalam_keluarga ?? '-',
            $row->alamat_siswa ?? '-',
            $row->rt_rw_siswa ?? '-',
            "'" . ($row->kode_pos_siswa ?? '-'),
            $row->kota_siswa ?? '-',
            $row->bahasa_harian ?? '-',
            $row->status_rumah ?? '-',
            $row->jarak_rumah_km ?? '-',
            $row->transportasi ?? '-',
            $row->jurusan_pilihan ?? '-',
            $row->asal_sekolah ?? '-',
            $row->alamat_asal_sekolah ?? '-',
            "'" . ($row->npsn ?? '-'),
            "'" . ($row->nsm ?? '-'),
            $row->hobi ?? '-',
            $row->cita_cita ?? '-',
            $row->golongan_darah ?? '-',
            $row->riwayat_sakit ?? '-',
            $row->tinggi_badan ?? '-',
            $row->berat_badan ?? '-',
            // Biodata Ayah
            $row->nama_ayah ?? '-',
            "'" . ($row->nik_ayah ?? '-'),
            $row->tempat_lahir_ayah ?? '-',
            $row->tanggal_lahir_ayah ? \Carbon\Carbon::parse($row->tanggal_lahir_ayah)->format('d/m/Y') : '-',
            $row->pendidikan_ayah ?? '-',
            $row->pekerjaan_ayah ?? '-',
            $row->penghasilan_ayah ?? '-',
            $row->alamat_ayah ?? '-',
            $row->rt_rw_ayah ?? '-',
            "'" . ($row->kode_pos_ayah ?? '-'),
            $row->kota_ayah ?? '-',
            "'" . ($row->no_hp_ayah ?? '-'),
            // Biodata Ibu
            $row->nama_ibu ?? '-',
            "'" . ($row->nik_ibu ?? '-'),
            $row->tempat_lahir_ibu ?? '-',
            $row->tanggal_lahir_ibu ? \Carbon\Carbon::parse($row->tanggal_lahir_ibu)->format('d/m/Y') : '-',
            $row->pendidikan_ibu ?? '-',
            $row->pekerjaan_ibu ?? '-',
            $row->penghasilan_ibu ?? '-',
            $row->alamat_ibu ?? '-',
            $row->rt_rw_ibu ?? '-',
            "'" . ($row->kode_pos_ibu ?? '-'),
            $row->kota_ibu ?? '-',
            "'" . ($row->no_hp_ibu ?? '-'),
            // Biodata Wali
            $row->nama_wali ?? '-',
            "'" . ($row->nik_wali ?? '-'),
            $row->tempat_lahir_wali ?? '-',
            $row->tanggal_lahir_wali ? \Carbon\Carbon::parse($row->tanggal_lahir_wali)->format('d/m/Y') : '-',
            $row->pendidikan_wali ?? '-',
            $row->pekerjaan_wali ?? '-',
            $row->penghasilan_wali ?? '-',
            $row->alamat_wali ?? '-',
            $row->rt_rw_wali ?? '-',
            "'" . ($row->kode_pos_wali ?? '-'),
            $row->kota_wali ?? '-',
            "'" . ($row->no_hp_wali ?? '-'),
            // Berkas (status saja, tanpa link)
            $ijazah[0], $ijazah[1],
            $kk[0], $kk[1],
            $akta[0], $akta[1],
            $foto[0], $foto[1],
            $raport[0], $raport[1],
            // Hasil Tes
            $hasilTesRingkasan,
            // Status
            $statusLabel,
            $tahap,
            $row->catatan_panitia ?? '-',
            $row->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastCol = 'CH'; // Adjusted for new columns (approx 86 columns)

        // Header row styling
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '16a34a']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']],
            ],
        ]);

        // Set header row height
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Freeze header row
        $sheet->freezePane('A2');

        return [];
    }
}
