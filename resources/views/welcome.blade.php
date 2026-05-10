<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sisa Guna — Berbagi Lebih Berarti</title>
    <link rel="icon" type="image/png" href="/storage/icon.png">
    <link rel="apple-touch-icon" href="/storage/icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --bg-body: #EAEFE4; /* Pale green outer background */
            --bg-app: #FFFFFF;
            --green-dark: #2C4027;
            --green-primary: #43643C;
            --green-light: #7E9773;
            --green-pale: #E4ECD9;
            --green-soft: #F2F5EB;
            --text-main: #334430;
            --text-muted: #7A9375;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg-body); 
            color: var(--text-main); 
            padding: 1.5rem; /* Creates the "app inside a screen" look */
        }

        /* App Wrapper for reference layout styling */
        .app-container {
            background: var(--bg-app);
            border-radius: 40px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 20px 40px rgba(44, 64, 39, 0.08);
            max-width: 1400px;
            margin: 0 auto;
            padding-bottom: 4rem;
        }

        /* ── NAVBAR ── */
        .navbar {
            position: absolute; 
            top: 0; 
            left: 0;
            width: 100%; 
            height: 90px; 
            z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            background: transparent;
            padding: 0 2.5rem;
        }
        @media(min-width: 768px) {
            .navbar { padding: 0 4rem; }
        }
        .nav-logo {
            font-size: 1.25rem; font-weight: 800; color: var(--green-dark);
            text-decoration: none; letter-spacing: -.02em;
        }
        .nav-logo em { color: var(--green-primary); font-style: normal; }
        .nav-links { display: flex; align-items: center; gap: 0.5rem; }
        .nav-link {
            padding: 0.5rem 1rem; border-radius: 99px;
            font-size: 0.875rem; font-weight: 600; color: var(--text-muted);
            text-decoration: none; transition: all 0.2s;
        }
        .nav-link:hover { background: var(--green-soft); color: var(--green-dark); }
        .nav-cta {
            padding: 0.75rem 1.5rem; background: var(--green-primary); color: #fff;
            border-radius: 99px; font-size: 0.875rem; font-weight: 700;
            text-decoration: none; transition: all 0.2s; margin-left: 0.5rem;
        }
        .nav-cta:hover { background: var(--green-dark); box-shadow: 0 4px 12px rgba(67, 100, 60, 0.2); transform: translateY(-1px); }

        /* ── HERO ── */
        .hero-section {
            padding: 1.5rem 1.5rem 0 1.5rem;
        }
        .hero-image-box {
            background: linear-gradient(135deg, #4F6D43 0%, #354E2D 100%);
            border-radius: 32px;
            min-height: 80vh;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-align: center; 
            padding: 9rem 1.5rem 8rem; 
            position: relative;
        }
        /* Soft nature pattern overlay */
        .hero-image-box::before {
            content: ''; position: absolute; inset: 0; border-radius: 32px;
            background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 40px 40px; pointer-events: none;
        }
        
        .hero-inner { max-width: 800px; position: relative; z-index: 10; color: #fff; }
        .hero-pill {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2);
            color: #fff; font-size: 0.85rem; font-weight: 600;
            padding: 0.5rem 1.25rem; border-radius: 99px;
            margin-bottom: 2rem; backdrop-filter: blur(4px);
        }
        .hero-title {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 800; line-height: 1.1;
            letter-spacing: -.03em; margin-bottom: 1.25rem;
        }
        .hero-sub {
            font-size: 1.1rem; color: rgba(255,255,255,0.85); line-height: 1.6;
            max-width: 580px; margin: 0 auto 2.5rem; font-weight: 400;
        }
        .hero-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn-hero-primary {
            padding: 1rem 2.5rem; background: var(--green-pale); color: var(--green-dark);
            border-radius: 99px; font-size: 1rem; font-weight: 800;
            text-decoration: none; transition: all 0.2s;
        }
        .btn-hero-primary:hover { background: #fff; transform: translateY(-2px); }
        .btn-hero-outline {
            padding: 1rem 2.5rem; background: transparent; color: #fff;
            border: 2px solid rgba(255,255,255,0.4); border-radius: 99px;
            font-size: 1rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
        }
        .btn-hero-outline:hover { border-color: #fff; background: rgba(255,255,255,0.1); }

        /* ── FLOATING STATS (Like the search bar in reference) ── */
        .stats-wrapper {
            position: relative;
            margin-top: -3.5rem; /* Pulls it up over the hero edge */
            display: flex; justify-content: center; z-index: 20; padding: 0 1.5rem;
        }
        .stats-bar {
            background: #fff; border-radius: 99px;
            display: flex; align-items: center; justify-content: center; gap: 4rem;
            padding: 1.5rem 4rem; box-shadow: 0 10px 40px rgba(44, 64, 39, 0.1);
            flex-wrap: wrap;
        }
        .stat-item { text-align: center; }
        .stat-num { font-size: 2rem; font-weight: 900; color: var(--green-dark); line-height: 1; }
        .stat-lbl { font-size: 0.85rem; color: var(--text-muted); font-weight: 600; margin-top: 0.4rem; }

        /* ── FEATURES (Card grid mimicking reference layout) ── */
        .features { padding: 6rem 2rem 4rem; max-width: 1200px; margin: 0 auto; }
        .section-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem; flex-wrap: wrap; gap: 1rem; }
        .section-title { font-size: 2rem; font-weight: 800; color: var(--green-dark); max-width: 400px; line-height: 1.2; }
        .section-sub { color: var(--text-muted); font-size: 0.95rem; max-width: 350px; line-height: 1.6; }
        
        .feat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
        .feat-card {
            background: var(--green-soft); border-radius: 32px; padding: 2.5rem 2rem;
            transition: all 0.3s ease; border: 1px solid transparent;
        }
        .feat-card:hover { background: #fff; border-color: var(--green-pale); box-shadow: 0 20px 40px rgba(44, 64, 39, 0.05); transform: translateY(-5px); }
        .feat-icon {
            width: 64px; height: 64px; border-radius: 99px;
            background: #fff; color: var(--green-primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; margin-bottom: 1.5rem; box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        }
        .feat-card h3 { font-size: 1.2rem; font-weight: 800; margin-bottom: 0.75rem; color: var(--green-dark); }
        .feat-card p  { font-size: 0.9rem; color: var(--text-muted); line-height: 1.6; }

        /* ── HOW IT WORKS ── */
        .how { padding: 4rem 2rem; max-width: 1000px; margin: 0 auto; background: var(--bg-app); }
        .how-title { text-align: center; font-size: 2rem; font-weight: 800; color: var(--green-dark); margin-bottom: 3rem; }
        .steps { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2.5rem; }
        .step { text-align: center; padding: 2rem; background: #fff; border-radius: 24px; border: 1px solid var(--green-pale); }
        .step-num {
            width: 48px; height: 48px; border-radius: 99px;
            background: var(--green-pale); color: var(--green-dark);
            font-size: 1.2rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem;
        }
        .step h4 { font-size: 1.1rem; font-weight: 800; margin-bottom: 0.5rem; color: var(--green-dark); }
        .step p  { font-size: 0.85rem; color: var(--text-muted); line-height: 1.6; }

        /* ── CTA BOTTOM ── */
        .cta-bottom {
            margin: 4rem 2rem 2rem; padding: 4rem 2rem;
            background: var(--green-pale); border-radius: 32px;
            text-align: center;
        }
        .cta-bottom h2 { font-size: 2.2rem; font-weight: 800; color: var(--green-dark); margin-bottom: 1rem; }
        .cta-bottom p { color: var(--green-primary); font-size: 1rem; margin-bottom: 2.5rem; }
        .btn-cta-primary {
            display: inline-block; padding: 1rem 2.5rem;
            background: var(--green-dark); color: #fff; border-radius: 99px;
            font-size: 1rem; font-weight: 700; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-cta-primary:hover { background: var(--text-main); }
        .btn-cta-ghost {
            display: inline-block; padding: 1rem 2.5rem;
            background: transparent; color: var(--green-dark);
            border: 2px solid var(--green-dark); border-radius: 99px;
            font-size: 1rem; font-weight: 700; text-decoration: none;
            transition: all 0.2s; margin-left: 0.75rem;
        }
        .btn-cta-ghost:hover { background: var(--green-dark); color: #fff; }

        /* ── FOOTER ── */
        .footer {
            padding: 2rem; text-align: center; font-size: 0.85rem;
            color: var(--text-muted); font-weight: 500;
        }
    </style>
</head>
<body>

<div class="app-container">

    {{-- HERO --}}
    <section class="p-4 sm:p-6 mb-16">
        <div class="bg-[#F2F5EB] rounded-[40px] overflow-hidden relative shadow-inner pt-28 pb-10">
            {{-- NAVBAR --}}
            <nav class="navbar">
                <a href="/" class="flex items-center gap-3 group" style="text-decoration: none;">
                    <img src="/storage/icon.png" alt="Sisa Guna Logo" class="w-9 h-9 aspect-square object-cover rounded-xl transition-transform group-hover:rotate-12">
                    <span class="font-black text-xl text-[#2C4027] tracking-tighter">Sisa<span class="text-[#43643C]">Guna</span></span>
                </a>
                <div class="nav-links">
                    @auth
                        @if(auth()->user()->role === 'donatur')
                            <a href="{{ route('donatur.dashboard') }}" class="nav-cta">Ke Dashboard</a>
                        @elseif(auth()->user()->role === 'penerima')
                            <a href="{{ route('penerima.dashboard') }}" class="nav-cta">Ke Dashboard</a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="nav-cta">Ke Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                        <a href="{{ route('register') }}" class="nav-cta">Daftar</a>
                    @endauth
                </div>
            </nav>

            <div class="flex flex-col md:flex-row items-center">
                <div class="px-10 md:px-16 md:w-3/5 z-10">
                    <div class="inline-flex items-center gap-2 bg-white/60 backdrop-blur border border-white/50 text-[#43643C] text-xs font-black px-4 py-2 rounded-full uppercase tracking-widest mb-6 shadow-sm">
                        <img src="/storage/icon.png" class="w-4 h-4 aspect-square object-cover rounded-md"> Ramah Lingkungan
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-[#2C4027] leading-[1.1] tracking-tight mb-6">
                        Berbagi Kelebihan,<br><span class="text-[#43643C]">Kurangi Pemborosan</span>
                    </h1>
                    <p class="text-[#7A9375] text-lg font-medium mb-10 max-w-md leading-relaxed">
                        Temukan barang berkualitas dengan harga terjangkau, atau donasikan kelebihan barangmu kepada yang membutuhkan.
                    </p>

                    <!-- Floating Stat Cards inside Hero -->
                    <div class="flex flex-wrap gap-4 mb-4">
                        <div class="bg-yellow-400 rounded-3xl p-6 shadow-xl shadow-yellow-500/20 transform rotate-[-2deg] hover:rotate-0 transition-transform w-40">
                            <div class="text-[10px] font-black uppercase tracking-widest text-yellow-900 mb-1">Pengguna Aktif</div>
                            <div class="text-3xl font-black text-yellow-900">1.2K+</div>
                        </div>
                        <div class="bg-white rounded-3xl p-6 shadow-xl shadow-[#43643C]/10 transform rotate-[3deg] hover:rotate-0 transition-transform w-40 border border-[#E9EFE3]">
                            <div class="text-[10px] font-black uppercase tracking-widest text-[#43643C] mb-1">Barang Tersedia</div>
                            <div class="text-3xl font-black text-[#2C4027]">500+</div>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-8 flex-wrap">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-[#43643C] text-white rounded-full font-bold text-sm hover:-translate-y-1 hover:shadow-xl hover:shadow-[#43643C]/20 transition-all">Mulai Sekarang</a>
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-white text-[#2C4027] border border-[#E9EFE3] rounded-full font-bold text-sm hover:-translate-y-1 hover:shadow-xl transition-all">Masuk ke Akun</a>
                    </div>
                </div>
                
                <div class="md:w-2/5 h-64 md:h-auto relative w-full flex justify-end">
                    <div class="w-full h-full bg-[#43643C]/5 flex items-center justify-center p-12 relative overflow-hidden">
                        <div class="absolute w-[500px] h-[500px] bg-white rounded-full blur-3xl opacity-50 -top-20 -right-20"></div>
                        <div class="text-[120px] z-10 drop-shadow-2xl hover:scale-110 transition-transform duration-500">📦</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES (Bento Grid) --}}
    <section class="max-w-7xl mx-auto px-6 mb-24">
        <div class="flex justify-between items-end mb-10 flex-wrap gap-4">
            <div>
                <h2 class="text-3xl font-black text-[#2C4027] tracking-tight">Satu Platform,<br>Banyak Manfaat</h2>
            </div>
            <p class="text-[#7A9375] font-medium max-w-sm">Mulai dari donasi gratis hingga jual beli murah untuk mendukung gaya hidup berkelanjutan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Bento 1 -->
            <div class="bg-[#2C4027] rounded-[40px] p-10 relative overflow-hidden group flex flex-col justify-end min-h-[300px] md:col-span-2">
                <div class="absolute top-8 left-8">
                    <span class="bg-white/20 backdrop-blur text-white text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest">Temukan & Klaim</span>
                </div>
                <div class="text-9xl absolute -right-4 top-10 opacity-30 group-hover:scale-110 transition-transform duration-500">🔍</div>
                <h3 class="font-black text-white text-3xl leading-tight w-2/3 mb-4 z-10">Hemat pengeluaran harian dengan mudah</h3>
                <p class="text-white/70 font-medium max-w-sm z-10">Browse katalog barang murah di sekitarmu, ajukan klaim, dan selesaikan transaksi dengan aman.</p>
            </div>

            <!-- Bento 2 -->
            <div class="bg-[#FACC15] rounded-[40px] p-10 relative overflow-hidden group flex flex-col justify-center min-h-[300px]">
                <div class="text-8xl absolute -right-8 -bottom-4 opacity-40 group-hover:scale-110 transition-transform duration-500">🎁</div>
                <div class="mb-4">
                    <span class="bg-yellow-600/20 backdrop-blur text-yellow-900 text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest">Donasi 100% Gratis</span>
                </div>
                <h3 class="font-black text-yellow-900 text-2xl leading-tight mb-3 z-10">Bagikan barang tidak terpakai</h3>
                <p class="text-yellow-800/80 font-medium text-sm z-10">Berikan kepada yang benar-benar membutuhkan di sekitarmu.</p>
            </div>

            <!-- Bento 3 -->
            <div class="bg-[#F2F5EB] rounded-[40px] p-10 relative overflow-hidden group flex flex-col justify-center min-h-[250px] md:col-span-3 border border-[#E9EFE3]">
                <div class="text-8xl absolute right-10 top-10 opacity-30 group-hover:scale-110 transition-transform duration-500">🏷️</div>
                <div class="mb-4">
                    <span class="bg-[#43643C]/10 text-[#43643C] text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest">Jual Murah</span>
                </div>
                <h3 class="font-black text-[#2C4027] text-2xl leading-tight w-1/2 mb-3 z-10">Barang sisa tidak mubazir, kamu dapat pemasukan.</h3>
                <p class="text-[#7A9375] font-medium text-sm max-w-md z-10">Jual barang layak pakai dengan harga terjangkau kepada mereka yang sedang mencari.</p>
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS (Horizontal Cards) --}}
    <section class="max-w-7xl mx-auto px-6 mb-24">
        <h2 class="text-center text-3xl font-black text-[#2C4027] mb-12 tracking-tight">Mudah dalam 3 Langkah</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-10 rounded-[40px] border border-[#E9EFE3] hover:border-[#43643C] hover:-translate-y-2 hover:shadow-2xl hover:shadow-[#43643C]/5 transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-[#F2F5EB] text-[#43643C] rounded-full flex items-center justify-center text-2xl font-black mx-auto mb-6">1</div>
                <h4 class="text-xl font-black text-[#2C4027] mb-3">Daftar Akun</h4>
                <p class="text-[#7A9375] font-medium text-sm">Buat akun sebagai Donatur atau Penerima secara gratis dalam hitungan detik.</p>
            </div>
            <div class="bg-white p-10 rounded-[40px] border border-[#E9EFE3] hover:border-[#43643C] hover:-translate-y-2 hover:shadow-2xl hover:shadow-[#43643C]/5 transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-[#F2F5EB] text-[#43643C] rounded-full flex items-center justify-center text-2xl font-black mx-auto mb-6">2</div>
                <h4 class="text-xl font-black text-[#2C4027] mb-3">Upload / Cari</h4>
                <p class="text-[#7A9375] font-medium text-sm">Donatur upload barang tak terpakai, Penerima bebas mencari melalui katalog modern.</p>
            </div>
            <div class="bg-white p-10 rounded-[40px] border border-[#E9EFE3] hover:border-[#43643C] hover:-translate-y-2 hover:shadow-2xl hover:shadow-[#43643C]/5 transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-[#2C4027] text-white rounded-full flex items-center justify-center text-2xl font-black mx-auto mb-6 shadow-lg shadow-[#2C4027]/20">3</div>
                <h4 class="text-xl font-black text-[#2C4027] mb-3">Klaim Selesai</h4>
                <p class="text-[#7A9375] font-medium text-sm">Ajukan klaim, selesaikan pembayaran (jika ada), dan ambil barangnya. Semudah itu!</p>
            </div>
        </div>
    </section>

    {{-- CTA BOTTOM --}}
    <section class="max-w-5xl mx-auto px-6 mb-20">
        <div class="bg-[#43643C] rounded-[40px] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl shadow-[#43643C]/20">
            <div class="absolute w-[400px] h-[400px] bg-white rounded-full blur-[80px] opacity-10 -top-40 -left-40 pointer-events-none"></div>
            <h2 class="text-3xl md:text-5xl font-black text-white mb-4 tracking-tight relative z-10">Siap Berbagi Kebaikan?</h2>
            <p class="text-white/80 font-medium text-lg mb-10 relative z-10">Bergabunglah dengan ribuan pengguna yang sudah merasakan manfaat dari sirkular ekonomi.</p>
            <div class="flex justify-center gap-4 flex-wrap relative z-10">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-[#2C4027] rounded-full font-bold text-sm hover:scale-105 transition-transform shadow-xl">Daftar Sekarang</a>
                <a href="{{ route('login') }}" class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-full font-bold text-sm hover:bg-white/10 transition-colors">Masuk Akun</a>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="footer">
        © {{ date('Y') }} Sisa Guna — Berbagi Lebih Berarti <img src="/storage/icon.png" class="inline-block w-4 h-4 aspect-square object-cover rounded-md mb-1">
    </footer>
</div>

</body>
</html>