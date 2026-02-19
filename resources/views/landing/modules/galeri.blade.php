<section class="bg-gray-50 dark:bg-gray-800">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <div class="mx-auto max-w-screen-sm text-center mb-8 lg:mb-16">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">{{ $data->title ?? 'Galeri Kegiatan' }}</h2>
        </div> 
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($data->items ?? [] as $item)
            <div class="grid gap-4">
                <div>
                    <img class="h-auto max-w-full rounded-lg" src="{{ str_starts_with($item->image ?? '', 'http') ? $item->image : asset($item->image ?? '') }}" alt="{{ $item->caption ?? '' }}">
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
