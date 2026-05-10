<x-guest-layout>
    <div class="auth-box shadow-2xl p-8 bg-white rounded-[2.5rem] border border-[#E9EFE3] max-w-md mx-auto text-center">
        <div class="text-5xl mb-4">📧</div>
        <h1 class="text-2xl font-black text-[#2C4027] mb-4">Verifikasi Email</h1>
        <p class="text-[#7A9375] font-medium mb-8 leading-relaxed">
            Terima kasih telah mendaftar! Silakan cek email Anda dan klik link verifikasi yang kami kirimkan. Belum menerima email?
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 bg-[#F2F5EB] p-4 rounded-2xl text-[#43643C] font-bold text-sm">
                Link verifikasi baru telah dikirim!
            </div>
        @endif

        <div class="flex flex-col gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button class="w-full bg-[#43643C] text-white font-bold py-4 rounded-2xl hover:bg-[#2C4027] transition-all">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm font-bold text-[#7A9375] hover:text-[#2C4027] underline">
                    Keluar / Log Out
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>