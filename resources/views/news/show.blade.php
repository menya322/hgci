@extends('layouts.app')

@php
    $category = $post->category
        ? ucwords(str_replace(['-', '_'], ' ', $post->category))
        : null;

    $paragraphs = collect(preg_split('/\R{2,}/', trim((string) $post->body)))
        ->map(fn (string $paragraph) => trim($paragraph))
        ->filter();
@endphp

@section('title', $post->title)
@section('meta_description', $post->excerpt ?: 'A story from Hope In God Child Initiatives (HGCI) in Uganda.')
@section('og_type', 'article')

@php
    // The article's own photograph becomes the social preview, but only once a
    // real file exists: ContentImages::shareImage() returns null while the slot
    // is still a placeholder, and the layout then falls back to the default card.
    $shareImage = \App\Support\ContentImages::shareImage(\App\Support\ContentImages::post($post));

    // An optional banner photo, kept separate from the article photo so the same
    // file is not shown twice on one page.
    $heroPhoto = \App\Support\ContentImages::postHero($post);

    $heroMetaTone = $heroPhoto ? 'text-white/90' : 'text-muted';
    $heroIconTone = $heroPhoto ? 'text-brand-yellow' : 'text-brand-teal';
    $heroDotTone = $heroPhoto ? 'bg-white/50' : 'bg-line';
@endphp

@include('partials.share-image')

@section('content')
    <x-page-hero
        :eyebrow="$category ?? 'News & stories'"
        :title="$post->title"
        :description="$post->excerpt"
        :image="$heroPhoto['src'] ?? null"
        :image-alt="$heroPhoto['alt'] ?? null"
        :breadcrumbs="[
            ['label' => 'News & Stories', 'url' => url('/news')],
            ['label' => $post->title],
        ]"
    >
        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm {{ $heroMetaTone }}">
            <time datetime="{{ $post->published_at?->toDateString() }}" class="inline-flex items-center gap-2">
                <x-icon name="calendar" class="size-4 {{ $heroIconTone }}" />
                {{ $post->published_at?->format('j F Y') }}
            </time>

            @if ($post->author?->name)
                <span aria-hidden="true" class="size-1 rounded-full {{ $heroDotTone }}"></span>
                <span>{{ $post->author->name }}</span>
            @endif
        </div>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="container-page grid gap-12 lg:grid-cols-[minmax(0,2fr)_minmax(0,1fr)] lg:items-start">
            <article>
                <div class="overflow-hidden rounded-lg border border-line bg-surface shadow-card">
                    @php $headerImage = \App\Support\ContentImages::post($post, '16/9'); @endphp

                    <x-responsive-image
                        :src="$headerImage['src'] ?? null"
                        :alt="$headerImage['alt'] ?? $post->title"
                        :width="$headerImage['width'] ?? 1200"
                        :height="$headerImage['height'] ?? 900"
                        :ratio="$headerImage['ratio'] ?? '16/9'"
                        :focus="$headerImage['focus'] ?? 'center'"
                        :asset="$headerImage['asset'] ?? false"
                        :label="$headerImage['label'] ?? '[ADD: story photo]'"
                    />
                </div>

                <div class="mt-8 space-y-5 text-base leading-relaxed text-ink">
                    @forelse ($paragraphs as $paragraph)
                        <p>{!! nl2br(e($paragraph)) !!}</p>
                    @empty
                        <p class="rounded-lg border border-dashed border-line bg-surface-warm p-6 text-muted">
                            [ADD: full story content.]
                        </p>
                    @endforelse
                </div>

                <div class="mt-10 flex flex-col gap-3 border-t border-line pt-8 sm:flex-row sm:items-center sm:justify-between">
                    <a
                        href="{{ url('/news') }}"
                        class="inline-flex min-h-11 items-center gap-2 rounded-sm text-sm font-semibold text-brand-teal transition-colors hover:text-brand-teal-dark focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
                    >
                        <x-icon name="arrow-right" class="size-4 rotate-180" />
                        Back to all stories
                    </a>

                    <x-button href="{{ url('/sponsor') }}" size="md">
                        <x-icon name="heart" class="size-4" />
                        Sponsor a child
                    </x-button>
                </div>
            </article>

            <aside class="space-y-8 lg:sticky lg:top-28" aria-label="More from HGCI">
                @if ($related->isNotEmpty())
                    <div class="rounded-lg border border-line bg-surface p-6 shadow-card">
                        <h2 class="font-display text-xl font-semibold text-ink">More stories</h2>

                        <ul class="mt-4 divide-y divide-line">
                            @foreach ($related as $relatedPost)
                                <li class="py-4 first:pt-0 last:pb-0">
                                    <a
                                        href="{{ url('/news/'.$relatedPost->slug) }}"
                                        class="group block rounded-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
                                    >
                                        <span class="block text-sm font-semibold leading-snug text-ink transition-colors group-hover:text-brand-teal">
                                            {{ $relatedPost->title }}
                                        </span>
                                        <span class="mt-1 block text-xs font-semibold uppercase tracking-[0.12em] text-muted">
                                            {{ $relatedPost->published_at?->format('j M Y') }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="rounded-lg border border-brand-yellow-dark/30 bg-brand-yellow p-6 text-ink">
                    <span class="inline-flex size-11 items-center justify-center rounded-lg bg-white text-brand-red">
                        <x-icon name="gift" class="size-6" />
                    </span>
                    <h2 class="mt-4 font-display text-xl font-semibold">Turn a story into hope</h2>
                    <p class="mt-2 text-sm leading-relaxed text-ink">
                        Your gift helps provide food, quality education and healthcare for a child in Uganda.
                    </p>
                    <x-button href="{{ url('/donate') }}" variant="donate" class="mt-5 w-full">
                        Donate today
                    </x-button>
                </div>
            </aside>
        </div>
    </section>

    <x-cta-band
        tone="teal"
        eyebrow="Share the hope"
        title="Walk with a child through school"
        description="Sponsorship connects you with a child and their community through a relationship built on care and trust."
        primary-label="Sponsor a child"
        :primary-href="url('/sponsor')"
        secondary-label="Get involved"
        :secondary-href="url('/get-involved')"
    />
@endsection
