<x-guest-layout>
    <div class="auth-box shadow-2xl p-8 bg-white rounded-[2.5rem] border border-[#E9EFE3] max-w-md mx-auto">
        <div class="text-center mb-6">
            <div class="text-4xl mb-2">🔒</div>
            <h1 class="text-2xl font-black text-[#2C4027]">Area Keamanan</h1>
            <p class="text-[#7A9375] font-medium mt-2">Harap konfirmasi password Anda sebelum melanjutkan.</p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-bold text-[#2C4027] mb-2">Password</label>
                <input id="password" class="w-full px-5 py-3 rounded-2xl border-2 border-[#E9EFE3] focus:border-[#43643C] outline-none transition-all" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <button class="w-full bg-[#43643C] text-white font-bold py-4 rounded-2xl hover:bg-[#2C4027] transition-all shadow-lg">
                Konfirmasi →
            </button>
        </form>
    </div>
</x-guest-layout>