<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Izin untuk Role: <span class="capitalize font-bold">{{ $role->name }}</span>
        </h2>
    </x-slot>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <a href="{{ route('admin.roles.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900 mb-4 inline-block">&larr; Kembali ke Daftar Role</a>

            <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    @php
                        $groupedPermissions = $permissions->groupBy(function($item, $key) {
                            return explode('.', $item->name)[0];
                        });
                    @endphp

                    @foreach ($groupedPermissions as $groupName => $permissionGroup)
                        <div class="border rounded-lg p-4">
                            <h4 class="font-bold capitalize mb-2">{{ str_replace('_', ' ', $groupName) }}</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach ($permissionGroup as $permission)
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                               class="rounded border-gray-300 text-unej-primary shadow-sm focus:ring-unej-green"
                                               @if($role->hasPermissionTo($permission->name)) checked @endif>
                                        <span class="ml-2 text-sm">{{ explode('.', $permission->name)[1] }}</span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    <x-primary-button class="bg-unej-action">Simpan Perubahan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>