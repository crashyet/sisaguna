<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Sisa Guna') }}</title>
    <link rel="icon" type="image/png" href="/storage/icon.png">
    <link rel="apple-touch-icon" href="/storage/icon.png">
    
    <!-- Fonts: Plus Jakarta Sans untuk kesan modern -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --sage-dark: #2C4027;
            --sage-prime: #43643C;
            --sage-soft: #7A9375;
            --sage-light: #E9EFE3;
            --sage-surface: #F9FBF7;
            --white: #ffffff;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--sage-surface);
            color: var(--sage-dark);
            -webkit-font-smoothing: antialiased;
        }

        /* Desain Header yang Lebih Luas */
        header {
            background: var(--white);
            border-bottom: 1px solid var(--sage-light);
            box-shadow: 0 4px 20px rgba(44, 64, 39, 0.03);
        }

        /* Kustomisasi Scrollbar agar selaras */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--sage-surface); }
        ::-webkit-scrollbar-thumb { background: var(--sage-light); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--sage-soft); }
    </style>
</head>
<body class="min-h-screen">
    @include('layouts.navigation')

    <!-- Judul Halaman / Page Header -->
    @if (isset($header))
        <header class="py-10">
            <div class="max-w-7xl mx-auto px-6 sm:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Konten Utama -->
    <main class="py-12">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            {{ $slot }}
        </div>
    </main>

    <footer class="py-10 text-center text-[#A6BBA0] text-xs font-bold uppercase tracking-widest">
        &copy; {{ date('2026') }} Sisa Guna — Berbagi Kebaikan, Kurangi Sampah.
    </footer>
</body>
</html>