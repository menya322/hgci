@props(['variant' => 'light', 'showWordmark' => true])

@php
    $hasLogo = file_exists(public_path('images/logo-mark.png'));
    $dark = $variant === 'dark';
@endphp

<a
    href="{{ url('/') }}"
    {{ $attributes->class('inline-flex shrink-0 items-center gap-3 rounded-md focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-brand-teal') }}
>
    @if ($hasLogo)
        <img
            src="{{ asset('images/logo-mark.png') }}"
            alt="Hope In God Child Initiatives logo"
            class="h-11 w-auto shrink-0"
            width="216"
            height="227"
        >
    @else
        <svg class="h-11 w-11 shrink-0" viewBox="0 0 64 64" role="img" aria-label="Hope In God Child Initiatives logo">
            <circle cx="32" cy="12" r="10" fill="#F5B700" />
            <circle cx="49.32" cy="22" r="10" fill="#F28A1E" />
            <circle cx="49.32" cy="42" r="10" fill="#4CAF50" />
            <circle cx="32" cy="52" r="10" fill="#D62F2F" />
            <circle cx="14.68" cy="42" r="10" fill="#F28A1E" />
            <circle cx="14.68" cy="22" r="10" fill="#F5B700" />
            <circle cx="32" cy="32" r="15" fill="{{ $dark ? '#0A5B65' : '#FFFFFF' }}" />
            <text
                x="32"
                y="35.5"
                text-anchor="middle"
                font-family="Poppins, Inter, sans-serif"
                font-size="10"
                font-weight="700"
                fill="{{ $dark ? '#FFFFFF' : '#0F7C89' }}"
            >HGCI</text>
        </svg>
    @endif

    @if ($showWordmark)
        <span class="flex flex-col leading-none">
            <span class="font-display text-[10px] font-semibold uppercase tracking-[0.22em] {{ $dark ? 'text-white/85' : 'text-brand-teal' }}">Hope In God</span>
            <span class="mt-1 font-display text-[15px] font-bold uppercase tracking-[0.05em] {{ $dark ? 'text-white' : 'text-ink' }}">Child Initiatives</span>
        </span>
    @endif
</a>
