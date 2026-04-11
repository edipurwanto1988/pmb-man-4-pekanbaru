<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Ujian PMB MAN 4 Kota Pekanbaru</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .card {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border: 1px solid #00030b;
            border-radius: 10px;
            overflow: hidden;
        }
        .header {
            background: #fffff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 18px;
            font-weight: normal;
        }
        .content {
            padding: 30px;
        }
        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 30px;
            text-decoration: underline;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 8px 5px;
            vertical-align: middle;
        }
        .info-label {
            font-weight: bold;
            width: 180px;
            color: #374151;
        }
        .info-separator {
            width: 10px;
            text-align: center;
        }
        .info-value {
            color: #1f2937;
        }
        .photo-section {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .photo-placeholder {
            width: 120px;
            height: 150px;
            border: 2px dashed #9ca3af;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 12px;
            text-align: center;
        }
        .status {
            background-color: #dcfce7;
            color: #166534;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            background-color: #f3f4f6;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }
        .signature {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }
        .signature-box {
            text-align: center;
        }
        .signature-space {
            height: 60px;
            margin-top: 10px;
        }
        .important {
            background-color: #fef3c7;
            color: #92400e;
            padding: 10px;
            border-radius: 5px;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 80px; vertical-align: middle; padding: 10px;">
                        @php
                            $logoPath = public_path('logo_man.png');
                            $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;
                        @endphp
                        @if($logoData)
                            <img src="data:image/png;base64,{{ $logoData }}" alt="Logo MAN 4" style="width: 70px; height: auto;">
                        @endif
                    </td>
                    <td style="vertical-align: middle; text-align: center;">
                        <h1>KEMENTERIAN AGAMA REPUBLIK INDONESIA</h1>
                        <h2>KANTOR KEMENTERIAN AGAMA KOTA PEKANBARU</h2>
                        <h2>MADRASAH ALIYAH NEGERI 4 KOTA PEKANBARU</h2>
                        <h2>TERAKREDITASI A</h2>
                        <h2 style="border-bottom: 2px solid black;">JL. YOS SUDARSO KM. 15 PEKANBARU</h2>
                    </td>
                </tr>
            </table>
        </div>

        <div class="content">
            <div class="title">KARTU PESERTA UJIAN</div>

            <table style="width: 100%; margin-bottom: 20px; border-collapse: collapse;">
                <tr>
                    <td style="width: 140px; vertical-align: top; padding-right: 20px;">
                        <div class="photo-section">
                            @if($calonSiswa->foto_profil)
                                @php
                                    $imagePath = storage_path('app/public/' . $calonSiswa->foto_profil);
                                    $imageData = file_exists($imagePath) ? base64_encode(file_get_contents($imagePath)) : null;
                                    $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                                @endphp
                                @if($imageData)
                                    <div style="width: 120px; height: 150px; border: 2px solid #1e40af; border-radius: 5px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                        <img src="data:image/{{ $imageType }};base64,{{ $imageData }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                @else
                                    <div class="photo-placeholder">
                                        FOTO 3x4<br>(Tempel Foto)
                                    </div>
                                @endif
                            @else
                                <div class="photo-placeholder">
                                    FOTO 3x4<br>(Tempel Foto)
                                </div>
                            @endif
                        </div>
                    </td>
                    <td style="vertical-align: top;">
                        <table class="info-table">
                            <tr>
                                <td class="info-label">No. Pendaftaran</td>
                                <td class="info-separator">:</td>
                                <td class="info-value">PPDB-M4C-2026-{{ $calonSiswa->id }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">NISN</td>
                                <td class="info-separator">:</td>
                                <td class="info-value">{{ $calonSiswa->nisn }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Nama Lengkap</td>
                                <td class="info-separator">:</td>
                                <td class="info-value">{{ $calonSiswa->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Tempat, Tgl Lahir</td>
                                <td class="info-separator">:</td>
                                <td class="info-value">{{ $calonSiswa->tempat_lahir ?? '-' }}, {{ $calonSiswa->tanggal_lahir ? \Carbon\Carbon::parse($calonSiswa->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Jenis Kelamin</td>
                                <td class="info-separator">:</td>
                                <td class="info-value">{{ $calonSiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">No. HP/WA</td>
                                <td class="info-separator">:</td>
                                <td class="info-value">{{ $calonSiswa->no_hp_siswa }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Asal Sekolah</td>
                                <td class="info-separator">:</td>
                                <td class="info-value">{{ $calonSiswa->asal_sekolah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Jurusan Pilihan</td>
                                <td class="info-separator">:</td>
                                <td class="info-value">{{ $calonSiswa->jurusan_pilihan ?? '-' }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <div class="status">
                STATUS: {{ strtoupper(str_replace('_', ' ', $calonSiswa->status)) }}
            </div>

            <div class="important">
                <strong>PENTING:</strong>
                <ul style="margin: 5px 0 0 20px; padding: 0;">
                    <li>Kartu ini wajib dibawa saat ujian</li>
                    <li>Harap membawa alat tulis sendiri</li>
                    <li>Peserta wajib hadir 30 menit sebelum ujian dimulai</li>
                    <li>Dilarang membawa alat komunikasi selama ujian</li>
                </ul>
            </div>

            <div class="signature">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 50%; text-align: center;">
                            <div class="signature-box">
                                <div>Panitia PMB</div>
                                <div class="signature-space"></div>
                                <div>( ................................. )</div>
                            </div>
                        </td>
                        <td style="width: 50%; text-align: center;">
                            <div class="signature-box">
                                <div>Peserta Ujian</div>
                                <div class="signature-space"></div>
                                <div>( {{ $calonSiswa->nama_lengkap }} )</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="footer">
            <p>Dicetak pada: {{ $tanggal_cetak }}</p>
            <p>MAN 4 Kota Pekanbaru - JL. YOS SUDARSO KM. 15 PEKANBARU</p>
        </div>
    </div>
</body>
</html>
