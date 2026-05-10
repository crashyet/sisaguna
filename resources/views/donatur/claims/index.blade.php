{{-- Modal Bukti Transfer --}}
<div id="buktiModal"
     class="fixed inset-0 bg-[#2C4027]/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4"
     onclick="closeBukti(event)">
    <div class="bg-white rounded-[40px] shadow-2xl max-w-md w-full p-8" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="font-black text-xl text-[#2C4027]" id="modalBarang"></h3>
                <p class="text-xs font-bold text-[#7A9375] uppercase tracking-widest" id="modalPembeli"></p>
            </div>
            <button onclick="closeBukti()"
                class="text-[#7A9375] hover:text-[#2C4027] text-3xl leading-none transition">&times;</button>
        </div>
        <div class="relative group">
            <img id="modalImg" src="" alt="Bukti Transfer"
                 class="w-full rounded-[30px] border-4 border-[#F2F5EB] cursor-zoom-in shadow-sm transition transform hover:scale-[1.02]"
                 onclick="window.open(this.src, '_blank')">
        </div>
        <p class="text-[10px] font-bold text-[#A6BBA0] text-center mt-4 uppercase tracking-tighter">Klik gambar untuk memperbesar di tab baru</p>
    </div>
</div>

<script>
function showBukti(src, barang, pembeli) {
    document.getElementById('modalImg').src = src;
    document.getElementById('modalBarang').textContent = barang;
    document.getElementById('modalPembeli').textContent = 'Pembeli: ' + pembeli;
    document.getElementById('buktiModal').classList.remove('hidden');
    document.getElementById('buktiModal').classList.add('flex');
}

function closeBukti(e) {
    if (!e || e.target === document.getElementById('buktiModal')) {
        document.getElementById('buktiModal').classList.add('hidden');
        document.getElementById('buktiModal').classList.remove('flex');
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeBukti();
});
</script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#2C4027] leading-tight">Request Masuk</h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-6">
        <div class="mb-10">
            <h1 class="text-3xl font-black text-[#2C4027] tracking-tight">Request Masuk</h1>
            <p class="text-[#7A9375] font-medium text-sm mt-1">Kelola permintaan klaim dari penerima donasi.</p>
        </div>


        @if($claims->isEmpty())
            <div class="bg-white p-16 rounded-[40px] shadow-sm border border-[#E9EFE3] text-center">
                <div class="text-6xl mb-4">📭</div>
                <p class="text-[#7A9375] font-black text-lg">Belum ada request masuk saat ini.</p>
                <p class="text-[#7A9375] font-medium mt-2">Permintaan dari penerima akan muncul di sini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($claims as $claim)
                <div class="bg-white rounded-[40px] shadow-sm border border-[#E9EFE3] p-8 transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-[#43643C]/5 flex flex-col">
                    <div class="flex items-start gap-5 mb-6">
                        @if($claim->item->foto)
                            <img src="{{ asset('storage/'.$claim->item->foto) }}"
                                 class="w-24 h-24 object-cover rounded-[24px] border border-[#E9EFE3] shadow-sm flex-shrink-0">
                        @else
                            <div class="w-24 h-24 bg-[#F9FBF7] rounded-[24px] flex items-center justify-center text-[#A6BBA0] text-3xl border border-[#E9EFE3] flex-shrink-0">📦</div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <h3 class="font-black text-xl text-[#2C4027] leading-tight mb-2 truncate">{{ $claim->item->nama_barang }}</h3>
                            <div class="flex flex-wrap gap-2 mb-2">
                                @if($claim->item->tipe === 'jual')
                                    <span class="text-[9px] bg-[#F2F5EB] text-[#43643C] px-3 py-1 rounded-full font-black uppercase tracking-widest">
                                        🏷️ Rp {{ number_format($claim->item->harga, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-[9px] bg-[#E9EFE3] text-[#2C4027] px-3 py-1 rounded-full font-black uppercase tracking-widest">
                                        🎁 Donasi
                                    </span>
                                @endif
                                @php
                                    $statusStyle = match($claim->status) {
                                        'pending'  => 'bg-yellow-100 text-yellow-800',
                                        'approved' => 'bg-[#E9EFE3] text-[#43643C]',
                                        'rejected' => 'bg-red-50 text-red-600',
                                        default    => 'bg-gray-100 text-gray-600'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $statusStyle }}">
                                    {{ ucfirst($claim->status) }}
                                </span>
                            </div>
                            <div class="text-[10px] font-bold text-[#A6BBA0] uppercase tracking-widest">
                                Request: <span class="text-[#43643C]">{{ $claim->jumlah }} {{ $claim->item->satuan }}</span> 
                                <span class="mx-1">|</span> Sisa: {{ $claim->item->jumlah }}
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#F9FBF7] rounded-[24px] p-5 mb-6 flex-1 border border-[#E9EFE3]">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-full bg-[#43643C] flex items-center justify-center text-xs font-black text-white">
                                {{ strtoupper(substr($claim->penerima->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-[#2C4027]">{{ $claim->penerima->name }}</div>
                                <div class="text-[10px] font-bold text-[#7A9375] uppercase tracking-widest">{{ $claim->penerima->kota }}</div>
                            </div>
                        </div>
                        <p class="text-xs text-[#43643C] italic leading-relaxed pl-3 border-l-2 border-[#43643C]/30">
                            "{{ $claim->alasan }}"
                        </p>
                    </div>

                    <div class="mt-auto flex flex-wrap gap-3">
                        @if($claim->status === 'pending')
                            @if($claim->item->tipe === 'donasi')
                                <form action="{{ route('donatur.claims.approve', $claim) }}" method="POST" class="flex-1 min-w-[120px]">
                                    @csrf @method('PATCH')
                                    <button class="w-full bg-[#43643C] text-white py-3.5 rounded-[20px] text-[10px] font-black uppercase tracking-widest hover:bg-[#2C4027] hover:-translate-y-1 transition-all shadow-lg shadow-[#43643C]/20">
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('donatur.claims.reject', $claim) }}" method="POST" class="flex-1 min-w-[120px]">
                                    @csrf @method('PATCH')
                                    <button class="w-full bg-white border-2 border-[#E9EFE3] text-red-500 py-3 rounded-[20px] text-[10px] font-black uppercase tracking-widest hover:bg-red-50 hover:border-red-200 transition-colors">
                                        Tolak
                                    </button>
                                </form>
                            @else
                                <div class="w-full text-center bg-yellow-50 text-yellow-800 border border-yellow-200 py-3.5 rounded-[20px] text-[10px] font-black uppercase tracking-widest">
                                    ⏳ Menunggu Pembayaran
                                </div>
                            @endif
                        @endif

                        {{-- Info Pembayaran Khusus Barang Jual --}}
                        @if($claim->item->tipe === 'jual' && $claim->payment && $claim->status !== 'rejected')
                            @if($claim->payment->bukti_transfer)
                                <button onclick="showBukti('{{ asset('storage/'.$claim->payment->bukti_transfer) }}', '{{ addslashes($claim->item->nama_barang) }}', '{{ addslashes($claim->penerima->name) }}')"
                                    class="w-full mt-2 text-[10px] bg-white border-2 border-[#E9EFE3] text-[#43643C] py-3 rounded-[20px] font-black uppercase tracking-widest hover:bg-[#F2F5EB] transition-colors">
                                    🖼️ Cek Bukti Transfer
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-10">{{ $claims->links() }}</div>
        @endif
    </div>
</x-app-layout>