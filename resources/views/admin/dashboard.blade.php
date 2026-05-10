<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6">
        @if(session('success'))
            <div class="bg-[#E9EFE3] text-[#2C4027] px-6 py-4 rounded-[24px] border border-[#43643C]/20 mb-8 font-semibold shadow-sm flex items-center gap-3">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        <!-- Hero Banner -->
        <div class="bg-[#2C4027] rounded-[40px] overflow-hidden relative mb-12 shadow-2xl shadow-[#2C4027]/20">
            <div class="absolute w-[600px] h-[600px] bg-white rounded-full blur-[100px] opacity-10 -top-40 -right-40 pointer-events-none"></div>
            
            <div class="flex flex-col md:flex-row items-center p-10 md:p-16">
                <div class="md:w-3/5 z-10 text-white">
                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur border border-white/20 text-white text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest mb-6">
                        <img src="/storage/icon.png" class="aspect-square object-cover w-4 h-4 rounded-md"> Administrator Panel
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black leading-tight tracking-tighter mb-4">
                        Halo, Admin!
                    </h1>
                    <p class="text-white/70 text-lg font-medium mb-10 max-w-md">
                        Pantau aktivitas platform, kelola pengguna, dan pastikan ekosistem Sisa Guna berjalan lancar.
                    </p>

                    <!-- Floating Stat Cards inside Hero -->
                    <div class="flex flex-wrap gap-4">
                        <div class="bg-[#FACC15] rounded-3xl p-6 shadow-xl shadow-black/20 transform rotate-[-2deg] hover:rotate-0 transition-transform w-36">
                            <div class="text-[10px] font-black uppercase tracking-widest text-yellow-900 mb-1">Users</div>
                            <div class="text-3xl font-black text-yellow-900">{{ $totalUsers }}</div>
                        </div>
                        <div class="bg-[#E9EFE3] rounded-3xl p-6 shadow-xl shadow-black/20 transform rotate-[3deg] hover:rotate-0 transition-transform w-36 border border-transparent">
                            <div class="text-[10px] font-black uppercase tracking-widest text-[#43643C] mb-1">Barang</div>
                            <div class="text-3xl font-black text-[#2C4027]">{{ $totalItems }}</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur rounded-3xl p-6 shadow-xl shadow-black/10 transform rotate-[-1deg] hover:rotate-0 transition-transform w-36 border border-white/20 text-white">
                            <div class="text-[10px] font-black uppercase tracking-widest text-white/70 mb-1">Klaim</div>
                            <div class="text-3xl font-black">{{ $totalClaims }}</div>
                        </div>
                        <div class="bg-white rounded-3xl p-6 shadow-xl shadow-black/10 transform rotate-[2deg] hover:rotate-0 transition-transform w-36">
                            <div class="text-[10px] font-black uppercase tracking-widest text-[#7A9375] mb-1">Tersalur</div>
                            <div class="text-3xl font-black text-[#2C4027]">{{ $itemTersalur }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="md:w-2/5 mt-10 md:mt-0 flex flex-col gap-4 justify-center items-center z-10 w-full max-w-xs mx-auto">
                    <a href="{{ route('admin.users') }}" class="group bg-white rounded-[32px] p-6 text-center w-full hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                        <div class="w-16 h-16 bg-[#F2F5EB] rounded-full flex items-center justify-center text-3xl mx-auto mb-4 group-hover:bg-[#43643C] group-hover:text-white transition-colors shadow-inner">
                            👥
                        </div>
                        <h3 class="font-black text-[#2C4027] text-lg mb-1">Kelola Pengguna</h3>
                        <p class="text-[#7A9375] text-[10px] font-bold uppercase tracking-widest">Verifikasi & Akses →</p>
                    </a>
                    <a href="{{ route('admin.items') }}" class="group bg-[#43643C] border border-white/20 rounded-[32px] p-6 text-center w-full hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                        <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center text-3xl mx-auto mb-4 group-hover:bg-white group-hover:text-[#43643C] transition-colors shadow-inner">
                            📦
                        </div>
                        <h3 class="font-black text-white text-lg mb-1">Manajemen Barang</h3>
                        <p class="text-white/70 text-[10px] font-bold uppercase tracking-widest">Pantau Inventaris →</p>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Pengguna Terbaru -->
            <div class="bg-white rounded-[40px] border border-[#E9EFE3] p-8 shadow-sm flex flex-col h-full">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-black text-[#2C4027] tracking-tight">Pengguna Baru</h2>
                    <a href="{{ route('admin.users') }}" class="text-[#43643C] font-bold text-sm hover:underline">Semua →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-[#E9EFE3]">
                            @forelse($recentUsers as $user)
                            <tr class="group hover:bg-[#F9FBF7] transition-colors">
                                <td class="py-4 px-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-[#E9EFE3] flex items-center justify-center text-[#43643C] font-black text-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-[#2C4027]">{{ $user->name }}</div>
                                            <div class="text-[10px] font-bold text-[#7A9375] uppercase tracking-widest">{{ $user->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-2 text-right">
                                    <span class="px-3 py-1 text-[10px] rounded-full font-black uppercase tracking-widest {{ $user->role === 'donatur' ? 'bg-[#F2F5EB] text-[#43643C]' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="py-8 text-center text-[#7A9375] font-bold">Belum ada pengguna baru.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Barang Terbaru -->
            <div class="bg-white rounded-[40px] border border-[#E9EFE3] p-8 shadow-sm flex flex-col h-full">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-black text-[#2C4027] tracking-tight">Barang Terbaru</h2>
                    <a href="{{ route('admin.items') }}" class="text-[#43643C] font-bold text-sm hover:underline">Semua →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-[#E9EFE3]">
                            @forelse($recentItems as $item)
                            <tr class="group hover:bg-[#F9FBF7] transition-colors">
                                <td class="py-4 px-2">
                                    <div class="flex items-center gap-3">
                                        @if($item->foto)
                                            <img src="{{ asset('storage/'.$item->foto) }}" class="w-10 h-10 rounded-xl object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-xl bg-[#F2F5EB] flex items-center justify-center text-lg">📦</div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-[#2C4027]">{{ $item->nama_barang }}</div>
                                            <div class="text-[10px] font-bold text-[#7A9375] uppercase tracking-widest">Oleh: {{ $item->donatur->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-2 text-right">
                                    <span class="px-3 py-1 text-[10px] rounded-full font-black uppercase tracking-widest {{ $item->tipe === 'jual' ? 'bg-[#F2F5EB] text-[#43643C]' : 'bg-[#E9EFE3] text-[#2C4027]' }}">
                                        {{ $item->tipe === 'jual' ? '🏷️ Jual' : '🎁 Donasi' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="py-8 text-center text-[#7A9375] font-bold">Belum ada barang baru.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pending Claims -->
        <div class="bg-white rounded-[40px] border border-[#E9EFE3] p-8 shadow-sm">
            <h2 class="text-2xl font-black text-[#2C4027] tracking-tight mb-6">Klaim Menunggu</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-[#7A9375] border-b border-[#E9EFE3] uppercase text-[10px] font-black tracking-widest">
                            <th class="pb-4 px-2">Barang</th>
                            <th class="pb-4 px-2">Penerima</th>
                            <th class="pb-4 px-2 hidden md:table-cell">Alasan</th>
                            <th class="pb-4 px-2 text-right">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E9EFE3]">
                        @forelse($pendingClaims as $claim)
                        <tr class="hover:bg-[#F9FBF7] transition-colors">
                            <td class="py-4 px-2 font-bold text-[#2C4027]">
                                <div class="flex items-center gap-3">
                                    <img src="/storage/icon.png" class="aspect-square object-cover w-8 h-8 rounded-full opacity-30">
                                    {{ $claim->item->nama_barang }}
                                </div>
                            </td>
                            <td class="py-4 px-2 text-[#7A9375] font-medium">{{ $claim->penerima->name }}</td>
                            <td class="py-4 px-2 text-[#7A9375] italic hidden md:table-cell max-w-xs truncate">"{{ $claim->alasan }}"</td>
                            <td class="py-4 px-2 text-right text-[10px] font-bold text-[#A6BBA0] uppercase tracking-widest">{{ $claim->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-[#7A9375] font-bold text-lg">
                                <div class="text-4xl mb-3">🍃</div>
                                Tidak ada klaim menunggu.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>