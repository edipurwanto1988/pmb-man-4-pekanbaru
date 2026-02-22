@php
    $fotoItems = collect($data->items ?? [])->filter(fn($item) => !empty($item->foto))->values();
@endphp

@if($fotoItems->isNotEmpty())
<section class="bg-gray-50 py-12 px-4">
    <div class="mx-auto max-w-screen-xl">
        {{-- Judul --}}
        <div class="text-center mb-10">
            <h2 class="text-4xl font-extrabold tracking-tight text-gray-900">
                {{ $data->title ?? 'Galeri Kegiatan' }}
            </h2>
            <p class="mt-2 text-gray-500 text-sm">Dokumentasi kegiatan MAN 4 Kota Pekanbaru</p>
        </div>

        {{-- Grid Foto --}}
        <div class="columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4">
            @foreach($fotoItems as $item)
                <div class="break-inside-avoid overflow-hidden rounded-lg shadow group relative">
                    <img
                        class="w-full object-cover transition-transform duration-300 group-hover:scale-105"
                        src="{{ asset($item->foto) }}"
                        alt="{{ $item->caption ?? '' }}"
                        onerror="this.parentElement.style.display='none'"
                    >
                    @if(!empty($item->caption))
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <p class="text-white text-xs font-medium">{{ $item->caption }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
