<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Syarat: {{ $syarat->nama_syarat }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('admin.syarat.update', $syarat->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="nama_syarat" :value="__('Nama Syarat')" />
                            <x-text-input id="nama_syarat" class="block mt-1 w-full" type="text" name="nama_syarat" :value="old('nama_syarat', $syarat->nama_syarat)" required />
                            <x-input-error :messages="$errors->get('nama_syarat')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tipe_file" :value="__('Tipe File yang Diterima')" />
                            <select id="tipe_file" name="tipe_file" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="image" {{ old('tipe_file', $syarat->tipe_file) == 'image' ? 'selected' : '' }}>Image (JPG, PNG)</option>
                                <option value="pdf" {{ old('tipe_file', $syarat->tipe_file) == 'pdf' ? 'selected' : '' }}>PDF</option>
                                <option value="image_pdf" {{ old('tipe_file', $syarat->tipe_file) == 'image_pdf' ? 'selected' : '' }}>Image atau PDF</option>
                            </select>
                            <x-input-error :messages="$errors->get('tipe_file')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="inline-flex items-center mt-2">
                                    <input type="checkbox" name="is_wajib" value="1" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" {{ old('is_wajib', $syarat->is_wajib) ? 'checked' : '' }}>
                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Wajib Diupload') }}</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center mt-2">
                                    <input type="checkbox" name="is_multiple" value="1" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" {{ old('is_multiple', $syarat->is_multiple) ? 'checked' : '' }}>
                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Boleh Upload Multiple File') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center mt-2">
                                <input type="checkbox" name="is_active" value="1" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" {{ old('is_active', $syarat->is_active) ? 'checked' : '' }}>
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Aktif') }}</span>
                            </label>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="keterangan" :value="__('Keterangan (Opsional)')" />
                            <textarea id="keterangan" name="keterangan" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('keterangan', $syarat->keterangan) }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('admin.syarat.index') }}" class="text-gray-600 dark:text-gray-400 underline">Batal</a>
                            <x-primary-button>{{ __('Perbarui Syarat') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
