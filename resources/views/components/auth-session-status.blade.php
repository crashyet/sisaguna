@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-semibold text-sm text-[#2C4027] bg-[#E9EFE3] p-4 rounded-2xl border border-[#43643C]/20 shadow-sm']) }}>
        {{ $status }}
    </div>
@endif