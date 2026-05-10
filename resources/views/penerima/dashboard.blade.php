<x-app-layout>
<style>
    /* Category Pills Scrollbar Hiding */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* Bento Box Grid */
    .bento-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    @media(min-width: 768px) {
        .bento-grid {
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(2, 180px);
        }
        .bento-electronic { grid-column: 1 / 3; grid-row: 1 / 3; }
        .bento-furniture { grid-column: 3 / 4; grid-row: 1 / 2; }
        .bento-fashion { grid-column: 3 / 4; grid-row: 2 / 3; }
        .bento-grocery { grid-column: 4 / 5; grid-row: 1 / 3; }
    }

    /* Product Grid */
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.5rem; }
    .prod-card {
        background: #fff; border-radius: 32px; border: 1px solid #E9EFE3; padding: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative;
    }
    .prod-card:hover { transform: translateY(-6px); box-shadow: 0 25px 50px -12px rgba(67, 100, 60, 0.15); border-color: #43643C; }
    .prod-img-box {
        background: #F9FBF7; border-radius: 24px; height: 180px; width: 100%;
        display: flex; align-items: center; justify-content: center; overflow: hidden; margin-bottom: 1rem;
        position: relative;
    }
    .prod-img-box img { width: 100%; height: 100%; object-fit: cover; }
    .prod-tag {
        position: absolute; top: 12px; left: 12px; padding: 4px 10px; border-radius: 99px;
        font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; backdrop-filter: blur(4px);
    }
</style>

<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6">

    <!-- 1. Category Pills -->
    <div class="flex items-center gap-3 overflow-x-auto hide-scrollbar mb-8 pb-2">
        <a href="{{ route('penerima.katalog') }}" class="flex-shrink-0 px-6 py-2.5 rounded-full bg-[#43643C] text-white text-sm font-black shadow-lg shadow-[#43643C]/20">Semua Barang</a>
        <a href="{{ route('penerima.katalog', ['tipe' => 'donasi']) }}" class="flex-shrink-0 px-6 py-2.5 rounded-full bg-white border border-[#E9EFE3] text-[#2C4027] text-sm font-bold hover:border-[#43643C] transition-colors">100% Gratis</a>
        
        @foreach(['bahan_baku'=>'Bahan Baku','makanan_jadi'=>'Makanan Jadi','pakaian'=>'Pakaian','peralatan'=>'Peralatan'] as $v => $l)
            <a href="{{ route('penerima.katalog', ['kategori' => $v]) }}" class="flex-shrink-0 px-6 py-2.5 rounded-full bg-white border border-[#E9EFE3] text-[#7A9375] text-sm font-bold hover:border-[#43643C] hover:text-[#43643C] transition-colors">{{ $l }}</a>
        @endforeach
    </div>

    <!-- 2. Hero Banner -->
    <div class="bg-[#F2F5EB] rounded-[40px] overflow-hidden relative mb-16 shadow-inner">
        <div class="flex flex-col md:flex-row items-center">
            <div class="p-10 md:p-16 md:w-3/5 z-10">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-[#2C4027] leading-tight tracking-tighter mb-6">
                    Pusat <span class="text-[#43643C]">Barang Sisa</span> untuk Segala Kebutuhan!
                </h1>
                <p class="text-[#7A9375] text-lg font-medium mb-10 max-w-md">
                    Cari, klaim, atau beli barang berlebih di sekitar Anda dengan pengiriman cepat dan aman.
                </p>

                <!-- Floating Stat Cards inside Hero -->
                <div class="flex flex-wrap gap-4">
                    <div class="bg-yellow-400 rounded-3xl p-6 shadow-xl shadow-yellow-500/20 transform rotate-[-2deg] hover:rotate-0 transition-transform w-40">
                        <div class="text-[10px] font-black uppercase tracking-widest text-yellow-900 mb-1">Total Diajukan</div>
                        <div class="text-3xl font-black text-yellow-900">{{ $totalKlaim }} Klaim</div>
                    </div>
                    <div class="bg-white rounded-3xl p-6 shadow-xl shadow-[#43643C]/10 transform rotate-[3deg] hover:rotate-0 transition-transform w-40 border border-[#E9EFE3]">
                        <div class="text-[10px] font-black uppercase tracking-widest text-[#43643C] mb-1">Berhasil Disetujui</div>
                        <div class="text-3xl font-black text-[#2C4027]">{{ $klaimDisetujui }} Klaim</div>
                    </div>
                </div>
            </div>
            
            <div class="md:w-2/5 h-64 md:h-auto relative w-full flex justify-end">
                <!-- Placeholder Image (Abstract Shapes or Package) -->
                <div class="w-full h-full bg-[#43643C]/5 flex items-center justify-center p-12">
                    <div class="text-[120px] opacity-20 group-hover:scale-110 transition-transform">📦</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Explore Trending Categories (Bento Box) -->
    <div class="mb-16">
        <div class="flex justify-between items-end mb-8">
            <h2 class="text-2xl font-black text-[#2C4027] tracking-tight">Kategori Terpopuler</h2>
            <a href="{{ route('penerima.katalog') }}" class="text-[#43643C] font-bold text-sm hover:underline flex items-center gap-1">Lihat semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
        </div>

        <div class="bento-grid">
            <!-- Peralatan -->
            <a href="{{ route('penerima.katalog', ['kategori' => 'peralatan']) }}" class="bento-electronic bg-[#2C4027] rounded-[32px] p-8 relative overflow-hidden group flex flex-col justify-end min-h-[250px]">
                <div class="absolute top-6 left-6 flex gap-2">
                    <span class="bg-white/20 backdrop-blur text-white text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest">Peralatan</span>
                    <span class="bg-white/20 backdrop-blur text-white text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest">Elektronik</span>
                </div>
                <div class="text-9xl absolute -right-4 -bottom-4 opacity-50 group-hover:scale-110 transition-transform">💻</div>
                <button class="bg-[#43643C] text-white w-max px-6 py-3 rounded-full text-xs font-bold mt-auto z-10 group-hover:bg-white group-hover:text-[#2C4027] transition-colors">Cari Peralatan →</button>
            </a>

            <!-- Bahan Baku -->
            <a href="{{ route('penerima.katalog', ['kategori' => 'bahan_baku']) }}" class="bento-furniture bg-[#F9FBF7] border border-[#E9EFE3] rounded-[32px] p-6 relative overflow-hidden group flex flex-col justify-center items-start min-h-[160px]">
                <div class="text-5xl absolute -right-2 top-4 opacity-30 group-hover:scale-110 transition-transform">🧱</div>
                <h3 class="font-black text-[#2C4027] text-lg leading-tight w-2/3 mb-3">Bahan Baku & Material</h3>
                <button class="bg-[#43643C] text-white px-5 py-2 rounded-full text-[10px] font-bold mt-auto">Cari →</button>
            </a>

            <!-- Pakaian -->
            <a href="{{ route('penerima.katalog', ['kategori' => 'pakaian']) }}" class="bento-fashion bg-[#E9EFE3] rounded-[32px] p-6 relative overflow-hidden group flex flex-col justify-center items-start min-h-[160px]">
                <div class="text-5xl absolute -right-2 top-4 opacity-30 group-hover:scale-110 transition-transform">👕</div>
                <h3 class="font-black text-[#2C4027] text-lg leading-tight w-2/3 mb-3">Pakaian & Aksesoris</h3>
                <button class="bg-[#43643C] text-white px-5 py-2 rounded-full text-[10px] font-bold mt-auto">Cari →</button>
            </a>

            <!-- Makanan -->
            <a href="{{ route('penerima.katalog', ['kategori' => 'makanan_jadi']) }}" class="bento-grocery bg-[#FACC15] rounded-[32px] p-8 relative overflow-hidden group flex flex-col justify-end min-h-[250px]">
                <div class="absolute top-6 left-6 flex gap-2">
                    <span class="bg-yellow-600/20 backdrop-blur text-yellow-900 text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest">Makanan</span>
                </div>
                <div class="text-9xl absolute -right-8 -bottom-4 opacity-50 group-hover:scale-110 transition-transform">🍔</div>
                <button class="bg-white text-yellow-900 w-max px-6 py-3 rounded-full text-xs font-bold mt-auto z-10 group-hover:bg-yellow-900 group-hover:text-white transition-colors">Cari Makanan →</button>
            </a>
        </div>
    </div>

    <!-- 4. Product of the Month (Barang Terbaru) -->
    <div class="mb-16">
        <div class="flex justify-between items-end mb-8">
            <h2 class="text-2xl font-black text-[#2C4027] tracking-tight">Barang Terbaru Tersedia</h2>
            <a href="{{ route('penerima.katalog') }}" class="text-[#43643C] font-bold text-sm hover:underline flex items-center gap-1">Lihat semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
        </div>

        <div class="product-grid">
            @foreach($barangTerbaru as $item)
            <div class="prod-card flex flex-col">
                <div class="prod-img-box">
                    <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://placehold.co/400x300?text=No+Image' }}">
                    <div class="prod-tag {{ $item->tipe === 'jual' ? 'bg-[#2563EB]/90 text-white' : 'bg-yellow-400/90 text-yellow-900' }}">
                        {{ $item->tipe === 'jual' ? '⭐ Terjual: ' . ($item->claims_sum_jumlah ?? 0) : '🎁 Gratis' }}
                    </div>
                </div>
                
                <div class="px-2 flex-1 flex flex-col">
                    <div class="font-black text-[#2563EB] text-lg mb-1">
                        {{ $item->tipe === 'jual' ? 'Rp ' . number_format($item->harga, 0, ',', '.') : 'Gratis' }}
                    </div>
                    <h3 class="font-bold text-[#2C4027] text-sm mb-1 line-clamp-1">{{ $item->nama_barang }}</h3>
                    <p class="text-xs text-[#7A9375] mb-4">Sisa Stok: {{ $item->jumlah }} {{ $item->satuan }}</p>
                    
                    <a href="{{ route('penerima.katalog') }}" class="mt-auto block text-center w-full py-3 bg-[#E9EFE3] text-[#43643C] rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-[#43643C] hover:text-white transition-colors">
                        Beli Sekarang
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- 5. Riwayat Klaim Table -->
    <div class="bg-white p-8 rounded-[40px] border border-[#E9EFE3] shadow-sm">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-xl font-black text-[#2C4027] tracking-tight">Riwayat Transaksi Terakhir</h2>
            <a href="{{ route('penerima.riwayat') }}" class="text-[#43643C] font-bold text-sm hover:underline flex items-center gap-1">Selengkapnya <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-[#7A9375] border-b-2 border-[#F2F5EB]">
                        <th class="pb-4 px-4 font-bold uppercase tracking-widest text-[10px]">Produk</th>
                        <th class="pb-4 px-4 font-bold uppercase tracking-widest text-[10px]">Tanggal</th>
                        <th class="pb-4 px-4 font-bold uppercase tracking-widest text-[10px]">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F2F5EB]">
                    @forelse($recentClaims as $claim)
                    <tr class="hover:bg-[#F9FBF7] transition-colors group">
                        <td class="py-4 px-4 flex items-center gap-4">
                            <img src="{{ $claim->item->foto ? asset('storage/'.$claim->item->foto) : 'https://placehold.co/48x48?text=Item' }}" class="w-12 h-12 rounded-xl object-cover shadow-sm group-hover:scale-105 transition-transform">
                            <div>
                                <div class="font-bold text-[#2C4027]">{{ $claim->item->nama_barang }}</div>
                                <div class="text-[11px] text-[#7A9375] font-semibold mt-0.5">Permintaan: {{ $claim->jumlah }} {{ $claim->item->satuan }}</div>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-[#7A9375] font-medium">{{ $claim->created_at->format('d M Y') }}</td>
                        <td class="py-4 px-4">
                            <span class="px-4 py-1.5 text-[10px] rounded-full font-black uppercase tracking-widest
                                {{ $claim->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                  ($claim->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($claim->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-12 text-center text-[#7A9375] font-medium">Belum ada riwayat transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
</x-app-layout>