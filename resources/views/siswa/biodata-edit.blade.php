<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Biodata</h2>
            <a href="{{ route('siswa.dashboard') }}" style="font-size:14px; color:#16a34a; text-decoration:none;">← Kembali ke Dashboard</a>
        </div>
    </x-slot>

    <div class="py-8" style="background:#f0fdf4; min-height:100vh;">
        <div style="max-width:760px; margin:0 auto; padding:0 16px;">

            {{-- Notifikasi Sukses --}}
            @if(session('success'))
            <div style="background:#dcfce7; border:1px solid #86efac; border-left:5px solid #16a34a; border-radius:8px; padding:14px 20px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
                <span style="font-size:20px;">✅</span>
                <span style="color:#166534; font-weight:600;">{{ session('success') }}</span>
            </div>
            @endif

            {{-- Notifikasi Error --}}
            @if($errors->any())
            <div id="error-banner" style="background:#fef2f2; border:1px solid #fca5a5; border-left:5px solid #ef4444; border-radius:8px; padding:16px 20px; margin-bottom:20px;">
                <div style="display:flex; align-items:flex-start; gap:12px;">
                    <span style="font-size:20px;">⚠️</span>
                    <div>
                        <p style="font-weight:700; color:#991b1b; margin:0 0 8px;">Terdapat kesalahan, silakan periksa:</p>
                        <ul style="margin:0; padding-left:20px; color:#b91c1c; font-size:14px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            {{-- Info NISN (readonly) --}}
            <div style="background:#fff; border-radius:10px; padding:12px 20px; margin-bottom:20px; border:1px solid #d1fae5; display:flex; align-items:center; justify-content:space-between;">
                <span style="color:#6b7280; font-size:14px;">NISN (tidak dapat diubah)</span>
                <span style="font-weight:700; color:#14532d; font-size:16px;">{{ $calonSiswa->nisn }}</span>
            </div>

            <form method="POST" action="{{ route('siswa.biodata.update') }}" id="biodata-form">
                @csrf
                @method('PUT')

                {{-- Progress Tab --}}
                <div style="display:flex; gap:8px; margin-bottom:24px;">
                    @foreach(['Biodata Siswa','Biodata Ayah','Biodata Ibu','Biodata Wali'] as $i => $label)
                    <div style="flex:1; text-align:center;">
                        <div id="tab-{{ $i+1 }}" style="height:6px; border-radius:4px; background:{{ $i==0 ? '#16a34a' : '#d1fae5' }}; transition:background 0.3s;"></div>
                        <span style="font-size:11px; color:#6b7280; margin-top:4px; display:block;">{{ $label }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- ============================= STEP 1: BIODATA SISWA ============================= --}}
                <div id="step-1" class="bio-step">
                    <div style="background:#fff; border-top:4px solid #16a34a; border-radius:12px; padding:28px; box-shadow:0 4px 20px rgba(0,0,0,0.07); margin-bottom:16px;">
                        <h2 style="font-size:17px; font-weight:700; color:#14532d; margin-bottom:20px; padding-bottom:10px; border-bottom:2px solid #dcfce7;">📋 BIODATA SISWA</h2>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            @php $full = 'grid-column:span 2'; @endphp

                            <div style="{{ $full }}">
                                <x-input-label for="nama_lengkap" :value="__('Nama Siswa *')" />
                                <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap" :value="old('nama_lengkap', $calonSiswa->nama_lengkap)" required />
                                <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-1" />
                            </div>
                            <div>
                                <x-input-label for="nik" :value="__('NIK')" />
                                <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik', $calonSiswa->nik)" maxlength="16" placeholder="16 digit NIK" />
                            </div>
                            <div>
                                <x-input-label for="no_kk" :value="__('No. KK')" />
                                <x-text-input id="no_kk" class="block mt-1 w-full" type="text" name="no_kk" :value="old('no_kk', $calonSiswa->no_kk)" maxlength="16" placeholder="16 digit No. KK" />
                            </div>
                            <div>
                                <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                                <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" :value="old('tempat_lahir', $calonSiswa->tempat_lahir)" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $calonSiswa->tanggal_lahir)" />
                            </div>
                            <div>
                                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                <select id="jenis_kelamin" name="jenis_kelamin" style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px;">
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ old('jenis_kelamin', $calonSiswa->jenis_kelamin)=='L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $calonSiswa->jenis_kelamin)=='P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div style="display:flex; gap:10px; align-items:flex-end;">
                                <div style="flex:1;">
                                    <x-input-label for="anak_ke" :value="__('Anak Ke')" />
                                    <x-text-input id="anak_ke" class="block mt-1 w-full" type="number" name="anak_ke" :value="old('anak_ke', $calonSiswa->anak_ke)" min="1" />
                                </div>
                                <span style="padding-bottom:10px; color:#6b7280;">Dari</span>
                                <div style="flex:1;">
                                    <x-input-label for="dari_bersaudara" :value="__('Bersaudara')" />
                                    <x-text-input id="dari_bersaudara" class="block mt-1 w-full" type="number" name="dari_bersaudara" :value="old('dari_bersaudara', $calonSiswa->dari_bersaudara)" min="1" />
                                </div>
                            </div>
                            <div>
                                <x-input-label for="status_dalam_keluarga" :value="__('Status dalam Keluarga')" />
                                <select id="status_dalam_keluarga" name="status_dalam_keluarga" style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px;">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['Anak Kandung','Anak Tiri','Anak Angkat'] as $s)
                                    <option value="{{ $s }}" {{ old('status_dalam_keluarga', $calonSiswa->status_dalam_keluarga)==$s ? 'selected':'' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="{{ $full }}">
                                <x-input-label for="alamat_siswa" :value="__('Alamat')" />
                                <textarea id="alamat_siswa" name="alamat_siswa" rows="2" style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px;">{{ old('alamat_siswa', $calonSiswa->alamat_siswa) }}</textarea>
                            </div>
                            <div>
                                <x-input-label for="rt_rw_siswa" :value="__('RT/RW')" />
                                <x-text-input id="rt_rw_siswa" class="block mt-1 w-full" type="text" name="rt_rw_siswa" :value="old('rt_rw_siswa', $calonSiswa->rt_rw_siswa)" placeholder="000/000" />
                            </div>
                            <div>
                                <x-input-label for="kode_pos_siswa" :value="__('Kode Pos')" />
                                <x-text-input id="kode_pos_siswa" class="block mt-1 w-full" type="text" name="kode_pos_siswa" :value="old('kode_pos_siswa', $calonSiswa->kode_pos_siswa)" />
                            </div>
                            <div style="{{ $full }}">
                                <x-input-label for="kota_siswa" :value="__('Kota/Kabupaten')" />
                                <x-text-input id="kota_siswa" class="block mt-1 w-full" type="text" name="kota_siswa" :value="old('kota_siswa', $calonSiswa->kota_siswa)" />
                            </div>
                            <div>
                                <x-input-label for="bahasa_harian" :value="__('Bahasa Harian')" />
                                <x-text-input id="bahasa_harian" class="block mt-1 w-full" type="text" name="bahasa_harian" :value="old('bahasa_harian', $calonSiswa->bahasa_harian)" />
                            </div>
                            <div>
                                <x-input-label for="status_rumah" :value="__('Status Rumah')" />
                                <select id="status_rumah" name="status_rumah" style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px;">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['Milik Sendiri','Kontrak/Sewa','Menumpang','Dinas'] as $s)
                                    <option value="{{ $s }}" {{ old('status_rumah', $calonSiswa->status_rumah)==$s ? 'selected':'' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="jarak_rumah_km" :value="__('Jarak ke MAN 4 (KM)')" />
                                <x-text-input id="jarak_rumah_km" class="block mt-1 w-full" type="number" step="0.1" name="jarak_rumah_km" :value="old('jarak_rumah_km', $calonSiswa->jarak_rumah_km)" />
                            </div>
                            <div>
                                <x-input-label for="transportasi" :value="__('Transportasi')" />
                                <select id="transportasi" name="transportasi" style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px;">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['Jalan Kaki','Sepeda','Motor','Mobil Pribadi','Angkutan Umum','Ojek/GrabBike'] as $t)
                                    <option value="{{ $t }}" {{ old('transportasi', $calonSiswa->transportasi)==$t ? 'selected':'' }}>{{ $t }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="no_hp_siswa" :value="__('No. HP/WA Aktif *')" />
                                <x-text-input id="no_hp_siswa" class="block mt-1 w-full" type="text" name="no_hp_siswa" :value="old('no_hp_siswa', $calonSiswa->no_hp_siswa)" required />
                                <x-input-error :messages="$errors->get('no_hp_siswa')" class="mt-1" />
                            </div>
                            <div>
                                <x-input-label for="jurusan_pilihan" :value="__('Jurusan Pilihan')" />
                                <select id="jurusan_pilihan" name="jurusan_pilihan" style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px;">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['SAINTEK','SOSHUM','Keagamaan (MAK)'] as $j)
                                    <option value="{{ $j }}" {{ old('jurusan_pilihan', $calonSiswa->jurusan_pilihan)==$j ? 'selected':'' }}>{{ $j }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="asal_sekolah" :value="__('Asal Sekolah')" />
                                <x-text-input id="asal_sekolah" class="block mt-1 w-full" type="text" name="asal_sekolah" :value="old('asal_sekolah', $calonSiswa->asal_sekolah)" />
                            </div>
                            <div style="{{ $full }}">
                                <x-input-label for="alamat_asal_sekolah" :value="__('Alamat Asal Sekolah')" />
                                <textarea id="alamat_asal_sekolah" name="alamat_asal_sekolah" rows="2" style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px;">{{ old('alamat_asal_sekolah', $calonSiswa->alamat_asal_sekolah) }}</textarea>
                            </div>
                            <div>
                                <x-input-label for="npsn" :value="__('NPSN (Bagi SMP)')" />
                                <x-text-input id="npsn" class="block mt-1 w-full" type="text" name="npsn" :value="old('npsn', $calonSiswa->npsn)" />
                            </div>
                            <div>
                                <x-input-label for="nsm" :value="__('NSM (Bagi Madrasah)')" />
                                <x-text-input id="nsm" class="block mt-1 w-full" type="text" name="nsm" :value="old('nsm', $calonSiswa->nsm)" />
                            </div>
                            <div>
                                <x-input-label for="hobi" :value="__('Hobi')" />
                                <x-text-input id="hobi" class="block mt-1 w-full" type="text" name="hobi" :value="old('hobi', $calonSiswa->hobi)" />
                            </div>
                            <div>
                                <x-input-label for="cita_cita" :value="__('Cita-cita')" />
                                <x-text-input id="cita_cita" class="block mt-1 w-full" type="text" name="cita_cita" :value="old('cita_cita', $calonSiswa->cita_cita)" />
                            </div>
                            <div>
                                <x-input-label for="golongan_darah" :value="__('Golongan Darah')" />
                                <select id="golongan_darah" name="golongan_darah" style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px;">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['A','B','AB','O','A+','A-','B+','B-','AB+','AB-','O+','O-'] as $gb)
                                    <option value="{{ $gb }}" {{ old('golongan_darah', $calonSiswa->golongan_darah)==$gb ? 'selected':'' }}>{{ $gb }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="riwayat_sakit" :value="__('Riwayat Sakit')" />
                                <x-text-input id="riwayat_sakit" class="block mt-1 w-full" type="text" name="riwayat_sakit" :value="old('riwayat_sakit', $calonSiswa->riwayat_sakit)" placeholder="Jika ada" />
                            </div>
                            <div>
                                <x-input-label for="tinggi_badan" :value="__('Tinggi Badan (cm)')" />
                                <x-text-input id="tinggi_badan" class="block mt-1 w-full" type="text" name="tinggi_badan" :value="old('tinggi_badan', $calonSiswa->tinggi_badan)" />
                            </div>
                            <div>
                                <x-input-label for="berat_badan" :value="__('Berat Badan (kg)')" />
                                <x-text-input id="berat_badan" class="block mt-1 w-full" type="text" name="berat_badan" :value="old('berat_badan', $calonSiswa->berat_badan)" />
                            </div>
                        </div>
                    </div>
                    <div style="display:flex; justify-content:flex-end; margin-bottom:20px;">
                        <button type="button" onclick="nextStep(1)" style="background:#16a34a; color:#fff; padding:10px 28px; border-radius:8px; border:none; font-weight:600; cursor:pointer;">Lanjut →</button>
                    </div>
                </div>

                {{-- ============================= STEP 2: BIODATA AYAH ============================= --}}
                <div id="step-2" class="bio-step" style="display:none;">
                    <div style="background:#fff; border-top:4px solid #2563eb; border-radius:12px; padding:28px; box-shadow:0 4px 20px rgba(0,0,0,0.07); margin-bottom:16px;">
                        <h2 style="font-size:17px; font-weight:700; color:#1e3a8a; margin-bottom:20px; padding-bottom:10px; border-bottom:2px solid #dbeafe;">👨 BIODATA AYAH</h2>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            @include('auth.partials.ortu-edit-fields', ['prefix' => 'ayah', 'label' => 'Ayah', 'data' => $calonSiswa])
                        </div>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
                        <button type="button" onclick="prevStep(2)" style="background:#6b7280; color:#fff; padding:10px 28px; border-radius:8px; border:none; font-weight:600; cursor:pointer;">← Kembali</button>
                        <button type="button" onclick="nextStep(2)" style="background:#16a34a; color:#fff; padding:10px 28px; border-radius:8px; border:none; font-weight:600; cursor:pointer;">Lanjut →</button>
                    </div>
                </div>

                {{-- ============================= STEP 3: BIODATA IBU ============================= --}}
                <div id="step-3" class="bio-step" style="display:none;">
                    <div style="background:#fff; border-top:4px solid #db2777; border-radius:12px; padding:28px; box-shadow:0 4px 20px rgba(0,0,0,0.07); margin-bottom:16px;">
                        <h2 style="font-size:17px; font-weight:700; color:#831843; margin-bottom:20px; padding-bottom:10px; border-bottom:2px solid #fce7f3;">👩 BIODATA IBU</h2>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            @include('auth.partials.ortu-edit-fields', ['prefix' => 'ibu', 'label' => 'Ibu', 'data' => $calonSiswa])
                        </div>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
                        <button type="button" onclick="prevStep(3)" style="background:#6b7280; color:#fff; padding:10px 28px; border-radius:8px; border:none; font-weight:600; cursor:pointer;">← Kembali</button>
                        <button type="button" onclick="nextStep(3)" style="background:#16a34a; color:#fff; padding:10px 28px; border-radius:8px; border:none; font-weight:600; cursor:pointer;">Lanjut →</button>
                    </div>
                </div>

                {{-- ============================= STEP 4: BIODATA WALI ============================= --}}
                <div id="step-4" class="bio-step" style="display:none;">
                    <div style="background:#fff; border-top:4px solid #d97706; border-radius:12px; padding:28px; box-shadow:0 4px 20px rgba(0,0,0,0.07); margin-bottom:16px;">
                        <h2 style="font-size:17px; font-weight:700; color:#78350f; margin-bottom:20px; padding-bottom:10px; border-bottom:2px solid #fef3c7;">🧑 BIODATA WALI</h2>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            @include('auth.partials.ortu-edit-fields', ['prefix' => 'wali', 'label' => 'Wali', 'data' => $calonSiswa])
                        </div>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
                        <button type="button" onclick="prevStep(4)" style="background:#6b7280; color:#fff; padding:10px 28px; border-radius:8px; border:none; font-weight:600; cursor:pointer;">← Kembali</button>
                        <button type="submit" style="background:#16a34a; color:#fff; padding:12px 36px; border-radius:8px; border:none; font-weight:700; cursor:pointer; font-size:16px;">
                            💾 Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <style>
        input, select, textarea { font-family: inherit; }
        input:focus, select:focus, textarea:focus { outline: 2px solid #16a34a; border-color: #16a34a; }
    </style>

    <script>
        const totalSteps = 4;
        const tabColors = ['#16a34a','#2563eb','#db2777','#d97706'];

        function nextStep(cur) {
            document.getElementById('step-' + cur).style.display = 'none';
            document.getElementById('step-' + (cur + 1)).style.display = 'block';
            updateTabs(cur + 1);
            window.scrollTo({top: 0, behavior: 'smooth'});
        }
        function prevStep(cur) {
            document.getElementById('step-' + cur).style.display = 'none';
            document.getElementById('step-' + (cur - 1)).style.display = 'block';
            updateTabs(cur - 1);
            window.scrollTo({top: 0, behavior: 'smooth'});
        }
        function updateTabs(active) {
            for (let i = 1; i <= totalSteps; i++) {
                const el = document.getElementById('tab-' + i);
                if (el) el.style.background = i <= active ? tabColors[i-1] : '#d1fae5';
            }
        }

        @if($errors->any())
            const errorKeys = {!! json_encode($errors->keys()) !!};
            let targetStep = 1;
            if (errorKeys.some(e => ['email','password','nama_wali','nik_wali','no_hp_wali'].includes(e) || e.endsWith('_wali'))) targetStep = 4;
            else if (errorKeys.some(e => e.endsWith('_ibu'))) targetStep = 3;
            else if (errorKeys.some(e => e.endsWith('_ayah'))) targetStep = 2;
            for (let i = 1; i <= totalSteps; i++) {
                document.getElementById('step-' + i).style.display = i === targetStep ? 'block' : 'none';
            }
            updateTabs(targetStep);
            document.getElementById('tab-' + targetStep).style.background = '#ef4444';
        @endif
    </script>
</x-app-layout>
