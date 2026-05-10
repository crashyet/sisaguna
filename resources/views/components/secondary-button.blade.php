<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-2 bg-white border border-[#E9EFE3] rounded-full font-bold text-xs text-[#43643C] uppercase tracking-widest shadow-sm hover:bg-[#F2F5EB] focus:outline-none focus:ring-2 focus:ring-[#43643C] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>