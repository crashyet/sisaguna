<x-app-layout>
<style>
    :root {
        --sage-prime: #43643C;
        --sage-soft: #7A9375;
        --sage-light: #E9EFE3;
        --sage-surface: #F9FBF7;
    }
    .pay-wrap { max-width: 580px; margin: 0 auto; padding: 1rem 0; }
    .pay-card { 
        background: #fff; border-radius: 28px; border: 1px solid var(--sage-light); 
        padding: 2rem; margin-bottom: 1.5rem; box-shadow: 0 4px 20px rgba(67, 100, 60, 0.05); 
    }
    .pay-card-title { 
        font-size: 0.75rem; font-weight: 800; color: var(--sage-soft); 
        text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1.5rem; 
    }
    .order-row { display: flex; gap: 1.5rem; align-items: center; }
    .order-img { 
        width: 90px; height: 90px; border-radius: 20px; object-fit: cover; 
        background: var(--sage-surface); flex-shrink: 0; overflow: hidden; 
    }
    .order-name { font-weight: 800; font-size: 1.15rem; color: #2C4027; margin-bottom: 0.25rem; }
    .order-meta { font-size: 0.85rem; color: var(--sage-soft); font-weight: 500; }
    
    .order-total { 
        display: flex; justify-content: space-between; align-items: center; 
        padding-top: 1.5rem; margin-top: 1.5rem; border-top: 2px dashed var(--sage-light); 
    }
    .order-total-amount { font-size: 1.5rem; font-weight: 900; color: var(--sage-prime); }

    .bank-info { background: #F2F5EB; border-radius: 20px; padding: 1.25rem; margin-bottom: 1.5rem; }
    .bank-row { font-size: 0.9rem; color: var(--sage-prime); font-weight: 700; margin-bottom: 0.4rem; }
    .bank-row code { background: white; padding: 2px 8px; border-radius: 6px; margin-left: 5px; }

    .metode-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; }
    .metode-lbl {
        display: flex; flex-direction: column; align-items: center; gap: 0.5rem;
        padding: 1.25rem; border: 2px solid var(--sage-light); border-radius: 20px;
        cursor: pointer; transition: all 0.2s;
    }
    .metode-opt input:checked ~ .metode-lbl { 
        border-color: var(--sage-prime); background: #F2F5EB; transform: scale(1.02);
    }

    .upload-area { 
        border: 2px dashed var(--sage-light); border-radius: 20px; padding: 2rem; 
        text-align: center; margin-bottom: 1.5rem; cursor: pointer;
    }
    .upload-area:hover { border-color: var(--sage-prime); background: var(--sage-surface); }

    .pay-submit {
        width: 100%; padding: 1.1rem; background: var(--sage-prime); color: #fff;
        border-radius: 20px; font-weight: 800; font-size: 0.9rem; text-transform: uppercase;
        letter-spacing: 0.05em; transition: all 0.3s;
    }
    .pay-submit:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(67, 100, 60, 0.2); }
</style>

