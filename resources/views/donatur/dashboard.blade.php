<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#2C4027] leading-tight">Dashboard Donatur</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6">

        <!-- Hero Banner -->
        <div class="bg-[#2C4027] rounded-[40px] overflow-hidden relative mb-12 shadow-2xl shadow-[#2C4027]/20">
            <div class="absolute w-[600px] h-[600px] bg-white rounded-full blur-[100px] opacity-10 -top-40 -right-40 pointer-events-none"></div>
            
            <div class="flex flex-col md:flex-row items-center p-10 md:p-16">
                <div class="md:w-3/5 z-10 text-white">
                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur border border-white/20 text-white text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest mb-6">
                        <img src="/storage/icon.png" class="aspect-square object-cover w-4 h-4 rounded-md"> Pahlawan Sisa Guna
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black leading-tight tracking-tighter mb-4">
                        Halo, {{ explode(' ', auth()->user()->name)[0] }}!
                    </h1>
                    <p class="text-white/70 text-lg font-medium mb-10 max-w-md">
                        Terima kasih telah berbagi dan mengurangi pemborosan. Kelola barang donasi dan jualan Anda dengan mudah di sini.
                    </p>

                    <!-- Floating Stat Cards inside Hero -->
                    <div class="flex flex-wrap gap-4">
                        <div class="bg-[#FACC15] rounded-3xl p-6 shadow-xl shadow-black/20 transform rotate-[-2deg] hover:rotate-0 transition-transform w-40">
                            <div class="text-[10px] font-black uppercase tracking-widest text-yellow-900 mb-1">Menunggu Proses</div>
                            <div class="text-3xl font-black text-yellow-900">{{ $requestPending }} Request</div>
                        </div>
                        <div class="bg-[#E9EFE3] rounded-3xl p-6 shadow-xl shadow-black/20 transform rotate-[3deg] hover:rotate-0 transition-transform w-40 border border-transparent">
                            <div class="text-[10px] font-black uppercase tracking-widest text-[#43643C] mb-1">Berhasil Disalurkan</div>
                            <div class="text-3xl font-black text-[#2C4027]">{{ $totalDisalurkan }} Barang</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur rounded-3xl p-6 shadow-xl shadow-black/10 transform rotate-[-1deg] hover:rotate-0 transition-transform w-40 border border-white/20 text-white">
                            <div class="text-[10px] font-black uppercase tracking-widest text-white/70 mb-1">Total Diupload</div>
                            <div class="text-3xl font-black">{{ $totalBarang }} Barang</div>
                        </div>
                    </div>
                </div>
                
                <div class="md:w-2/5 mt-10 md:mt-0 flex justify-center z-10">
                    <a href="{{ route('donatur.items.create') }}" class="group bg-white rounded-[40px] p-8 text-center w-full max-w-xs hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                        <div class="w-20 h-20 bg-[#F2F5EB] rounded-full flex items-center justify-center text-4xl mx-auto mb-6 group-hover:bg-[#43643C] group-hover:text-white transition-colors shadow-inner">
                            +
                        </div>
                        <h3 class="font-black text-[#2C4027] text-xl mb-2">Upload Barang Baru</h3>
                        <p class="text-[#7A9375] text-xs font-bold uppercase tracking-widest">Mulai Berbagi →</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Actions Bento Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Permintaan Klaim Terbaru -->
            <div class="bg-white rounded-[40px] border border-[#E9EFE3] p-8 shadow-sm flex flex-col h-full">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-black text-[#2C4027] tracking-tight">Request Masuk</h2>
                    <a href="{{ route('donatur.claims') }}" class="text-[#43643C] font-bold text-sm hover:underline">Kelola Semua →</a>
                </div>
                
                <div class="space-y-4 flex-1">
                    @forelse($recentClaims as $claim)
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-5 rounded-[24px] border border-[#E9EFE3] hover:border-[#43643C] hover:shadow-lg hover:shadow-[#43643C]/5 transition-all group">
                        <div class="flex items-center gap-4 mb-3 sm:mb-0">
                            <img src="{{ $claim->item->foto ? asset('storage/'.$claim->item->foto) : 'https://placehold.co/100x100?text=Item' }}" class="w-14 h-14 rounded-2xl object-cover shadow-sm group-hover:scale-105 transition-transform">
                            <div>
                                <h4 class="font-bold text-[#2C4027]">{{ $claim->item->nama_barang }}</h4>
                                <p class="text-[10px] font-black uppercase tracking-widest text-[#7A9375]">Dari: {{ $claim->penerima->name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-4 py-1.5 text-[10px] rounded-full font-black uppercase tracking-widest
                                {{ $claim->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                  ($claim->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($claim->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center h-full text-center py-8">
                        <img src="/storage/icon.png" class="aspect-square object-cover w-12 h-12 rounded-xl opacity-30 mb-4">
                        <p class="text-[#7A9375] font-bold">Belum ada permintaan masuk.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Barang Terbaru -->
            <div class="bg-white rounded-[40px] border border-[#E9EFE3] p-8 shadow-sm flex flex-col h-full">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-black text-[#2C4027] tracking-tight">Barang Anda</h2>
                    <a href="{{ route('donatur.items.index') }}" class="text-[#43643C] font-bold text-sm hover:underline">Kelola Katalog →</a>
                </div>
                
                <div class="space-y-4 flex-1">
                    @forelse($recentItems as $item)
                    <div class="flex items-center gap-4 p-5 rounded-[24px] border border-[#E9EFE3] hover:border-[#43643C] hover:shadow-lg hover:shadow-[#43643C]/5 transition-all group">
                        <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://placehold.co/100x100?text=No+Image' }}" class="w-14 h-14 rounded-2xl object-cover shadow-sm group-hover:scale-105 transition-transform">
                        <div class="flex-1">
                            <h4 class="font-bold text-[#2C4027]">{{ $item->nama_barang }}</h4>
                            <p class="text-[10px] font-black uppercase tracking-widest text-[#7A9375]">{{ $item->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-4 py-1.5 text-[10px] rounded-full font-black uppercase tracking-widest {{ $item->status === 'available' ? 'bg-[#E9EFE3] text-[#43643C]' : 'bg-gray-100 text-gray-500' }}">
                                Sisa: {{ $item->jumlah }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center h-full text-center py-8">
                        <div class="text-4xl mb-4">📦</div>
                        <p class="text-[#7A9375] font-bold">Katalog barang masih kosong.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>