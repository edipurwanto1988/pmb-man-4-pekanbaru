<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Input Nilai: {{ $pendaftar->nama_lengkap }}</h2>
            <a href="{{ route('admin.penilaian.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">{{ session('success') }}</div>
            @endif

            <!-- Info -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-6 p-6">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div><p class="text-xs text-gray-500 dark:text-gray-400">Nama</p><p class="font-semibold text-gray-900 dark:text-gray-100">{{ $pendaftar->nama_lengkap }}</p></div>
                    <div><p class="text-xs text-gray-500 dark:text-gray-400">NISN</p><p class="font-semibold text-gray-900 dark:text-gray-100">{{ $pendaftar->nisn }}</p></div>
                    <div><p class="text-xs text-gray-500 dark:text-gray-400">Status</p>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            {{ ucfirst(str_replace('_', ' ', $pendaftar->status)) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tes Akademik -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">📝 Tes Akademik</h3>
                    <form action="{{ route('admin.penilaian.store', $pendaftar->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="jenis_tes" value="akademik">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nilai (0-100)</label>
                            <input type="number" name="nilai" value="{{ $akademik->nilai ?? '' }}" min="0" max="100" step="0.01" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <select name="status" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                <option value="belum_dinilai" {{ ($akademik->status ?? '') == 'belum_dinilai' ? 'selected' : '' }}>Belum Dinilai</option>
                                <option value="lulus" {{ ($akademik->status ?? '') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                <option value="tidak_lulus" {{ ($akademik->status ?? '') == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Tes</label>
                            <input type="date" name="tanggal_tes" value="{{ $akademik->tanggal_tes?->format('Y-m-d') ?? '' }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan</label>
                            <textarea name="catatan" rows="2" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">{{ $akademik->catatan ?? '' }}</textarea>
                        </div>
                        <x-primary-button class="w-full justify-center">Simpan Nilai Akademik</x-primary-button>
                    </form>
                </div>

                <!-- Tes Ibadah -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">🕌 Tes Ibadah</h3>
                    <form action="{{ route('admin.penilaian.store', $pendaftar->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="jenis_tes" value="ibadah">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nilai (0-100)</label>
                            <input type="number" name="nilai" value="{{ $ibadah->nilai ?? '' }}" min="0" max="100" step="0.01" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <select name="status" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                <option value="belum_dinilai" {{ ($ibadah->status ?? '') == 'belum_dinilai' ? 'selected' : '' }}>Belum Dinilai</option>
                                <option value="lulus" {{ ($ibadah->status ?? '') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                <option value="tidak_lulus" {{ ($ibadah->status ?? '') == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Tes</label>
                            <input type="date" name="tanggal_tes" value="{{ $ibadah->tanggal_tes?->format('Y-m-d') ?? '' }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan</label>
                            <textarea name="catatan" rows="2" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">{{ $ibadah->catatan ?? '' }}</textarea>
                        </div>
                        <x-primary-button class="w-full justify-center">Simpan Nilai Ibadah</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
