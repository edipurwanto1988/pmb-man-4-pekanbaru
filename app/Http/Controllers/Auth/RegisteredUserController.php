<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CalonSiswa;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_lengkap'      => ['required', 'string', 'max:255'],
            'nisn'              => ['required', 'string', 'size:10', 'unique:calon_siswa,nisn'],
            'nik'               => ['nullable', 'string', 'max:16'],
            'no_kk'             => ['nullable', 'string', 'max:16'],
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
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
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'nama_lengkap.required' => 'Nama siswa wajib diisi.',
            'nisn.required'         => 'NISN wajib diisi.',
            'nisn.size'             => 'NISN harus tepat 10 digit angka.',
            'nisn.unique'           => 'NISN sudah terdaftar. Hubungi panitia jika ada kesalahan.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah terdaftar. Gunakan email lain atau masuk ke akun Anda.',
            'no_hp_siswa.required'  => 'No. HP/WA siswa wajib diisi.',
            'password.required'     => 'Password wajib diisi.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
            'password.min'          => 'Password minimal 8 karakter.',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->nama_lengkap,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('calon_siswa');

            CalonSiswa::create(array_merge(
                $request->except(['email', 'password', 'password_confirmation', '_token']),
                ['user_id' => $user->id, 'status' => 'terdaftar']
            ));

            event(new Registered($user));
            Auth::login($user);
        });

        return redirect('/siswa/dashboard');
    }
}
