<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sisa Guna') }}</title>
        <link rel="icon" type="image/png" href="/storage/icon.png">
        <link rel="apple-touch-icon" href="/storage/icon.png">

        <!-- Fonts: Menggunakan Plus Jakarta Sans agar seragam dengan app.blade.php -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background-color: #F9FBF7; /* Sage Surface */
                color: #2C4027; /* Sage Dark */
            }
            
            /* Kustomisasi kartu login agar lebih membulat (soft) */
            .auth-card {
                background: #ffffff;
                border: 1px solid #E9EFE3;
                box-shadow: 0 10px 25px -5px rgba(44, 64, 39, 0.05);
                border-radius: 24px;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Logo Sisa Guna -->
            <div class="mb-8">
                <a href="/" class="flex flex-col items-center gap-2 group">
                    <img src="/storage/icon.png" alt="Sisa Guna Logo" class="w-16 h-16 aspect-square object-cover rounded-2xl shadow-lg shadow-[#43643C]/20 transition-transform group-hover:scale-105">
                    <span class="font-black text-2xl tracking-tighter text-[#2C4027]">
                        Sisa<span class="text-[#43643C]">Guna</span>
                    </span>
                </a>
            </div>

            <!-- Box Form Autentikasi -->
            <div class="w-full sm:max-w-md mt-2 px-8 py-10 auth-card overflow-hidden">
                {{ $slot }}
            </div>

            <!-- Footer Sederhana -->
            <div class="mt-8 text-center">
                <p class="text-sm text-[#7A9375] font-medium">
                    &copy; {{ date('2026') }} Sisa Guna.
                </p>
            </div>
        </div>
    </body>
</html>