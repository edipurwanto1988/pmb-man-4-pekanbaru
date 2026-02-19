<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\SyaratDaftarUlangController;
use App\Http\Controllers\Admin\PendaftarController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\Admin\PenilaianController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\DaftarUlangController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Siswa\SiswaDashboardController;
use App\Http\Controllers\Siswa\BerkasAwalController;
use App\Http\Controllers\Siswa\BerkasDaftarUlangController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth (Breeze)
require __DIR__.'/auth.php';

// Authenticated: Profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard redirect based on role
    Route::get('/dashboard', function () {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('siswa.dashboard');
    })->name('dashboard');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Landing Page Builder
    Route::resource('landing-page', LandingPageController::class);
    Route::post('landing-page/reorder', [LandingPageController::class, 'reorder'])->name('landing-page.reorder');
    Route::post('landing-page/toggle/{id}', [LandingPageController::class, 'toggle'])->name('landing-page.toggle');

    // Kelola Pendaftar
    Route::get('pendaftar', [PendaftarController::class, 'index'])->name('pendaftar.index');
    Route::get('pendaftar/{id}', [PendaftarController::class, 'show'])->name('pendaftar.show');
    Route::put('pendaftar/{id}/status', [PendaftarController::class, 'updateStatus'])->name('pendaftar.updateStatus');
    Route::delete('pendaftar/{id}', [PendaftarController::class, 'destroy'])->name('pendaftar.destroy');

    // Verifikasi Berkas
    Route::get('verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::get('verifikasi/{id}', [VerifikasiController::class, 'show'])->name('verifikasi.show');
    Route::put('verifikasi/berkas/{id}', [VerifikasiController::class, 'updateBerkas'])->name('verifikasi.updateBerkas');
    Route::post('verifikasi/{id}/luluskan', [VerifikasiController::class, 'luluskanAdministrasi'])->name('verifikasi.luluskan');
    Route::post('verifikasi/{id}/tolak', [VerifikasiController::class, 'tolakAdministrasi'])->name('verifikasi.tolak');

    // Penilaian / Input Nilai
    Route::get('penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('penilaian/{id}', [PenilaianController::class, 'show'])->name('penilaian.show');
    Route::post('penilaian/{id}', [PenilaianController::class, 'store'])->name('penilaian.store');

    // Jadwal
    Route::resource('jadwal', JadwalController::class);
    Route::post('jadwal/{id}/toggle', [JadwalController::class, 'toggleAktif'])->name('jadwal.toggleAktif');

    // Pengumuman Kelulusan
    Route::get('pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::post('pengumuman/{id}/luluskan', [PengumumanController::class, 'luluskan'])->name('pengumuman.luluskan');
    Route::post('pengumuman/{id}/tidak-luluskan', [PengumumanController::class, 'tidakLuluskan'])->name('pengumuman.tidakLuluskan');
    Route::post('pengumuman/massal', [PengumumanController::class, 'luluskanMassal'])->name('pengumuman.massal');

    // Daftar Ulang (Admin)
    Route::get('daftar-ulang', [DaftarUlangController::class, 'index'])->name('daftar-ulang.index');
    Route::get('daftar-ulang/{id}', [DaftarUlangController::class, 'show'])->name('daftar-ulang.show');
    Route::put('daftar-ulang/berkas/{id}', [DaftarUlangController::class, 'verifyBerkas'])->name('daftar-ulang.verifyBerkas');
    Route::post('daftar-ulang/{id}/konfirmasi', [DaftarUlangController::class, 'konfirmasi'])->name('daftar-ulang.konfirmasi');

    // Syarat & Berkas
    Route::resource('syarat', SyaratDaftarUlangController::class);

    // Role Management
    Route::resource('roles', RoleController::class);
});

// Siswa Routes
Route::middleware(['auth', 'role:calon_siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

    // Berkas Awal (Pendaftaran)
    Route::get('/berkas-awal', [BerkasAwalController::class, 'index'])->name('berkas-awal.index');
    Route::post('/berkas-awal', [BerkasAwalController::class, 'store'])->name('berkas-awal.store');
    Route::delete('/berkas-awal/{id}', [BerkasAwalController::class, 'destroy'])->name('berkas-awal.destroy');

    // Berkas Daftar Ulang
    Route::get('/berkas', [BerkasDaftarUlangController::class, 'index'])->name('berkas.index');
    Route::post('/berkas', [BerkasDaftarUlangController::class, 'store'])->name('berkas.store');
    Route::delete('/berkas/{id}', [BerkasDaftarUlangController::class, 'destroy'])->name('berkas.destroy');

    // Jadwal
    Route::get('/jadwal', [SiswaDashboardController::class, 'jadwal'])->name('jadwal');

    // Hasil Tes
    Route::get('/hasil-tes', [SiswaDashboardController::class, 'hasilTes'])->name('hasil-tes');

    // Pengumuman
    Route::get('/pengumuman', [SiswaDashboardController::class, 'pengumuman'])->name('pengumuman');
});
