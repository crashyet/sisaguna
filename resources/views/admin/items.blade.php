<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-black text-[#2C4027] tracking-tight">Manajemen Barang</h1>
                <p class="text-[#7A9375] font-medium text-sm mt-1">Validasi dan pantau sirkulasi barang di platform.</p>
            </div>
        </div>


        <div class="bg-white rounded-[40px] shadow-sm border border-[#E9EFE3] overflow-hidden p-2">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr
                            class="text-[#7A9375] uppercase text-[10px] font-black tracking-widest border-b-2 border-[#F2F5EB]">
                            <th class="px-6 py-5 text-left">Produk</th>
                            <th class="px-6 py-5 text-left">Donatur</th>
                            <th class="px-6 py-5 text-left">Tipe</th>
                            <th class="px-6 py-5 text-left">Lokasi</th>
                            <th class="px-6 py-5 text-left">Status</th>
                            <th class="px-6 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F2F5EB]">
                        @foreach($items as $item)
                            <tr class="hover:bg-[#F9FBF7] transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        @if($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}"
                                                class="w-14 h-14 object-cover rounded-[16px] border border-[#E9EFE3] shadow-sm group-hover:scale-105 transition-transform">
                                        @else
                                            <div
                                                class="w-14 h-14 bg-[#F2F5EB] rounded-[16px] flex items-center justify-center text-xl shadow-sm">
                                                📦</div>
                                        @endif
                                        <div>
                                            <div class="font-black text-[#2C4027] text-base mb-1">{{ $item->nama_barang }}
                                            </div>
                                            <div
                                                class="text-[9px] text-[#43643C] bg-[#F2F5EB] px-2 py-0.5 rounded-full inline-block uppercase font-black tracking-widest">
                                                {{ str_replace('_', ' ', $item->kategori) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-[#2C4027]">{{ $item->donatur->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->tipe === 'jual')
                                        <span
                                            class="bg-[#F2F5EB] text-[#43643C] px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">🏷️
                                            Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                    @else
                                        <span
                                            class="bg-[#E9EFE3] text-[#2C4027] px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">🎁
                                            GRATIS</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-[#7A9375] font-bold text-xs">{{ $item->kota }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusStyle = match ($item->status) {
                                            'available' => 'bg-[#E9EFE3] text-[#43643C]',
                                            'claimed' => 'bg-yellow-100 text-yellow-800',
                                            'done' => 'bg-gray-100 text-gray-500',
                                            default => 'bg-red-50 text-red-600'
                                        };
                                    @endphp
                                    <span
                                        class="{{ $statusStyle }} px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.items.delete', $item) }}" method="POST"
                                        onsubmit="return confirm('Hapus barang ini secara permanen?')">
                                        @csrf @method('DELETE')
                                        <button
                                            class="bg-white border-2 border-red-100 text-red-500 w-10 h-10 rounded-[14px] flex items-center justify-center hover:bg-red-50 hover:border-red-200 hover:scale-110 transition-all mx-auto">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if($items->isEmpty())
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-[#7A9375] font-bold">
                                    <div class="text-4xl mb-3">📦</div>
                                    Belum ada barang di platform.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">{{ $items->links() }}</div>
    </div>
</x-app-layout>