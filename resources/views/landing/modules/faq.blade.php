<section class="bg-white dark:bg-gray-900" id="faq">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-16">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">{{ $data->title ?? 'FAQ' }}</h2>
        </div>
        <div class="w-full">
            @foreach($data->items ?? [] as $item)
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700 pb-4">
                <h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
                    <svg class="flex-shrink-0 mr-2 w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 111.731-1.332 9 9 0 012.3 2 9 9 0 01-1.733 1.332 1.002 1.002 0 00-.865.5 1 1 0 00-1.735 1.332 1.001 1.001 0 00-.865.5H9a1 1 0 000-2h.001a1 1 0 111.998-.002A1 1 0 009 13V7a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    {{ $item->question ?? '' }}
                </h3>
                <div class="text-gray-500 dark:text-gray-400">
                    <p>{{ $item->answer ?? '' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
