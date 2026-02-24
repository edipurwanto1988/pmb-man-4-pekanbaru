<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\CalonSiswa;
use App\Models\Jadwal;
use App\Models\HasilTes;
use Illuminate\Support\Facades\Auth;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $calonSiswa = CalonSiswa::where('user_id', $user->id)->first();

        $berkasCount = 0;
        $hasilTes = collect();
        
        if ($calonSiswa) {
            $berkasCount = $calonSiswa->berkas()->count();
            $hasilTes = $calonSiswa->hasilTes;
        }

        return view('siswa.dashboard', compact('calonSiswa', 'berkasCount', 'hasilTes'));
    }

    public function jadwal()
    {
        $jadwals = Jadwal::where('aktif', true)->orderBy('waktu_mulai')->get();
        return view('siswa.jadwal', compact('jadwals'));
    }

    public function hasilTes()
    {
        $user = Auth::user();
        $calonSiswa = CalonSiswa::where('user_id', $user->id)->first();

        $hasilTes = collect();
        if ($calonSiswa) {
            $hasilTes = HasilTes::where('calon_siswa_id', $calonSiswa->id)->get();
        }

        return view('siswa.hasil-tes', compact('calonSiswa', 'hasilTes'));
    }

    public function pengumuman()
    {
        $user = Auth::user();
        $calonSiswa = CalonSiswa::where('user_id', $user->id)->first();

        return view('siswa.pengumuman', compact('calonSiswa'));
    }

    public function editBiodata()
    {
        $calonSiswa = CalonSiswa::where('user_id', Auth::id())->firstOrFail();
        return view('siswa.biodata-edit', compact('calonSiswa'));
    }

    public function updateBiodata(\Illuminate\Http\Request $request)
    {
        $calonSiswa = CalonSiswa::where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'nama_lengkap'      => ['required', 'string', 'max:255'],
            'nik'               => ['nullable', 'string', 'max:16'],
            'no_kk'             => ['nullable', 'string', 'max:16'],
            'tempat_lahir'      => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'     => ['nullable', 'date'],
            'jenis_kelamin'     => ['nullable', 'in:L,P'],
            'anak_ke'           => ['nullable', 'integer'],
            'dari_bersaudara'   => ['nullable', 'integer'],
            'status_dalam_keluarga' => ['nullable', 'string', 'max:100'],
            'alamat_siswa'      => ['nullable', 'string'],
            'rt_rw_siswa'       => ['nullable', 'string', 'max:20'],
            'kode_pos_siswa'    => ['nullable', 'string', 'max:10'],
            'kota_siswa'        => ['nullable', 'string', 'max:100'],
            'bahasa_harian'     => ['nullable', 'string', 'max:100'],
            'status_rumah'      => ['nullable', 'string', 'max:100'],
            'jarak_rumah_km'    => ['nullable', 'numeric'],
            'transportasi'      => ['nullable', 'string', 'max:100'],
            'no_hp_siswa'       => ['required', 'string', 'max:15'],
            'jurusan_pilihan'   => ['nullable', 'string', 'max:50'],
            'asal_sekolah'      => ['nullable', 'string', 'max:255'],
            'alamat_asal_sekolah' => ['nullable', 'string'],
            'npsn'              => ['nullable', 'string', 'max:20'],
            'nsm'               => ['nullable', 'string', 'max:20'],
            'hobi'              => ['nullable', 'string', 'max:255'],
            'cita_cita'         => ['nullable', 'string', 'max:255'],
            'golongan_darah'    => ['nullable', 'string', 'max:5'],
            'riwayat_sakit'     => ['nullable', 'string'],
            'tinggi_badan'      => ['nullable', 'string', 'max:10'],
            'berat_badan'       => ['nullable', 'string', 'max:10'],
            // Ayah
            'nama_ayah'         => ['nullable', 'string', 'max:255'],
            'nik_ayah'          => ['nullable', 'string', 'max:16'],
            'tempat_lahir_ayah' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir_ayah'=> ['nullable', 'date'],
            'pendidikan_ayah'   => ['nullable', 'string', 'max:50'],
            'pekerjaan_ayah'    => ['nullable', 'string', 'max:100'],
            'penghasilan_ayah'  => ['nullable', 'string', 'max:100'],
            'alamat_ayah'       => ['nullable', 'string'],
            'rt_rw_ayah'        => ['nullable', 'string', 'max:20'],
            'kode_pos_ayah'     => ['nullable', 'string', 'max:10'],
            'kota_ayah'         => ['nullable', 'string', 'max:100'],
            'no_hp_ayah'        => ['nullable', 'string', 'max:15'],
            // Ibu
            'nama_ibu'          => ['nullable', 'string', 'max:255'],
            'nik_ibu'           => ['nullable', 'string', 'max:16'],
            'tempat_lahir_ibu'  => ['nullable', 'string', 'max:100'],
            'tanggal_lahir_ibu' => ['nullable', 'date'],
            'pendidikan_ibu'    => ['nullable', 'string', 'max:50'],
            'pekerjaan_ibu'     => ['nullable', 'string', 'max:100'],
            'penghasilan_ibu'   => ['nullable', 'string', 'max:100'],
            'alamat_ibu'        => ['nullable', 'string'],
            'rt_rw_ibu'         => ['nullable', 'string', 'max:20'],
            'kode_pos_ibu'      => ['nullable', 'string', 'max:10'],
            'kota_ibu'          => ['nullable', 'string', 'max:100'],
            'no_hp_ibu'         => ['nullable', 'string', 'max:15'],
            // Wali
            'nama_wali'         => ['nullable', 'string', 'max:255'],
            'nik_wali'          => ['nullable', 'string', 'max:16'],
            'tempat_lahir_wali' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir_wali'=> ['nullable', 'date'],
            'pendidikan_wali'   => ['nullable', 'string', 'max:50'],
            'pekerjaan_wali'    => ['nullable', 'string', 'max:100'],
            'penghasilan_wali'  => ['nullable', 'string', 'max:100'],
            'alamat_wali'       => ['nullable', 'string'],
            'rt_rw_wali'        => ['nullable', 'string', 'max:20'],
            'kode_pos_wali'     => ['nullable', 'string', 'max:10'],
            'kota_wali'         => ['nullable', 'string', 'max:100'],
            'no_hp_wali'        => ['nullable', 'string', 'max:15'],
        ], [
            'nama_lengkap.required' => 'Nama siswa wajib diisi.',
            'no_hp_siswa.required'  => 'No. HP/WA siswa wajib diisi.',
        ]);

        $calonSiswa->update($validated);

        // Sync nama di tabel users
        Auth::user()->update(['name' => $request->nama_lengkap]);

        return redirect()->route('siswa.biodata.edit')
            ->with('success', 'Biodata berhasil diperbarui!');
    }
}
