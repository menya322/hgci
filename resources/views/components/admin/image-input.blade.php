@props([
    'name',
    'label' => 'Image',
    'hint' => 'JPG, PNG or WebP, up to 2 MB.',
    'current' => null,
    'alt' => '',
])

<x-form.field :label="$label" :name="$name" :hint="$hint">
    @if ($current)
        <div class="mb-3 overflow-hidden rounded-lg border border-line bg-surface-warm">
            <img
                src="{{ Storage::disk('public')->url($current) }}"
                alt="{{ $alt }}"
                class="h-32 w-full object-cover"
            >
        </div>
    @endif

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="file"
        accept="image/jpeg,image/png,image/webp"
        @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
        {{ $attributes->class('block w-full rounded-lg border border-line bg-surface px-3.5 py-2.5 text-sm text-ink file:mr-3 file:rounded-md file:border-0 file:bg-brand-teal file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal') }}
    >
</x-form.field>
