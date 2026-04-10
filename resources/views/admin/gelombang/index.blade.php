<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Kelola Gelombang</h2>
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-modal')" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="ri-add-line mr-1"></i> Tambah Gelombang
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Gelombang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status Aktif</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($items as $index => $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $item->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if($item->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Aktif</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-modal-{{ $item->id }}')" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3"><i class="ri-edit-line"></i> Edit</button>
                                
                                <form action="{{ route('admin.gelombang.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"><i class="ri-delete-bin-line"></i> Hapus</button>
                                </form>

                                <!-- Edit Modal -->
                                <x-modal name="edit-modal-{{ $item->id }}" focusable>
                                    <form method="POST" action="{{ route('admin.gelombang.update', $item->id) }}" class="p-6">
                                        @csrf
                                        @method('PUT')
                                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            Edit Gelombang
                                        </h2>
                                        <div class="mt-6">
                                            <x-input-label for="nama_{{ $item->id }}" value="Nama Gelombang" />
                                            <x-text-input id="nama_{{ $item->id }}" name="nama" type="text" class="mt-1 block w-full" value="{{ $item->nama }}" required />
                                        </div>
                                        <div class="mt-4 flex items-center">
                                            <input id="is_active_{{ $item->id }}" name="is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ $item->is_active ? 'checked' : '' }}>
                                            <label for="is_active_{{ $item->id }}" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Status Aktif</label>
                                        </div>
                                        <div class="mt-6 flex justify-end">
                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                Batal
                                            </x-secondary-button>
                                            <x-primary-button class="ml-3">
                                                Simpan
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </x-modal>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">Belum ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Create Modal -->
            <x-modal name="create-modal" focusable>
                <form method="POST" action="{{ route('admin.gelombang.store') }}" class="p-6">
                    @csrf
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Tambah Gelombang
                    </h2>
                    <div class="mt-6">
                        <x-input-label for="nama" value="Nama Gelombang (Contoh: Gelombang 1)" />
                        <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" required autofocus />
                    </div>
                    <div class="mt-4 flex items-center">
                        <input id="is_active" name="is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Status Aktif</label>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            Batal
                        </x-secondary-button>
                        <x-primary-button class="ml-3">
                            Simpan
                        </x-primary-button>
                    </div>
                </form>
            </x-modal>

        </div>
    </div>
</x-app-layout>
