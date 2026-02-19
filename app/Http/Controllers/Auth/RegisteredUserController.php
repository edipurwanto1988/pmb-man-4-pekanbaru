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
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nisn' => ['required', 'string', 'size:10', 'unique:calon_siswa,nisn'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'no_hp_siswa' => ['required', 'string', 'max:15'],
            'no_hp_ortu' => ['required', 'string', 'max:15'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Assign default role
            $user->assignRole('calon_siswa');

            // Create CalonSiswa record
            CalonSiswa::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'nisn' => $request->nisn,
                'no_hp_siswa' => $request->no_hp_siswa,
                'no_hp_ortu' => $request->no_hp_ortu,
                'status' => 'terdaftar',
            ]);

            event(new Registered($user));
            Auth::login($user);
        });

        return redirect('/siswa/dashboard');
    }
}
