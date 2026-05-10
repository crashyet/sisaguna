<section class="space-y-6">

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" 
            class="px-8 py-3 bg-[#EF4444] text-white rounded-2xl font-bold text-sm hover:bg-[#991B1B] transition-all">
        {{ __('Hapus Akun Saya') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-lg font-black text-[#2C4027]">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="mt-3 text-sm text-[#7A9375]">
                {{ __('Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.') }}
            </p>

            <div class="mt-6">
                <x-text-input id="password" name="password" type="password" class="block w-full border-[#E9EFE3] focus:border-[#EF4444] rounded-2xl" placeholder="{{ __('Kata Sandi') }}" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 bg-[#F2F5EB] text-[#43643C] rounded-2xl font-bold text-sm">
                    {{ __('Batal') }}
                </button>
                <button type="submit" class="px-6 py-3 bg-[#EF4444] text-white rounded-2xl font-bold text-sm hover:bg-[#991B1B]">
                    {{ __('Ya, Hapus Permanen') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>