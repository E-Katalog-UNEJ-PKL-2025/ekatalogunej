<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6 max-w-lg mx-auto">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="name" value="Nama" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
                </div>

                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                </div>

                <div>
                    <x-input-label for="password" value="Password Baru (Opsional)" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                    <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password.</p>
                </div>

                <div>
                    <x-input-label for="role" value="Pilih Role" />
                    <select name="role" id="role" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        @if($user->hasRole('supplier'))

                            <option value="supplier" disabled class="text-red-500" title="Role 'supplier' tidak dapat diubah." @selected($user->hasRole('supplier'))>
                                supplier (Tidak Dapat Diubah) 
                            </option>

                        @else
                        @foreach($roles as $role)
                        {{-- Saya bingung kenapa tidak kedetect role user suppliernya --}}
                            
                            {{--  --}}

                            <option value="{{ $role->name }}" @selected($user->hasRole($role->name))>
                                {{ $role->name }}
                            </option>
                            
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button class="bg-unej-action">{{ __('Update') }}</x-primary-button>
                    <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>