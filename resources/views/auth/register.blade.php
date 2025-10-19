<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-g">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>e-Catalog - Login</title>
    <link rel="stylesheet" href="css/auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
</head>
<body>
    <div id="registerPage" class="page auth-page">
        <a href="/"><img src="images/logo-unej.png" alt="Logo" class="auth-logo"></a>
        <div class="auth-card">
            <div class="auth-header">
                <h2>e-Catalog</h2>
                <p>Sign in to your admin account or create a new one</p>
            </div>
            <div class="auth-toggle">
                <a href="{{ route('login') }}">Log In</a>
                <a href="{{ route('register') }}" class="active">Register</a>
            </div>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <x-input-label for="name" value="Nama Supplier (Perusahaan/Pribadi)" />
                    <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="form-group">
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="form-group">
                    <x-input-label for="password" value="Password" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="form-group">
                    <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <div class="form-group-checkbox">
                    <input type="checkbox" id="is-supplier" required>
                    <label for="is-supplier">Mendaftar Sebagai Supplier</label>
                </div>
                <button type="submit" class="btn btn-action full-width">{{ __('Register') }}</button>
            </form>
        </div>
    </div>
</body>
</html>
