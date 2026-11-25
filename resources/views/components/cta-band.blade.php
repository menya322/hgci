@props([
    'title',
    'description' => null,
    'eyebrow' => null,
    'tone' => 'yellow',
    'primaryLabel' => 'Donate',
    'primaryHref' => null,
    'primaryVariant' => null,
    'secondaryLabel' => null,
    'secondaryHref' => null,
    'secondaryVariant' => null,
    'image' => null,
])

@php
    $tones = [
        'yellow' => [
            'section' => 'border-brand-yellow-dark/30 bg-brand-yellow text-ink',
            'body' => 'text-ink',
            'bar' => 'bg-brand-red',
            'circle' => 'bg-white/40',
            'primary' => 'primary',
            'secondary' => 'outline-dark',
        ],
        'teal' => [
            'section' => 'border-brand-teal-dark bg-brand-teal text-white',
            'body' => 'text-white',
            'bar' => 'bg-brand-yellow',
            'circle' => 'bg-white/10',
            'primary' => 'sponsor',
            'secondary' => 'outline-light',
        ],
        'red' => [
            'section' => 'border-brand-red-dark bg-brand-red text-white',
            'body' => 'text-white',
            'bar' => 'bg-brand-yellow',
            'circle' => 'bg-white/10',
            'primary' => 'sponsor',
            'secondary' => 'outline-light',
        ],
    ];

    $palette = $tones[$tone] ?? $tones['yellow'];
    $primary = $primaryVariant ?? $palette['primary'];
    $secondary = $secondaryVariant ?? $palette['secondary'];
@endphp

<section class="relative overflow-hidden border-y py-14 lg:py-16 {{ $palette['section'] }}">
    <div aria-hidden="true" class="pointer-events-none absolute -right-16 -top-24 hidden size-72 rounded-full lg:block {{ $palette['circle'] }}"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -bottom-28 -left-20 hidden size-64 rounded-full lg:block {{ $palette['circle'] }}"></div>

    <div class="container-page relative">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                @if ($eyebrow)
                    <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em]">
                        <span class="h-1.5 w-6 rounded-full {{ $palette['bar'] }}" aria-hidden="true"></span>
                        {{ $eyebrow }}
                    </p>
                @endif

                <h2 class="mt-3 font-display text-3xl font-semibold leading-tight sm:text-4xl">{{ $title }}</h2>

                @if ($description)
                    <p class="mt-4 text-base leading-relaxed {{ $palette['body'] }}">{{ $description }}</p>
                @endif
            </div>

            <div class="flex flex-col gap-3 sm:flex-row lg:shrink-0">
                <x-button :href="$primaryHref ?? url('/donate')" :variant="$primary" size="lg">
                    {{ $primaryLabel }}
                </x-button>

                @if ($secondaryLabel && $secondaryHref)
                    <x-button :href="$secondaryHref" :variant="$secondary" size="lg">
                        {{ $secondaryLabel }}
                    </x-button>
                @endif
            </div>

            @if ($image)
                <div class="w-36 shrink-0 overflow-hidden rounded-lg border border-white/30 shadow-card sm:w-44 lg:w-52">
                    <x-responsive-image
                        :src="$image['src'] ?? null"
                        :alt="$image['alt'] ?? ''"
                        :width="$image['width'] ?? 480"
                        :height="$image['height'] ?? 640"
                        :ratio="$image['ratio'] ?? '3/4'"
                        :focus="$image['focus'] ?? 'center'"
                        :asset="$image['asset'] ?? false"
                        :label="$image['label'] ?? '[ADD: photo]'"
                    />
                </div>
            @endif
        </div>
    </div>
</section>
