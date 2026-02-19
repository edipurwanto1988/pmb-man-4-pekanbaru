<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Role: {{ $role->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Role Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $role->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            @if(in_array($role->name, ['admin', 'calon_siswa']))
                                <p class="text-xs text-yellow-600 mt-1">Warning: Renaming system roles might affect application logic.</p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <span class="block font-medium text-sm text-gray-700 mb-2">Permissions</span>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 border p-4 rounded bg-gray-50">
                                @foreach($permissions as $permission)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600">{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.roles.index') }}" class="text-gray-600 underline mr-4">Cancel</a>
                            <x-primary-button>
                                {{ __('Update Role') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
