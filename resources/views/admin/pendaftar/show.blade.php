<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Detail Pendaftar</h2>
            <a href="{{ route('admin.pendaftar.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">{{ session('success') }}</div>
            @endif

            <!-- Student Info -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nama Lengkap</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $pendaftar->nama_lengkap }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">NISN</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $pendaftar->nisn }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $pendaftar->user->email ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No. HP Siswa</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $pendaftar->no_hp_siswa }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No. HP Orang Tua</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $pendaftar->no_hp_ortu }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                            @php
                                $statusColors = [
                                    'terdaftar' => 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200',
                                    'menunggu_verifikasi' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                    'lulus_administrasi' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                    'tidak_lulus_administrasi' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    'lulus_tes' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
                                    'tidak_lulus_tes' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    'lulus_pnbm' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                    'daftar_ulang' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                    'resmi_terdaftar' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$pendaftar->status] ?? '' }}">
                                {{ ucfirst(str_replace('_', ' ', $pendaftar->status)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Daftar</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $pendaftar->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        @if($pendaftar->catatan_panitia)
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Catatan Panitia</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $pendaftar->catatan_panitia }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>


            {{-- Tombol buka modal --}}
            <div class="mb-6">
                <button onclick="document.getElementById('modal-biodata').classList.remove('hidden')"
                    style="display:inline-flex; align-items:center; gap:8px; padding:10px 20px; background:#16a34a; color:#fff; border:none; border-radius:8px; font-weight:600; cursor:pointer; font-size:14px;">
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Lihat Biodata Lengkap
                </button>
            </div>

            {{-- ===================== MODAL BIODATA ===================== --}}
            <div id="modal-biodata" class="hidden fixed inset-0 z-50 flex items-start justify-center pt-10 px-4"
                 style="background:rgba(0,0,0,0.55);" onclick="if(event.target===this)this.classList.add('hidden')">
                <div style="background:#fff; border-radius:14px; width:100%; max-width:780px; max-height:85vh; display:flex; flex-direction:column; box-shadow: 0 25px 60px rgba(0,0,0,0.25);">

                    {{-- Modal Header --}}
                    <div style="padding:18px 24px; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
                        <div>
                            <h3 style="font-size:16px; font-weight:700; color:#111827; margin:0;">📋 Biodata Lengkap</h3>
                            <p style="font-size:13px; color:#6b7280; margin:2px 0 0;">{{ $pendaftar->nama_lengkap }} — NISN {{ $pendaftar->nisn }}</p>
                        </div>
                        <button onclick="document.getElementById('modal-biodata').classList.add('hidden')"
                            style="background:#f3f4f6; border:none; border-radius:50%; width:32px; height:32px; font-size:18px; cursor:pointer; color:#374151; display:flex; align-items:center; justify-content:center;">&times;</button>
                    </div>

                    {{-- Tab Navigasi --}}
                    <div style="display:flex; gap:0; border-bottom:1px solid #e5e7eb; flex-shrink:0;">
                        @foreach([
                            ['id'=>'tab-siswa','label'=>'📋 Siswa','color'=>'#16a34a'],
                            ['id'=>'tab-ayah','label'=>'👨 Ayah','color'=>'#2563eb'],
                            ['id'=>'tab-ibu','label'=>'👩 Ibu','color'=>'#db2777'],
                            ['id'=>'tab-wali','label'=>'🧑 Wali','color'=>'#d97706'],
                        ] as $i => $tab)
                        <button id="btn-{{ $tab['id'] }}"
                            onclick="switchTab('{{ $tab['id'] }}')"
                            style="padding:12px 20px; border:none; background:{{ $i===0 ? '#f9fafb' : 'transparent' }}; border-bottom:3px solid {{ $i===0 ? $tab['color'] : 'transparent' }}; font-size:13px; font-weight:{{ $i===0 ? '700' : '500' }}; color:{{ $i===0 ? $tab['color'] : '#6b7280' }}; cursor:pointer; transition:all 0.2s; white-space:nowrap;"
                            data-color="{{ $tab['color'] }}">
                            {{ $tab['label'] }}
                        </button>
                        @endforeach
                    </div>

                    {{-- Tab Content (scrollable) --}}
                    <div style="overflow-y:auto; flex:1; padding:20px 24px;">

                        {{-- === TAB SISWA === --}}
                        <div id="tab-siswa" class="bio-tab">
                            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px;">
                                @php
                                    $fields_siswa = [
                                        ['NIK', $pendaftar->nik],
                                        ['No. KK', $pendaftar->no_kk],
                                        ['Jenis Kelamin', $pendaftar->jenis_kelamin == 'L' ? 'Laki-laki' : ($pendaftar->jenis_kelamin == 'P' ? 'Perempuan' : null)],
                                        ['Tempat Lahir', $pendaftar->tempat_lahir],
                                        ['Tanggal Lahir', $pendaftar->tanggal_lahir ? \Carbon\Carbon::parse($pendaftar->tanggal_lahir)->format('d M Y') : null],
                                        ['Anak Ke / Dari', $pendaftar->anak_ke ? $pendaftar->anak_ke.' / '.$pendaftar->dari_bersaudara.' bersaudara' : null],
                                        ['Status Keluarga', $pendaftar->status_dalam_keluarga],
                                        ['Bahasa Harian', $pendaftar->bahasa_harian],
                                        ['Status Rumah', $pendaftar->status_rumah],
                                        ['Jarak ke MAN 4', $pendaftar->jarak_rumah_km ? $pendaftar->jarak_rumah_km.' KM' : null],
                                        ['Transportasi', $pendaftar->transportasi],
                                        ['No. HP/WA', $pendaftar->no_hp_siswa],
                                        ['Jurusan Pilihan', $pendaftar->jurusan_pilihan],
                                        ['Asal Sekolah', $pendaftar->asal_sekolah],
                                        ['NPSN', $pendaftar->npsn],
                                        ['NSM', $pendaftar->nsm],
                                        ['Hobi', $pendaftar->hobi],
                                        ['Cita-cita', $pendaftar->cita_cita],
                                        ['Golongan Darah', $pendaftar->golongan_darah],
                                        ['Riwayat Sakit', $pendaftar->riwayat_sakit],
                                        ['Tinggi Badan', $pendaftar->tinggi_badan ? $pendaftar->tinggi_badan.' cm' : null],
                                        ['Berat Badan', $pendaftar->berat_badan ? $pendaftar->berat_badan.' kg' : null],
                                    ];
                                @endphp
                                @foreach($fields_siswa as $f)
                                <div style="background:#f9fafb; border-radius:8px; padding:10px 12px;">
                                    <p style="font-size:11px; color:#9ca3af; margin:0 0 3px;">{{ $f[0] }}</p>
                                    <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">{{ $f[1] ?: '-' }}</p>
                                </div>
                                @endforeach
                                {{-- Alamat full width --}}
                                <div style="grid-column:span 3; background:#f0fdf4; border-radius:8px; padding:10px 12px; border-left:3px solid #16a34a;">
                                    <p style="font-size:11px; color:#9ca3af; margin:0 0 3px;">Alamat Lengkap</p>
                                    <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">
                                        {{ $pendaftar->alamat_siswa ?: '-' }}
                                        {{ $pendaftar->rt_rw_siswa ? ' RT/RW '.$pendaftar->rt_rw_siswa : '' }}
                                        {{ $pendaftar->kode_pos_siswa ? ', '.$pendaftar->kode_pos_siswa : '' }}
                                        {{ $pendaftar->kota_siswa ? ' - '.$pendaftar->kota_siswa : '' }}
                                    </p>
                                </div>
                                <div style="grid-column:span 3; background:#f0fdf4; border-radius:8px; padding:10px 12px; border-left:3px solid #16a34a;">
                                    <p style="font-size:11px; color:#9ca3af; margin:0 0 3px;">Alamat Asal Sekolah</p>
                                    <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">{{ $pendaftar->alamat_asal_sekolah ?: '-' }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- === TAB AYAH === --}}
                        <div id="tab-ayah" class="bio-tab" style="display:none;">
                            @php
                                $fields_ayah = [
                                    ['Nama Ayah', $pendaftar->nama_ayah],
                                    ['NIK', $pendaftar->nik_ayah],
                                    ['Tempat Lahir', $pendaftar->tempat_lahir_ayah],
                                    ['Tanggal Lahir', $pendaftar->tanggal_lahir_ayah ? \Carbon\Carbon::parse($pendaftar->tanggal_lahir_ayah)->format('d M Y') : null],
                                    ['Pendidikan Terakhir', $pendaftar->pendidikan_ayah],
                                    ['Pekerjaan', $pendaftar->pekerjaan_ayah],
                                    ['Penghasilan/Bulan', $pendaftar->penghasilan_ayah],
                                    ['No. HP/WA', $pendaftar->no_hp_ayah],
                                ];
                            @endphp
                            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px;">
                                @foreach($fields_ayah as $f)
                                <div style="background:#f9fafb; border-radius:8px; padding:10px 12px;">
                                    <p style="font-size:11px; color:#9ca3af; margin:0 0 3px;">{{ $f[0] }}</p>
                                    <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">{{ $f[1] ?: '-' }}</p>
                                </div>
                                @endforeach
                                <div style="grid-column:span 3; background:#eff6ff; border-radius:8px; padding:10px 12px; border-left:3px solid #2563eb;">
                                    <p style="font-size:11px; color:#9ca3af; margin:0 0 3px;">Alamat Lengkap</p>
                                    <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">
                                        {{ $pendaftar->alamat_ayah ?: '-' }}
                                        {{ $pendaftar->rt_rw_ayah ? ' RT/RW '.$pendaftar->rt_rw_ayah : '' }}
                                        {{ $pendaftar->kode_pos_ayah ? ', '.$pendaftar->kode_pos_ayah : '' }}
                                        {{ $pendaftar->kota_ayah ? ' - '.$pendaftar->kota_ayah : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- === TAB IBU === --}}
                        <div id="tab-ibu" class="bio-tab" style="display:none;">
                            @php
                                $fields_ibu = [
                                    ['Nama Ibu', $pendaftar->nama_ibu],
                                    ['NIK', $pendaftar->nik_ibu],
                                    ['Tempat Lahir', $pendaftar->tempat_lahir_ibu],
                                    ['Tanggal Lahir', $pendaftar->tanggal_lahir_ibu ? \Carbon\Carbon::parse($pendaftar->tanggal_lahir_ibu)->format('d M Y') : null],
                                    ['Pendidikan Terakhir', $pendaftar->pendidikan_ibu],
                                    ['Pekerjaan', $pendaftar->pekerjaan_ibu],
                                    ['Penghasilan/Bulan', $pendaftar->penghasilan_ibu],
                                    ['No. HP/WA', $pendaftar->no_hp_ibu],
                                ];
                            @endphp
                            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px;">
                                @foreach($fields_ibu as $f)
                                <div style="background:#f9fafb; border-radius:8px; padding:10px 12px;">
                                    <p style="font-size:11px; color:#9ca3af; margin:0 0 3px;">{{ $f[0] }}</p>
                                    <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">{{ $f[1] ?: '-' }}</p>
                                </div>
                                @endforeach
                                <div style="grid-column:span 3; background:#fdf2f8; border-radius:8px; padding:10px 12px; border-left:3px solid #db2777;">
                                    <p style="font-size:11px; color:#9ca3af; margin:0 0 3px;">Alamat Lengkap</p>
                                    <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">
                                        {{ $pendaftar->alamat_ibu ?: '-' }}
                                        {{ $pendaftar->rt_rw_ibu ? ' RT/RW '.$pendaftar->rt_rw_ibu : '' }}
                                        {{ $pendaftar->kode_pos_ibu ? ', '.$pendaftar->kode_pos_ibu : '' }}
                                        {{ $pendaftar->kota_ibu ? ' - '.$pendaftar->kota_ibu : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- === TAB WALI === --}}
                        <div id="tab-wali" class="bio-tab" style="display:none;">
                            @if($pendaftar->nama_wali)
                            @php
                                $fields_wali = [
                                    ['Nama Wali', $pendaftar->nama_wali],
                                    ['NIK', $pendaftar->nik_wali],
                                    ['Tempat Lahir', $pendaftar->tempat_lahir_wali],
                                    ['Tanggal Lahir', $pendaftar->tanggal_lahir_wali ? \Carbon\Carbon::parse($pendaftar->tanggal_lahir_wali)->format('d M Y') : null],
                                    ['Pendidikan Terakhir', $pendaftar->pendidikan_wali],
                                    ['Pekerjaan', $pendaftar->pekerjaan_wali],
                                    ['Penghasilan/Bulan', $pendaftar->penghasilan_wali],
                                    ['No. HP/WA', $pendaftar->no_hp_wali],
                                ];
                            @endphp
                            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px;">
                                @foreach($fields_wali as $f)
                                <div style="background:#f9fafb; border-radius:8px; padding:10px 12px;">
                                    <p style="font-size:11px; color:#9ca3af; margin:0 0 3px;">{{ $f[0] }}</p>
                                    <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">{{ $f[1] ?: '-' }}</p>
                                </div>
                                @endforeach
                                <div style="grid-column:span 3; background:#fffbeb; border-radius:8px; padding:10px 12px; border-left:3px solid #d97706;">
                                    <p style="font-size:11px; color:#9ca3af; margin:0 0 3px;">Alamat Lengkap</p>
                                    <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">
                                        {{ $pendaftar->alamat_wali ?: '-' }}
                                        {{ $pendaftar->rt_rw_wali ? ' RT/RW '.$pendaftar->rt_rw_wali : '' }}
                                        {{ $pendaftar->kode_pos_wali ? ', '.$pendaftar->kode_pos_wali : '' }}
                                        {{ $pendaftar->kota_wali ? ' - '.$pendaftar->kota_wali : '' }}
                                    </p>
                                </div>
                            </div>
                            @else
                            <div style="text-align:center; padding:40px 0; color:#9ca3af;">
                                <p style="font-size:32px; margin:0 0 8px;">🧑</p>
                                <p style="font-size:14px;">Data wali tidak diisi oleh siswa.</p>
                            </div>
                            @endif
                        </div>

                    </div>{{-- end scrollable --}}
                </div>
            </div>
            {{-- ===================== END MODAL ===================== --}}

            <script>
            function switchTab(activeId) {
                // sembunyikan semua panel
                document.querySelectorAll('.bio-tab').forEach(t => t.style.display = 'none');
                document.getElementById(activeId).style.display = 'block';

                // reset semua tombol tab
                ['tab-siswa','tab-ayah','tab-ibu','tab-wali'].forEach(id => {
                    const btn = document.getElementById('btn-' + id);
                    if (btn) {
                        btn.style.borderBottomColor = 'transparent';
                        btn.style.fontWeight = '500';
                        btn.style.color = '#6b7280';
                        btn.style.background = 'transparent';
                    }
                });

                // aktifkan tombol yang diklik
                const activeBtn = document.getElementById('btn-' + activeId);
                if (activeBtn) {
                    const color = activeBtn.dataset.color;
                    activeBtn.style.borderBottomColor = color;
                    activeBtn.style.fontWeight = '700';
                    activeBtn.style.color = color;
                    activeBtn.style.background = '#f9fafb';
                }
            }
            </script>






            <!-- Update Status -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ubah Status</h3>
                    <form action="{{ route('admin.pendaftar.updateStatus', $pendaftar->id) }}" method="POST" class="space-y-4">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Baru</label>
                                <select name="status" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm">
                                    @foreach(['terdaftar','menunggu_verifikasi','lulus_administrasi','tidak_lulus_administrasi','lulus_tes','tidak_lulus_tes','lulus_pnbm','tidak_lulus_pnbm','daftar_ulang','resmi_terdaftar'] as $s)
                                        <option value="{{ $s }}" {{ $pendaftar->status == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan Panitia</label>
                                <input type="text" name="catatan_panitia" value="{{ $pendaftar->catatan_panitia }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm">
                            </div>
                        </div>
                        <x-primary-button>Simpan Perubahan</x-primary-button>
                    </form>
                </div>
            </div>

            <!-- Berkas Pendaftaran -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                        <i class="ri-folder-2-line text-indigo-500"></i> Berkas Pendaftaran
                        <span class="text-sm font-normal text-gray-400">({{ $pendaftar->berkas->count() }} berkas)</span>
                    </h3>

                    @if($pendaftar->berkas->count() > 0)
                    <div class="space-y-4">
                        @foreach($pendaftar->berkas as $berkas)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                                {{-- Header berkas --}}
                                <div class="flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-gray-700">
                                    <div class="flex items-center gap-3">
                                        @php $ext = strtolower(pathinfo($berkas->nama_file, PATHINFO_EXTENSION)); @endphp
                                        @if($ext === 'pdf')
                                            <i class="ri-file-pdf-2-line text-2xl text-red-400"></i>
                                        @else
                                            <i class="ri-image-line text-2xl text-blue-400"></i>
                                        @endif
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                {{ ucfirst(str_replace('_', ' ', $berkas->jenis_berkas)) }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $berkas->nama_file }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                            {{ $berkas->status == 'pending'         ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                            {{ $berkas->status == 'diterima'        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                            {{ $berkas->status == 'ditolak'         ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                            {{ $berkas->status == 'perlu_perbaikan' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200' : '' }}
                                        ">
                                            @if($berkas->status == 'pending') ⏳ Menunggu
                                            @elseif($berkas->status == 'diterima') ✅ Diterima
                                            @elseif($berkas->status == 'ditolak') ❌ Ditolak
                                            @elseif($berkas->status == 'perlu_perbaikan') ⚠️ Perlu Perbaikan
                                            @endif
                                        </span>
                                        <a href="{{ Storage::url($berkas->path) }}" target="_blank"
                                           style="display:inline-flex;align-items:center;gap:4px;padding:5px 12px;border-radius:5px;font-size:12px;font-weight:600;background:#e0e7ff;color:#4338ca;text-decoration:none;">
                                            <i class="ri-eye-line"></i> Lihat
                                        </a>
                                    </div>
                                </div>

                                {{-- Form verifikasi inline --}}
                                <form action="{{ route('admin.pendaftar.updateBerkas', $berkas->id) }}" method="POST"
                                      class="px-4 py-3 bg-white dark:bg-gray-800">
                                    @csrf @method('PUT')
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Status Verifikasi</label>
                                            <select name="status"
                                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm text-sm">
                                                <option value="pending"         {{ $berkas->status == 'pending'         ? 'selected' : '' }}>⏳ Menunggu</option>
                                                <option value="diterima"        {{ $berkas->status == 'diterima'        ? 'selected' : '' }}>✅ Diterima</option>
                                                <option value="ditolak"         {{ $berkas->status == 'ditolak'         ? 'selected' : '' }}>❌ Ditolak</option>
                                                <option value="perlu_perbaikan" {{ $berkas->status == 'perlu_perbaikan' ? 'selected' : '' }}>⚠️ Perlu Perbaikan</option>
                                            </select>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                                Keterangan <span class="text-gray-400">(opsional, misal: alasan ditolak)</span>
                                            </label>
                                            <div class="flex gap-2">
                                                <input type="text" name="keterangan"
                                                       value="{{ $berkas->keterangan }}"
                                                       placeholder="Contoh: Foto buram, harap upload ulang..."
                                                       class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm text-sm">
                                                <button type="submit"
                                                        style="display:inline-flex;align-items:center;gap:5px;padding:8px 14px;border-radius:6px;font-size:12px;font-weight:600;background:#4f46e5;color:#fff;border:none;cursor:pointer;white-space:nowrap;">
                                                    <i class="ri-save-line"></i> Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @if($berkas->keterangan)
                                        <p class="mt-2 text-xs text-amber-600 dark:text-amber-400 flex items-center gap-1">
                                            <i class="ri-chat-quote-line"></i>
                                            Keterangan terakhir: <em>{{ $berkas->keterangan }}</em>
                                        </p>
                                    @endif
                                </form>
                            </div>
                        @endforeach
                    </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400 italic">Siswa belum mengupload berkas apapun.</p>
                    @endif
                </div>
            </div>


            <!-- Hasil Tes -->
            @if($pendaftar->hasilTes->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Hasil Tes</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($pendaftar->hasilTes as $tes)
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <p class="font-medium text-gray-900 dark:text-gray-100">Tes {{ ucfirst($tes->jenis_tes) }}</p>
                                <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-1">{{ $tes->nilai ?? '-' }}</p>
                                <p class="text-sm mt-1">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $tes->status == 'lulus' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                        {{ $tes->status == 'tidak_lulus' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                        {{ $tes->status == 'belum_dinilai' ? 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200' : '' }}
                                    ">{{ ucfirst(str_replace('_', ' ', $tes->status)) }}</span>
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Delete -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-red-600 dark:text-red-400 mb-2">Zona Bahaya</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Menghapus pendaftar akan menghapus seluruh data termasuk akun user.</p>
                    <form action="{{ route('admin.pendaftar.destroy', $pendaftar->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data pendaftar ini?');">
                        @csrf @method('DELETE')
                        <x-danger-button>Hapus Pendaftar</x-danger-button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
