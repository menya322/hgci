@props([
    'title',
    'description',
    'href',
    'icon' => 'book-open',
    'tone' => 'teal',
    'image' => null,
])

@php
    $tones = [
        'teal' => 'bg-brand-teal text-white',
        'yellow' => 'bg-brand-yellow text-ink',
        'orange' => 'bg-brand-orange text-ink',
        'green' => 'bg-brand-green text-ink',
        'red' => 'bg-brand-red text-white',
    ];
@endphp

<article class="group flex flex-col overflow-hidden rounded-lg border border-line bg-surface shadow-card transition-colors hover:border-brand-teal">
    @if ($image)
        <x-responsive-image
            :src="$image['src'] ?? null"
            :alt="$image['alt'] ?? ''"
            :width="$image['width'] ?? 800"
            :height="$image['height'] ?? 500"
            :ratio="$image['ratio'] ?? '16/10'"
            :focus="$image['focus'] ?? 'center'"
            :asset="$image['asset'] ?? false"
            :label="$image['label'] ?? '[ADD: photo]'"
            class="border-b border-line"
        />
    @else
        <div class="flex aspect-[16/10] items-center justify-center border-b border-line bg-surface-warm">
            <span class="inline-flex items-center gap-2 rounded-md border border-dashed border-line bg-surface px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.15em] text-muted">
                <x-icon name="photo" class="size-4" />
                [ADD: photo]
            </span>
        </div>
    @endif

    <div class="flex flex-1 flex-col p-6">
        <span class="inline-flex size-11 items-center justify-center rounded-lg {{ $tones[$tone] ?? $tones['teal'] }}">
            <x-icon :name="$icon" class="size-6" />
        </span>

        <h3 class="mt-4 font-display text-xl font-semibold leading-snug text-ink">{{ $title }}</h3>
        <p class="mt-2 flex-1 text-sm leading-relaxed text-muted">{{ $description }}</p>

        <a
            href="{{ $href }}"
            class="mt-5 inline-flex min-h-11 items-center gap-1.5 rounded-sm text-sm font-semibold text-brand-teal transition-colors hover:text-brand-teal-dark focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
        >
            Learn more
            <x-icon name="arrow-right" class="size-4" />
        </a>
    </div>
</article>
