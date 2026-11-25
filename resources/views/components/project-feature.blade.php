@props([
    'project',
    'reverse' => false,
])

@php
    $image = \App\Support\ContentImages::project($project, '4/3');
@endphp

<article
    id="project-{{ $project->slug }}"
    {{ $attributes->class('grid scroll-mt-28 gap-8 lg:grid-cols-2 lg:items-center lg:gap-12') }}
>
    <div class="overflow-hidden rounded-lg border border-line bg-surface shadow-card {{ $reverse ? 'lg:order-2' : '' }}">
        <x-responsive-image
            :src="$image['src'] ?? null"
            :alt="$image['alt'] ?? $project->title"
            :width="$image['width'] ?? 1500"
            :height="$image['height'] ?? 1000"
            ratio="{{ $image['ratio'] ?? '4/3' }}"
            :focus="$image['focus'] ?? 'center'"
            :asset="$image['asset'] ?? false"
            :label="$image['label'] ?? '[ADD: photo]'"
        />
    </div>

    <div class="{{ $reverse ? 'lg:order-1' : '' }}">
        <div class="flex flex-wrap items-center gap-2">
            <x-badge tone="yellow">{{ ucfirst($project->category) }}</x-badge>

            @if ($project->program && strcasecmp($project->program->title, $project->category) !== 0)
                <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-muted">
                    <x-icon name="briefcase" class="size-4 text-brand-teal" />
                    {{ $project->program->title }}
                </span>
            @endif
        </div>

        <h3 class="mt-4 font-display text-2xl font-semibold leading-tight text-ink sm:text-3xl">
            {{ $project->title }}
        </h3>

        <p class="mt-4 leading-relaxed text-muted">
            {{ $project->description ?: $project->summary }}
        </p>

        <div class="mt-6 rounded-md border border-line bg-surface-warm p-4">
            <p class="text-xs font-bold uppercase tracking-[0.15em] text-brand-teal">People reached</p>

            @if ($project->beneficiaries_count)
                <p class="mt-1 font-display text-2xl font-semibold text-ink">{{ $project->beneficiaries_count }}</p>
            @else
                <p class="mt-1 text-sm font-semibold text-ink" title="[ADD: number of beneficiaries]">
                    [ADD: number of beneficiaries]
                </p>
                <p class="mt-0.5 text-xs text-muted">A verified figure will be published when available.</p>
            @endif
        </div>
    </div>
</article>
