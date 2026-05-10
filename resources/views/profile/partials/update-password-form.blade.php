<section>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" :value="__('Kata Sandi Saat Ini')" class="text-[#43643C] font-bold" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full border-[#E9EFE3] focus:border-[#43643C] focus:ring-[#43643C] rounded-2xl" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Kata Sandi Baru')" class="text-[#43643C] font-bold" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full border-[#E9EFE3] focus:border-[#43643C] focus:ring-[#43643C] rounded-2xl" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-8 py-3 bg-[#43643C] text-white rounded-2xl font-bold text-sm hover:shadow-lg transition-all">
                {{ __('Perbarui Sandi') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-[#7A9375] font-medium">
                    {{ __('Berhasil diperbarui.') }}
                </p>
            @endif
        </div>
    </form>
</section>