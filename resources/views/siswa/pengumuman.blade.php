<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Pengumuman Kelulusan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if($calonSiswa)
                @if(in_array($calonSiswa->status, ['lulus_pnbm', 'daftar_ulang', 'resmi_terdaftar']))
                    <!-- LULUS -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-8 text-center text-white">
                            <div class="text-6xl mb-4">🎉</div>
                            <h3 class="text-3xl font-bold mb-2">SELAMAT!</h3>
                            <p class="text-xl">Anda dinyatakan <strong>LULUS</strong></p>
                            <p class="text-green-100 mt-1">Penerimaan Murid Baru MAN 4 Kota Pekanbaru</p>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div><p class="text-xs text-gray-500 dark:text-gray-400">Nama</p><p class="font-semibold text-gray-900 dark:text-gray-100">{{ $calonSiswa->nama_lengkap }}</p></div>
                                <div><p class="text-xs text-gray-500 dark:text-gray-400">NISN</p><p class="font-semibold text-gray-900 dark:text-gray-100">{{ $calonSiswa->nisn }}</p></div>
                            </div>

                            @if($calonSiswa->status == 'lulus_pnbm')
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4">
                                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                        <strong>⚠️ Langkah Selanjutnya:</strong> Silakan lakukan proses <strong>Daftar Ulang</strong> dengan mengupload berkas yang diperlukan.
                                    </p>
                                    <a href="{{ route('siswa.berkas.index') }}" class="mt-3 inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                                        Lanjut Daftar Ulang →
                                    </a>
                                </div>
                            @elseif($calonSiswa->status == 'resmi_terdaftar')
                                <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-lg p-4">
                                    <p class="text-sm text-emerald-800 dark:text-emerald-200">
                                        <strong>✅ Selamat!</strong> Anda telah resmi terdaftar sebagai siswa baru MAN 4 Kota Pekanbaru.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                @elseif(in_array($calonSiswa->status, ['tidak_lulus_pnbm', 'tidak_lulus_tes', 'tidak_lulus_administrasi']))
                    <!-- TIDAK LULUS -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-500 to-gray-600 p-8 text-center text-white">
                            <div class="text-6xl mb-4">📋</div>
                            <h3 class="text-2xl font-bold mb-2">Pengumuman</h3>
                            <p>Terima kasih atas partisipasi Anda</p>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                Mohon maaf, berdasarkan hasil seleksi, Anda dinyatakan <strong>belum diterima</strong> di MAN 4 Kota Pekanbaru pada tahun ajaran ini.
                            </p>
                            @if($calonSiswa->catatan_panitia)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Catatan:</strong> {{ $calonSiswa->catatan_panitia }}</p>
                                </div>
                            @endif
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                                Jangan berkecil hati. Semoga Anda mendapatkan kesempatan terbaik di tempat lain. Terima kasih telah mendaftar. 🙏
                            </p>
                        </div>
                    </div>

                @else
                    <!-- BELUM ADA PENGUMUMAN -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-8 text-center">
                        <div class="text-6xl mb-4">⏳</div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Menunggu Pengumuman</h3>
                        <p class="text-gray-500 dark:text-gray-400">
                            Pengumuman kelulusan belum tersedia. <br>Silakan cek kembali secara berkala.
                        </p>
                        <div class="mt-4">
                            <p class="text-sm text-gray-400">Status saat ini: <strong>{{ ucfirst(str_replace('_', ' ', $calonSiswa->status)) }}</strong></p>
                        </div>
                    </div>
                @endif
            @else
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-8 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Data pendaftar tidak ditemukan.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
