<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Pengaturan PMB
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.pengaturan-pmb.update') }}" method="POST">
                        @csrf
                        
                        <!-- Toggle Tutup PMB -->
                        <div class="mb-6">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_tutup" value="1" class="sr-only peer" {{ $pengaturan->is_tutup ? 'checked' : '' }}>
                                <div class="relative w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Aktifkan Mode Tutup PMB</span>
                            </label>
                            <p class="mt-2 text-sm text-gray-500">Jika diaktifkan, pengunjung halaman depan akan melihat pesan khusus di bawah ini.</p>
                        </div>

                        <!-- Pesan Tutup PMB -->
                        <div class="mb-6">
                            <label for="pesan_tutup" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pesan Penutupan PMB</label>
                            <textarea id="pesan_tutup" name="pesan_tutup" rows="10" class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('pesan_tutup', $pengaturan->pesan_tutup) }}</textarea>
                            @error('pesan_tutup')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                Simpan Pengaturan
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include TinyMCE / Rich Text Editor -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#pesan_tutup',
            menubar: false,
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
            toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | code | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            height: 400
        });
    </script>
</x-app-layout>
