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
    <style>
        /* ── TOAST NOTIFICATION SYSTEM ── */
        #toast-container {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            pointer-events: none;
        }
        .toast {
            pointer-events: all;
            display: flex;
            align-items: flex-start;
            gap: 0.875rem;
            padding: 1rem 1.25rem;
            border-radius: 20px;
            min-width: 300px;
            max-width: 380px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.12), 0 4px 12px rgba(0,0,0,0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.2);
            position: relative;
            overflow: hidden;
            animation: toastSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        .toast.hiding {
            animation: toastSlideOut 0.35s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        @keyframes toastSlideIn {
            from { opacity: 0; transform: translateX(110%) scale(0.9); }
            to   { opacity: 1; transform: translateX(0)   scale(1);   }
        }
        @keyframes toastSlideOut {
            from { opacity: 1; transform: translateX(0)   scale(1);   }
            to   { opacity: 0; transform: translateX(110%) scale(0.9); }
        }
        .toast-success { background: linear-gradient(135deg, #2C4027 0%, #43643C 100%); color: #fff; }
        .toast-error   { background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%); color: #fff; }
        .toast-info    { background: linear-gradient(135deg, #1e3a5f 0%, #1d4ed8 100%); color: #fff; }
        .toast-icon {
            flex-shrink: 0;
            width: 36px; height: 36px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.15);
        }
        .toast-body { flex: 1; min-width: 0; }
        .toast-title { font-size: 0.7rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.08em; opacity: 0.75; margin-bottom: 0.2rem; }
        .toast-msg   { font-size: 0.875rem; font-weight: 600; line-height: 1.4; word-break: break-word; }
        .toast-close {
            flex-shrink: 0; background: none; border: none; cursor: pointer;
            color: rgba(255,255,255,0.6); font-size: 1.1rem; line-height: 1;
            padding: 0; transition: color 0.2s;
        }
        .toast-close:hover { color: #fff; }
        .toast-progress {
            position: absolute; bottom: 0; left: 0;
            height: 3px; border-radius: 0 0 20px 20px;
            background: rgba(255,255,255,0.4);
            animation: toastProgress 3.5s linear forwards;
        }
        @keyframes toastProgress {
            from { width: 100%; }
            to   { width: 0%;   }
        }
    </style>
</head>
<body class="min-h-screen">

    {{-- ── TOAST NOTIFICATION CONTAINER ── --}}
    <div id="toast-container">
        @if(session('success'))
        <div class="toast toast-success" id="toast-success">
            <div class="toast-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
            </div>
            <div class="toast-body">
                <div class="toast-title">Berhasil</div>
                <div class="toast-msg">{{ session('success') }}</div>
            </div>
            <button class="toast-close" onclick="dismissToast('toast-success')">&times;</button>
            <div class="toast-progress"></div>
        </div>
        @endif

        @if(session('error'))
        <div class="toast toast-error" id="toast-error">
            <div class="toast-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div class="toast-body">
                <div class="toast-title">Gagal</div>
                <div class="toast-msg">{{ session('error') }}</div>
            </div>
            <button class="toast-close" onclick="dismissToast('toast-error')">&times;</button>
            <div class="toast-progress"></div>
        </div>
        @endif

        @if(session('info'))
        <div class="toast toast-info" id="toast-info">
            <div class="toast-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div class="toast-body">
                <div class="toast-title">Info</div>
                <div class="toast-msg">{{ session('info') }}</div>
            </div>
            <button class="toast-close" onclick="dismissToast('toast-info')">&times;</button>
            <div class="toast-progress"></div>
        </div>
        @endif
    </div>

    <script>
        function dismissToast(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.add('hiding');
            setTimeout(() => el.remove(), 350);
        }
        // Auto-dismiss semua toast setelah 3.5 detik
        document.addEventListener('DOMContentLoaded', () => {
            ['toast-success', 'toast-error', 'toast-info'].forEach(id => {
                const el = document.getElementById(id);
                if (el) setTimeout(() => dismissToast(id), 3500);
            });
        });
    </script>
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