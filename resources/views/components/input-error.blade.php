@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-[11px] font-bold text-red-500 space-y-1 ml-4 mt-1']) }}>
        @foreach ((array) $messages as $message)
            <li>• {{ $message }}</li>
        @endforeach
    </ul>
@endif