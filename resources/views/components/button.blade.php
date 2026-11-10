@props([
    'href' => null,
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
])

@php
    $variants = [
        'primary' => 'bg-brand-teal text-white hover:bg-brand-teal-dark',
        'donate' => 'bg-brand-red text-white hover:bg-brand-red-dark',
        'sponsor' => 'bg-brand-yellow text-ink hover:bg-brand-yellow-dark',
        'outline' => 'border border-brand-teal bg-transparent text-brand-teal hover:bg-brand-teal hover:text-white',
        'outline-dark' => 'border border-ink/40 bg-transparent text-ink hover:bg-ink hover:text-white',
        'outline-light' => 'border border-white/60 bg-transparent text-white hover:bg-white hover:text-brand-teal-dark',
        'ghost' => 'bg-transparent text-brand-teal hover:bg-surface-warm',
    ];

    $sizes = [
        'sm' => 'min-h-11 px-4 text-sm',
        'md' => 'min-h-11 px-5 text-sm',
        'lg' => 'min-h-12 px-6 text-base',
    ];

    $focus = $variant === 'outline-light' ? 'focus-visible:outline-white' : 'focus-visible:outline-brand-teal';

    $classes = implode(' ', [
        'inline-flex items-center justify-center gap-2 rounded-lg font-semibold transition-colors',
        $focus,
        'focus-visible:outline-2 focus-visible:outline-offset-2',
        'disabled:pointer-events-none disabled:opacity-60',
        $variants[$variant] ?? $variants['primary'],
        $sizes[$size] ?? $sizes['md'],
    ]);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>{{ $slot }}</button>
@endif
