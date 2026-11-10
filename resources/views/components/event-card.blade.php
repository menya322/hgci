@props([
    'event',
])

<article class="flex gap-5 rounded-lg border border-line bg-surface p-5 shadow-card transition-colors hover:border-brand-teal sm:p-6">
    <div class="flex h-fit w-16 shrink-0 flex-col items-center rounded-md border border-line bg-surface-warm py-3">
        <span class="text-xs font-bold uppercase tracking-[0.12em] text-brand-teal">
            {{ $event->starts_at->format('M') }}
        </span>
        <span class="font-display text-2xl font-semibold leading-none text-ink">
            {{ $event->starts_at->format('j') }}
        </span>
    </div>

    <div class="min-w-0">
        <h3 class="font-display text-lg font-semibold leading-snug text-ink">
            <a
                href="{{ url('/events/'.$event->slug) }}"
                class="rounded-sm transition-colors hover:text-brand-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
            >
                {{ $event->title }}
            </a>
        </h3>

        <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-sm text-muted">
            <span class="inline-flex items-center gap-1.5">
                <x-icon name="clock" class="size-4 text-brand-teal" />
                {{ $event->starts_at->format('g:i A') }}
            </span>

            @if ($event->location)
                <span class="inline-flex items-center gap-1.5">
                    <x-icon name="map-pin" class="size-4 text-brand-teal" />
                    {{ $event->location }}
                </span>
            @endif
        </div>

        @if ($event->excerpt)
            <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-muted">{{ $event->excerpt }}</p>
        @endif

        <a
            href="{{ url('/events/'.$event->slug) }}"
            class="mt-3 inline-flex min-h-11 items-center gap-1.5 rounded-sm text-sm font-semibold text-brand-teal transition-colors hover:text-brand-teal-dark focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
        >
            Event details
            <x-icon name="arrow-right" class="size-4" />
        </a>
    </div>
</article>
