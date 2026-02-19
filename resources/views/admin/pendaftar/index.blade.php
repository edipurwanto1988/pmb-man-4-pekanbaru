<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Kelola Pendaftar</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="flex flex-wrap gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NISN..." class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <select name="status" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                        <x-primary-button>Filter</x-primary-button>
                        @if(request()->hasAny(['search', 'status']))
                            <a href="{{ route('admin.pendaftar.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded-md text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-400">Reset</a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NISN</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tgl Daftar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($pendaftars as $index => $p)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pendaftars->firstItem() + $index }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-sm font-bold">
                                                {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $p->nama_lengkap }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $p->nisn }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $p->user->email ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $p->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('admin.pendaftar.show', $p->id) }}" class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors">
                                            <i class="ri-eye-line"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada pendaftar.</td>
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
