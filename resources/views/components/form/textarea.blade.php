@props([
    'name',
    'rows' => 5,
    'value' => null,
])

@php
    $hasError = $errors->has($name);
@endphp

<textarea
    id="{{ $name }}"
    name="{{ $name }}"
    rows="{{ $rows }}"
    @if ($hasError)
        aria-invalid="true"
        aria-describedby="{{ $name }}-error"
    @endif
    {{ $attributes->class([
        'block w-full rounded-lg border bg-surface px-3.5 py-2.5 text-base leading-relaxed text-ink shadow-none transition-colors placeholder:text-muted/70 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal',
        'border-brand-red' => $hasError,
        'border-line focus:border-brand-teal' => ! $hasError,
    ]) }}
>{{ old($name, $value) }}</textarea>
