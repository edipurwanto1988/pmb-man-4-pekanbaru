<section class="bg-gray-50 dark:bg-gray-800" id="kontak">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-16">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">{{ $data->title ?? 'Kontak Kami' }}</h2>
            <p class="font-light text-gray-500 dark:text-gray-400 sm:text-xl">{{ $data->subtitle ?? 'Hubungi panitia PMB untuk informasi lebih lanjut.' }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white dark:bg-gray-900 p-8 rounded-lg shadow-lg">
                <h3 class="mb-4 text-2xl font-bold dark:text-white">Alamat</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">{{ $data->address ?? 'Jl. Yos Sudarso KM. 15, Muara Fajar, Rumbai Barat, Pekanbaru' }}</p>
                
                <h3 class="mb-4 text-2xl font-bold dark:text-white">Telepon</h3>
                <p class="text-gray-500 dark:text-gray-400">{{ $data->phone ?? '081268713026 (HUMAS)' }}</p>
            </div>
            <div class="h-96 bg-gray-300 rounded-lg overflow-hidden">
                <!-- Embed Map -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15958.4636652416!2d101.4429!3d0.6405!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMzgnMjUuOCJOIDEwMcKwMjYnMzQuNCJF!5e0!3m2!1sen!2sid!4v1634567890123!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>
