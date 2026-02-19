<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Pengumuman Kelulusan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">{{ session('success') }}</div>
            @endif

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Menunggu Keputusan</p>
                    <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['lulus_tes'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Lulus PMB</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['lulus_pnbm'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tidak Lulus</p>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $stats['tidak_lulus_pnbm'] }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="flex flex-wrap gap-4">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NISN..." class="flex-1 min-w-[200px] rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm">
                        <select name="status" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm">
                            <option value="">Semua</option>
                            <option value="lulus_tes" {{ request('status') == 'lulus_tes' ? 'selected' : '' }}>Lulus Tes (Menunggu)</option>
                            <option value="lulus_pnbm" {{ request('status') == 'lulus_pnbm' ? 'selected' : '' }}>Lulus PMB</option>
                            <option value="tidak_lulus_pnbm" {{ request('status') == 'tidak_lulus_pnbm' ? 'selected' : '' }}>Tidak Lulus PMB</option>
                        </select>
                        <x-primary-button>Filter</x-primary-button>
                    </form>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">NISN</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Nilai</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($pendaftars as $i => $p)
                            @php
                                $akademik = $p->hasilTes->where('jenis_tes', 'akademik')->first();
                                $ibadah = $p->hasilTes->where('jenis_tes', 'ibadah')->first();
                                $rataRata = 0;
                                if ($akademik && $ibadah) { $rataRata = ($akademik->nilai + $ibadah->nilai) / 2; }
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $pendaftars->firstItem() + $i }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $p->nama_lengkap }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $p->nisn }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="text-gray-500 dark:text-gray-400">Akd: {{ $akademik->nilai ?? '-' }} | Ibd: {{ $ibadah->nilai ?? '-' }}</span>
                                    @if($rataRata > 0)
                                        <br><span class="font-bold text-indigo-600 dark:text-indigo-400">Rata: {{ number_format($rataRata, 1) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $p->status == 'lulus_tes' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                        {{ $p->status == 'lulus_pnbm' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                        {{ $p->status == 'tidak_lulus_pnbm' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                        {{ $p->status == 'tidak_lulus_tes' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                    ">{{ ucfirst(str_replace('_', ' ', $p->status)) }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($p->status == 'lulus_tes')
                                        <div class="flex gap-2">
                                            <form action="{{ route('admin.pengumuman.luluskan', $p->id) }}" method="POST">
                                                @csrf
                                                <button class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 hover:bg-green-200 dark:hover:bg-green-800 transition-colors" onclick="return confirm('Luluskan?')">
                                                    <i class="ri-check-double-line"></i> Lulus
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.pengumuman.tidakLuluskan', $p->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="catatan_panitia" value="">
                                                <button class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 hover:bg-red-200 dark:hover:bg-red-800 transition-colors" onclick="return confirm('Tidak luluskan?')">
                                                    <i class="ri-close-line"></i> Tidak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                            <i class="ri-check-line"></i> Selesai
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-6">{{ $pendaftars->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
