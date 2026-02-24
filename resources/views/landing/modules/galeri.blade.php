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
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach($fotoItems as $index => $item)
                <div class="overflow-hidden rounded-lg shadow group relative bg-gray-200 cursor-pointer"
                     style="height:180px;"
                     onclick="openLightbox({{ $index }})">
                    <img
                        class="w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-105"
                        src="{{ asset($item->foto) }}"
                        alt="{{ $item->caption ?? '' }}"
                        onerror="this.parentElement.style.display='none'"
                    >
                    {{-- Overlay hint klik --}}
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/25 transition-colors duration-300 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 drop-shadow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                        </svg>
                    </div>
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

{{-- ============ LIGHTBOX ============ --}}
<div id="lightbox" onclick="if(event.target===this)closeLightbox()"
    class="hidden fixed inset-0 z-50 flex items-center justify-center"
    style="background:rgba(0,0,0,0.88);">

    {{-- Tombol tutup --}}
    <button onclick="closeLightbox()" title="Tutup"
        style="position:absolute; top:16px; right:16px; z-index:60; background:rgba(255,255,255,0.15); border:none; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#fff; transition:background 0.2s;"
        onmouseover="this.style.background='rgba(255,255,255,0.35)'"
        onmouseout="this.style.background='rgba(255,255,255,0.15)'">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    {{-- Tombol prev --}}
    <button onclick="changeLightbox(-1)"
        class="absolute left-4 text-white text-4xl font-bold leading-none hover:text-gray-300 z-10 select-none">&#8249;</button>

    {{-- Gambar utama --}}
    <div class="flex flex-col items-center max-w-4xl w-full px-16">
        <img id="lightbox-img" src="" alt=""
            class="max-h-[80vh] max-w-full rounded-lg shadow-2xl object-contain">
        <p id="lightbox-caption" class="mt-3 text-white text-sm text-center opacity-80"></p>
        <p id="lightbox-counter" class="mt-1 text-gray-400 text-xs"></p>
    </div>

    {{-- Tombol next --}}
    <button onclick="changeLightbox(1)"
        class="absolute right-4 text-white text-4xl font-bold leading-none hover:text-gray-300 z-10 select-none">&#8250;</button>
</div>

<script>
const galeriData = @json($fotoItems->map(fn($item) => [
    'src'     => asset($item->foto),
    'caption' => $item->caption ?? '',
])->values());

let currentIndex = 0;

function openLightbox(index) {
    currentIndex = index;
    updateLightbox();
    document.getElementById('lightbox').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.body.style.overflow = '';
}

function changeLightbox(dir) {
    currentIndex = (currentIndex + dir + galeriData.length) % galeriData.length;
    updateLightbox();
}

function updateLightbox() {
    const item = galeriData[currentIndex];
    document.getElementById('lightbox-img').src = item.src;
    document.getElementById('lightbox-img').alt = item.caption;
    document.getElementById('lightbox-caption').textContent = item.caption;
    document.getElementById('lightbox-counter').textContent = (currentIndex + 1) + ' / ' + galeriData.length;
}

// Tutup dengan ESC, navigasi dengan arrow key
document.addEventListener('keydown', e => {
    if (document.getElementById('lightbox').classList.contains('hidden')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowRight') changeLightbox(1);
    if (e.key === 'ArrowLeft')  changeLightbox(-1);
});
</script>
@endif

