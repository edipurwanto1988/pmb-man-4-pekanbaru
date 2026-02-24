<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Daftar Ulang</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Status Banner --}}
            @if($calonSiswa)
                @php
                    $status = $calonSiswa->status;
                @endphp

                @if($status === 'resmi_terdaftar')
                    <div style="background:#ecfdf5; border:1px solid #6ee7b7; border-radius:12px; padding:20px 24px; display:flex; align-items:center; gap:16px;">
                        <span style="font-size:40px;">🎉</span>
                        <div>
                            <p style="font-size:16px; font-weight:700; color:#065f46; margin:0;">Selamat! Anda Resmi Terdaftar</p>
                            <p style="font-size:13px; color:#047857; margin:4px 0 0;">Anda telah resmi diterima sebagai siswa baru MAN 4 Kota Pekanbaru Tahun Ajaran ini.</p>
                        </div>
                    </div>

                @elseif($status === 'tidak_lulus_pnbm')
                    <div style="background:#fef2f2; border:1px solid #fca5a5; border-radius:12px; padding:20px 24px; display:flex; align-items:center; gap:16px;">
                        <span style="font-size:40px;">😔</span>
                        <div>
                            <p style="font-size:16px; font-weight:700; color:#991b1b; margin:0;">Mohon Maaf, Anda Tidak Lulus</p>
                            <p style="font-size:13px; color:#b91c1c; margin:4px 0 0;">Hasil seleksi PMB menunjukkan Anda belum diterima. Silakan hubungi pihak sekolah untuk informasi lebih lanjut.</p>
                        </div>
                    </div>

                @elseif($status === 'lulus_pnbm' || $status === 'daftar_ulang')
                    <div style="background:#eff6ff; border:1px solid #93c5fd; border-radius:12px; padding:20px 24px; display:flex; align-items:center; gap:16px;">
                        <span style="font-size:40px;">📋</span>
                        <div>
                            <p style="font-size:16px; font-weight:700; color:#1e3a8a; margin:0;">Selamat! Anda Lulus PMB</p>
                            <p style="font-size:13px; color:#1d4ed8; margin:4px 0 0;">Silakan datang ke sekolah untuk melakukan daftar ulang dengan membawa dokumen yang diperlukan.</p>
                        </div>
                    </div>
                @else
                    <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:12px; padding:20px 24px;">
                        <p style="color:#6b7280; font-size:14px; margin:0;">Status pendaftaran Anda: <strong>{{ ucfirst(str_replace('_', ' ', $status)) }}</strong></p>
                        <p style="color:#9ca3af; font-size:13px; margin:6px 0 0;">Informasi daftar ulang akan tersedia setelah Anda dinyatakan lulus seleksi.</p>
                    </div>
                @endif
            @endif

            {{-- Info Barang Bawaan --}}
            @if($infoBawaan && in_array($calonSiswa?->status, ['lulus_pnbm', 'daftar_ulang', 'resmi_terdaftar']))
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-1 flex items-center gap-2">
                        <i class="ri-file-list-3-line text-green-500"></i>
                        Dokumen yang Harus Dibawa ke Sekolah
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Pastikan Anda membawa semua dokumen berikut saat datang untuk daftar ulang:</p>

                    <div style="background:#f0fdf4; border-left:4px solid #16a34a; border-radius:8px; padding:16px 20px;">
                        @foreach(explode("\n", $infoBawaan) as $baris)
                            @if(trim($baris))
                                <div style="display:flex; align-items:flex-start; gap:10px; margin-bottom:10px;">
                                    <span style="color:#16a34a; font-size:16px; flex-shrink:0;">✓</span>
                                    <p style="margin:0; font-size:14px; color:#166534; line-height:1.5;">{{ trim($baris) }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div style="margin-top:16px; padding:12px 16px; background:#fefce8; border-radius:8px; border:1px solid #fde68a;">
                        <p style="margin:0; font-size:13px; color:#92400e;">
                            ⚠️ <strong>Penting:</strong> Harap datang sesuai jadwal yang telah ditentukan. Ketidakhadiran tanpa konfirmasi dapat dianggap mengundurkan diri.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Tombol kembali --}}
            <div>
                <a href="{{ route('siswa.dashboard') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                    ← Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
