<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>






<body>
    <div id="dashboardPage">
        <!-- Navbar -->
        <header class="navbar">
            <div class="navbar-left">
                <button id="mobile-menu-button" class="mobile-menu-button">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
                <div class="navbar-brand">
                    <a href="/dashboard">
                     <img src="{{ asset('images/logo-unej.png') }}" alt="Logo">
                    </a>
                    <h1>e-Catalog</h1>
                </div>
            </div>
            @if (Route::is('dashboard'))
            <div class="navbar-search">
                <input type="text" placeholder="Cari barang atau jasa">
                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            @elseif (Route::is('admin.roles.index'))
            <div class="navbar-center">
                Manajemen Role
            </div>
            @elseif (Route::is('admin.roles.create'))
            <div class="navbar-center">
                Manajemen Role > Tambah Role
            </div>
            @elseif (Route::is('admin.roles.edit'))
            <div class="navbar-center">
                Manajemen Role > Edit Role
            </div>
            @elseif (Route::is('admin.users.index'))
            <div class="navbar-center">
                Manajemen User
            </div>
            @elseif (Route::is('admin.users.create'))
            <div class="navbar-center">
                Manajemen User > Tambah User
            </div>
            @elseif (Route::is('admin.users.edit'))
            <div class="navbar-center">
                Manajemen User > Edit User
            </div>
            @elseif (Route::is('verificator.suppliers.*'))
            <div class="navbar-center">
                Verifikator Menu
            </div>
            @elseif (Route::is('products.index'))
            <div class="navbar-center">
                Produk Saya
            </div>
            @elseif (Route::is('products.create'))
            <div class="navbar-center">
                Produk Saya > Tambah Produk
            </div>
            @elseif (Route::is('products.edit'))
            <div class="navbar-center">
                Produk Saya > Edit Produk
            </div>
            @elseif (Route::is('documents.index'))
            <div class="navbar-center">
                Verifikasi Supplier
            </div>
            @elseif (Route::is('profile.index'))
            <div class="navbar-center">
                Profil Saya
            </div>
            @elseif (Route::is('profile.edit'))
            <div class="navbar-center">
                Ubah Password
            </div>
            @endif
            <div class="user-actions">
                <div class="role-switcher">
                    <div class="role-button" id="role-button">
                        <span class="arrow" style="color: blue">●</span>
                        @auth
                        <span id="current-role">{{ auth()->user()->getRoleNames()->first() }}</span>
                        @endauth
                        <span class="arrow" style="color: blue">●</span>
                    </div>
                    <div class="role-dropdown" id="role-dropdown">
                        <a href="#" data-role="admin">Admin</a>
                        <a href="#" data-role="operator">Operator</a>
                        <a href="#" data-role="pimpinan">Pimpinan</a>
                        <a href="#" data-role="verificator">Verificator</a>
                        <a href="#" data-role="supplier">Supplier</a>
                    </div>
                </div>
            
            <div class="navbar-right">
                
                <a href="{{route('profile.index')}}" class="profile-button-link">
                    <svg viewBox="0 0 20 20" fill="currentColor">{{ __('Profile') }}<path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                </a>
            </div>
        </header>

        <div class="dashboard-layout">
            <!-- Sidebar -->

            @include('layouts.partials.sidebar')

            <div class="main-content-wrapper">
                <!-- Main Content -->
                <main class="main-content">
                    <div class="container-fluid">
                        {{ $slot }}
                    </div>
                </main>
            </div>

        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
        