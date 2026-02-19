<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Daftar Ulang: {{ $pendaftar->nama_lengkap }}</h2>
            <a href="{{ route('admin.daftar-ulang.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">← Kembali</a>
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
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $pendaftar->status == 'lulus_pnbm' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $pendaftar->status == 'daftar_ulang' ? 'bg-purple-100 text-purple-800' : '' }}
                            {{ $pendaftar->status == 'resmi_terdaftar' ? 'bg-emerald-100 text-emerald-800' : '' }}
                        ">{{ ucfirst(str_replace('_', ' ', $pendaftar->status)) }}</span>
                    </div>
                </div>
            </div>

            <!-- Berkas Daftar Ulang -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Berkas Daftar Ulang</h3>
                    @if($pendaftar->berkasDaftarUlang->count() > 0)
                        <div class="space-y-4">
                            @foreach($pendaftar->berkasDaftarUlang as $berkas)
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center justify-between mb-3">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $berkas->syarat->nama ?? 'Syarat #'.$berkas->syarat_daftar_ulang_id }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $berkas->nama_file }} • {{ $berkas->created_at->format('d M Y') }}</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                {{ $berkas->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $berkas->status == 'verified' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $berkas->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                            ">{{ ucfirst($berkas->status) }}</span>
                                            <a href="{{ Storage::url($berkas->path) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">Lihat →</a>
                                        </div>
                                    </div>
                                    <form action="{{ route('admin.daftar-ulang.verifyBerkas', $berkas->id) }}" method="POST" class="flex gap-3">
                                        @csrf @method('PUT')
                                        <select name="status" class="text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-600 dark:text-gray-200">
                                            <option value="pending" {{ $berkas->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="verified" {{ $berkas->status == 'verified' ? 'selected' : '' }}>✅ Verified</option>
                                            <option value="rejected" {{ $berkas->status == 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                                        </select>
                                        <input type="text" name="catatan" value="{{ $berkas->catatan }}" placeholder="Catatan..." class="flex-1 text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-600 dark:text-gray-200">
                                        <button type="submit" class="px-3 py-1 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Simpan</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada berkas daftar ulang.</p>
                    @endif
                </div>
            </div>

            <!-- Konfirmasi -->
            @if($pendaftar->status != 'resmi_terdaftar')
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Konfirmasi Pendaftaran</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Klik tombol berikut untuk mengkonfirmasi bahwa siswa telah resmi terdaftar sebagai siswa baru MAN 4 Pekanbaru.</p>
                <form action="{{ route('admin.daftar-ulang.konfirmasi', $pendaftar->id) }}" method="POST">
                    @csrf
                    <x-primary-button onclick="return confirm('Konfirmasi pendaftaran resmi?')">✅ Konfirmasi Resmi Terdaftar</x-primary-button>
                </form>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
