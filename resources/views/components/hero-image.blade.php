{{--
    Full-bleed hero image with content on a solid semi-transparent overlay.

    Usage:
        <x-hero-image
            src="hero/home-hero.jpg"
            alt="Children playing outside at an HGCI community day"
            :width="1600"
            :height="900"
            eyebrow="Child sponsorship in Uganda"
            title="Every child deserves hope."
            description="Hope In God Child Initiatives walks with orphans and vulnerable children."
        >
            <x-button href="/sponsor">Sponsor a child</x-button>
        </x-hero-image>

    Required: alt, width, height.
    - The image loads eagerly with high fetch priority because it is the LCP
      element; every other image on the site stays lazy.
    - Text sits on a flat `bg-black/50` overlay (never a gradient). Pass
      overlay-class="bg-black/60" for busier photographs.
    - A missing image renders a neutral flat panel; the overlay and heading
      remain readable.
    - ratio defines the frame at every breakpoint, but the content row can grow
      taller than the ratio on narrow screens instead of clipping the text.
    - focus nudges the crop (center, top, upper, lower) so faces stay in frame.
--}}

@props([
    'src' => null,
    'alt',
    'width',
    'height',
    'ratio' => '16/9',
    'label' => '[ADD: hero photo]',
    'asset' => false,
    'disk' => 'public',
    'overlayClass' => 'bg-black/50',
    'eyebrow' => null,
    'title' => null,
    'description' => null,
    'as' => 'h1',
    'focus' => 'center',
])

@php
    $ratios = [
        '16/9' => 'aspect-[16/9]',
        '16/10' => 'aspect-[16/10]',
        '3/2' => 'aspect-[3/2]',
        '4/3' => 'aspect-[4/3]',
        '1/1' => 'aspect-square',
        '21/9' => 'aspect-[21/9]',
    ];

    $normalisedRatio = str_replace(':', '/', (string) $ratio);
    $ratioClass = $ratios[$normalisedRatio] ?? $ratios['16/9'];

    $url = \App\Support\ImageSource::url($src, (bool) $asset, (string) $disk);
    $headingTag = $as === 'h2' ? 'h2' : 'h1';

    $focusClasses = [
        'center' => 'object-center',
        'top' => 'object-top',
        'bottom' => 'object-bottom',
        'left' => 'object-left',
        'right' => 'object-right',
        'upper' => 'object-[center_25%]',
        'lower' => 'object-[center_75%]',
    ];

    $focusClass = $focusClasses[$focus] ?? $focusClasses['center'];
@endphp

<section {{ $attributes->class('relative isolate grid overflow-hidden bg-ink') }}>
    <div class="col-start-1 row-start-1">
        <div class="{{ $ratioClass }}" aria-hidden="true"></div>

        <span
            class="absolute inset-0 flex items-center justify-center bg-ink p-4"
            @if ($url) aria-hidden="true" @else role="img" aria-label="{{ $alt }}" @endif
        >
            <span class="inline-flex items-center gap-2 rounded-md border border-dashed border-white/40 bg-ink px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.15em] text-white/80">
                <x-icon name="photo" class="size-4" />
                {{ $label }}
            </span>
        </span>

        @if ($url)
            <img
                src="{{ $url }}"
                alt="{{ $alt }}"
                width="{{ (int) $width }}"
                height="{{ (int) $height }}"
                loading="eager"
                fetchpriority="high"
                decoding="async"
                class="absolute inset-0 h-full w-full object-cover {{ $focusClass }}"
                onerror="this.remove()"
            >
        @endif

        <div aria-hidden="true" class="absolute inset-0 {{ $overlayClass }}"></div>
    </div>

    <div class="container-page relative col-start-1 row-start-1 flex min-h-[22rem] flex-col justify-center py-16 sm:min-h-[28rem]">
        @if ($eyebrow)
            <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-white">
                <span class="h-1.5 w-6 rounded-full bg-brand-yellow" aria-hidden="true"></span>
                {{ $eyebrow }}
            </p>
        @endif

        @if ($title)
            @if ($headingTag === 'h2')
                <h2 class="mt-4 max-w-3xl font-display text-4xl font-semibold leading-[1.05] tracking-tight text-white sm:text-5xl lg:text-6xl">
                    {{ $title }}
                </h2>
            @else
                <h1 class="mt-4 max-w-3xl font-display text-4xl font-semibold leading-[1.05] tracking-tight text-white sm:text-5xl lg:text-6xl">
                    {{ $title }}
                </h1>
            @endif
        @endif

        @if ($description)
            <p class="mt-5 max-w-2xl text-lg leading-relaxed text-white/90">
                {{ $description }}
            </p>
        @endif

        @if ($slot->isNotEmpty())
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                {{ $slot }}
            </div>
        @endif
    </div>
</section>
