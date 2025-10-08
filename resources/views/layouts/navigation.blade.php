<div class="hidden sm:flex sm:items-center sm:ms-6">
    @if(session()->has('original_user_id'))
        {{-- Tampilan saat sedang beralih peran --}}
        <div class="flex items-center text-sm text-gray-500">
            <span class="mr-2">Login sebagai: <strong class="font-semibold capitalize">{{ session('switched_to_role') }}</strong></span>
            <a href="{{ route('admin.roles.revert') }}" class="px-3 py-1.5 border border-yellow-500 text-yellow-600 rounded-md hover:bg-yellow-500 hover:text-white transition-colors">
                Kembali ke Admin!
            </a>
        </div>
    @elseif(Auth::user()->hasRole('admin'))
        {{-- Dropdown untuk Admin asli --}}
        <form action="{{ route('admin.roles.switch') }}" method="POST" class="flex items-center">
            @csrf
            <label for="role-switcher" class="text-sm text-gray-500 mr-2">Switch Role:</label>
            <select name="role" id="role-switcher" class="border-gray-300 rounded-md shadow-sm text-sm py-1" onchange="this.form.submit()">
                <option value="admin">Admin</option>
                <option value="supplier">Supplier</option>
                <option value="verifikator">Verifikator</option>
                <option value="pimpinan">Pimpinan</option>
                <option value="operator_fakultas">Operator Fakultas</option>
            </select>
        </form>
    @endif

    {{-- Dropdown Nama Pengguna --}}
    <div class="ms-3 relative">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    <div>{{ Auth::user()->name }}</div>
                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</div>