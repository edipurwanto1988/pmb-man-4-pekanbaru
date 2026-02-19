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
}
