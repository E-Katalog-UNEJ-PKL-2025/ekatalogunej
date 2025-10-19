<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di E-Katalog Kampus</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="welcome-page-body">

    <div class="welcome-container">
        
        <!-- Div logo dipindah ke sini (sebelah kiri) -->
        <div class="welcome-logo">
            <img src="{{ asset('images/logo-unej.png') }}" alt="Logo Universitas" id="welcome-logo-img">
        </div>

        <!-- Div konten teks sekarang di sebelah kanan -->
        <div class="welcome-content" id="welcome-content">
            <h1>e-Catalog</h1>
            <p>
                Selamat datang di platform e-katalog Universitas Jember.
                Sistem pengadaan barang dan jasa yang terintegrasi untuk memenuhi
                kebutuhan setiap fakultas secara efisien, transparan, dan akuntabel.
            </p>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-warning" id="startButton">Ke Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-warning" id="startButton">Mulai Sekarang!</a>
            @endauth
        </div>

    </div>

    <script>
        // Menangkap event klik pada tombol 'Mulai Sekarang'
        document.getElementById('startButton').addEventListener('click', function(event) {
            // Mencegah link berpindah halaman secara langsung
            event.preventDefault();
            
            const destination = this.href;
            const welcomeContent = document.getElementById('welcome-content');
            const logo = document.getElementById('welcome-logo-img');

            // Menambahkan class untuk memicu animasi CSS
            welcomeContent.classList.add('fade-out');
            logo.classList.add('animate-logo');

            // Tunggu animasi selesai (1000ms = 1 detik), baru pindah halaman
            setTimeout(() => {
                window.location.href = destination;
            }, 1000); 
        });
    </script>

</body>
</html>

