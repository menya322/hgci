@props([
    'label',
    'name',
    'hint' => null,
    'required' => false,
])

<div {{ $attributes->class('space-y-1.5') }}>
    <label for="{{ $name }}" class="block text-sm font-semibold text-ink">
        {{ $label }}@if ($required)<span class="ml-1 text-brand-red" aria-hidden="true">*</span>@endif
    </label>

    {{ $slot }}

    @if ($hint)
        <p id="{{ $name }}-hint" class="text-xs leading-relaxed text-muted">{{ $hint }}</p>
    @endif

    @error($name)
        <p id="{{ $name }}-error" class="text-sm font-medium text-brand-red">{{ $message }}</p>
    @enderror
</div>
