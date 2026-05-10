<label {{ $attributes->merge(['class' => 'block font-bold text-sm text-[#2C4027] ml-4 mb-1']) }}>
    {{ $value ?? $slot }}
</label>