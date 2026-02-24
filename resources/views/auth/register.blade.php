@extends('layouts.landing')

@section('content')
<div style="min-height:100vh; background:#f0fdf4; padding: 40px 16px;">

    {{-- Header --}}
    <div style="text-align:center; margin-bottom:32px;">
        <img src="{{ asset('logo_man.png') }}" style="height:60px; margin:0 auto 12px; display:block;">
        <h1 style="font-size:22px; font-weight:800; color:#14532d;">Formulir Pendaftaran PMBM</h1>
        <p style="color:#6b7280; font-size:14px;">MAN 4 Kota Pekanbaru — Tahun Pelajaran 2026/2027</p>
    </div>

    {{-- Notifikasi Error Global --}}
    @if($errors->any())
    <div id="error-banner" style="max-width:720px; margin:0 auto 20px; background:#fef2f2; border:1px solid #fca5a5; border-left:5px solid #ef4444; border-radius:8px; padding:16px 20px;">
        <div style="display:flex; align-items:flex-start; gap:12px;">
            <span style="font-size:20px;">⚠️</span>
            <div>
                <p style="font-weight:700; color:#991b1b; margin:0 0 8px;">Pendaftaran gagal! Silakan periksa isian berikut:</p>
                <ul style="margin:0; padding-left:20px; color:#b91c1c; font-size:14px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- Progress Bar --}}
    <div style="max-width:720px; margin:0 auto 28px; display:flex; gap:8px;">
        @foreach(['Biodata Siswa','Biodata Ayah','Biodata Ibu','Biodata Wali & Akun'] as $i => $label)
        <div style="flex:1; text-align:center;">
            <div id="step-indicator-{{ $i+1 }}" style="height:6px; border-radius:4px; background:{{ $i==0 ? '#16a34a' : '#d1fae5' }}; transition:background 0.3s;"></div>
            <span style="font-size:11px; color:#6b7280; margin-top:4px; display:block;">{{ $label }}</span>
        </div>
        @endforeach
    </div>

    <form method="POST" action="{{ route('register') }}" id="reg-form">
        @csrf

        <div style="max-width:720px; margin:0 auto;">

            {{-- ============================================================ --}}
            {{-- STEP 1: BIODATA SISWA --}}
            {{-- ============================================================ --}}
            <div id="step-1" class="reg-step">
                <div style="background:#fff; border-top:4px solid #16a34a; border-radius:12px; padding:28px; box-shadow:0 4px 20px rgba(0,0,0,0.07); margin-bottom:20px;">
                    <h2 style="font-size:17px; font-weight:700; color:#14532d; margin-bottom:20px; padding-bottom:10px; border-bottom:2px solid #dcfce7;">
                        📋 BIODATA SISWA
                    </h2>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

                        @php $full = 'grid-column:span 2'; @endphp

                        <div style="{{ $full }}">
                            <x-input-label for="nama_lengkap" :value="__('Nama Siswa *')" />
                            <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap" :value="old('nama_lengkap')" required placeholder="Nama lengkap sesuai ijazah" />
                            <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="nisn" :value="__('NISN *')" />
                            <x-text-input id="nisn" class="block mt-1 w-full" type="text" name="nisn" :value="old('nisn')" required placeholder="10 digit NISN" maxlength="10" pattern="[0-9]{10}" />
                            <x-input-error :messages="$errors->get('nisn')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="nik" :value="__('NIK')" />
                            <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')" placeholder="16 digit NIK" maxlength="16" />
                            <x-input-error :messages="$errors->get('nik')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="no_kk" :value="__('No. KK')" />
                            <x-text-input id="no_kk" class="block mt-1 w-full" type="text" name="no_kk" :value="old('no_kk')" placeholder="16 digit No. KK" maxlength="16" />
                            <x-input-error :messages="$errors->get('no_kk')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                            <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" :value="old('tempat_lahir')" placeholder="Kota tempat lahir" />
                            <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                            <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir')" />
                            <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                            <select id="jenis_kelamin" name="jenis_kelamin" style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px; color:#111827; outline:none;">
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ old('jenis_kelamin')=='L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin')=='P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-1" />
                        </div>

                        <div style="display:flex; gap:10px; align-items:flex-end;">
                            <div style="flex:1;">
                                <x-input-label for="anak_ke" :value="__('Anak Ke')" />
                                <x-text-input id="anak_ke" class="block mt-1 w-full" type="number" name="anak_ke" :value="old('anak_ke')" min="1" placeholder="ke-" />
                            </div>
                            <span style="padding-bottom:10px; color:#6b7280;">Dari</span>
                            <div style="flex:1;">
                                <x-input-label for="dari_bersaudara" :value="__('Bersaudara')" />
                                <x-text-input id="dari_bersaudara" class="block mt-1 w-full" type="number" name="dari_bersaudara" :value="old('dari_bersaudara')" min="1" placeholder="orang" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="status_dalam_keluarga" :value="__('Status dalam Keluarga')" />
                            <select id="status_dalam_keluarga" name="status_dalam_keluarga" style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px; color:#111827;">
                                <option value="">-- Pilih --</option>
                                <option value="Anak Kandung" {{ old('status_dalam_keluarga')=='Anak Kandung' ? 'selected' : '' }}>Anak Kandung</option>
                                <option value="Anak Tiri" {{ old('status_dalam_keluarga')=='Anak Tiri' ? 'selected' : '' }}>Anak Tiri</option>
                                <option value="Anak Angkat" {{ old('status_dalam_keluarga')=='Anak Angkat' ? 'selected' : '' }}>Anak Angkat</option>
                            </select>
                            <x-input-error :messages="$errors->get('status_dalam_keluarga')" class="mt-1" />
                        </div>

                        <div style="{{ $full }}">
                            <x-input-label for="alamat_siswa" :value="__('Alamat')" />
                            <textarea id="alamat_siswa" name="alamat_siswa" rows="2" placeholder="Alamat lengkap" style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px; color:#111827;">{{ old('alamat_siswa') }}</textarea>
                            <x-input-error :messages="$errors->get('alamat_siswa')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="rt_rw_siswa" :value="__('RT/RW')" />
                            <x-text-input id="rt_rw_siswa" class="block mt-1 w-full" type="text" name="rt_rw_siswa" :value="old('rt_rw_siswa')" placeholder="000/000" />
                            <x-input-error :messages="$errors->get('rt_rw_siswa')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="kode_pos_siswa" :value="__('Kode Pos')" />
                            <x-text-input id="kode_pos_siswa" class="block mt-1 w-full" type="text" name="kode_pos_siswa" :value="old('kode_pos_siswa')" placeholder="5 digit" />
                            <x-input-error :messages="$errors->get('kode_pos_siswa')" class="mt-1" />
                        </div>

                        <div style="{{ $full }}">
                            <x-input-label for="kota_siswa" :value="__('Kota/Kabupaten')" />
                            <x-text-input id="kota_siswa" class="block mt-1 w-full" type="text" name="kota_siswa" :value="old('kota_siswa')" placeholder="Kota/Kabupaten" />
                            <x-input-error :messages="$errors->get('kota_siswa')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="bahasa_harian" :value="__('Bahasa Harian')" />
                            <x-text-input id="bahasa_harian" class="block mt-1 w-full" type="text" name="bahasa_harian" :value="old('bahasa_harian')" placeholder="Indonesia / Daerah" />
                            <x-input-error :messages="$errors->get('bahasa_harian')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="status_rumah" :value="__('Status Rumah')" />
                            <select id="status_rumah" name="status_rumah" style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px; color:#111827;">
                                <option value="">-- Pilih --</option>
                                <option value="Milik Sendiri" {{ old('status_rumah')=='Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                <option value="Kontrak/Sewa" {{ old('status_rumah')=='Kontrak/Sewa' ? 'selected' : '' }}>Kontrak/Sewa</option>
                                <option value="Menumpang" {{ old('status_rumah')=='Menumpang' ? 'selected' : '' }}>Menumpang</option>
                                <option value="Dinas" {{ old('status_rumah')=='Dinas' ? 'selected' : '' }}>Dinas</option>
                            </select>
                            <x-input-error :messages="$errors->get('status_rumah')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="jarak_rumah_km" :value="__('Jarak Rumah ke MAN 4 (KM)')" />
                            <x-text-input id="jarak_rumah_km" class="block mt-1 w-full" type="number" step="0.1" name="jarak_rumah_km" :value="old('jarak_rumah_km')" placeholder="contoh: 5.5" />
                            <x-input-error :messages="$errors->get('jarak_rumah_km')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="transportasi" :value="__('Transportasi ke MAN 4')" />
                            <select id="transportasi" name="transportasi" style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px; color:#111827;">
                                <option value="">-- Pilih --</option>
                                <option value="Jalan Kaki">Jalan Kaki</option>
                                <option value="Sepeda">Sepeda</option>
                                <option value="Motor">Motor</option>
                                <option value="Mobil Pribadi">Mobil Pribadi</option>
                                <option value="Angkutan Umum">Angkutan Umum</option>
                                <option value="Ojek/GrabBike">Ojek/GrabBike</option>
                            </select>
                            <x-input-error :messages="$errors->get('transportasi')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="no_hp_siswa" :value="__('No. HP/WA Aktif Siswa *')" />
                            <x-text-input id="no_hp_siswa" class="block mt-1 w-full" type="text" name="no_hp_siswa" :value="old('no_hp_siswa')" required placeholder="08xxxxxxxxxx" />
                            <x-input-error :messages="$errors->get('no_hp_siswa')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="jurusan_pilihan" :value="__('Jurusan Pilihan')" />
                            <select id="jurusan_pilihan" name="jurusan_pilihan" style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px; color:#111827;">
                                <option value="">-- Pilih --</option>
                                <option value="SAINTEK" {{ old('jurusan_pilihan')=='SAINTEK' ? 'selected' : '' }}>SAINTEK</option>
                                <option value="SOSHUM" {{ old('jurusan_pilihan')=='SOSHUM' ? 'selected' : '' }}>SOSHUM</option>
                                <option value="Keagamaan (MAK)" {{ old('jurusan_pilihan')=='Keagamaan (MAK)' ? 'selected' : '' }}>Keagamaan (MAK)</option>
                            </select>
                            <x-input-error :messages="$errors->get('jurusan_pilihan')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="asal_sekolah" :value="__('Asal Sekolah')" />
                            <x-text-input id="asal_sekolah" class="block mt-1 w-full" type="text" name="asal_sekolah" :value="old('asal_sekolah')" placeholder="Nama sekolah asal" />
                            <x-input-error :messages="$errors->get('asal_sekolah')" class="mt-1" />
                        </div>

                        <div style="{{ $full }}">
                            <x-input-label for="alamat_asal_sekolah" :value="__('Alamat Asal Sekolah')" />
                            <textarea id="alamat_asal_sekolah" name="alamat_asal_sekolah" rows="2" placeholder="Alamat lengkap sekolah asal" style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px; color:#111827;">{{ old('alamat_asal_sekolah') }}</textarea>
                        </div>

                        <div>
                            <x-input-label for="npsn" :value="__('NPSN (Bagi SMP)')" />
                            <x-text-input id="npsn" class="block mt-1 w-full" type="text" name="npsn" :value="old('npsn')" placeholder="NPSN Sekolah" />
                        </div>

                        <div>
                            <x-input-label for="nsm" :value="__('NSM (Bagi Madrasah)')" />
                            <x-text-input id="nsm" class="block mt-1 w-full" type="text" name="nsm" :value="old('nsm')" placeholder="NSM Madrasah" />
                        </div>

                        <div>
                            <x-input-label for="hobi" :value="__('Hobi')" />
                            <x-text-input id="hobi" class="block mt-1 w-full" type="text" name="hobi" :value="old('hobi')" placeholder="Hobi / kegemaran" />
                        </div>

                        <div>
                            <x-input-label for="cita_cita" :value="__('Cita-cita')" />
                            <x-text-input id="cita_cita" class="block mt-1 w-full" type="text" name="cita_cita" :value="old('cita_cita')" placeholder="Cita-cita" />
                        </div>

                        <div>
                            <x-input-label for="golongan_darah" :value="__('Golongan Darah')" />
                            <select id="golongan_darah" name="golongan_darah" style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px; color:#111827;">
                                <option value="">-- Pilih --</option>
                                @foreach(['A','B','AB','O','A+','A-','B+','B-','AB+','AB-','O+','O-'] as $gb)
                                <option value="{{ $gb }}" {{ old('golongan_darah')==$gb ? 'selected':'' }}>{{ $gb }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="riwayat_sakit" :value="__('Riwayat Sakit')" />
                            <x-text-input id="riwayat_sakit" class="block mt-1 w-full" type="text" name="riwayat_sakit" :value="old('riwayat_sakit')" placeholder="Jika ada, sebutkan" />
                        </div>

                        <div>
                            <x-input-label for="tinggi_badan" :value="__('Tinggi Badan (cm)')" />
                            <x-text-input id="tinggi_badan" class="block mt-1 w-full" type="text" name="tinggi_badan" :value="old('tinggi_badan')" placeholder="cm" />
                        </div>

                        <div>
                            <x-input-label for="berat_badan" :value="__('Berat Badan (kg)')" />
                            <x-text-input id="berat_badan" class="block mt-1 w-full" type="text" name="berat_badan" :value="old('berat_badan')" placeholder="kg" />
                        </div>

                    </div>
                </div>
                <div style="display:flex; justify-content:flex-end;">
                    <button type="button" onclick="nextStep(1)" style="background:#16a34a; color:#fff; padding:10px 28px; border-radius:8px; border:none; font-weight:600; cursor:pointer; font-size:15px;">Lanjut &rarr;</button>
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- STEP 2: BIODATA AYAH --}}
            {{-- ============================================================ --}}
            <div id="step-2" class="reg-step" style="display:none;">
                <div style="background:#fff; border-top:4px solid #2563eb; border-radius:12px; padding:28px; box-shadow:0 4px 20px rgba(0,0,0,0.07); margin-bottom:20px;">
                    <h2 style="font-size:17px; font-weight:700; color:#1e3a8a; margin-bottom:20px; padding-bottom:10px; border-bottom:2px solid #dbeafe;">
                        👨 BIODATA AYAH
                    </h2>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        @include('auth.partials.ortu-fields', ['prefix' => 'ayah', 'label' => 'Ayah'])
                    </div>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <button type="button" onclick="prevStep(2)" style="background:#6b7280; color:#fff; padding:10px 28px; border-radius:8px; border:none; font-weight:600; cursor:pointer;">&larr; Kembali</button>
                    <button type="button" onclick="nextStep(2)" style="background:#16a34a; color:#fff; padding:10px 28px; border-radius:8px; border:none; font-weight:600; cursor:pointer; font-size:15px;">Lanjut &rarr;</button>
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- STEP 3: BIODATA IBU --}}
            {{-- ============================================================ --}}
            <div id="step-3" class="reg-step" style="display:none;">
                <div style="background:#fff; border-top:4px solid #db2777; border-radius:12px; padding:28px; box-shadow:0 4px 20px rgba(0,0,0,0.07); margin-bottom:20px;">
                    <h2 style="font-size:17px; font-weight:700; color:#831843; margin-bottom:20px; padding-bottom:10px; border-bottom:2px solid #fce7f3;">
                        👩 BIODATA IBU
                    </h2>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        @include('auth.partials.ortu-fields', ['prefix' => 'ibu', 'label' => 'Ibu'])
                    </div>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <button type="button" onclick="prevStep(3)" style="background:#6b7280; color:#fff; padding:10px 28px; border-radius:8px; border:none; font-weight:600; cursor:pointer;">&larr; Kembali</button>
                    <button type="button" onclick="nextStep(3)" style="background:#16a34a; color:#fff; padding:10px 28px; border-radius:8px; border:none; font-weight:600; cursor:pointer; font-size:15px;">Lanjut &rarr;</button>
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- STEP 4: BIODATA WALI + AKUN --}}
            {{-- ============================================================ --}}
            <div id="step-4" class="reg-step" style="display:none;">
                {{-- Wali --}}
                <div style="background:#fff; border-top:4px solid #d97706; border-radius:12px; padding:28px; box-shadow:0 4px 20px rgba(0,0,0,0.07); margin-bottom:20px;">
                    <h2 style="font-size:17px; font-weight:700; color:#78350f; margin-bottom:20px; padding-bottom:10px; border-bottom:2px solid #fef3c7;">
                        🧑 BIODATA WALI
                    </h2>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        @include('auth.partials.ortu-fields', ['prefix' => 'wali', 'label' => 'Wali'])
                    </div>
                </div>

                {{-- Akun --}}
                <div style="background:#fff; border-top:4px solid #16a34a; border-radius:12px; padding:28px; box-shadow:0 4px 20px rgba(0,0,0,0.07); margin-bottom:20px;">
                    <h2 style="font-size:17px; font-weight:700; color:#14532d; margin-bottom:20px; padding-bottom:10px; border-bottom:2px solid #dcfce7;">
                        🔐 DATA AKUN
                    </h2>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        <div style="grid-column:span 2;">
                            <x-input-label for="email" :value="__('Email *')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required placeholder="contoh@email.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="password" :value="__('Password *')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password *')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>
                    </div>
                </div>

                <div style="display:flex; justify-content:space-between;">
                    <button type="button" onclick="prevStep(4)" style="background:#6b7280; color:#fff; padding:10px 28px; border-radius:8px; border:none; font-weight:600; cursor:pointer;">&larr; Kembali</button>
                    <button type="submit" style="background:#16a34a; color:#fff; padding:12px 36px; border-radius:8px; border:none; font-weight:700; cursor:pointer; font-size:16px;">
                        ✅ Daftar Sekarang
                    </button>
                </div>
            </div>

            <div style="text-align:center; margin-top:20px;">
                <span style="color:#6b7280; font-size:14px;">Sudah punya akun?</span>
                <a href="{{ route('login') }}" style="color:#16a34a; font-size:14px; font-weight:600; text-decoration:none; margin-left:4px;">Masuk di sini</a>
            </div>

        </div>
    </form>
