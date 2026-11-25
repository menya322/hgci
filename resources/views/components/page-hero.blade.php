{{--
    Page hero with an optional full-bleed photograph.

    Without an `image` prop this renders exactly as before: a flat cream band
    with ink text. Pass `image="images/foo.jpg"` (a path inside public/) to
    fill the band with a photograph, a solid dark overlay, and white text.

    Usage:
        <x-page-hero
            eyebrow="What we do"
            title="Programs that meet children where they are"
            image="images/programs/education.jpg"
            :breadcrumbs="[['label' => 'Our Programs']]"
        >
            <x-button href="/sponsor">Sponsor a child</x-button>
        </x-page-hero>
--}}

@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'breadcrumbs' => null,
    'image' => null,
    'imageAlt' => null,
])

@php
    $crumbs = $breadcrumbs ?? [['label' => $title]];

    // Resolve through ImageSource so a missing file simply means "no photo",
    // leaving pages without a valid image on the original flat hero.
    $imageUrl = \App\Support\ImageSource::url($image, asset: true);
    $imageAlt = $imageAlt ?? $title;

    // Text colours swap to white only when a photo is behind them.
    $crumbInactive = $imageUrl ? 'text-white/90' : 'text-muted';
    $crumbLink = $imageUrl ? 'hover:text-white' : 'hover:text-brand-teal';
    $crumbDivider = $imageUrl ? 'text-white/50' : 'text-line';
    $crumbCurrent = $imageUrl ? 'text-white' : 'text-ink';
    $eyebrowTone = $imageUrl ? 'text-white' : 'text-brand-teal';
    $eyebrowBar = $imageUrl ? 'bg-brand-yellow' : 'bg-brand-red';
    $titleTone = $imageUrl ? 'text-white' : 'text-ink';
    $descriptionTone = $imageUrl ? 'text-white/90' : 'text-muted';
@endphp

<section @class([
    'relative isolate overflow-hidden border-b border-line',
    'bg-ink' => $imageUrl,
    'bg-surface-warm' => ! $imageUrl,
])>
    @if ($imageUrl)
        <img
            src="{{ $imageUrl }}"
            alt="{{ $imageAlt }}"
            loading="eager"
            fetchpriority="high"
            decoding="async"
            class="absolute inset-0 h-full w-full object-cover"
        >
        <div aria-hidden="true" class="absolute inset-0 bg-ink/75"></div>
    @endif

    <div @class([
        'container-page relative py-14 lg:py-20',
        'z-10 flex min-h-[20rem] flex-col justify-center sm:min-h-[24rem]' => $imageUrl,
    ])>
        <nav aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-2 text-sm {{ $crumbInactive }}">
                <li>
                    <a href="{{ url('/') }}" class="rounded-sm {{ $crumbLink }} focus-visible:outline-2 focus-visible:outline-offset-2 {{ $imageUrl ? 'focus-visible:outline-white' : 'focus-visible:outline-brand-teal' }}">Home</a>
                </li>
                @foreach ($crumbs as $crumb)
                    <li aria-hidden="true" class="{{ $crumbDivider }}">/</li>
                    <li>
                        @if (! empty($crumb['url']))
                            <a href="{{ $crumb['url'] }}" class="rounded-sm {{ $crumbLink }} focus-visible:outline-2 focus-visible:outline-offset-2 {{ $imageUrl ? 'focus-visible:outline-white' : 'focus-visible:outline-brand-teal' }}">{{ $crumb['label'] }}</a>
                        @else
                            <span aria-current="page" class="font-semibold {{ $crumbCurrent }}">{{ $crumb['label'] }}</span>
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>

        <div class="mt-6 max-w-3xl">
            @if ($eyebrow)
                <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] {{ $eyebrowTone }}">
                    <span class="h-1.5 w-6 rounded-full {{ $eyebrowBar }}" aria-hidden="true"></span>
                    {{ $eyebrow }}
                </p>
            @endif

            <h1 class="mt-3 font-display text-4xl font-semibold leading-[1.1] tracking-tight {{ $titleTone }} sm:text-5xl">
                {{ $title }}
            </h1>

            @if ($description)
                <p class="mt-5 text-lg leading-relaxed {{ $descriptionTone }}">{{ $description }}</p>
            @endif

            @if ($slot->isNotEmpty())
                <div class="mt-8">{{ $slot }}</div>
            @endif
        </div>
    </div>
</section>
