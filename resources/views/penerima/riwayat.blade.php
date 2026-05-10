<x-app-layout>
<style>
    .riwayat-row {
        background: #fff; border-radius: 24px; border: 1px solid var(--sage-light);
        padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 1.25rem;
        margin-bottom: 1rem; transition: all 0.3s;
    }
    .riwayat-row:hover { transform: translateX(8px); border-color: var(--sage-prime); }
    .riwayat-thumb {
        width: 60px; height: 60px; border-radius: 16px; flex-shrink: 0;
        background: var(--sage-surface); overflow: hidden;
    }
    .riwayat-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .badge-status {
        padding: 6px 12px; border-radius: 12px; font-size: 10px; font-weight: 900; 
        text-transform: uppercase; letter-spacing: 0.05em;
    }
    .bg-pending { background: #FEF3C7; color: #92400E; }
    .bg-approved { background: #DCFCE7; color: #166534; }
    .bg-rejected { background: #FEE2E2; color: #991B1B; }
</style>

<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
        <div>
            <h2 class="text-3xl font-black text-[#2C4027] tracking-tight">Riwayat Klaim Saya</h2>
            <p class="text-[#7A9375] font-medium mt-1">Pantau status pengajuan barang dan pembayaran Anda di sini.</p>
        </div>
        <a href="{{ route('penerima.katalog') }}" class="bg-[#43643C] text-white px-8 py-4 rounded-full font-bold text-sm shadow-xl shadow-[#43643C]/20 hover:bg-[#2C4027] hover:-translate-y-1 transition-all">
            + Cari Barang Lagi
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($claims as $claim)
        <div class="bg-white rounded-[32px] border border-[#E9EFE3] overflow-hidden flex flex-col transition-all duration-300 hover:shadow-2xl hover:shadow-[#43643C]/5 hover:-translate-y-2 group">
            <div class="relative h-56 overflow-hidden">
                <img src="{{ $claim->item->foto ? asset('storage/'.$claim->item->foto) : 'https://placehold.co/400x300' }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                
                {{-- Status Badge --}}
                <div class="absolute top-4 right-4 backdrop-blur-md px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm
                    {{ $claim->status === 'pending' ? 'bg-yellow-400/90 text-yellow-900' : 
                      ($claim->status === 'approved' ? 'bg-green-500/90 text-white' : 'bg-red-500/90 text-white') }}">
                    {{ $claim->status === 'pending' ? 'Menunggu' : ($claim->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                </div>

                {{-- Tipe Barang --}}
                <div class="absolute bottom-4 left-4 bg-white/95 backdrop-blur px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm
                    {{ $claim->item->tipe === 'jual' ? 'text-blue-600' : 'text-green-600' }}">
                    {{ $claim->item->tipe === 'jual' ? 'Beli' : 'Gratis' }}
                </div>
            </div>

            <div class="p-8 flex flex-col flex-1">
                <div class="mb-4">
                    <h3 class="font-black text-xl text-[#2C4027] leading-tight">{{ $claim->item->nama_barang }}</h3>
                    <p class="text-xs font-bold text-[#7A9375] mt-2 flex items-center gap-1">
                        <span>📍 {{ $claim->item->kota }}</span>
                        <span>•</span>
                        <span>{{ $claim->created_at->format('d M Y') }}</span>
                    </p>
                </div>

                <div class="bg-[#F9FBF7] rounded-3xl p-5 mb-8 border border-[#E9EFE3]">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-xs text-[#7A9375] font-bold uppercase tracking-wider">Jumlah Diminta</span>
                        <span class="font-black text-base text-[#2C4027]">{{ $claim->jumlah }} {{ $claim->item->satuan }}</span>
                    </div>
                    @if($claim->item->tipe === 'jual')
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-xs text-[#7A9375] font-bold uppercase tracking-wider">Total Harga</span>
                        <span class="font-black text-base text-[#2C4027]">Rp {{ number_format($claim->item->harga * $claim->jumlah, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="mt-4 pt-4 border-t border-[#E9EFE3]/60 w-full overflow-hidden">
                        <span class="text-[10px] text-[#7A9375] font-black uppercase tracking-widest block mb-2">Alasan Pengajuan</span>
                        <p class="text-sm text-[#2C4027] italic leading-relaxed break-all">"{{ $claim->alasan }}"</p>
                    </div>
                </div>

                <div class="mt-auto">
                    @if($claim->item->tipe === 'jual' && $claim->status !== 'rejected')
                        @if($claim->payment)
                            <a href="{{ route('penerima.payment.show', $claim) }}" class="block w-full text-center py-4 rounded-2xl font-black text-xs uppercase tracking-widest bg-[#F2F5EB] text-[#43643C] hover:bg-[#E9EFE3] transition-colors">
                                🧾 Lihat Bukti Pembayaran
                            </a>
                        @else
                            <a href="{{ route('penerima.payment.show', $claim) }}" class="block w-full text-center py-4 rounded-2xl font-black text-xs uppercase tracking-widest bg-[#2563EB] text-white hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-1">
                                💳 Lanjutkan Pembayaran
                            </a>
                        @endif
                    @elseif($claim->status === 'rejected')
                        <div class="w-full text-center py-4 rounded-2xl font-black text-xs uppercase tracking-widest bg-red-50 text-red-500 border border-red-100">
                            Klaim Ditolak
                        </div>
                    @else
                        {{-- Barang Gratis & status bukan rejected --}}
                        @if($claim->status === 'pending')
                        <div class="w-full text-center py-4 rounded-2xl font-black text-xs uppercase tracking-widest bg-yellow-50 text-yellow-700 border border-yellow-100">
                            Menunggu Persetujuan Donatur
                        </div>
                        @else
                        <div class="w-full text-center py-4 rounded-2xl font-black text-xs uppercase tracking-widest bg-green-50 text-green-700 border border-green-100">
                            Silakan Ambil Barang
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-24 bg-white rounded-[40px] border-2 border-dashed border-[#E9EFE3]">
            <div class="w-24 h-24 bg-[#F9FBF7] rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="text-5xl">🍃</span>
            </div>
            <h3 class="text-2xl font-black text-[#2C4027] mb-2">Belum Ada Riwayat</h3>
            <p class="font-medium text-[#7A9375] mb-8">Anda belum pernah mengajukan klaim barang apapun.</p>
            <a href="{{ route('penerima.katalog') }}" class="inline-block bg-[#43643C] text-white px-8 py-4 rounded-full font-bold text-sm shadow-xl shadow-[#43643C]/20 hover:bg-[#2C4027] transition-all">
                Mulai Cari Barang
            </a>
        </div>
        @endforelse
    </div>

    <div class="mt-12">{{ $claims->links() }}</div>
</div>
</x-app-layout>