@props([
    'album',
    'count' => null,
])

@php
    $count = $count ?? $album->images_count ?? $album->images()->count();
@endphp

<article class="group flex flex-col overflow-hidden rounded-lg border border-line bg-surface shadow-card transition-colors hover:border-brand-teal">
    <a href="{{ route('gallery.show', $album) }}" class="flex flex-1 flex-col rounded-lg focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal">
        <div class="relative aspect-[4/3] overflow-hidden border-b border-line bg-surface-warm">
            @if ($album->cover_image && file_exists(public_path($album->cover_image)))
                <img
                    src="{{ asset($album->cover_image) }}"
                    alt="{{ $album->title }}"
                    loading="lazy"
                    decoding="async"
                    width="1200"
                    height="900"
                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.02]"
                >
            @else
                <span class="absolute inset-0 flex items-center justify-center p-4">
                    <span class="inline-flex items-center gap-2 rounded-md border border-dashed border-line bg-surface px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.15em] text-muted">
                        <x-icon name="photo" class="size-4" />
                        [ADD: album cover]
                    </span>
                </span>
            @endif

            <span class="absolute bottom-3 left-3 inline-flex items-center gap-1.5 rounded-md bg-ink/85 px-2.5 py-1 text-xs font-semibold text-white">
                <x-icon name="photo" class="size-3.5" />
                {{ $count }} {{ \Illuminate\Support\Str::plural('photo', $count) }}
            </span>
        </div>

        <div class="flex flex-1 flex-col p-6">
            <h3 class="font-display text-xl font-semibold leading-snug text-ink transition-colors group-hover:text-brand-teal">
                {{ $album->title }}
            </h3>

            @if ($album->description)
                <p class="mt-2 flex-1 text-sm leading-relaxed text-muted">{{ $album->description }}</p>
            @endif

            <span class="mt-5 inline-flex min-h-11 items-center gap-1.5 text-sm font-semibold text-brand-teal">
                View album
                <x-icon name="arrow-right" class="size-4" />
            </span>
        </div>
    </a>
</article>
