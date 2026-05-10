<x-app-layout>
    <div class="max-w-2xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-black text-[#2C4027] mb-8 text-center">
            {{ isset($item) ? 'Edit Detail Barang' : 'Upload Barang Baru' }}
        </h1>

        <div class="bg-white p-10 rounded-[40px] shadow-sm border border-[#E9EFE3]">
            @if($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-[20px] mb-6 text-sm font-medium">
                    <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ isset($item) ? route('donatur.items.update', $item) : route('donatur.items.store') }}"
                method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ 
                      tipe: '{{ old('tipe', isset($item) ? $item->tipe : 'donasi') }}', 
                      kategori: '{{ old('kategori', $item->kategori ?? '') }}',
                      harga: {{ old('harga', $item->harga ?? 0) }},
                      jumlah: {{ old('jumlah', $item->jumlah ?? 1) }}
                  }">
                @csrf
                @if(isset($item)) @method('PUT') @endif

                {{-- Nama Barang --}}
                <div>
                    <label class="block text-xs font-black text-[#7A9375] uppercase tracking-widest mb-2 ml-4">Nama
                        Barang *</label>
                    <input type="text" name="nama_barang" value="{{ old('nama_barang', $item->nama_barang ?? '') }}"
                        class="w-full border-[#E9EFE3] bg-[#F9FBF7] rounded-full px-6 py-3 focus:border-[#43643C] focus:ring-[#43643C] text-[#2C4027]"
                        placeholder="Contoh: Beras 5kg, Kaos layak pakai">
                </div>

                {{-- Tipe Listing --}}
                <div>
                    <label class="block text-xs font-black text-[#7A9375] uppercase tracking-widest mb-3 ml-4">Tipe
                        Listing</label>
                    <div class="flex gap-4 ml-2">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="tipe" value="donasi" x-model="tipe"
                                class="text-[#43643C] focus:ring-[#43643C]">
                            <span class="text-sm font-bold text-[#43643C] group-hover:text-[#2C4027]">🎁 Donasi</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="tipe" value="jual" x-model="tipe"
                                class="text-[#43643C] focus:ring-[#43643C]">
                            <span class="text-sm font-bold text-[#43643C] group-hover:text-[#2C4027]">🏷️ Jual
                                Murah</span>
                        </label>
                    </div>
                </div>

                {{-- Harga (Kondisional) --}}
                <div x-show="tipe === 'jual'" x-transition x-cloak>
                    <label class="block text-xs font-black text-[#7A9375] uppercase tracking-widest mb-2 ml-4">Harga
                        Satuan (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-6 top-3 text-[#A6BBA0] font-bold">Rp</span>
                        <input type="number" name="harga" x-model="harga"
                            class="w-full border-[#E9EFE3] bg-[#F9FBF7] rounded-full pl-14 pr-6 py-3 focus:border-[#43643C] focus:ring-[#43643C]">
                    </div>
                    <div x-show="jumlah > 1 && harga > 0"
                        class="mt-4 p-4 bg-[#F2F5EB] rounded-[20px] border border-[#E9EFE3] flex justify-between items-center transition-all">
                        <span class="text-xs font-black text-[#7A9375] uppercase tracking-widest">
                            Total Harga (@{{ jumlah }} Barang)
                        </span>
                        <span class="text-lg font-black text-[#43643C]"
                            x-text="'Rp ' + (harga * jumlah).toLocaleString('id-ID')"></span>
                    </div>
                </div>

                {{-- Foto --}}
                <div>
                    <label class="block text-xs font-black text-[#7A9375] uppercase tracking-widest mb-2 ml-4">Foto
                        Barang *</label>
                    @if(isset($item) && $item->foto)
                        <img src="{{ Storage::url($item->foto) }}"
                            class="h-32 rounded-[20px] mb-3 object-cover border-2 border-[#F2F5EB]">
                    @endif
                    <input type="file" name="foto" accept="image/*"
                        class="w-full text-sm text-[#7A9375] file:mr-4 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-xs file:font-black file:uppercase file:bg-[#E9EFE3] file:text-[#43643C] hover:file:bg-[#DDE5D3]">
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-xs font-black text-[#7A9375] uppercase tracking-widest mb-2 ml-4">Kategori
                        *</label>
                    <select name="kategori" x-model="kategori"
                        class="w-full border-[#E9EFE3] bg-[#F9FBF7] rounded-full px-6 py-3 focus:border-[#43643C] focus:ring-[#43643C] text-[#2C4027] appearance-none">
                        <option value="">Pilih Kategori</option>
                        @foreach(['bahan_baku' => 'Bahan Baku', 'makanan_jadi' => 'Makanan Jadi', 'pakaian' => 'Pakaian', 'peralatan' => 'Peralatan', 'lainnya' => 'Lainnya'] as $val => $label)
                            <option value="{{ $val }}" {{ old('kategori', $item->kategori ?? '') == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kategori Lainnya (Kondisional) --}}
                <div x-show="kategori === 'lainnya'" x-transition x-cloak>
                    <label class="block text-xs font-black text-[#7A9375] uppercase tracking-widest mb-2 ml-4">Nama
                        Kategori *</label>
                    <input type="text" name="kategori_lainnya"
                        value="{{ old('kategori_lainnya', $item->kategori_lainnya ?? '') }}"
                        class="w-full border-[#E9EFE3] bg-[#F9FBF7] rounded-full px-6 py-3 focus:border-[#43643C] focus:ring-[#43643C] text-[#2C4027]"
                        placeholder="Ketik manual kategori barang...">
                </div>

                {{-- Jumlah & Satuan --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-xs font-black text-[#7A9375] uppercase tracking-widest mb-2 ml-4">Jumlah
                            *</label>
                        <input type="number" name="jumlah" x-model="jumlah"
                            class="w-full border-[#E9EFE3] bg-[#F9FBF7] rounded-full px-6 py-3 focus:border-[#43643C] focus:ring-[#43643C]">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-black text-[#7A9375] uppercase tracking-widest mb-2 ml-4">Satuan
                            *</label>
                        <input type="text" name="satuan" value="{{ old('satuan', $item->satuan ?? '') }}"
                            class="w-full border-[#E9EFE3] bg-[#F9FBF7] rounded-full px-6 py-3 focus:border-[#43643C] focus:ring-[#43643C]"
                            placeholder="kg/pcs/dus">
                    </div>
                </div>

                {{-- Lokasi: Kota & Alamat --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-[#7A9375] uppercase tracking-widest mb-2 ml-4">Kota
                            Domisili *</label>
                        <input type="text" name="kota" value="{{ old('kota', $item->kota ?? '') }}"
                            class="w-full border-[#E9EFE3] bg-[#F9FBF7] rounded-full px-6 py-3 focus:border-[#43643C] focus:ring-[#43643C]"
                            placeholder="Contoh: Jakarta Selatan">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-black text-[#7A9375] uppercase tracking-widest mb-2 ml-4">Tanggal
                            Kedaluwarsa (Jika Ada)</label>
                        <input type="date" name="expiry_date"
                            value="{{ old('expiry_date', isset($item) && $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('Y-m-d') : '') }}"
                            class="w-full border-[#E9EFE3] bg-[#F9FBF7] rounded-full px-6 py-3 focus:border-[#43643C] focus:ring-[#43643C]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-[#7A9375] uppercase tracking-widest mb-2 ml-4">Alamat
                        Lengkap Pengambilan *</label>
                    <textarea name="alamat" rows="2"
                        class="w-full border-[#E9EFE3] bg-[#F9FBF7] rounded-[24px] px-6 py-4 focus:border-[#43643C] focus:ring-[#43643C] text-[#2C4027]"
                        placeholder="Detail alamat pengambilan barang...">{{ old('alamat', $item->alamat ?? '') }}</textarea>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-xs font-black text-[#7A9375] uppercase tracking-widest mb-2 ml-4">Deskripsi
                        Singkat</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full border-[#E9EFE3] bg-[#F9FBF7] rounded-[24px] px-6 py-4 focus:border-[#43643C] focus:ring-[#43643C] text-[#2C4027]"
                        placeholder="Berikan keterangan mengenai kondisi barang saat ini...">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex flex-col gap-3 pt-6">
                    <button type="submit"
                        class="w-full bg-[#43643C] hover:bg-[#2C4027] text-white py-4 rounded-full font-black uppercase tracking-widest transition shadow-lg shadow-[#43643C]/20">
                        {{ isset($item) ? 'Simpan Perubahan' : 'Upload Sekarang' }}
                    </button>
                    <a href="{{ route('donatur.items.index') }}"
                        class="w-full text-center bg-white text-[#7A9375] py-4 rounded-full font-bold uppercase text-xs tracking-widest hover:bg-[#F9FBF7] transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>