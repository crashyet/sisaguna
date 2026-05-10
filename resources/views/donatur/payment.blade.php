<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#2C4027] leading-tight">Konfirmasi Pembayaran</h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-6">
        <div class="mb-10">
            <h1 class="text-3xl font-black text-[#2C4027] tracking-tight">Konfirmasi Pembayaran</h1>
            <p class="text-[#7A9375] font-medium text-sm mt-1">Verifikasi bukti pembayaran dari penerima.</p>
        </div>


        @if($payments->isEmpty())
            <div class="bg-white p-16 rounded-[40px] shadow-sm border border-[#E9EFE3] text-center">
                <div class="text-6xl mb-4">💳</div>
                <p class="text-[#7A9375] font-black text-lg">Belum ada pembayaran masuk saat ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($payments as $payment)
                <div class="bg-white rounded-[40px] shadow-sm border border-[#E9EFE3] p-8 transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-[#43643C]/5 flex flex-col">
                    <div class="flex items-start gap-5 mb-6">
                        @if($payment->claim->item->foto)
                            <img src="{{ asset('storage/'.$payment->claim->item->foto) }}"
                                 class="w-20 h-20 object-cover rounded-[20px] border border-[#E9EFE3] shadow-sm flex-shrink-0">
                        @else
                            <div class="w-20 h-20 bg-[#F9FBF7] rounded-[20px] flex items-center justify-center text-[#A6BBA0] text-3xl border border-[#E9EFE3] flex-shrink-0">📦</div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <h3 class="font-black text-xl text-[#2C4027] leading-tight mb-2 truncate">{{ $payment->claim->item->nama_barang }}</h3>
                            <div class="flex flex-wrap gap-2 mb-2">
                                <span class="text-[9px] bg-[#F2F5EB] text-[#43643C] px-3 py-1 rounded-full font-black uppercase tracking-widest">
                                    {{ $payment->metode === 'transfer' ? '🏦 Transfer' : '🤝 COD' }}
                                </span>
                                @php
                                    $statusStyle = match($payment->status) {
                                        'pending'  => 'bg-yellow-100 text-yellow-800',
                                        'verified' => 'bg-[#E9EFE3] text-[#43643C]',
                                        'rejected' => 'bg-red-50 text-red-600',
                                        default    => 'bg-gray-100 text-gray-600'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $statusStyle }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </div>
                            <div class="text-[10px] font-bold text-[#A6BBA0] uppercase tracking-widest">
                                Jml: {{ $payment->claim->jumlah }} | Total: <span class="text-[#43643C]">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#F9FBF7] rounded-[24px] p-5 mb-6 flex-1 border border-[#E9EFE3]">
                        <div class="flex items-center gap-3 mb-4 border-b border-[#E9EFE3] pb-4">
                            <div class="w-8 h-8 rounded-full bg-[#43643C] flex items-center justify-center text-xs font-black text-white">
                                {{ strtoupper(substr($payment->claim->penerima->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-[9px] font-black uppercase tracking-widest text-[#7A9375]">Pembeli</div>
                                <div class="text-sm font-bold text-[#2C4027]">{{ $payment->claim->penerima->name }} <span class="text-[10px] text-[#7A9375] font-normal">— {{ $payment->claim->penerima->kota }}</span></div>
                            </div>
                        </div>
                        
                        {{-- Bukti Transfer dengan tampilan premium --}}
                        @if($payment->bukti_transfer)
                            <p class="text-[9px] font-black text-[#7A9375] uppercase tracking-widest mb-2">Lampiran Bukti Transfer</p>
                            <div class="relative group w-32">
                                <img src="{{ asset('storage/'.$payment->bukti_transfer) }}"
                                     class="w-32 h-auto rounded-[16px] border border-[#E9EFE3] shadow-sm cursor-zoom-in transition transform hover:scale-105"
                                     onclick="window.open(this.src)">
                            </div>
                        @else
                            <p class="text-xs text-[#7A9375] italic">Tidak ada lampiran (COD).</p>
                        @endif
                    </div>

                    @if($payment->status === 'pending')
                        <div class="mt-auto flex flex-wrap gap-3">
                            <form action="{{ route('donatur.payments.verify', $payment) }}" method="POST" class="flex-1 min-w-[120px]">
                                @csrf @method('PATCH')
                                <button class="w-full bg-[#43643C] text-white py-3.5 rounded-[20px] text-[10px] font-black uppercase tracking-widest hover:bg-[#2C4027] hover:-translate-y-1 transition-all shadow-lg shadow-[#43643C]/20">
                                    Setujui
                                </button>
                            </form>
                            <form action="{{ route('donatur.payments.reject', $payment) }}" method="POST" class="flex-1 min-w-[120px]">
                                @csrf @method('PATCH')
                                <button class="w-full bg-white border-2 border-[#E9EFE3] text-red-500 py-3 rounded-[20px] text-[10px] font-black uppercase tracking-widest hover:bg-red-50 hover:border-red-200 transition-colors">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>

            <div class="mt-10">{{ $payments->links() }}</div>
        @endif
    </div>
</x-app-layout>