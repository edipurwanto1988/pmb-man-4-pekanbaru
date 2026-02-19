@extends('layouts.landing')

@section('content')
<div style="min-height: 80vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 16px; background-color: #f9fafb;">
    <div style="width: 100%; max-width: 480px;">
        <div style="background: #ffffff; border-top: 4px solid #15803d; border-radius: 12px; padding: 32px; box-shadow: 0 10px 25px rgba(0,0,0,0.08);">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold" style="color: #111827;">Pendaftaran PMB</h2>
                <p class="text-sm mt-1" style="color: #6b7280;">MAN 4 Kota Pekanbaru</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                    <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap" :value="old('nama_lengkap')" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap" />
                    <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                </div>

                <!-- NISN -->
                <div class="mt-4">
                    <x-input-label for="nisn" :value="__('NISN')" />
                    <x-text-input id="nisn" class="block mt-1 w-full" type="text" name="nisn" :value="old('nisn')" required autocomplete="off" placeholder="10 digit NISN" maxlength="10" pattern="[0-9]{10}" />
                    <x-input-error :messages="$errors->get('nisn')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="contoh@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- No HP Siswa -->
                <div class="mt-4">
                    <x-input-label for="no_hp_siswa" :value="__('No. HP Siswa')" />
                    <x-text-input id="no_hp_siswa" class="block mt-1 w-full" type="text" name="no_hp_siswa" :value="old('no_hp_siswa')" required placeholder="08xxxxxxxxxx" />
                    <x-input-error :messages="$errors->get('no_hp_siswa')" class="mt-2" />
                </div>

                <!-- No HP Orang Tua -->
                <div class="mt-4">
                    <x-input-label for="no_hp_ortu" :value="__('No. HP Orang Tua')" />
                    <x-text-input id="no_hp_ortu" class="block mt-1 w-full" type="text" name="no_hp_ortu" :value="old('no_hp_ortu')" required placeholder="08xxxxxxxxxx" />
                    <x-input-error :messages="$errors->get('no_hp_ortu')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="mt-6">
                    <button type="submit" style="width: 100%; padding: 12px; background-color: #15803d; color: #ffffff; font-weight: 600; border-radius: 8px; border: none; cursor: pointer; font-size: 16px; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#166534'" onmouseout="this.style.backgroundColor='#15803d'">
                        Daftar Sekarang
                    </button>
                </div>

                <div class="mt-4 text-center">
                    <span style="color: #6b7280; font-size: 14px;">Sudah punya akun?</span>
                    <a href="{{ route('login') }}" style="color: #15803d; font-size: 14px; font-weight: 600; text-decoration: none; margin-left: 4px;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Masuk di sini</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
