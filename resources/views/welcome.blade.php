<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>E-Katalog Universitas Jember</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white" style="background-color: #0F2D37;">

            {{-- Tombol Login/Register di pojok kanan atas --}}
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-white hover:text-gray-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-white hover:text-gray-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-white hover:text-gray-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            {{-- Konten Utama Landing Page --}}
            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex flex-col md:flex-row items-center justify-center">
                    
                    {{-- BAGIAN KANAN (LOGO) DIPINDAH KE SINI --}}
                    <div class="w-full md:w-1/2 flex justify-center mb-8 md:mb-0">
                        <img src="{{ asset('images/logo-unej.png') }}" alt="Logo UNEJ" class="w-64 h-64 md:w-80 md:h-80">
                    </div>

                    {{-- BAGIAN KIRI (TEKS) SEKARANG DI KANAN --}}
                    <div class="w-full md:w-1/2 text-white text-center md:text-left pl-0 md:pl-16">
                        <h1 class="text-5xl font-bold mb-4">E-Catalog</h1>
                        <p class="text-lg text-gray-300">
                            Mendukung transparansi dan efisiensi proses pengelolaan kegiatan di lingkungan fakultas/universitas, dibutuhkan sebuah sistem informasi yang mampu memfasilitasi pengajuan acara, pengelolaan dokumen, hingga pendaftaran produk/jasa dari supplier eksternal.
                        </p>
                        <div class="mt-8">
                            <a href="{{ route('login') }}" class="inline-block bg-unej-yellow text-gray-900 font-bold py-3 px-8 rounded-lg hover:bg-yellow-400 transition-colors">
                                Mulai Sekarang!
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>