<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Verifikasi: {{ $pendaftar->nama_lengkap }}</h2>
            <a href="{{ route('admin.verifikasi.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg">{{ session('error') }}</div>
            @endif

            <!-- Info -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-6 p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div><p class="text-xs text-gray-500 dark:text-gray-400">Nama</p><p class="font-semibold text-gray-900 dark:text-gray-100">{{ $pendaftar->nama_lengkap }}</p></div>
                    <div><p class="text-xs text-gray-500 dark:text-gray-400">NISN</p><p class="font-semibold text-gray-900 dark:text-gray-100">{{ $pendaftar->nisn }}</p></div>
                    <div><p class="text-xs text-gray-500 dark:text-gray-400">HP Siswa</p><p class="text-gray-900 dark:text-gray-100">{{ $pendaftar->no_hp_siswa }}</p></div>
                    <div><p class="text-xs text-gray-500 dark:text-gray-400">HP Ortu</p><p class="text-gray-900 dark:text-gray-100">{{ $pendaftar->no_hp_ortu }}</p></div>
                </div>
            </div>

            <!-- Berkas -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Berkas yang Diupload</h3>
                    @if($pendaftar->berkas->count() > 0)
                        <div class="space-y-4">
                            @foreach($pendaftar->berkas as $berkas)
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center justify-between mb-3">
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ ucfirst(str_replace('_', ' ', $berkas->jenis_berkas)) }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $berkas->nama_file }} • {{ $berkas->created_at->format('d M Y') }}</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                {{ $berkas->status == 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                                {{ $berkas->status == 'diterima' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                                {{ $berkas->status == 'ditolak' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                                {{ $berkas->status == 'perlu_perbaikan' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200' : '' }}
                                            ">{{ ucfirst(str_replace('_', ' ', $berkas->status)) }}</span>
                                            <a href="{{ Storage::url($berkas->path) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">Lihat →</a>
                                        </div>
                                    </div>
                                    <form action="{{ route('admin.verifikasi.updateBerkas', $berkas->id) }}" method="POST" class="flex flex-wrap gap-3 items-end">
                                        @csrf @method('PUT')
                                        <div class="flex-1 min-w-[120px]">
                                            <select name="status" class="w-full text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-600 dark:text-gray-200">
                                                <option value="pending" {{ $berkas->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="diterima" {{ $berkas->status == 'diterima' ? 'selected' : '' }}>✅ Diterima</option>
                                                <option value="perlu_perbaikan" {{ $berkas->status == 'perlu_perbaikan' ? 'selected' : '' }}>⚠️ Perlu Perbaikan</option>
                                                <option value="ditolak" {{ $berkas->status == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                                            </select>
                                        </div>
                                        <div class="flex-1 min-w-[200px]">
                                            <input type="text" name="keterangan" value="{{ $berkas->keterangan }}" placeholder="Keterangan..." class="w-full text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-600 dark:text-gray-200">
                                        </div>
                                        <button type="submit" class="px-3 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Simpan</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada berkas yang diupload.</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Aksi Cepat</h3>
                <div class="flex flex-wrap gap-3">
                    <form action="{{ route('admin.verifikasi.luluskan', $pendaftar->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700" onclick="return confirm('Luluskan administrasi?')">✅ Luluskan Administrasi</button>
                    </form>
                    <form action="{{ route('admin.verifikasi.tolak', $pendaftar->id) }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="catatan_panitia" placeholder="Alasan penolakan..." class="text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" required>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-700" onclick="return confirm('Tolak administrasi?')">❌ Tolak</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
