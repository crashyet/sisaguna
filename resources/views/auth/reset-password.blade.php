<x-guest-layout>
    <div class="auth-box shadow-2xl p-8 bg-white rounded-[2.5rem] border border-[#E9EFE3] max-w-md mx-auto">
        <div class="text-center mb-8">
            <div class="text-4xl mb-2">🛡️</div>
            <h1 class="text-2xl font-black text-[#2C4027]">Password Baru</h1>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-4">
                <label class="block text-sm font-bold text-[#2C4027] mb-2">Email</label>
                <input id="email" class="w-full px-5 py-3 rounded-2xl border-2 border-[#E9EFE3] bg-[#F2F5EB]/50" type="email" name="email" :value="old('email', $request->email)" required readonly />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-[#2C4027] mb-2">Password Baru</label>
                <input id="password" class="w-full px-5 py-3 rounded-2xl border-2 border-[#E9EFE3] focus:border-[#43643C] outline-none transition-all" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-[#2C4027] mb-2">Konfirmasi Password</label>
                <input id="password_confirmation" class="w-full px-5 py-3 rounded-2xl border-2 border-[#E9EFE3] focus:border-[#43643C] outline-none transition-all" type="password" name="password_confirmation" required />
            </div>

            <button class="w-full bg-[#43643C] text-white font-bold py-4 rounded-2xl hover:bg-[#2C4027] transition-all shadow-lg">
                Update Password →
            </button>
        </form>
    </div>
</x-guest-layout>