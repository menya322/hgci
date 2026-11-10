@props(['tone' => 'teal'])

@php
    $tones = [
        'teal' => 'bg-brand-teal text-white',
        'yellow' => 'bg-brand-yellow text-ink',
        'green' => 'bg-brand-green text-ink',
        'red' => 'bg-brand-red text-white',
        'orange' => 'bg-brand-orange text-ink',
        'neutral' => 'border border-line bg-surface text-ink',
    ];
@endphp

<span {{ $attributes->class(['inline-flex items-center rounded-md px-3 py-1 text-xs font-semibold', $tones[$tone] ?? $tones['neutral']]) }}>
    {{ $slot }}
</span>
