<x-guest-layout>
    <div class="auth-box shadow-2xl p-8 bg-white rounded-[2.5rem] border border-[#E9EFE3] max-w-md mx-auto">
        <div class="text-center mb-6">
            <div class="text-4xl mb-2">🔑</div>
            <h1 class="text-2xl font-black text-[#2C4027]">Reset Password</h1>
            <p class="text-[#7A9375] font-medium mt-2 leading-relaxed">
                Jangan khawatir. Masukkan email Anda dan kami akan kirimkan link untuk membuat password baru.
            </p>
        </div>

        <x-auth-session-status class="mb-4 bg-[#F2F5EB] p-4 rounded-2xl text-[#43643C] font-semibold text-sm" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-bold text-[#2C4027] mb-2">Alamat Email</label>
                <input id="email" class="w-full px-5 py-3 rounded-2xl border-2 border-[#E9EFE3] focus:border-[#43643C] outline-none transition-all" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <button class="w-full bg-[#43643C] text-white font-bold py-4 rounded-2xl hover:bg-[#2C4027] transition-all shadow-lg">
                Kirim Link Reset →
            </button>
        </form>
    </div>
</x-guest-layout>