</div>

<style>
    input, select, textarea { font-family: inherit; }
    input:focus, select:focus, textarea:focus { outline: 2px solid #16a34a; border-color: #16a34a; }
</style>

<script>
    const totalSteps = 4;
    const stepColors = ['#16a34a','#2563eb','#db2777','#d97706'];

    function nextStep(current) {
        document.getElementById('step-' + current).style.display = 'none';
        document.getElementById('step-' + (current + 1)).style.display = 'block';
        updateProgress(current + 1);
        window.scrollTo({top: 0, behavior: 'smooth'});
    }
    function prevStep(current) {
        document.getElementById('step-' + current).style.display = 'none';
        document.getElementById('step-' + (current - 1)).style.display = 'block';
        updateProgress(current - 1);
        window.scrollTo({top: 0, behavior: 'smooth'});
    }
    function updateProgress(active) {
        for (let i = 1; i <= totalSteps; i++) {
            const el = document.getElementById('step-indicator-' + i);
            if (el) el.style.background = i <= active ? stepColors[i-1] : '#d1fae5';
        }
    }

    @if($errors->any())
        // Field map per step
        const errorKeys = {!! json_encode($errors->keys()) !!};
        const step2Fields = {{ Js::from(array_filter($errors->keys(), fn($k) => str_ends_with($k, '_ayah'))) }};
        const step3Fields = {{ Js::from(array_filter($errors->keys(), fn($k) => str_ends_with($k, '_ibu'))) }};
        const step4Fields = ['email','password','password_confirmation'];

        let targetStep = 1;
        if (errorKeys.some(e => step4Fields.includes(e))) targetStep = 4;
        else if (errorKeys.some(e => e.endsWith('_ibu'))) targetStep = 3;
        else if (errorKeys.some(e => e.endsWith('_ayah'))) targetStep = 2;
        else if (errorKeys.some(e => e.endsWith('_wali'))) targetStep = 4;

        // Tampilkan step yang tepat
        for (let i = 1; i <= totalSteps; i++) {
            document.getElementById('step-' + i).style.display = i === targetStep ? 'block' : 'none';
        }
        updateProgress(targetStep);

        // Highlight label step yang error di progress bar (warna merah)
        const errIndicator = document.getElementById('step-indicator-' + targetStep);
        if (errIndicator) errIndicator.style.background = '#ef4444';

        // Scroll ke error banner
        window.setTimeout(() => {
            const banner = document.getElementById('error-banner');
            if (banner) banner.scrollIntoView({behavior: 'smooth', block: 'start'});
        }, 100);
    @endif
</script>
@endsection
