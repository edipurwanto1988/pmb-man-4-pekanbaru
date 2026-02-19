<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Landing Page Builder') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="mb-4 text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Add New Section -->
                    <form action="{{ route('admin.landing-page.store') }}" method="POST" class="mb-6 flex gap-4">
                        @csrf
                        <select name="landing_page_module_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Add New Section --</option>
                            @foreach($modules as $module)
                                <option value="{{ $module->id }}">{{ $module->nama_modul }}</option>
                            @endforeach
                        </select>
                        <x-primary-button>Add</x-primary-button>
                    </form>

                    <!-- List Sections -->
                    <ul id="section-list" class="space-y-4">
                        @foreach($sections as $section)
                            <li class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-lg shadow-sm" data-id="{{ $section->id }}">
                                <div class="flex items-center gap-4">
                                    <span class="cursor-move text-gray-400 hover:text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                    </span>
                                    <div>
                                        <h3 class="font-medium text-lg">{{ $section->module->nama_modul }}</h3>
                                        <span class="text-xs text-gray-500">Urutan: <span class="order-display">{{ $section->urutan }}</span></span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <!-- Toggle Active -->
                                    <button class="toggle-active px-3 py-1 text-xs font-semibold rounded-full {{ $section->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}" data-id="{{ $section->id }}">
                                        {{ $section->is_active ? 'Active' : 'Hidden' }}
                                    </button>
                                    
                                    <!-- Edit -->
                                    <a href="{{ route('admin.landing-page.edit', $section->id) }}" class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 hover:bg-amber-200 transition-colors" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </a>
                                    
                                    <!-- Delete -->
                                    <form action="{{ route('admin.landing-page.destroy', $section->id) }}" method="POST" onsubmit="return confirm('Delete this section?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 hover:bg-red-200 transition-colors" title="Hapus">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <!-- SortableJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('section-list');
            var sortable = Sortable.create(el, {
                handle: '.cursor-move',
                animation: 150,
                onEnd: function (evt) {
                    var order = [];
                    el.querySelectorAll('li').forEach(function (row, index) {
                        order.push({
                            id: row.getAttribute('data-id'),
                            position: index + 1
                        });
                        row.querySelector('.order-display').textContent = index + 1;
                    });

                    fetch("{{ route('admin.landing-page.reorder') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ order: order })
                    });
                }
            });

            // Toggle Active
            document.querySelectorAll('.toggle-active').forEach(function(button) {
                button.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');
                    fetch(`/admin/landing-page/toggle/${id}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.is_active) {
                            this.classList.remove('bg-red-100', 'text-red-800');
                            this.classList.add('bg-green-100', 'text-green-800');
                            this.textContent = 'Active';
                        } else {
                            this.classList.remove('bg-green-100', 'text-green-800');
                            this.classList.add('bg-red-100', 'text-red-800');
                            this.textContent = 'Hidden';
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
