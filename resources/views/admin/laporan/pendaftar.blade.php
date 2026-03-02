<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Laporan Pendaftar</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Statistics Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 border-l-4 border-indigo-500">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Total Pendaftar</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Laki-laki</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['laki'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 border-l-4 border-pink-500">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Perempuan</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['perempuan'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 border-l-4 border-green-500">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Lulus PMB</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['lulus_pnbm'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 border-l-4 border-emerald-500">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Resmi Terdaftar</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['resmi_terdaftar'] }}</p>
                </div>
            </div>

            <!-- Status Breakdown -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">Rekap Berdasarkan Status</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <div class="flex justify-between items-center p-2 rounded bg-gray-50 dark:bg-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-300">Terdaftar</span>
                            <span class="text-sm font-bold text-gray-800 dark:text-gray-100">{{ $stats['terdaftar'] }}</span>
                        </div>
                        <div class="flex justify-between items-center p-2 rounded bg-yellow-50 dark:bg-yellow-900/30">
                            <span class="text-sm text-gray-600 dark:text-gray-300">Menunggu Verifikasi</span>
                            <span class="text-sm font-bold text-yellow-700 dark:text-yellow-300">{{ $stats['menunggu_verifikasi'] }}</span>
                        </div>
                        <div class="flex justify-between items-center p-2 rounded bg-blue-50 dark:bg-blue-900/30">
                            <span class="text-sm text-gray-600 dark:text-gray-300">Lulus Administrasi</span>
                            <span class="text-sm font-bold text-blue-700 dark:text-blue-300">{{ $stats['lulus_administrasi'] }}</span>
                        </div>
                        <div class="flex justify-between items-center p-2 rounded bg-indigo-50 dark:bg-indigo-900/30">
                            <span class="text-sm text-gray-600 dark:text-gray-300">Lulus Tes</span>
                            <span class="text-sm font-bold text-indigo-700 dark:text-indigo-300">{{ $stats['lulus_tes'] }}</span>
                        </div>
                        <div class="flex justify-between items-center p-2 rounded bg-green-50 dark:bg-green-900/30">
                            <span class="text-sm text-gray-600 dark:text-gray-300">Lulus PMB</span>
                            <span class="text-sm font-bold text-green-700 dark:text-green-300">{{ $stats['lulus_pnbm'] }}</span>
                        </div>
                        <div class="flex justify-between items-center p-2 rounded bg-purple-50 dark:bg-purple-900/30">
                            <span class="text-sm text-gray-600 dark:text-gray-300">Daftar Ulang</span>
                            <span class="text-sm font-bold text-purple-700 dark:text-purple-300">{{ $stats['daftar_ulang'] }}</span>
                        </div>
                        <div class="flex justify-between items-center p-2 rounded bg-emerald-50 dark:bg-emerald-900/30">
                            <span class="text-sm text-gray-600 dark:text-gray-300">Resmi Terdaftar</span>
                            <span class="text-sm font-bold text-emerald-700 dark:text-emerald-300">{{ $stats['resmi_terdaftar'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-wrap gap-4 items-end justify-between">
                        <form method="GET" class="flex flex-wrap gap-4 items-end flex-1">
                            <div class="min-w-[150px]">
                                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cari</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nama, NISN, Asal Sekolah..." class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <select name="status" id="status" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    <option value="">Semua Status</option>
                                    <option value="terdaftar" {{ request('status') == 'terdaftar' ? 'selected' : '' }}>Terdaftar</option>
                                    <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                    <option value="lulus_administrasi" {{ request('status') == 'lulus_administrasi' ? 'selected' : '' }}>Lulus Administrasi</option>
                                    <option value="tidak_lulus_administrasi" {{ request('status') == 'tidak_lulus_administrasi' ? 'selected' : '' }}>Tidak Lulus Administrasi</option>
                                    <option value="lulus_tes" {{ request('status') == 'lulus_tes' ? 'selected' : '' }}>Lulus Tes</option>
                                    <option value="tidak_lulus_tes" {{ request('status') == 'tidak_lulus_tes' ? 'selected' : '' }}>Tidak Lulus Tes</option>
                                    <option value="lulus_pnbm" {{ request('status') == 'lulus_pnbm' ? 'selected' : '' }}>Lulus PMB</option>
                                    <option value="daftar_ulang" {{ request('status') == 'daftar_ulang' ? 'selected' : '' }}>Daftar Ulang</option>
                                    <option value="resmi_terdaftar" {{ request('status') == 'resmi_terdaftar' ? 'selected' : '' }}>Resmi Terdaftar</option>
                                </select>
                            </div>
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    <option value="">Semua</option>
                                    <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            @if($jurusanList->count())
                            <div>
                                <label for="jurusan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jurusan</label>
                                <select name="jurusan" id="jurusan" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    <option value="">Semua Jurusan</option>
                                    @foreach($jurusanList as $j)
                                        <option value="{{ $j }}" {{ request('jurusan') == $j ? 'selected' : '' }}>{{ $j }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div>
                                <label for="dari_tanggal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
                                <input type="date" name="dari_tanggal" id="dari_tanggal" value="{{ request('dari_tanggal') }}" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                            <div>
                                <label for="sampai_tanggal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
                                <input type="date" name="sampai_tanggal" id="sampai_tanggal" value="{{ request('sampai_tanggal') }}" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                            <x-primary-button>Filter</x-primary-button>
                            @if(request()->hasAny(['search', 'status', 'jenis_kelamin', 'jurusan', 'dari_tanggal', 'sampai_tanggal']))
                                <a href="{{ route('admin.laporan.pendaftar') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded-md text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-400">Reset</a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <!-- Export Button -->
            <div class="flex justify-between items-center mb-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Menampilkan {{ $pendaftars->total() }} data</p>
                <a href="{{ route('admin.laporan.export-pendaftar', request()->query()) }}" style="background-color: #16a34a; color: white;" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <i class="ri-file-excel-2-line mr-2"></i> Export Excel
                </a>
            </div>

            <!-- Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NISN</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">L/P</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Asal Sekolah</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jurusan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tgl Daftar</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($pendaftars as $index => $p)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pendaftars->firstItem() + $index }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-7 h-7 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xs font-bold">
                                                {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                                            </div>
                                            <div class="ml-2">
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $p->nama_lengkap }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $p->nisn ?? '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $p->jenis_kelamin == 'L' ? 'L' : ($p->jenis_kelamin == 'P' ? 'P' : '-') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $p->asal_sekolah ?? '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $p->jurusan_pilihan ?? '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
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
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $p->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada data pendaftar.</td>
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
