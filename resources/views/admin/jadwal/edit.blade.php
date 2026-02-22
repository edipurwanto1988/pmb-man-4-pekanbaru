<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Jadwal</h2>
            <a href="{{ route('admin.jadwal.index') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"><i class="ri-arrow-left-line"></i> Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <x-input-label for="nama_kegiatan" value="Nama Kegiatan" />
                        <x-text-input id="nama_kegiatan" name="nama_kegiatan" class="mt-1 block w-full" :value="old('nama_kegiatan', $jadwal->nama_kegiatan)" required />
                    </div>
                    <div>
                        <x-input-label for="jenis" value="Jenis Kegiatan" />
                        <select name="jenis" id="jenis" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm">
                            @foreach(['pendaftaran','verifikasi','tes_akademik','tes_ibadah','pengumuman','daftar_ulang'] as $j)
                                <option value="{{ $j }}" {{ $jadwal->jenis == $j ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $j)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="waktu_mulai" value="Waktu Mulai" />
                            <input type="datetime-local" name="waktu_mulai" id="waktu_mulai" value="{{ $jadwal->waktu_mulai->format('Y-m-d\TH:i') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <x-input-label for="waktu_selesai" value="Waktu Selesai" />
                            <input type="datetime-local" name="waktu_selesai" id="waktu_selesai" value="{{ $jadwal->waktu_selesai->format('Y-m-d\TH:i') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm" required>
                        </div>
                    </div>
                    <div>
                        <x-input-label for="keterangan" value="Keterangan" />
                        <textarea name="keterangan" id="keterangan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm">{{ old('keterangan', $jadwal->keterangan) }}</textarea>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="aktif" value="1" id="aktif" {{ $jadwal->aktif ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 text-indigo-600">
                        <label for="aktif" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</label>
                    </div>
                    <div class="flex justify-between items-center">
                        <a href="{{ route('admin.jadwal.index') }}" class="inline-flex items-center gap-1 px-3 py-2 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            <i class="ri-close-line"></i> Batal
                        </a>
                        <x-primary-button><i class="ri-save-line mr-1"></i> Update Jadwal</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
