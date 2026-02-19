<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Upload Berkas Pendaftaran</h2>
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
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800 dark:text-blue-200">
                    <strong>Petunjuk:</strong> Upload semua berkas yang ditandai <span class="text-red-500">*wajib</span>. Format file yang diterima: JPG, JPEG, PNG, PDF. Maksimal 5MB per file.
                </p>
            </div>

            <div class="space-y-4">
                @foreach($jenisBerkas as $key => $info)
                    @php
                        $uploaded = $uploadedBerkas[$key] ?? null;
                    @endphp
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $info['label'] }}
                                    @if($info['required'])
                                        <span class="text-red-500 text-sm">*wajib</span>
                                    @else
                                        <span class="text-gray-400 text-sm">(opsional)</span>
                                    @endif
                                </h3>
                            </div>
                            @if($uploaded)
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $uploaded->status == 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                    {{ $uploaded->status == 'diterima' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                    {{ $uploaded->status == 'ditolak' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                    {{ $uploaded->status == 'perlu_perbaikan' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200' : '' }}
                                ">
                                    {{ ucfirst(str_replace('_', ' ', $uploaded->status)) }}
                                </span>
                            @endif
                        </div>

                        @if($uploaded)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg mb-3">
                                <div class="flex items-center">
                                    <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $uploaded->nama_file }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $uploaded->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ Storage::url($uploaded->path) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">Lihat</a>
                                    @if($uploaded->status != 'diterima')
                                        <form action="{{ route('siswa.berkas-awal.destroy', $uploaded->id) }}" method="POST" onsubmit="return confirm('Hapus berkas ini?')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-500 hover:underline text-sm">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            @if($uploaded->keterangan)
                                <div class="p-2 bg-yellow-50 dark:bg-yellow-900/20 rounded">
                                    <p class="text-sm text-yellow-800 dark:text-yellow-200"><strong>Keterangan:</strong> {{ $uploaded->keterangan }}</p>
                                </div>
                            @endif
                        @endif

                        @if(!$uploaded || $uploaded->status != 'diterima')
                            <form action="{{ route('siswa.berkas-awal.store') }}" method="POST" enctype="multipart/form-data" class="flex gap-3 items-end mt-3">
                                @csrf
                                <input type="hidden" name="jenis_berkas" value="{{ $key }}">
                                <div class="flex-1">
                                    <input type="file" name="file" accept=".jpg,.jpeg,.png,.pdf" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300">
                                </div>
                                <x-primary-button>{{ $uploaded ? 'Ganti' : 'Upload' }}</x-primary-button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
