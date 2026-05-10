<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto px-6">
        <div class="mb-10">
            <h1 class="text-3xl font-black text-[#2C4027] tracking-tight">Verifikasi Pengguna</h1>
            <p class="text-[#7A9375] font-medium text-sm mt-1">Kelola hak akses dan status verifikasi komunitas Sisa Guna.</p>
        </div>

        @if(session('success'))
            <div class="bg-[#E9EFE3] text-[#2C4027] px-6 py-4 rounded-[24px] border border-[#43643C]/20 mb-8 font-semibold shadow-sm flex items-center gap-3">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-[40px] shadow-sm border border-[#E9EFE3] overflow-hidden p-2">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-[#7A9375] uppercase text-[10px] font-black tracking-widest border-b-2 border-[#F2F5EB]">
                            <th class="px-6 py-5 text-left">Pengguna</th>
                            <th class="px-6 py-5 text-left">Peran</th>
                            <th class="px-6 py-5 text-left">Lokasi</th>
                            <th class="px-6 py-5 text-left">Status</th>
                            <th class="px-6 py-5 text-center">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F2F5EB]">
                        @foreach($users as $user)
                        <tr class="hover:bg-[#F9FBF7] transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#E9EFE3] flex items-center justify-center text-[#43643C] font-black text-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-black text-[#2C4027] text-base mb-0.5">{{ $user->name }}</div>
                                        <div class="text-[10px] font-bold text-[#7A9375]">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $user->role === 'donatur' ? 'bg-[#F2F5EB] text-[#43643C]' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-[#7A9375] font-bold text-xs">{{ $user->kota ?? 'Bumi' }}</td>
                            <td class="px-6 py-4">
                                @if($user->is_verified)
                                    <span class="text-green-600 bg-green-50 px-3 py-1 rounded-full font-black text-[9px] uppercase tracking-widest">✅ Terverifikasi</span>
                                @else
                                    <span class="text-gray-500 bg-gray-100 px-3 py-1 rounded-full font-bold text-[9px] uppercase tracking-widest">⏳ Menunggu</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('admin.users.verify', $user) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="font-black text-[10px] uppercase tracking-widest px-6 py-3 rounded-[20px] transition-all hover:-translate-y-0.5 
                                        {{ $user->is_verified 
                                            ? 'bg-white border-2 border-[#E9EFE3] text-[#7A9375] hover:border-[#43643C] hover:text-[#43643C]' 
                                            : 'bg-[#43643C] text-white shadow-lg shadow-[#43643C]/20 hover:bg-[#2C4027]' 
                                        }}">
                                        {{ $user->is_verified ? 'Batalkan' : 'Verifikasi' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        
                        @if($users->isEmpty())
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-[#7A9375] font-bold">
                                <div class="text-4xl mb-3">👥</div>
                                Belum ada pengguna di platform.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-8">{{ $users->links() }}</div>
    </div>
</x-app-layout>