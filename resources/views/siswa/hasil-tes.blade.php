<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Hasil Tes</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if($calonSiswa && $hasilTes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    @foreach($hasilTes as $tes)
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                            <div class="text-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Tes {{ ucfirst($tes->jenis_tes) }}</p>
                                <p class="text-5xl font-bold {{ $tes->status == 'lulus' ? 'text-green-600 dark:text-green-400' : ($tes->status == 'tidak_lulus' ? 'text-red-600 dark:text-red-400' : 'text-gray-500') }}">
                                    {{ $tes->nilai ?? '-' }}
                                </p>
                                <div class="mt-3">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                                        {{ $tes->status == 'lulus' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                        {{ $tes->status == 'tidak_lulus' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                        {{ $tes->status == 'belum_dinilai' ? 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200' : '' }}
                                    ">
                                        {{ ucfirst(str_replace('_', ' ', $tes->status)) }}
                                    </span>
                                </div>
                                @if($tes->tanggal_tes)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Tanggal: {{ $tes->tanggal_tes->format('d M Y') }}</p>
                                @endif
                                @if($tes->catatan)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 italic">{{ $tes->catatan }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Rata-rata -->
                @if($hasilTes->count() > 1)
                    @php $avg = $hasilTes->avg('nilai'); @endphp
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Rata-rata Nilai</p>
                        <p class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($avg, 1) }}</p>
                    </div>
                @endif
            @else
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <p class="mt-4 text-gray-500 dark:text-gray-400">Belum ada hasil tes yang tersedia.</p>
                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Hasil tes akan ditampilkan setelah panitia menginput nilai.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
