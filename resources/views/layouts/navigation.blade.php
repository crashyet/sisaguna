<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-[#E9EFE3]">
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                {{-- Logo Premium --}}
                <a href="/" class="flex items-center gap-3 group">
                    <img src="/storage/icon.png" alt="Sisa Guna Logo" class="w-9 h-9 aspect-square object-cover rounded-xl transition-transform group-hover:rotate-12">
                    <span class="font-black text-2xl text-[#2C4027] tracking-tighter">Sisa<span class="text-[#43643C]">Guna</span></span>
                </a>

                {{-- Desktop Menu --}}
                <div class="hidden sm:flex sm:items-center sm:ml-12 gap-2">
                    @auth
                        @php
                            $links = match(auth()->user()->role) {
                                'donatur' => [
                                    'Dashboard' => 'donatur.dashboard',
                                    'Barang Saya' => 'donatur.items.index',
                                    'Request Masuk' => 'donatur.claims',
                                    'Pembayaran' => 'donatur.payments',
                                ],
                                'penerima' => [
                                    'Dashboard' => 'penerima.dashboard',
                                    'Katalog' => 'penerima.katalog',
                                    'Riwayat' => 'penerima.riwayat',
                                ],
                                'admin' => [
                                    'Dashboard' => 'admin.dashboard',
                                    'Users' => 'admin.users',
                                    'Moderasi' => 'admin.items',
                                ],
                                default => []
                            };
                        @endphp

                        @foreach($links as $label => $route)
                            <a href="{{ route($route) }}"
                               class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-200
                               {{ request()->routeIs($route . '*') ? 'bg-[#43643C] text-white shadow-lg shadow-[#43643C]/20' : 'text-[#7A9375] hover:bg-[#F2F5EB] hover:text-[#43643C]' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    @endauth
                </div>
            </div>

            {{-- Kanan: Profile & Logout --}}
            <div class="hidden sm:flex sm:items-center gap-6">
                @auth
                    <div class="flex flex-col items-end">
                        <span class="text-xs font-black text-[#43643C] uppercase tracking-widest">{{ auth()->user()->role }}</span>
                        <span class="text-sm font-bold text-[#2C4027]">{{ auth()->user()->name }}</span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <a href="{{ route('profile.edit') }}" class="bg-[#F2F5EB] text-[#43643C] p-3 rounded-full hover:bg-[#E9EFE3] transition-colors" title="Pengaturan Profil">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-[#F2F5EB] text-[#43643C] p-3 rounded-full hover:bg-red-50 hover:text-red-500 transition-colors" title="Keluar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            </button>
                        </form>
                    </div>
                @endauth
            </div>

            {{-- Mobile Button --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="p-3 rounded-2xl bg-[#F2F5EB] text-[#43643C]">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-transition class="sm:hidden bg-white border-t border-[#E9EFE3] px-6 py-8 space-y-3">
        @auth
            @foreach($links as $label => $route)
                <a href="{{ route($route) }}" class="block px-6 py-4 rounded-2xl text-base font-bold {{ request()->routeIs($route . '*') ? 'bg-[#F2F5EB] text-[#43643C]' : 'text-[#7A9375]' }}">
                    {{ $label }}
                </a>
            @endforeach
            
            <div class="pt-6 mt-6 border-t border-[#E9EFE3] space-y-3">
                <a href="{{ route('profile.edit') }}" class="block text-center py-4 rounded-2xl bg-[#F2F5EB] text-[#43643C] font-black uppercase tracking-widest text-xs">
                    Pengaturan Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-center py-4 rounded-2xl bg-red-50 text-red-500 font-black uppercase tracking-widest text-xs">
                        Keluar Aplikasi
                    </button>
                </form>
            </div>
        @endauth
    </div>
</nav>