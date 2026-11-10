@props([
    'title',
    'description' => null,
    'href',
    'icon' => 'sparkles',
    'tone' => 'teal',
])

@php
    $tones = [
        'teal' => 'bg-brand-teal text-white',
        'yellow' => 'bg-brand-yellow text-ink',
        'orange' => 'bg-brand-orange text-ink',
        'green' => 'bg-brand-green text-ink',
        'red' => 'bg-brand-red text-white',
    ];
@endphp

<a
    href="{{ $href }}"
    {{ $attributes->class('group flex h-full flex-col rounded-lg border border-line bg-surface p-5 shadow-card transition-colors hover:border-brand-teal hover:bg-surface-warm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal') }}
>
    <span class="inline-flex size-11 items-center justify-center rounded-lg {{ $tones[$tone] ?? $tones['teal'] }}">
        <x-icon :name="$icon" class="size-6" />
    </span>

    <span class="mt-4 flex items-center justify-between gap-2">
        <span class="font-display text-base font-semibold leading-snug text-ink">{{ $title }}</span>
        <x-icon name="arrow-up-right" class="size-4 shrink-0 text-muted transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-brand-teal" />
    </span>

    @if ($description)
        <span class="mt-1 text-xs leading-relaxed text-muted">{{ $description }}</span>
    @endif
</a>