<div class="max-w-2xl mx-auto py-12 px-6">
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-black text-[#2C4027] tracking-tight">Selesaikan Pembayaran</h2>
        <p class="text-[#7A9375] font-medium mt-2">Pastikan detail pesanan sudah sesuai sebelum membayar.</p>
    </div>

    {{-- Detail Pesanan --}}
    <div class="bg-white rounded-[40px] border border-[#E9EFE3] p-8 md:p-12 shadow-2xl shadow-[#43643C]/5 mb-8 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-[#43643C]"></div>
        
        <div class="flex items-center gap-2 mb-8">
            <span class="text-xl">📦</span>
            <h3 class="text-xs font-black text-[#7A9375] uppercase tracking-widest">Detail Pesanan</h3>
        </div>

        <div class="flex flex-col md:flex-row gap-6 items-start md:items-center p-6 bg-[#F9FBF7] rounded-[32px] border border-[#E9EFE3] mb-8 group hover:border-[#43643C] transition-colors">
            <img src="{{ $claim->item->foto ? asset('storage/'.$claim->item->foto) : 'https://placehold.co/200' }}" class="w-24 h-24 rounded-2xl object-cover shadow-sm group-hover:scale-105 transition-transform">
            <div class="flex-1">
                <h4 class="font-black text-xl text-[#2C4027] mb-1">{{ $claim->item->nama_barang }}</h4>
                <div class="text-sm font-bold text-[#43643C] bg-[#E9EFE3] px-3 py-1 rounded-full inline-block mb-2">Jumlah: {{ $claim->jumlah }} {{ $claim->item->satuan }}</div>
                <p class="text-xs text-[#7A9375] font-medium">📍 {{ $claim->item->kota }} &nbsp;·&nbsp; Penjual: {{ $claim->item->donatur->name }}</p>
            </div>
            <div class="text-right mt-4 md:mt-0">
                <span class="block text-[10px] font-black text-[#7A9375] uppercase tracking-widest mb-1">Harga Satuan</span>
                <span class="font-bold text-[#2C4027]">Rp {{ number_format($claim->item->harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="pt-8 border-t-2 border-dashed border-[#E9EFE3] flex justify-between items-end">
            <div>
                <span class="block text-xs font-black text-[#7A9375] uppercase tracking-widest mb-1">Total Tagihan</span>
                <span class="text-3xl font-black text-[#43643C]">Rp {{ number_format($claim->item->harga * $claim->jumlah, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Form Pembayaran --}}
    @if(!$payment || $payment->status === 'rejected')
    <div class="bg-white rounded-[40px] border border-[#E9EFE3] p-8 md:p-12 shadow-2xl shadow-[#43643C]/5">
        <div class="flex items-center gap-2 mb-8">
            <span class="text-xl">💳</span>
            <h3 class="text-xs font-black text-[#7A9375] uppercase tracking-widest">Metode Pembayaran</h3>
        </div>
        
        <div class="bg-[#2C4027] text-white rounded-[32px] p-8 mb-8 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 text-9xl opacity-10">🏦</div>
            <p class="text-xs font-black text-white/70 uppercase tracking-widest mb-4">Transfer ke Rekening Resmi</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div class="bg-white/10 backdrop-blur rounded-2xl p-4 border border-white/20">
                    <div class="text-[10px] text-white/70 font-bold uppercase tracking-widest mb-1">BCA</div>
                    <div class="font-black text-xl tracking-wider">1234 5678 90</div>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-2xl p-4 border border-white/20">
                    <div class="text-[10px] text-white/70 font-bold uppercase tracking-widest mb-1">BRI</div>
                    <div class="font-black text-xl tracking-wider">0987 6543 21</div>
                </div>
            </div>
            <p class="text-[10px] font-black uppercase tracking-widest text-yellow-400">A.N. SISA GUNA OFFICIAL</p>
        </div>

        <form action="{{ route('penerima.payment.store', $claim) }}" method="POST" enctype="multipart/form-data" x-data="{ metode: 'transfer' }">
            @csrf
            
            <div class="grid grid-cols-2 gap-4 mb-8">
                <label class="relative cursor-pointer group">
                    <input type="radio" name="metode" value="transfer" x-model="metode" class="peer hidden" checked>
                    <div class="p-6 rounded-[24px] border-2 border-[#E9EFE3] text-center peer-checked:border-[#43643C] peer-checked:bg-[#F2F5EB] transition-all group-hover:border-[#43643C]">
                        <span class="text-3xl block mb-2">📲</span>
                        <span class="font-black text-xs text-[#2C4027] uppercase tracking-widest">Transfer Bank</span>
                    </div>
                    <div class="absolute top-4 right-4 w-4 h-4 rounded-full border-2 border-[#E9EFE3] peer-checked:border-4 peer-checked:border-[#43643C]"></div>
                </label>
                
                <label class="relative cursor-pointer group">
                    <input type="radio" name="metode" value="cod" x-model="metode" class="peer hidden">
                    <div class="p-6 rounded-[24px] border-2 border-[#E9EFE3] text-center peer-checked:border-[#43643C] peer-checked:bg-[#F2F5EB] transition-all group-hover:border-[#43643C]">
                        <span class="text-3xl block mb-2">🤝</span>
                        <span class="font-black text-xs text-[#2C4027] uppercase tracking-widest">COD (Di Tempat)</span>
                    </div>
                    <div class="absolute top-4 right-4 w-4 h-4 rounded-full border-2 border-[#E9EFE3] peer-checked:border-4 peer-checked:border-[#43643C]"></div>
                </label>
            </div>

            <div x-show="metode === 'transfer'" class="mb-8" x-transition>
                <label class="block w-full p-8 border-2 border-dashed border-[#E9EFE3] rounded-[32px] text-center cursor-pointer hover:border-[#43643C] hover:bg-[#F9FBF7] transition-all">
                    <span class="text-4xl mb-4 block">📎</span>
                    <span class="block text-xs font-black text-[#43643C] uppercase tracking-widest mb-2">Upload Bukti Transfer</span>
                    <span class="block text-[10px] font-bold text-[#7A9375]">Format JPG/PNG, Maks 2MB</span>
                    <input type="file" name="bukti_transfer" class="hidden">
                </label>
            </div>

            <button type="submit" class="w-full py-5 bg-[#2563EB] text-white rounded-[24px] font-black text-sm uppercase tracking-widest hover:bg-blue-700 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-500/30 transition-all">
                Konfirmasi & Selesaikan →
            </button>
        </form>
    </div>
    @else
    {{-- Status Pembayaran (Sudah Bayar) --}}
    <div class="bg-white rounded-[40px] border border-[#E9EFE3] p-8 md:p-12 shadow-2xl shadow-[#43643C]/5 text-center">
        @if($payment->status === 'pending')
            <div class="w-24 h-24 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">⏳</div>
            <h3 class="text-2xl font-black text-[#2C4027] mb-2">Pembayaran Diproses</h3>
            <p class="text-[#7A9375] font-medium mb-8">Mohon tunggu, donatur sedang memverifikasi bukti pembayaran Anda.</p>
        @elseif($payment->status === 'approved')
            <div class="w-24 h-24 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">✅</div>
            <h3 class="text-2xl font-black text-[#2C4027] mb-2">Pembayaran Berhasil!</h3>
            <p class="text-[#7A9375] font-medium mb-8">Pembayaran Anda telah disetujui. Silakan ambil barang Anda.</p>
        @endif
        
        <div class="bg-[#F9FBF7] border border-[#E9EFE3] rounded-[24px] p-6 max-w-sm mx-auto text-left">
            <div class="text-[10px] font-black text-[#7A9375] uppercase tracking-widest mb-4">Ringkasan</div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-bold text-[#2C4027]">Metode</span>
                <span class="text-sm font-black text-[#43643C] uppercase">{{ $payment->metode }}</span>
            </div>
            @if($payment->metode === 'transfer' && $payment->bukti_transfer)
            <div class="mt-4 pt-4 border-t border-[#E9EFE3]">
                <img src="{{ asset('storage/'.$payment->bukti_transfer) }}" class="w-full rounded-xl">
            </div>
            @endif
        </div>
        
        <div class="mt-8">
            <a href="{{ route('penerima.riwayat') }}" class="inline-block px-8 py-4 bg-[#F2F5EB] text-[#43643C] rounded-full font-bold text-sm hover:bg-[#E9EFE3] transition-colors">
                ← Kembali ke Riwayat
            </a>
        </div>
    </div>
    @endif
</div>
</x-app-layout>