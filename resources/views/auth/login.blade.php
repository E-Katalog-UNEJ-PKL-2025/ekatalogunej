<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="flex w-full max-w-5xl bg-white rounded-lg shadow-lg overflow-hidden">

            <div class="hidden md:flex flex-col items-center justify-center w-5/12 bg-unej-green text-white p-12">
                <img src="{{ asset('images/logo-unej.png') }}" alt="Logo UNEJ" class="w-32 h-32 mb-4">
                <h1 class="text-3xl font-bold mb-2">E-Katalog</h1>
                <p class="text-center">Universitas Jember</p>
            </div>

            <div class="w-full md:w-7/12 p-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Login Akun</h2>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" value="Password" />
                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-unej-green shadow-sm focus:ring-unej-green" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        @if (Route::has('register'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                                Belum punya akun?
                            </a>
                        @endif

                        <x-primary-button class="ms-3 bg-unej-green hover:bg-opacity-90">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>