<section class="bg-gray-50 dark:bg-gray-800">
    <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
        <div class="max-w-screen-md mb-8 lg:mb-16">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">{{ $data->title ?? 'Program Unggulan' }}</h2>
        </div>
        <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0">
            @foreach($data->items ?? [] as $item)
            <div>
                <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-green-100 lg:h-12 lg:w-12 dark:bg-green-900">
                    <svg class="w-5 h-5 text-green-600 lg:w-6 lg:h-6 dark:text-green-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 00-1-1H3zm6 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                </div>
                <h3 class="mb-2 text-xl font-bold dark:text-white">{{ $item->nama ?? '' }}</h3>
                <p class="text-gray-500 dark:text-gray-400">{{ $item->desc ?? '' }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
