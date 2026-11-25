@extends('layouts.app')

@php
    $starts = $event->starts_at;
    $ends = $event->ends_at;

    $dateLine = $starts->format('l j F Y');

    if ($ends && ! $ends->isSameDay($starts)) {
        $timeLine = $starts->format('j M, g:i A').' – '.$ends->format('j M, g:i A');
    } elseif ($ends) {
        $timeLine = $starts->format('g:i A').' – '.$ends->format('g:i A');
    } else {
        $timeLine = $starts->format('g:i A');
    }

    $isPast = $starts->isPast();
@endphp

@section('title', $event->title)
@section('meta_description', $event->excerpt ?: 'An event from Hope In God Child Initiatives (HGCI) in Uganda.')
@section('og_type', 'article')

@php
    // The event's own photograph becomes the social preview once a real file
    // exists; while the slot is a placeholder the default card is kept.
    $shareImage = \App\Support\ContentImages::shareImage(\App\Support\ContentImages::event($event));
@endphp

@include('partials.share-image')

@section('content')
    <x-page-hero
        eyebrow="{{ $isPast ? 'Past event' : 'Upcoming event' }}"
        :title="$event->title"
        :description="$event->excerpt"
        :breadcrumbs="[
            ['label' => 'Events', 'url' => url('/events')],
            ['label' => $event->title],
        ]"
    >
        <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-muted">
            <span class="inline-flex items-center gap-2">
                <x-icon name="calendar" class="size-4 text-brand-teal" />
                {{ $dateLine }}
            </span>
            <span aria-hidden="true" class="size-1 rounded-full bg-line"></span>
            <span class="inline-flex items-center gap-2">
                <x-icon name="clock" class="size-4 text-brand-teal" />
                {{ $timeLine }}
            </span>
            @if ($event->location)
                <span aria-hidden="true" class="size-1 rounded-full bg-line"></span>
                <span class="inline-flex items-center gap-2">
                    <x-icon name="map-pin" class="size-4 text-brand-teal" />
                    {{ $event->location }}
                </span>
            @endif
        </div>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="container-page grid gap-12 lg:grid-cols-[minmax(0,2fr)_minmax(0,1fr)] lg:items-start">
            <article>
                @if ($isPast)
                    <div class="mb-8 flex items-start gap-3 rounded-lg border border-brand-yellow-dark/30 bg-brand-yellow p-5 text-ink">
                        <x-icon name="info" class="mt-0.5 size-5 shrink-0" />
                        <p class="text-sm leading-relaxed">
                            This event has already taken place. Explore our upcoming events or contact us to find out
                            what is next.
                        </p>
                    </div>
                @endif

                <div class="overflow-hidden rounded-lg border border-line bg-surface shadow-card">
                    @php $eventImage = \App\Support\ContentImages::event($event, '16/9'); @endphp

                    <x-responsive-image
                        :src="$eventImage['src'] ?? null"
                        :alt="$eventImage['alt'] ?? $event->title"
                        :width="$eventImage['width'] ?? 1080"
                        :height="$eventImage['height'] ?? 810"
                        :ratio="$eventImage['ratio'] ?? '16/9'"
                        :focus="$eventImage['focus'] ?? 'center'"
                        :asset="$eventImage['asset'] ?? false"
                        :label="$eventImage['label'] ?? '[ADD: event photo]'"
                    />
                </div>

                <div class="mt-8 space-y-5 text-base leading-relaxed text-ink">
                    @php
                        $paragraphs = collect(preg_split('/\R{2,}/', trim((string) $event->description)))
                            ->map(fn (string $paragraph) => trim($paragraph))
                            ->filter();
                    @endphp

                    @forelse ($paragraphs as $paragraph)
                        <p>{!! nl2br(e($paragraph)) !!}</p>
                    @empty
                        <p class="rounded-lg border border-dashed border-line bg-surface-warm p-6 text-muted">
                            [ADD: event details, programme and who is invited.]
                        </p>
                    @endforelse
                </div>

                <div class="mt-10 flex flex-col gap-3 border-t border-line pt-8 sm:flex-row sm:items-center sm:justify-between">
                    <a
                        href="{{ url('/events') }}"
                        class="inline-flex min-h-11 items-center gap-2 rounded-sm text-sm font-semibold text-brand-teal transition-colors hover:text-brand-teal-dark focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
                    >
                        <x-icon name="arrow-right" class="size-4 rotate-180" />
                        Back to all events
                    </a>

                    <x-button href="{{ url('/get-involved') }}" size="md">
                        <x-icon name="users" class="size-4" />
                        Get involved
                    </x-button>
                </div>
            </article>

            <aside class="space-y-8 lg:sticky lg:top-28" aria-label="Event details">
                <div class="rounded-lg border border-line bg-surface p-6 shadow-card">
                    <h2 class="font-display text-xl font-semibold text-ink">Event details</h2>

                    <dl class="mt-5 space-y-4 text-sm">
                        <div class="flex gap-3">
                            <dt class="shrink-0 text-muted">
                                <span class="sr-only">Date</span>
                                <x-icon name="calendar" class="size-5 text-brand-teal" />
                            </dt>
                            <dd class="font-medium text-ink">{{ $dateLine }}</dd>
                        </div>

                        <div class="flex gap-3">
                            <dt class="shrink-0 text-muted">
                                <span class="sr-only">Time</span>
                                <x-icon name="clock" class="size-5 text-brand-teal" />
                            </dt>
                            <dd class="font-medium text-ink">{{ $timeLine }}</dd>
                        </div>

                        <div class="flex gap-3">
                            <dt class="shrink-0 text-muted">
                                <span class="sr-only">Location</span>
                                <x-icon name="map-pin" class="size-5 text-brand-teal" />
                            </dt>
                            <dd class="font-medium text-ink">
                                {{ $event->location ?: '[ADD: event location]' }}
                            </dd>
                        </div>
                    </dl>

                    <p class="mt-5 border-t border-line pt-4 text-sm leading-relaxed text-muted">
                        For questions about this event, please
                        <a href="{{ url('/contact') }}" class="font-semibold text-brand-teal underline decoration-2 underline-offset-4 hover:text-brand-teal-dark">contact our team</a>.
                    </p>
                </div>

                @if ($otherEvents->isNotEmpty())
                    <div class="rounded-lg border border-line bg-surface-warm p-6">
                        <h2 class="font-display text-xl font-semibold text-ink">Other upcoming events</h2>

                        <ul class="mt-4 space-y-3">
                            @foreach ($otherEvents as $otherEvent)
                                <li>
                                    <a
                                        href="{{ url('/events/'.$otherEvent->slug) }}"
                                        class="group flex items-start gap-3 rounded-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
                                    >
                                        <span class="flex size-12 shrink-0 flex-col items-center justify-center rounded-md border border-line bg-surface">
                                            <span class="text-[10px] font-bold uppercase tracking-[0.12em] text-brand-teal">{{ $otherEvent->starts_at->format('M') }}</span>
                                            <span class="font-display text-lg font-semibold leading-none text-ink">{{ $otherEvent->starts_at->format('j') }}</span>
                                        </span>
                                        <span class="min-w-0">
                                            <span class="block text-sm font-semibold leading-snug text-ink transition-colors group-hover:text-brand-teal">{{ $otherEvent->title }}</span>
                                            <span class="mt-1 block text-xs text-muted">{{ $otherEvent->starts_at->format('g:i A') }}{{ $otherEvent->location ? ' · '.$otherEvent->location : '' }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </aside>
        </div>
    </section>

    <x-cta-band
        tone="teal"
        eyebrow="Be part of the next one"
        title="Serve alongside HGCI"
        description="Volunteers, partners and supporters help us reach more children and families in Uganda."
        primary-label="Get involved"
        :primary-href="url('/get-involved')"
        secondary-label="Sponsor a child"
        :secondary-href="url('/sponsor')"
    />
@endsection
