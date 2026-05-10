@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[#E9EFE3] bg-[#F9FBF7] text-[#2C4027] focus:border-[#43643C] focus:ring-[#43643C] rounded-full px-5 shadow-sm placeholder-[#A6BBA0]']) }}>