<x-guest-layout>
    <div class="auth-box shadow-2xl p-8 bg-white rounded-[2.5rem] border border-[#E9EFE3] max-w-md mx-auto">
        <div class="text-center mb-8">
            <div class="flex justify-center mb-2">
                <img src="/storage/icon.png" alt="Sisa Guna Logo" class="w-16 h-16 aspect-square object-cover rounded-2xl shadow-lg shadow-[#43643C]/20 inline-flex">
            </div>
            <h1 class="text-2xl font-black text-[#2C4027]">Selamat Datang Kembali</h1>
            <p class="text-[#7A9375] font-medium">Masuk untuk lanjut berbagi kebaikan</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-bold text-[#2C4027] mb-2">Email</label>
                <input id="email" class="w-full px-5 py-3 rounded-2xl border-2 border-[#E9EFE3] focus:border-[#43643C] outline-none transition-all" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-[#2C4027] mb-2">Password</label>
                <input id="password" class="w-full px-5 py-3 rounded-2xl border-2 border-[#E9EFE3] focus:border-[#43643C] outline-none transition-all" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <label class="flex items-center text-sm font-semibold text-[#7A9375] cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded-lg border-[#E9EFE3] text-[#43643C] focus:ring-0 mr-2">
                    Ingat saya
                </label>
                @if (Route::has('password.request'))
                    <a class="text-sm font-bold text-[#43643C] hover:underline" href="{{ route('password.request') }}">Lupa Password?</a>
                @endif
            </div>

            <button class="w-full bg-[#43643C] text-white font-bold py-4 rounded-2xl mt-8 hover:bg-[#2C4027] transition-all shadow-lg shadow-[#43643c]/20">
                Masuk Sekarang →
            </button>
        </form>
        
        <p class="text-center mt-8 text-[#7A9375] font-medium text-sm">
            Belum punya akun? <a href="{{ route('register') }}" class="text-[#43643C] font-bold hover:underline">Daftar di sini</a>
        </p>
    </div>
</x-guest-layout>