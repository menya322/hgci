@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'align' => 'left',
    'tone' => 'light',
])

@php
    $center = $align === 'center';
    $dark = $tone === 'dark';
@endphp

<div class="{{ $center ? 'mx-auto max-w-3xl text-center' : 'max-w-3xl' }}">
    @if ($eyebrow)
        <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] {{ $dark ? 'text-white' : 'text-brand-teal' }} {{ $center ? 'justify-center' : '' }}">
            <span class="h-1.5 w-6 rounded-full {{ $dark ? 'bg-brand-yellow' : 'bg-brand-red' }}" aria-hidden="true"></span>
            {{ $eyebrow }}
        </p>
    @endif

    <h2 class="mt-3 font-display text-3xl font-semibold leading-tight tracking-tight sm:text-4xl {{ $dark ? 'text-white' : 'text-ink' }}">
        {{ $title }}
    </h2>

    @if ($description)
        <p class="mt-4 text-base leading-relaxed sm:text-lg {{ $dark ? 'text-white' : 'text-muted' }}">
            {{ $description }}
        </p>
    @endif

    @if ($slot->isNotEmpty())
        <div class="mt-6">{{ $slot }}</div>
    @endif
</div>
