@props(['href', 'active' => false])

<a
    href="{{ $href }}"
    @if ($active) aria-current="page" @endif
    {{ $attributes->class([
        'inline-flex min-h-11 items-center whitespace-nowrap rounded-md px-3 text-sm font-semibold transition-colors',
        'focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal',
        'bg-surface-warm text-brand-teal' => $active,
        'text-ink hover:bg-surface-warm hover:text-brand-teal' => ! $active,
    ]) }}
>{{ $slot }}</a>
