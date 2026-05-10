@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#43643C] text-sm font-bold leading-5 text-[#2C4027] focus:outline-none focus:border-[#2C4027] transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-[#7A9375] hover:text-[#43643C] hover:border-[#E9EFE3] focus:outline-none focus:text-[#43643C] focus:border-[#E9EFE3] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>