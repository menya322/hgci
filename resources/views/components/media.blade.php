@props([
    'src' => null,
    'alt' => '',
    'label' => '[ADD: photo]',
    'ratio' => 'aspect-[16/10]',
])

<div {{ $attributes->class("relative overflow-hidden $ratio border-b border-line bg-surface-warm") }}>
    @if ($src)
        <img
            src="{{ Storage::disk('public')->url($src) }}"
            alt="{{ $alt }}"
            loading="lazy"
            decoding="async"
            class="h-full w-full object-cover"
        >
    @else
        <span class="absolute inset-0 flex items-center justify-center p-4">
            <span class="inline-flex items-center gap-2 rounded-md border border-dashed border-line bg-surface px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.15em] text-muted">
                <x-icon name="photo" class="size-4" />
                {{ $label }}
            </span>
        </span>
    @endif
</div>
