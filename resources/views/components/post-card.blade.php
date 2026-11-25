@props([
    'post',
])

@php
    $image = \App\Support\ContentImages::post($post, '16/10');
@endphp

<article class="group flex flex-col overflow-hidden rounded-lg border border-line bg-surface shadow-card transition-colors hover:border-brand-teal">
    <x-responsive-image
        :src="$image['src'] ?? null"
        :alt="$image['alt'] ?? $post->title"
        :width="$image['width'] ?? 1200"
        :height="$image['height'] ?? 900"
        :ratio="$image['ratio'] ?? '16/10'"
        :focus="$image['focus'] ?? 'center'"
        :asset="$image['asset'] ?? false"
        :label="$image['label'] ?? '[ADD: photo]'"
        class="border-b border-line"
    />

    <div class="flex flex-1 flex-col p-6">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs font-semibold uppercase tracking-[0.12em] text-muted">
            @if ($post->category)
                <span class="text-brand-teal">{{ $post->category }}</span>
                <span aria-hidden="true" class="size-1 rounded-full bg-line"></span>
            @endif
            <time datetime="{{ $post->published_at?->toDateString() }}">
                {{ $post->published_at?->format('j M Y') }}
            </time>
        </div>

        <h3 class="mt-3 font-display text-xl font-semibold leading-snug text-ink">
            <a
                href="{{ url('/news/'.$post->slug) }}"
                class="rounded-sm transition-colors hover:text-brand-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
            >
                {{ $post->title }}
            </a>
        </h3>

        @if ($post->excerpt)
            <p class="mt-2 flex-1 text-sm leading-relaxed text-muted">{{ $post->excerpt }}</p>
        @endif

        <a
            href="{{ url('/news/'.$post->slug) }}"
            class="mt-5 inline-flex min-h-11 items-center gap-1.5 rounded-sm text-sm font-semibold text-brand-teal transition-colors hover:text-brand-teal-dark focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
        >
            Read the story
            <x-icon name="arrow-right" class="size-4" />
        </a>
    </div>
</article>
