@extends('layouts.landing')

@section('content')
<div style="min-height: 80vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 16px; background-color: #f9fafb;">
    <div style="width: 100%; max-width: 480px;">
        <div style="background: #ffffff; border-top: 4px solid #15803d; border-radius: 12px; padding: 32px; box-shadow: 0 10px 25px rgba(0,0,0,0.08);">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold" style="color: #111827;">Masuk</h2>
                <p class="text-sm mt-1" style="color: #6b7280;">PMB MAN 4 Kota Pekanbaru</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="contoh@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 16px;">
                    <label for="remember_me" style="display: inline-flex; align-items: center; cursor: pointer;">
                        <input id="remember_me" type="checkbox" name="remember" style="border-radius: 4px; border: 1px solid #d1d5db; margin-right: 8px;">
                        <span style="font-size: 14px; color: #6b7280;">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size: 14px; color: #15803d; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Lupa password?</a>
                    @endif
                </div>

                <div class="mt-6">
                    <button type="submit" style="width: 100%; padding: 12px; background-color: #15803d; color: #ffffff; font-weight: 600; border-radius: 8px; border: none; cursor: pointer; font-size: 16px; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#166534'" onmouseout="this.style.backgroundColor='#15803d'">
                        Masuk
                    </button>
                </div>

                <div class="mt-4 text-center">
                    <span style="color: #6b7280; font-size: 14px;">Belum punya akun?</span>
                    <a href="{{ route('register') }}" style="color: #15803d; font-size: 14px; font-weight: 600; text-decoration: none; margin-left: 4px;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Daftar sekarang</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
