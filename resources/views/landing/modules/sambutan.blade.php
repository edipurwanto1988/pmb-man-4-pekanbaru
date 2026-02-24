<section id="sambutan" class="bg-white dark:bg-gray-900">
    <div class="gap-12 items-center py-12 px-4 mx-auto max-w-screen-xl lg:grid lg:grid-cols-2 lg:py-20 lg:px-6">

        {{-- Teks sambutan --}}
        <div class="font-light text-gray-500 sm:text-lg dark:text-gray-400">
            <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full mb-4 uppercase tracking-widest">Sambutan</span>
            <h2 class="mb-5 text-3xl tracking-tight font-extrabold text-gray-900 dark:text-white leading-tight">
                {{ $data->title ?? 'Sambutan Kepala Madrasah' }}
            </h2>
            <p class="mb-6 leading-relaxed text-gray-600 dark:text-gray-400">
                {{ $data->content ?? 'Isi sambutan...' }}
            </p>
            <div class="mt-4 text-left">
                <p class="font-bold text-gray-900 dark:text-white text-base">{{ $data->nama_kepsek ?? 'Kepala Madrasah' }}</p>
                <p class="text-sm text-gray-500">Kepala MAN 4 Kota Pekanbaru</p>
            </div>
        </div>

        {{-- Foto kepsek --}}
        <div class="flex justify-center mt-10 lg:mt-0">
            <div class="text-center">
                <img
                    src="{{ asset($data->image ?? 'kepsek-man-4.png') }}"
                    alt="{{ $data->nama_kepsek ?? 'Kepala Madrasah' }}"
                    class="w-48 h-56 object-cover object-top rounded-xl shadow-lg mx-auto border-4 border-green-100"
                    onerror="this.src='https://ui-avatars.com/api/?name=Kepala+Madrasah&size=200&background=16a34a&color=fff&rounded=true'"
                >
                <p class="mt-3 text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $data->nama_kepsek ?? 'Kepala Madrasah' }}</p>
                <p class="text-xs text-gray-400">Kepala MAN 4 Kota Pekanbaru</p>
            </div>
        </div>

    </div>
</section>

