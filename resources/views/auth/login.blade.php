<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-g">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>e-Katalog - Login</title>
    <link rel="stylesheet" href="css/auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div id="loginPage" class="page auth-page">
        <a href="/"><img src="images/logo-unej.png" alt="Logo" class="auth-logo"></a>
        <div class="auth-card">
            <div class="auth-header">
                <h2>e-Katalog</h2>
                <p>Log in untuk masuk ke website atau register jika anda belum memiliki akun sebagai supplier</p>
            </div>
            <div class="auth-toggle">
                <a href="{{ route('login') }}" class="active">Log In</a>
                <a href="{{ route('register') }}">Register</a>
            </div>
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="login-email">Email</label>
                    <input type="email" id="email" name="email" :value="old('email')" placeholder="Masukkan alamat email anda" required>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password anda" required>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="form-group-checkbox">
                    <input type="checkbox" id="is-supplier" name="remember">
                    <label for="is-supplier">{{ __('Remember me') }}</label>
                </div>
                <button type="submit" class="btn btn-action full-width">{{ __('Log in') }}</button>
            </form>
        </div>
    </div>

</body>
</html>