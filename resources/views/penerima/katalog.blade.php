<x-app-layout>


<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

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
    .prod-cat-tag {
        position: absolute; bottom: 12px; right: 12px; padding: 4px 10px; border-radius: 99px;
        font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; 
        background: rgba(255,255,255,0.9); color: #2C4027; backdrop-filter: blur(4px);
    }
</style>

<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6">

    <!-- Category Pills & Search -->
    <div class="flex flex-col lg:flex-row gap-4 justify-between items-center mb-8">
        <div class="flex items-center gap-3 overflow-x-auto hide-scrollbar w-full lg:w-auto pb-2">
            <a href="{{ route('penerima.katalog') }}" class="flex-shrink-0 px-6 py-2.5 rounded-full {{ !request('kategori') && !request('tipe') ? 'bg-[#43643C] text-white shadow-lg shadow-[#43643C]/20' : 'bg-white border border-[#E9EFE3] text-[#7A9375]' }} text-sm font-black transition-colors">Semua Barang</a>
            <a href="{{ route('penerima.katalog', ['tipe' => 'donasi']) }}" class="flex-shrink-0 px-6 py-2.5 rounded-full {{ request('tipe') == 'donasi' ? 'bg-[#43643C] text-white shadow-lg shadow-[#43643C]/20' : 'bg-white border border-[#E9EFE3] text-[#2C4027]' }} text-sm font-bold transition-colors">100% Gratis</a>
            
            @foreach(['bahan_baku'=>'Bahan Baku','makanan_jadi'=>'Makanan Jadi','pakaian'=>'Pakaian','peralatan'=>'Peralatan'] as $v => $l)
                <a href="{{ route('penerima.katalog', ['kategori' => $v]) }}" class="flex-shrink-0 px-6 py-2.5 rounded-full {{ request('kategori') == $v ? 'bg-[#43643C] text-white shadow-lg shadow-[#43643C]/20' : 'bg-white border border-[#E9EFE3] text-[#7A9375]' }} text-sm font-bold hover:border-[#43643C] hover:text-[#43643C] transition-colors">{{ $l }}</a>
            @endforeach
        </div>

        <form method="GET" class="w-full lg:w-auto flex gap-2">
            @if(request('kategori')) <input type="hidden" name="kategori" value="{{ request('kategori') }}"> @endif
            @if(request('tipe')) <input type="hidden" name="tipe" value="{{ request('tipe') }}"> @endif
            
            <input type="text" name="kota" value="{{ request('kota') }}" placeholder="Cari kota..." 
                   class="flex-1 px-5 py-2.5 bg-white border border-[#E9EFE3] rounded-full text-sm font-bold focus:border-[#43643C] focus:ring-0 outline-none placeholder-[#7A9375]">
            <button type="submit" class="px-6 py-2.5 bg-[#43643C] text-white rounded-full font-bold text-sm shadow-lg shadow-[#43643C]/20 hover:-translate-y-1 transition-all">Cari</button>
        </form>
    </div>

    <div class="mb-6">
        <h2 class="text-2xl font-black text-[#2C4027] tracking-tight">Katalog Barang</h2>
        <p class="text-[#7A9375] font-medium text-sm mt-1">{{ $items->total() }} Barang Tersedia</p>
    </div>

    <div x-data="{ 
        showModal: false, 
        item: { id: null, nama: '', max: 1, tipe: '' } 
    }">

        <div class="product-grid mb-12">
            @foreach($items as $item)
            <div class="prod-card flex flex-col">
                <div class="prod-img-box">
                    <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://placehold.co/400x300?text=No+Image' }}">
                    <div class="prod-tag {{ $item->tipe === 'jual' ? 'bg-[#2563EB]/90 text-white' : 'bg-yellow-400/90 text-yellow-900' }}">
                        {{ $item->tipe === 'jual' ? '⭐ Terjual: ' . ($item->claims_sum_jumlah ?? 0) : '🎁 Gratis' }}
                    </div>
                    @if($item->expiry_date)
                        <div class="absolute top-12 left-3 bg-red-500/90 text-white px-3 py-1 rounded-full text-[9px] font-black uppercase backdrop-blur(4px)">
                            ⏳ Exp: {{ $item->expiry_date->format('d M y') }}
                        </div>
                    @endif
                    <div class="prod-cat-tag">
                        🏷️ {{ $item->kategori === 'lainnya' ? $item->kategori_lainnya : ucfirst(str_replace('_', ' ', $item->kategori)) }}
                    </div>
                </div>
                
                <div class="px-2 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-1">
                        <div class="font-black {{ $item->tipe === 'jual' ? 'text-[#2563EB]' : 'text-[#43643C]' }} text-lg">
                            {{ $item->tipe === 'jual' ? 'Rp ' . number_format($item->harga ?? 0, 0, ',', '.') : 'Gratis' }}
                        </div>
                    </div>
                    <h3 class="font-bold text-[#2C4027] text-sm mb-1 line-clamp-1" title="{{ $item->nama_barang }}">{{ $item->nama_barang }}</h3>
                    <div class="text-[10px] font-bold text-[#7A9375] mb-2 flex justify-between">
                        <span>Sisa: {{ $item->jumlah }} {{ $item->satuan }}</span>
                        <span>📍 {{ $item->kota }}</span>
                    </div>
                    
                    <p class="text-xs text-[#7A9375] leading-relaxed mb-4 line-clamp-2 italic">"{{ $item->deskripsi }}"</p>
                    
                    <div class="mt-auto">
                        <div class="text-[9px] font-black text-[#7A9375] uppercase tracking-widest mb-2 text-center">
                            By: {{ $item->donatur->name }}
                        </div>
                        <button @click="showModal = true; item = { id: {{ $item->id }}, nama: '{{ addslashes($item->nama_barang) }}', max: {{ $item->jumlah }}, tipe: '{{ $item->tipe }}' }" 
                            class="block text-center w-full py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all
                                {{ $item->tipe === 'jual' ? 'bg-[#2563EB] hover:bg-blue-700 text-white shadow-lg shadow-blue-500/30' : 'bg-[#E9EFE3] text-[#43643C] hover:bg-[#43643C] hover:text-white' }}">
                            {{ $item->tipe === 'jual' ? 'Beli Sekarang' : 'Ajukan Klaim' }}
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- Pagination --}}
        <div class="mt-8">
            {{ $items->links() }}
        </div>

    {{-- Modal --}}
    <div x-show="showModal" style="display: none;"
         class="fixed inset-0 z-50 flex items-center justify-center bg-[#2C4027]/60 backdrop-blur-sm p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="bg-white rounded-[32px] shadow-2xl max-w-md w-full p-8" @click.away="showModal = false">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-black text-2xl text-[#2C4027]" x-text="item.tipe === 'jual' ? 'Beli Barang' : 'Ajukan Klaim'"></h3>
                <button @click="showModal = false" class="text-[#7A9375] hover:text-[#2C4027] text-3xl leading-none">&times;</button>
            </div>
            
            <p class="text-sm font-bold text-[#7A9375] mb-6">Anda akan <span x-text="item.tipe === 'jual' ? 'membeli' : 'mengklaim'"></span> <span class="text-[#43643C]" x-text="item.nama"></span></p>

            <form :action="'{{ route('penerima.claim.store', 999999) }}'.replace('999999', item.id)" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-black text-[#7A9375] uppercase tracking-widest mb-2 ml-4">Jumlah Kebutuhan (Max: <span x-text="item.max"></span>)</label>
                    <input type="number" name="jumlah" min="1" :max="item.max" value="1" required
                           class="w-full px-6 py-4 border-2 border-[#E9EFE3] bg-[#F9FBF7] rounded-full text-sm font-bold focus:border-[#43643C] focus:ring-[#43643C] outline-none">
                </div>
                <div class="mb-8">
                    <label class="block text-xs font-black text-[#7A9375] uppercase tracking-widest mb-2 ml-4">Alasan Kebutuhan</label>
                    <textarea name="alasan" required placeholder="Kenapa kamu membutuhkan barang ini?" 
                              class="w-full px-6 py-4 border-2 border-[#E9EFE3] bg-[#F9FBF7] rounded-3xl text-sm focus:border-[#43643C] focus:ring-[#43643C] outline-none resize-none h-32"></textarea>
                </div>
                
                <button type="submit" class="w-full py-4 rounded-full font-black text-sm uppercase tracking-widest transition-all shadow-lg text-white"
                        :class="item.tipe === 'jual' ? 'bg-[#2563EB] hover:bg-blue-700 shadow-blue-500/20' : 'bg-[#43643C] hover:bg-[#2C4027] shadow-[#43643C]/20'"
                        x-text="item.tipe === 'jual' ? 'Konfirmasi Beli' : 'Kirim Pengajuan'">
                </button>
            </form>
        </div>
    </div>
</div>
</x-app-layout>