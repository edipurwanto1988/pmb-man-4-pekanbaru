<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Upload Berkas Daftar Ulang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Student Info -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-green-500 flex items-center justify-center">
                            <span class="text-white font-bold text-lg">{{ strtoupper(substr($calonSiswa->nama_lengkap, 0, 1)) }}</span>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">{{ $calonSiswa->nama_lengkap }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">NISN: {{ $calonSiswa->nisn }}</p>
                        </div>
                        <div class="ml-auto">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $calonSiswa->status == 'daftar_ulang' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                {{ ucfirst(str_replace('_', ' ', $calonSiswa->status)) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Progress -->
            @php
                $totalSyarat = $syarats->where('is_wajib', true)->count();
                $uploadedWajib = 0;
                foreach ($syarats->where('is_wajib', true) as $s) {
                    if (isset($uploadedBerkas[$s->id]) && $uploadedBerkas[$s->id]->count() > 0) {
                        $uploadedWajib++;
                    }
                }
                $progress = $totalSyarat > 0 ? round(($uploadedWajib / $totalSyarat) * 100) : 0;
            @endphp
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-700 dark:text-gray-300 font-medium">Progress Berkas Wajib</span>
                        <span class="text-gray-500 dark:text-gray-400">{{ $uploadedWajib }}/{{ $totalSyarat }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        <div class="bg-green-500 h-3 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Syarat Cards -->
            <div class="space-y-4">
                @foreach($syarats as $syarat)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $syarat->nama_syarat }}
                                        @if($syarat->is_wajib)
                                            <span class="text-red-500 text-sm">*wajib</span>
                                        @else
                                            <span class="text-gray-400 text-sm">(opsional)</span>
                                        @endif
                                    </h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Format: <span class="font-medium">{{ strtoupper(str_replace('_', ' / ', $syarat->tipe_file)) }}</span>
                                        • Max: 5MB
                                        @if($syarat->is_multiple)
                                            • <span class="text-blue-500">Multiple upload</span>
                                        @endif
                                    </p>
                                    @if($syarat->keterangan)
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 italic">{{ $syarat->keterangan }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Uploaded Files -->
                            @if(isset($uploadedBerkas[$syarat->id]) && $uploadedBerkas[$syarat->id]->count() > 0)
                                <div class="mt-4 space-y-2">
                                    @foreach($uploadedBerkas[$syarat->id] as $berkas)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <div class="flex items-center">
                                                @if(str_contains($berkas->mime_type, 'image'))
                                                    <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                    </svg>
                                                @endif
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $berkas->nama_file }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        Diupload: {{ $berkas->created_at->format('d M Y, H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <!-- Status Badge -->
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                    {{ $berkas->status == 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                                    {{ $berkas->status == 'verified' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                                    {{ $berkas->status == 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                                ">
                                                    {{ ucfirst($berkas->status) }}
                                                </span>

                                                <!-- View Link -->
                                                <a href="{{ Storage::url($berkas->path) }}" target="_blank" class="text-blue-500 hover:text-blue-700">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>

                                                <!-- Delete -->
                                                @if($berkas->status !== 'verified')
                                                    <form action="{{ route('siswa.berkas.destroy', $berkas->id) }}" method="POST" onsubmit="return confirm('Yakin hapus berkas ini?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>

                                        @if($berkas->status == 'rejected' && $berkas->catatan)
                                            <div class="ml-11 p-2 bg-red-50 dark:bg-red-900/30 rounded text-sm text-red-600 dark:text-red-300">
                                                <strong>Catatan:</strong> {{ $berkas->catatan }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            <!-- Upload Form -->
                            @php
                                $canUpload = $syarat->is_multiple || !isset($uploadedBerkas[$syarat->id]) || $uploadedBerkas[$syarat->id]->count() == 0;
                            @endphp
                            @if($canUpload)
                                <form action="{{ route('siswa.berkas.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="syarat_id" value="{{ $syarat->id }}">
                                    <div class="flex items-center gap-3">
                                        <input type="file" name="file" required
                                            accept="{{ $syarat->tipe_file == 'image' ? 'image/jpeg,image/png' : ($syarat->tipe_file == 'pdf' ? 'application/pdf' : 'image/jpeg,image/png,application/pdf') }}"
                                            class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300">
                                        <x-primary-button class="whitespace-nowrap">Upload</x-primary-button>
                                    </div>
                                    @if($errors->has('file'))
                                        <p class="text-red-500 text-sm mt-1">{{ $errors->first('file') }}</p>
                                    @endif
                                </form>
                            @else
                                <p class="mt-4 text-sm text-gray-500 dark:text-gray-400 italic">
                                    Berkas sudah diupload. Hapus terlebih dahulu untuk mengganti.
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
