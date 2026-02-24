<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Konfirmasi Daftar Ulang</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">{{ session('success') }}</div>
            @endif

            {{-- ===================== PENGATURAN INFO BARANG BAWAAN ===================== --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-1 flex items-center gap-2">
                        <i class="ri-settings-3-line text-indigo-500"></i> Pengaturan Info Daftar Ulang
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        Informasi ini akan tampil di dashboard siswa sebagai panduan barang yang harus dibawa saat daftar ulang ke sekolah.
                    </p>
                    <form action="{{ route('admin.daftar-ulang.saveInfo') }}" method="POST">
                        @csrf
                        <textarea
                            name="info_barang_bawaan"
                            rows="7"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm text-sm font-mono"
                            placeholder="Tulis daftar barang yang harus dibawa, satu per baris..."
                        >{{ $infoBawaan }}</textarea>
                        <div class="mt-3">
                            <button type="submit"
                                style="display:inline-flex; align-items:center; gap:6px; padding:8px 18px; background:#4f46e5; color:#fff; border:none; border-radius:7px; font-size:13px; font-weight:600; cursor:pointer;">
                                <i class="ri-save-line"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ===================== FILTER ===================== --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4">
                    <form method="GET" class="flex flex-wrap gap-3 items-center">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau NISN..."
                            class="flex-1 min-w-[200px] rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm text-sm">
                        <select name="status" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm text-sm">
                            <option value="">Semua Status</option>
                            <option value="lulus_pnbm"       {{ request('status') == 'lulus_pnbm'       ? 'selected' : '' }}>Lulus PMB (Belum DU)</option>
                            <option value="daftar_ulang"     {{ request('status') == 'daftar_ulang'     ? 'selected' : '' }}>Proses Daftar Ulang</option>
                            <option value="resmi_terdaftar"  {{ request('status') == 'resmi_terdaftar'  ? 'selected' : '' }}>Resmi Terdaftar ✅</option>
                            <option value="tidak_lulus_pnbm" {{ request('status') == 'tidak_lulus_pnbm' ? 'selected' : '' }}>Tidak Lulus ❌</option>
                        </select>
                        <x-primary-button>Filter</x-primary-button>
                    </form>
                </div>
            </div>

            {{-- ===================== TABEL SISWA ===================== --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">NISN</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status Sekarang</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Ubah Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($pendaftars as $i => $p)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $pendaftars->firstItem() + $i }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $p->nama_lengkap }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $p->nisn }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $badgeClass = match($p->status) {
                                            'lulus_pnbm'       => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                            'daftar_ulang'     => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                            'resmi_terdaftar'  => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
                                            'tidak_lulus_pnbm' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                            default            => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('admin.daftar-ulang.updateStatus', $p->id) }}" method="POST"
                                          class="flex items-center gap-2" onsubmit="return confirm('Ubah status siswa ini?')">
                                        @csrf @method('PUT')
                                        <select name="status"
                                            class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm text-sm py-1">
                                            <option value="lulus_pnbm"       {{ $p->status == 'lulus_pnbm'       ? 'selected' : '' }}>Lulus PMB</option>
                                            <option value="daftar_ulang"     {{ $p->status == 'daftar_ulang'     ? 'selected' : '' }}>Proses Daftar Ulang</option>
                                            <option value="resmi_terdaftar"  {{ $p->status == 'resmi_terdaftar'  ? 'selected' : '' }}>✅ Resmi Terdaftar</option>
                                            <option value="tidak_lulus_pnbm" {{ $p->status == 'tidak_lulus_pnbm' ? 'selected' : '' }}>❌ Tidak Lulus</option>
                                        </select>
                                        <button type="submit"
                                            style="padding:5px 12px; background:#4f46e5; color:#fff; border:none; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer;">
                                            Simpan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada data daftar ulang.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">{{ $pendaftars->withQueryString()->links() }}</div>
            </div>

        </div>
    </div>
</x-app-layout>
