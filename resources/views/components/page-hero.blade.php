@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'breadcrumbs' => null,
])

@php
    $crumbs = $breadcrumbs ?? [['label' => $title]];
@endphp

<section class="border-b border-line bg-surface-warm">
    <div class="container-page py-14 lg:py-20">
        <nav aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-2 text-sm text-muted">
                <li>
                    <a href="{{ url('/') }}" class="rounded-sm hover:text-brand-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal">Home</a>
                </li>
                @foreach ($crumbs as $crumb)
                    <li aria-hidden="true" class="text-line">/</li>
                    <li>
                        @if (! empty($crumb['url']))
                            <a href="{{ $crumb['url'] }}" class="rounded-sm hover:text-brand-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal">{{ $crumb['label'] }}</a>
                        @else
                            <span aria-current="page" class="font-semibold text-ink">{{ $crumb['label'] }}</span>
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>

        <div class="mt-6 max-w-3xl">
            @if ($eyebrow)
                <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-brand-teal">
                    <span class="h-1.5 w-6 rounded-full bg-brand-red" aria-hidden="true"></span>
                    {{ $eyebrow }}
                </p>
            @endif

            <h1 class="mt-3 font-display text-4xl font-semibold leading-[1.1] tracking-tight text-ink sm:text-5xl">
                {{ $title }}
            </h1>

            @if ($description)
                <p class="mt-5 text-lg leading-relaxed text-muted">{{ $description }}</p>
            @endif

            @if ($slot->isNotEmpty())
                <div class="mt-8">{{ $slot }}</div>
            @endif
        </div>
    </div>
</section>
