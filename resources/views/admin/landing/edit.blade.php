<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Section: {{ $section->module->nama_modul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.landing-page.update', $section->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <!-- Common: Title -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $content['title'] ?? '')" />
                        </div>

                        <!-- Module Specific Fields -->
                        @if($section->module->kode_modul == 'hero')
                            <div class="mb-4">
                                <x-input-label for="subtitle" :value="__('Subtitle')" />
                                <x-text-input id="subtitle" class="block mt-1 w-full" type="text" name="subtitle" :value="old('subtitle', $content['subtitle'] ?? '')" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="image" :value="__('Background Image')" />
                                <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100"/>
                                @if(isset($content['image']))
                                    <img src="{{ asset($content['image']) }}" class="h-20 mt-2 rounded">
                                @endif
                            </div>
                            <div class="mb-4 grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="cta_text" :value="__('CTA Text')" />
                                    <x-text-input id="cta_text" class="block mt-1 w-full" type="text" name="cta_text" :value="old('cta_text', $content['cta_text'] ?? '')" />
                                </div>
                                <div>
                                    <x-input-label for="cta_link" :value="__('CTA Link')" />
                                    <x-text-input id="cta_link" class="block mt-1 w-full" type="text" name="cta_link" :value="old('cta_link', $content['cta_link'] ?? '')" />
                                </div>
                            </div>
                        @endif

                        @if($section->module->kode_modul == 'sambutan')
                            <div class="mb-4">
                                <x-input-label for="content" :value="__('Content')" />
                                <textarea name="content" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="5">{{ old('content', $content['content'] ?? '') }}</textarea>
                            </div>
                            <div class="mb-4">
                                <x-input-label for="nama_kepsek" :value="__('Nama Kepala Madrasah')" />
                                <x-text-input id="nama_kepsek" class="block mt-1 w-full" type="text" name="nama_kepsek" :value="old('nama_kepsek', $content['nama_kepsek'] ?? '')" />
                            </div>
                             <div class="mb-4">
                                <x-input-label for="image" :value="__('Foto Kepala Madrasah')" />
                                <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100"/>
                                @if(isset($content['image']))
                                    <img src="{{ asset($content['image']) }}" class="h-20 mt-2 rounded">
                                @endif
                            </div>
                        @endif

                        <!-- Dynamic Items (Jurusan, FAQ, etc) -->
                         @if(in_array($section->module->kode_modul, ['jurusan', 'faq', 'alur']))
                            <div class="mb-4 border-t pt-4">
                                <h3 class="text-lg font-medium mb-2">Items</h3>
                                <div id="items-container" class="space-y-4">
                                    @foreach($content['items'] ?? [] as $index => $item)
                                        <div class="p-4 border rounded bg-gray-50 item-row">
                                             @if($section->module->kode_modul == 'jurusan')
                                                <input type="text" name="items[{{$index}}][nama]" value="{{ $item['nama'] ?? '' }}" placeholder="Nama Jurusan" class="mb-2 w-full border-gray-300 rounded">
                                                <textarea name="items[{{$index}}][desc]" placeholder="Deskripsi" class="w-full border-gray-300 rounded">{{ $item['desc'] ?? '' }}</textarea>
                                             @elseif($section->module->kode_modul == 'faq')
                                                <input type="text" name="items[{{$index}}][question]" value="{{ $item['question'] ?? '' }}" placeholder="Question" class="mb-2 w-full border-gray-300 rounded">
                                                <textarea name="items[{{$index}}][answer]" placeholder="Answer" class="w-full border-gray-300 rounded">{{ $item['answer'] ?? '' }}</textarea>
                                             @elseif($section->module->kode_modul == 'alur')
                                                <input type="text" name="items[{{$index}}][title]" value="{{ $item['title'] ?? '' }}" placeholder="Judul Tahapan" class="mb-2 w-full border-gray-300 rounded">
                                                <textarea name="items[{{$index}}][desc]" placeholder="Deskripsi" class="w-full border-gray-300 rounded">{{ $item['desc'] ?? '' }}</textarea>
                                             @endif
                                             <button type="button" onclick="this.parentElement.remove()" class="text-red-500 text-sm mt-2">Remove Item</button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-item" class="mt-2 text-blue-600 hover:underline">+ Add New Item</button>
                                
                                <template id="item-template">
                                    <div class="p-4 border rounded bg-gray-50 item-row">
                                        @if($section->module->kode_modul == 'jurusan')
                                            <input type="text" name="items[INDEX][nama]" placeholder="Nama Jurusan" class="mb-2 w-full border-gray-300 rounded">
                                            <textarea name="items[INDEX][desc]" placeholder="Deskripsi" class="w-full border-gray-300 rounded"></textarea>
                                        @elseif($section->module->kode_modul == 'faq')
                                            <input type="text" name="items[INDEX][question]" placeholder="Question" class="mb-2 w-full border-gray-300 rounded">
                                            <textarea name="items[INDEX][answer]" placeholder="Answer" class="w-full border-gray-300 rounded"></textarea>
                                        @elseif($section->module->kode_modul == 'alur')
                                            <input type="text" name="items[INDEX][title]" placeholder="Judul Tahapan" class="mb-2 w-full border-gray-300 rounded">
                                            <textarea name="items[INDEX][desc]" placeholder="Deskripsi" class="w-full border-gray-300 rounded"></textarea>
                                        @endif
                                        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 text-sm mt-2">Remove Item</button>
                                    </div>
                                </template>

                                <script>
                                    document.getElementById('add-item').addEventListener('click', function() {
                                        let container = document.getElementById('items-container');
                                        let template = document.getElementById('item-template');
                                        if(template) {
                                            let index = container.children.length + Math.floor(Math.random() * 1000); // Unique index
                                            let clone = template.content.cloneNode(true);
                                            // Handle text replacement carefully to avoid breaking HTML
                                            let div = clone.querySelector('div');
                                            div.innerHTML = div.innerHTML.replace(/INDEX/g, index);
                                            container.appendChild(clone);
                                        }
                                    });
                                </script>
                            </div>
                         @endif

                         @if($section->module->kode_modul == 'kontak')
                            <div class="mb-4">
                                <x-input-label for="subtitle" :value="__('Subtitle')" />
                                <x-text-input id="subtitle" class="block mt-1 w-full" type="text" name="subtitle" :value="old('subtitle', $content['subtitle'] ?? '')" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="address" :value="__('Address')" />
                                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address', $content['address'] ?? '')" />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                     <x-input-label for="email" :value="__('Email')" />
                                     <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $content['email'] ?? '')" />
                                </div>
                                <div>
                                     <x-input-label for="phone" :value="__('Phone')" />
                                     <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $content['phone'] ?? '')" />
                                </div>
                            </div>
                         @endif

                        <div class="flex items-center justify-end mt-4 gap-4">
                            <a href="{{ route('admin.landing-page.index') }}" class="text-gray-600 underline">Cancel</a>
                            <x-primary-button>Update Section</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
