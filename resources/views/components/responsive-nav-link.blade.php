@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#43643C] text-start text-base font-bold text-[#2C4027] bg-[#F2F5EB] focus:outline-none focus:text-[#1B2918] focus:bg-[#E9EFE3] focus:border-[#2C4027] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-[#7A9375] hover:text-[#43643C] hover:bg-[#F9FBF7] hover:border-[#E9EFE3] focus:outline-none focus:text-[#43643C] focus:border-[#E9EFE3] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>