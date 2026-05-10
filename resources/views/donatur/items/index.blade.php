<x-app-layout>
<style>
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
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-black text-[#2C4027] tracking-tight">Katalog Barang Anda</h1>
            <p class="text-[#7A9375] font-medium text-sm mt-1">Kelola barang yang telah Anda unggah di Sisa Guna.</p>
        </div>
        <a href="{{ route('donatur.items.create') }}"
           class="bg-[#43643C] text-white px-8 py-3 rounded-full font-bold text-sm hover:-translate-y-1 hover:shadow-lg hover:shadow-[#43643C]/30 transition-all flex items-center gap-2">
            <span>+</span> Upload Barang
        </a>
    </div>

    @if(session('success'))
        <div class="bg-[#E9EFE3] text-[#2C4027] px-6 py-4 rounded-[24px] border border-[#43643C]/20 mb-8 font-semibold shadow-sm flex items-center gap-3">
            <span>✅</span> {{ session('success') }}
        </div>
    @endif

    @if($items->isEmpty())
        <div class="bg-white rounded-[40px] shadow-sm border border-[#E9EFE3] p-16 text-center">
            <div class="text-6xl mb-4">📦</div>
            <p class="text-[#7A9375] text-lg font-bold">Belum ada barang yang diupload.</p>
            <p class="text-[#7A9375] text-sm mb-6">Ayo mulai berbagi dan kurangi pemborosan!</p>
            <a href="{{ route('donatur.items.create') }}"
               class="inline-block bg-[#F2F5EB] text-[#43643C] px-8 py-3 rounded-full font-bold hover:bg-[#E9EFE3] transition-colors">
                Upload Sekarang →
            </a>
        </div>
    @else
        <div class="product-grid mb-12">
            @foreach($items as $item)
            <div class="prod-card flex flex-col">
                <div class="prod-img-box">
                    <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://placehold.co/400x300?text=No+Image' }}">
                    <div class="prod-tag {{ $item->status === 'available' ? 'bg-[#E9EFE3]/90 text-[#43643C]' : 'bg-gray-200/90 text-gray-700' }}">
                        {{ $item->status === 'available' ? 'Tersedia' : 'Habis/Tutup' }}
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
                    
                    <div class="mt-auto pt-4 border-t border-[#E9EFE3] flex gap-2">
                        <a href="{{ route('donatur.items.edit', $item) }}" 
                            class="flex-1 text-center py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all bg-[#F2F5EB] text-[#43643C] hover:bg-[#E9EFE3]">
                            Edit
                        </a>
                        <form action="{{ route('donatur.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus barang ini?')" class="flex-shrink-0">
                            @csrf @method('DELETE')
                            <button type="submit" 
                                class="w-10 h-10 flex items-center justify-center rounded-xl text-xs font-black transition-all bg-white border border-red-100 text-red-500 hover:bg-red-50">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $items->links() }}
        </div>
    @endif
</div>
</x-app-layout>