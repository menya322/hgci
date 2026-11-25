@props([
    'name',
    'value' => '1',
    'checked' => false,
])

<label for="{{ $name }}" class="flex cursor-pointer items-start gap-3 text-sm leading-relaxed text-ink">
    <input
        type="checkbox"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @checked(old($name, $checked))
        @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
        {{ $attributes->class('mt-0.5 size-5 shrink-0 rounded border-line text-brand-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal') }}
    >

    <span>{{ $slot }}</span>
</label>

@error($name)
    <p id="{{ $name }}-error" class="mt-1.5 text-sm font-medium text-brand-red">{{ $message }}</p>
@enderror
