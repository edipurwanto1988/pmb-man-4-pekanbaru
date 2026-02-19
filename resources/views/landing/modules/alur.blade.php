<section class="bg-white dark:bg-gray-900" id="alur">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <div class="mx-auto max-w-screen-sm text-center mb-8 lg:mb-16">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">{{ $data->title ?? 'Alur Pendaftaran' }}</h2>
            <p class="font-light text-gray-500 lg:mb-16 sm:text-xl dark:text-gray-400">{{ $data->subtitle ?? 'Ikuti langkah mudah berikut ini' }}</p>
        </div> 
        <div class="grid gap-8 mb-6 lg:mb-16 md:grid-cols-3">
            @foreach($data->items ?? [] as $index => $item)
            <div class="text-center text-gray-500 dark:text-gray-400">
                <div class="flex justify-center items-center mb-4 w-12 h-12 rounded-full mx-auto" style="background-color: #dcfce7;">
                    <span class="text-xl font-bold" style="color: #16a34a;">{{ $loop->iteration }}</span>
                </div>
                <h3 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $item->title ?? '' }}</h3>
                <p>{{ $item->desc ?? '' }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
