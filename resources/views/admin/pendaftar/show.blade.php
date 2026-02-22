<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Detail Pendaftar</h2>
            <a href="{{ route('admin.pendaftar.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">{{ session('success') }}</div>
            @endif

            <!-- Student Info -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nama Lengkap</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $pendaftar->nama_lengkap }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">NISN</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $pendaftar->nisn }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $pendaftar->user->email ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No. HP Siswa</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $pendaftar->no_hp_siswa }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No. HP Orang Tua</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $pendaftar->no_hp_ortu }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                            @php
                                $statusColors = [
                                    'terdaftar' => 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200',
                                    'menunggu_verifikasi' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                    'lulus_administrasi' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                    'tidak_lulus_administrasi' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    'lulus_tes' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
                                    'tidak_lulus_tes' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    'lulus_pnbm' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                    'daftar_ulang' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                    'resmi_terdaftar' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$pendaftar->status] ?? '' }}">
                                {{ ucfirst(str_replace('_', ' ', $pendaftar->status)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Daftar</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $pendaftar->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        @if($pendaftar->catatan_panitia)
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Catatan Panitia</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $pendaftar->catatan_panitia }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ubah Status</h3>
                    <form action="{{ route('admin.pendaftar.updateStatus', $pendaftar->id) }}" method="POST" class="space-y-4">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Baru</label>
                                <select name="status" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm">
                                    @foreach(['terdaftar','menunggu_verifikasi','lulus_administrasi','tidak_lulus_administrasi','lulus_tes','tidak_lulus_tes','lulus_pnbm','tidak_lulus_pnbm','daftar_ulang','resmi_terdaftar'] as $s)
                                        <option value="{{ $s }}" {{ $pendaftar->status == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan Panitia</label>
                                <input type="text" name="catatan_panitia" value="{{ $pendaftar->catatan_panitia }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm">
                            </div>
                        </div>
                        <x-primary-button>Simpan Perubahan</x-primary-button>
                    </form>
                </div>
            </div>

            <!-- Berkas Pendaftaran -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                        <i class="ri-folder-2-line text-indigo-500"></i> Berkas Pendaftaran
                        <span class="text-sm font-normal text-gray-400">({{ $pendaftar->berkas->count() }} berkas)</span>
                    </h3>

                    @if($pendaftar->berkas->count() > 0)
                    <div class="space-y-4">
                        @foreach($pendaftar->berkas as $berkas)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                                {{-- Header berkas --}}
                                <div class="flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-gray-700">
                                    <div class="flex items-center gap-3">
                                        @php $ext = strtolower(pathinfo($berkas->nama_file, PATHINFO_EXTENSION)); @endphp
                                        @if($ext === 'pdf')
                                            <i class="ri-file-pdf-2-line text-2xl text-red-400"></i>
                                        @else
                                            <i class="ri-image-line text-2xl text-blue-400"></i>
                                        @endif
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                {{ ucfirst(str_replace('_', ' ', $berkas->jenis_berkas)) }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $berkas->nama_file }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                            {{ $berkas->status == 'pending'         ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                            {{ $berkas->status == 'diterima'        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                            {{ $berkas->status == 'ditolak'         ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                            {{ $berkas->status == 'perlu_perbaikan' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200' : '' }}
                                        ">
                                            @if($berkas->status == 'pending') ⏳ Menunggu
                                            @elseif($berkas->status == 'diterima') ✅ Diterima
                                            @elseif($berkas->status == 'ditolak') ❌ Ditolak
                                            @elseif($berkas->status == 'perlu_perbaikan') ⚠️ Perlu Perbaikan
                                            @endif
                                        </span>
                                        <a href="{{ Storage::url($berkas->path) }}" target="_blank"
                                           style="display:inline-flex;align-items:center;gap:4px;padding:5px 12px;border-radius:5px;font-size:12px;font-weight:600;background:#e0e7ff;color:#4338ca;text-decoration:none;">
                                            <i class="ri-eye-line"></i> Lihat
                                        </a>
                                    </div>
                                </div>

                                {{-- Form verifikasi inline --}}
                                <form action="{{ route('admin.pendaftar.updateBerkas', $berkas->id) }}" method="POST"
                                      class="px-4 py-3 bg-white dark:bg-gray-800">
                                    @csrf @method('PUT')
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Status Verifikasi</label>
                                            <select name="status"
                                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm text-sm">
                                                <option value="pending"         {{ $berkas->status == 'pending'         ? 'selected' : '' }}>⏳ Menunggu</option>
                                                <option value="diterima"        {{ $berkas->status == 'diterima'        ? 'selected' : '' }}>✅ Diterima</option>
                                                <option value="ditolak"         {{ $berkas->status == 'ditolak'         ? 'selected' : '' }}>❌ Ditolak</option>
                                                <option value="perlu_perbaikan" {{ $berkas->status == 'perlu_perbaikan' ? 'selected' : '' }}>⚠️ Perlu Perbaikan</option>
                                            </select>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                                Keterangan <span class="text-gray-400">(opsional, misal: alasan ditolak)</span>
                                            </label>
                                            <div class="flex gap-2">
                                                <input type="text" name="keterangan"
                                                       value="{{ $berkas->keterangan }}"
                                                       placeholder="Contoh: Foto buram, harap upload ulang..."
                                                       class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm text-sm">
                                                <button type="submit"
                                                        style="display:inline-flex;align-items:center;gap:5px;padding:8px 14px;border-radius:6px;font-size:12px;font-weight:600;background:#4f46e5;color:#fff;border:none;cursor:pointer;white-space:nowrap;">
                                                    <i class="ri-save-line"></i> Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @if($berkas->keterangan)
                                        <p class="mt-2 text-xs text-amber-600 dark:text-amber-400 flex items-center gap-1">
                                            <i class="ri-chat-quote-line"></i>
                                            Keterangan terakhir: <em>{{ $berkas->keterangan }}</em>
                                        </p>
                                    @endif
                                </form>
                            </div>
                        @endforeach
                    </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400 italic">Siswa belum mengupload berkas apapun.</p>
                    @endif
                </div>
            </div>


            <!-- Hasil Tes -->
            @if($pendaftar->hasilTes->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Hasil Tes</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($pendaftar->hasilTes as $tes)
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <p class="font-medium text-gray-900 dark:text-gray-100">Tes {{ ucfirst($tes->jenis_tes) }}</p>
                                <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-1">{{ $tes->nilai ?? '-' }}</p>
                                <p class="text-sm mt-1">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $tes->status == 'lulus' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                        {{ $tes->status == 'tidak_lulus' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                        {{ $tes->status == 'belum_dinilai' ? 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200' : '' }}
                                    ">{{ ucfirst(str_replace('_', ' ', $tes->status)) }}</span>
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Delete -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-red-600 dark:text-red-400 mb-2">Zona Bahaya</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Menghapus pendaftar akan menghapus seluruh data termasuk akun user.</p>
                    <form action="{{ route('admin.pendaftar.destroy', $pendaftar->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data pendaftar ini?');">
                        @csrf @method('DELETE')
                        <x-danger-button>Hapus Pendaftar</x-danger-button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
