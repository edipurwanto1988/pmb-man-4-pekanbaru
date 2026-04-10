<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Data Arsip Pendaftar</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Filters and Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-wrap gap-4 items-end justify-between">
                        <form method="GET" class="flex flex-wrap gap-4 items-end">
                            <div class="flex-1 min-w-[200px]">
                                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cari</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nama atau NISN..." class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="tahun_pmb_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun PMB</label>
                                <select name="tahun_pmb_id" id="tahun_pmb_id" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Semua Tahun</option>
                                    @foreach($tahunPmbs as $t)
                                        <option value="{{ $t->id }}" {{ request('tahun_pmb_id') == $t->id ? 'selected' : '' }}>{{ $t->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-primary-button>Filter</x-primary-button>
                            @if(request()->hasAny(['search', 'tahun_pmb_id']))
                                <a href="{{ route('admin.arsip.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded-md text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-400">Reset</a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tahun & Gel.</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NISN</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tahap</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tgl Daftar</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider bg-gray-50 dark:bg-gray-700" style="position: sticky; right: 0; z-index: 10; box-shadow: -4px 0 6px -2px rgba(0,0,0,0.1);">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($pendaftars as $index => $p)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 group">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pendaftars->firstItem() + $index }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $p->tahunPmb->nama ?? '-' }}<br><span class="text-xs text-gray-500">{{ $p->gelombang->nama ?? '-' }}</span></td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-sm font-bold">
                                                {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $p->nama_lengkap }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $p->nisn }}<br><span class="text-xs">{{ $p->user->email ?? '-' }}</span></td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        @php
                                            $tahap = '';
                                            switch ($p->status) {
                                                case 'terdaftar':
                                                case 'menunggu_verifikasi':
                                                    $tahap = 'Pendaftaran & Verifikasi Awal';
                                                    break;
                                                case 'lulus_administrasi':
                                                case 'tidak_lulus_administrasi':
                                                    $tahap = 'Seleksi Administrasi';
                                                    break;
                                                case 'lulus_tes':
                                                case 'tidak_lulus_tes':
                                                    $tahap = 'Seleksi Tes';
                                                    break;
                                                case 'lulus_pnbm':
                                                case 'tidak_lulus_pnbm':
                                                    $tahap = 'Pengumuman Kelulusan';
                                                    break;
                                                case 'daftar_ulang':
                                                case 'resmi_terdaftar':
                                                    $tahap = 'Daftar Ulang & Finalisasi';
                                                    break;
                                                default:
                                                    $tahap = 'Tidak Diketahui';
                                                    break;
                                            }
                                        @endphp
                                        {{ $tahap }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'terdaftar' => 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200',
                                                'menunggu_verifikasi' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                'lulus_administrasi' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                                'tidak_lulus_administrasi' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                                'lulus_tes' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
                                                'tidak_lulus_tes' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                                'lulus_pnbm' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                'tidak_lulus_pnbm' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                                'daftar_ulang' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                                'resmi_terdaftar' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
                                            ];
                                        @endphp
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$p->status] ?? '' }}">
                                            {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $p->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm bg-white dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-700" style="position: sticky; right: 0; z-index: 5; box-shadow: -4px 0 6px -2px rgba(0,0,0,0.1);">
                                        <a href="{{ route('admin.pendaftar.show', $p->id) }}" class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors">
                                            <i class="ri-eye-line"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada data arsip pendaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-6">
                    {{ $pendaftars->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
