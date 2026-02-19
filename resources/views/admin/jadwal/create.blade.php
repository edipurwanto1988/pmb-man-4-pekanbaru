<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tambah Jadwal</h2>
            <a href="{{ route('admin.jadwal.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="nama_kegiatan" value="Nama Kegiatan" />
                        <x-text-input id="nama_kegiatan" name="nama_kegiatan" class="mt-1 block w-full" :value="old('nama_kegiatan')" required />
                        <x-input-error :messages="$errors->get('nama_kegiatan')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="jenis" value="Jenis Kegiatan" />
                        <select name="jenis" id="jenis" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm">
                            <option value="pendaftaran">Pendaftaran</option>
                            <option value="verifikasi">Verifikasi</option>
                            <option value="tes_akademik">Tes Akademik</option>
                            <option value="tes_ibadah">Tes Ibadah</option>
                            <option value="pengumuman">Pengumuman</option>
                            <option value="daftar_ulang">Daftar Ulang</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="waktu_mulai" value="Waktu Mulai" />
                            <input type="datetime-local" name="waktu_mulai" id="waktu_mulai" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm" required>
                            <x-input-error :messages="$errors->get('waktu_mulai')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="waktu_selesai" value="Waktu Selesai" />
                            <input type="datetime-local" name="waktu_selesai" id="waktu_selesai" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm" required>
                            <x-input-error :messages="$errors->get('waktu_selesai')" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="keterangan" value="Keterangan" />
                        <textarea name="keterangan" id="keterangan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm">{{ old('keterangan') }}</textarea>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="aktif" value="1" id="aktif" checked class="rounded border-gray-300 dark:border-gray-600 text-indigo-600">
                        <label for="aktif" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</label>
                    </div>
                    <div class="flex justify-end">
                        <x-primary-button>Simpan Jadwal</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
