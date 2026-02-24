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
        $query = CalonSiswa::with('user')
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
            'Nama Lengkap',
            'NISN',
            'NIK',
            'Email',
            'No HP Siswa',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Asal Sekolah',
            'Jurusan Pilihan',
            'Nama Ayah',
            'No HP Ayah',
            'Nama Ibu',
            'No HP Ibu',
            'Status',
            'Keterangan Status',
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

        return [
            $this->no,
            $row->nama_lengkap,
            $row->nisn ?? '-',
            $row->nik ?? '-',
            $row->user->email ?? '-',
            $row->no_hp_siswa ?? '-',
            $row->jenis_kelamin == 'L' ? 'Laki-laki' : ($row->jenis_kelamin == 'P' ? 'Perempuan' : '-'),
            $row->tempat_lahir ?? '-',
            $row->tanggal_lahir ? \Carbon\Carbon::parse($row->tanggal_lahir)->format('d/m/Y') : '-',
            $row->asal_sekolah ?? '-',
            $row->jurusan_pilihan ?? '-',
            $row->nama_ayah ?? '-',
            $row->no_hp_ayah ?? '-',
            $row->nama_ibu ?? '-',
            $row->no_hp_ibu ?? '-',
            $statusLabel,
            $tahap,
            $row->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header row styling
        $sheet->getStyle('A1:R1')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '16a34a']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);

        // Freeze header row
        $sheet->freezePane('A2');

        return [];
    }
}
