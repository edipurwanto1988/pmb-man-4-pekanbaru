<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Jadwal PMB</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if($jadwals->count() > 0)
                <div class="space-y-4">
                    @foreach($jadwals as $jadwal)
                        @php
                            $isOngoing = now()->between($jadwal->waktu_mulai, $jadwal->waktu_selesai);
                            $isPast = now()->gt($jadwal->waktu_selesai);
                            $isUpcoming = now()->lt($jadwal->waktu_mulai);
                        @endphp
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 {{ $isOngoing ? 'border-l-4 border-green-500' : '' }} {{ $isPast ? 'opacity-60' : '' }}">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $jadwal->nama_kegiatan }}</h3>
                                        @if($isOngoing)
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 animate-pulse">Berlangsung</span>
                                        @elseif($isPast)
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">Selesai</span>
                                        @else
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Akan Datang</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-indigo-600 dark:text-indigo-400">
                                        {{ ucfirst(str_replace('_', ' ', $jadwal->jenis)) }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $jadwal->waktu_mulai->format('d M Y') }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $jadwal->waktu_mulai->format('H:i') }} - {{ $jadwal->waktu_selesai->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                            @if($jadwal->keterangan)
                                <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">{{ $jadwal->keterangan }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="mt-4 text-gray-500 dark:text-gray-400">Belum ada jadwal yang diterbitkan.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
