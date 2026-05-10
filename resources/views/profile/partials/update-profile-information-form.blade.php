<section>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-[#43643C] font-bold" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-[#E9EFE3] focus:border-[#43643C] focus:ring-[#43643C] rounded-2xl" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-[#43643C] font-bold" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-[#E9EFE3] focus:border-[#43643C] focus:ring-[#43643C] rounded-2xl" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="kota" :value="__('Kota Domisili')" class="text-[#43643C] font-bold" />
            <x-text-input id="kota" name="kota" type="text" class="mt-1 block w-full border-[#E9EFE3] focus:border-[#43643C] focus:ring-[#43643C] rounded-2xl" :value="old('kota', $user->kota)" required />
            <x-input-error class="mt-2" :messages="$errors->get('kota')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Nomor Telepon/WhatsApp')" class="text-[#43643C] font-bold" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full border-[#E9EFE3] focus:border-[#43643C] focus:ring-[#43643C] rounded-2xl" :value="old('phone', $user->phone)" required />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="bio" :value="__('Deskripsi Singkat (Bio)')" class="text-[#43643C] font-bold" />
            <textarea id="bio" name="bio" required rows="3" class="mt-1 block w-full border-[#E9EFE3] focus:border-[#43643C] focus:ring-[#43643C] rounded-2xl">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-8 py-3 bg-[#43643C] text-white rounded-2xl font-bold text-sm hover:shadow-lg transition-all">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-[#7A9375] font-medium">
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>