@props([
    'name',
    'options' => [],
    'placeholder' => null,
    'selected' => null,
])

@php
    $hasError = $errors->has($name);
    $current = old($name, $selected);
@endphp

<select
    id="{{ $name }}"
    name="{{ $name }}"
    @if ($hasError)
        aria-invalid="true"
        aria-describedby="{{ $name }}-error"
    @endif
    {{ $attributes->class([
        'block min-h-11 w-full rounded-lg border bg-surface px-3.5 py-2.5 text-base text-ink shadow-none transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal',
        'border-brand-red' => $hasError,
        'border-line focus:border-brand-teal' => ! $hasError,
    ]) }}
>
    @if ($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif

    @foreach ($options as $value => $label)
        <option value="{{ $value }}" @selected((string) $current === (string) $value)>{{ $label }}</option>
    @endforeach
</select>
