<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard Siswa</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome Card -->
            <div class="overflow-hidden shadow-sm sm:rounded-lg mb-6" style="background: linear-gradient(to right, #22c55e, #059669);">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-1" style="color: #ffffff;">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                    <p style="color: #ecfdf5;">Sistem Penerimaan Murid Baru MAN 4 Kota Pekanbaru</p>
                </div>
            </div>

            @if($calonSiswa)
            <!-- Status -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status Pendaftaran Anda</p>
                            @php
                                $statusStyles = [
                                    'terdaftar' => 'background-color:#f3f4f6;color:#1f2937;',
                                    'menunggu_verifikasi' => 'background-color:#fef9c3;color:#92400e;',
                                    'lulus_administrasi' => 'background-color:#dbeafe;color:#1e40af;',
                                    'tidak_lulus_administrasi' => 'background-color:#fee2e2;color:#991b1b;',
                                    'lulus_tes' => 'background-color:#e0e7ff;color:#3730a3;',
                                    'tidak_lulus_tes' => 'background-color:#fee2e2;color:#991b1b;',
                                    'lulus_pnbm' => 'background-color:#dcfce7;color:#166534;',
                                    'daftar_ulang' => 'background-color:#f3e8ff;color:#6b21a8;',
                                    'resmi_terdaftar' => 'background-color:#d1fae5;color:#065f46;',
                                ];
                            @endphp
                            <span class="inline-block mt-2 px-4 py-2 rounded-full text-sm font-bold" style="{{ $statusStyles[$calonSiswa->status] ?? 'background-color:#f3f4f6;color:#1f2937;' }}">
                                {{ ucfirst(str_replace('_', ' ', $calonSiswa->status)) }}
                            </span>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500 dark:text-gray-400">NISN</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $calonSiswa->nisn }}</p>
                        </div>
                    </div>
                    @if($calonSiswa->catatan_panitia)
                        <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                            <p class="text-sm text-yellow-800 dark:text-yellow-200"><strong>Catatan Panitia:</strong> {{ $calonSiswa->catatan_panitia }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Progress Steps -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Progres Pendaftaran</h3>
                    @php
                        $steps = [
                            ['key' => 'terdaftar', 'label' => 'Terdaftar', 'icon' => '1'],
                            ['key' => 'menunggu_verifikasi', 'label' => 'Upload Berkas', 'icon' => '2'],
                            ['key' => 'lulus_administrasi', 'label' => 'Verifikasi', 'icon' => '3'],
                            ['key' => 'lulus_tes', 'label' => 'Tes PMB', 'icon' => '4'],
                            ['key' => 'lulus_pnbm', 'label' => 'Pengumuman', 'icon' => '5'],
                            ['key' => 'resmi_terdaftar', 'label' => 'Daftar Ulang', 'icon' => '6'],
                        ];
                        $statusOrder = ['terdaftar','menunggu_verifikasi','lulus_administrasi','lulus_tes','lulus_pnbm','daftar_ulang','resmi_terdaftar'];
                        $currentIndex = array_search($calonSiswa->status, $statusOrder);
                        if ($currentIndex === false) $currentIndex = 0;
                    @endphp
                    <div class="flex justify-between items-center">
                        @foreach($steps as $i => $step)
                            <div class="flex flex-col items-center {{ $i < count($steps) - 1 ? 'flex-1' : '' }}">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold"
                                    style="{{ $i <= $currentIndex ? 'background-color:#22c55e;color:#ffffff;' : 'background-color:#e5e7eb;color:#6b7280;' }}"
                                >
                                    @if($i < $currentIndex)
                                        ✓
                                    @else
                                        {{ $step['icon'] }}
                                    @endif
                                </div>
                                <p class="text-xs mt-2 text-center" style="{{ $i <= $currentIndex ? 'color:#16a34a;font-weight:600;' : 'color:#6b7280;' }}">
                                    {{ $step['label'] }}
                                </p>
                            </div>
                            @if($i < count($steps) - 1)
                                <div class="flex-1 h-1 mx-2 rounded" style="{{ $i < $currentIndex ? 'background-color:#22c55e;' : 'background-color:#e5e7eb;' }}"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('siswa.berkas-awal.index') }}" class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 hover:shadow-md transition block">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md p-3" style="background-color:#3b82f6;">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-900 dark:text-gray-100">Berkas Pendaftaran</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $berkasCount }} berkas terupload</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('siswa.jadwal') }}" class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 hover:shadow-md transition block">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md p-3" style="background-color:#a855f7;">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-900 dark:text-gray-100">Jadwal PMB</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Lihat jadwal kegiatan</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('siswa.hasil-tes') }}" class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 hover:shadow-md transition block">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md p-3" style="background-color:#6366f1;">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-900 dark:text-gray-100">Hasil Tes</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                @if($hasilTes->count() > 0)
                                    {{ $hasilTes->count() }} tes tercatat
                                @else
                                    Belum ada hasil
                                @endif
                            </p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('siswa.pengumuman') }}" class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 hover:shadow-md transition block">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md p-3" style="background-color:#22c55e;">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-900 dark:text-gray-100">Pengumuman</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Lihat pengumuman</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('siswa.berkas.index') }}" class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 hover:shadow-md transition block">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md p-3" style="background-color:#f97316;">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-900 dark:text-gray-100">Daftar Ulang</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Upload berkas DU</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}" class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 hover:shadow-md transition block">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md p-3" style="background-color:#6b7280;">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-900 dark:text-gray-100">Profil Saya</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Edit data profil</p>
                        </div>
                    </div>
                </a>
            </div>
            @else
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Data calon siswa belum ditemukan. Silakan hubungi admin.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
