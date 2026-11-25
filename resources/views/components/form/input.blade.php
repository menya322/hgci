@props([
    'name',
    'type' => 'text',
    'value' => null,
])

@php
    $hasError = $errors->has($name);
@endphp

<input
    id="{{ $name }}"
    name="{{ $name }}"
    type="{{ $type }}"
    value="{{ old($name, $value) }}"
    @if ($hasError)
        aria-invalid="true"
        aria-describedby="{{ $name }}-error"
    @endif
    {{ $attributes->class([
        'block min-h-11 w-full rounded-lg border bg-surface px-3.5 py-2.5 text-base text-ink shadow-none transition-colors placeholder:text-muted/70 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal',
        'border-brand-red' => $hasError,
        'border-line focus:border-brand-teal' => ! $hasError,
    ]) }}
>
