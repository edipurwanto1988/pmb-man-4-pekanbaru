<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
            <h2 class="mb-4 text-3xl lg:text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">{{ $data->title ?? 'Berita Terkini' }}</h2>
        </div> 
        <div class="grid gap-8 lg:grid-cols-3">
            @foreach($data->items ?? [] as $item)
            <article class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><a href="#">{{ $item->title ?? '' }}</a></h2>
                <p class="mb-5 font-light text-gray-500 dark:text-gray-400">{{ $item->excerpt ?? '' }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">{{ $item->date ?? '' }}</span>
                    <a href="#" class="inline-flex items-center font-medium hover:underline" style="color: #16a34a;">
                        Read more
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
