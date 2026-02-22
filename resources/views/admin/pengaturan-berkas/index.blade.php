<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="ri-file-settings-line mr-2"></i>Pengaturan Berkas Pendaftaran
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg flex items-center gap-2">
                    <i class="ri-checkbox-circle-line text-lg"></i> {{ session('success') }}
                </div>
            @endif

            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mb-6 flex items-start gap-2">
                <i class="ri-information-line text-blue-500 text-lg mt-0.5 flex-shrink-0"></i>
                <p class="text-sm text-blue-800 dark:text-blue-200">
                    Atur jenis berkas yang harus diupload oleh calon siswa saat pendaftaran. 
                    Berkas <strong>wajib</strong> harus diupload sebelum status berubah ke <em>menunggu verifikasi</em>.
                </p>
            </div>

            <div class="space-y-4">
                @foreach($pengaturan as $item)
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-5">
                    <form action="{{ route('admin.pengaturan-berkas.update', $item->id) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="flex flex-col gap-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold"
                                          style="background:#e0e7ff;color:#4338ca;">
                                        {{ $loop->iteration }}
                                    </span>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100 text-sm">Kode: <code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded text-xs">{{ $item->kode }}</code></span>
                                </div>
                                {{-- Status badge --}}
                                @if($item->aktif)
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300">Aktif</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">Nonaktif</span>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Label --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Label / Nama Berkas</label>
                                    <input type="text" name="label" value="{{ $item->label }}"
                                           class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm text-sm"
                                           required>
                                </div>

                                {{-- Urutan --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Urutan Tampil</label>
                                    <input type="number" name="urutan" value="{{ $item->urutan }}" min="0"
                                           class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm text-sm">
                                </div>

                                {{-- Wajib --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis</label>
                                    <select name="wajib" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm text-sm">
                                        <option value="1" {{ $item->wajib ? 'selected' : '' }}>⭐ Wajib</option>
                                        <option value="0" {{ !$item->wajib ? 'selected' : '' }}>📎 Opsional</option>
                                    </select>
                                </div>

                                {{-- Aktif --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                    <select name="aktif" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm text-sm">
                                        <option value="1" {{ $item->aktif ? 'selected' : '' }}>✅ Aktif (tampil ke siswa)</option>
                                        <option value="0" {{ !$item->aktif ? 'selected' : '' }}>🚫 Nonaktif (sembunyikan)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex justify-end pt-1">
                                <button type="submit"
                                        style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:6px;font-size:13px;font-weight:600;background:#4f46e5;color:#fff;border:none;cursor:pointer;">
                                    <i class="ri-save-line"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
