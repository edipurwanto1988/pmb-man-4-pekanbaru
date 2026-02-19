<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalonSiswa;
use App\Models\LandingPageSection;
use App\Models\SyaratDaftarUlang;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pendaftar' => CalonSiswa::count(),
            'menunggu_verifikasi' => CalonSiswa::where('status', 'menunggu_verifikasi')->count(),
            'lulus_administrasi' => CalonSiswa::where('status', 'lulus_administrasi')->count(),
            'lulus_tes' => CalonSiswa::where('status', 'lulus_tes')->count(),
            'lulus_pnbm' => CalonSiswa::where('status', 'lulus_pnbm')->count(),
            'daftar_ulang' => CalonSiswa::where('status', 'daftar_ulang')->count(),
            'resmi_terdaftar' => CalonSiswa::where('status', 'resmi_terdaftar')->count(),
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'total_syarat' => SyaratDaftarUlang::count(),
            'active_sections' => LandingPageSection::where('is_active', true)->count(),
        ];

        // Recent registrations
        $recentPendaftar = CalonSiswa::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPendaftar'));
    }
}
