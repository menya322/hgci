@props([
    'project',
])

@php
    $image = \App\Support\ContentImages::project($project, '16/10');
@endphp

<article class="group flex flex-col overflow-hidden rounded-lg border border-line bg-surface shadow-card transition-colors hover:border-brand-teal">
    <x-responsive-image
        :src="$image['src'] ?? null"
        :alt="$image['alt'] ?? $project->title"
        :width="$image['width'] ?? 1500"
        :height="$image['height'] ?? 1000"
        ratio="{{ $image['ratio'] ?? '16/10' }}"
        :focus="$image['focus'] ?? 'center'"
        :asset="$image['asset'] ?? false"
        :label="$image['label'] ?? '[ADD: photo]'"
        class="border-b border-line"
    />

    <div class="flex flex-1 flex-col p-6">
        <div class="flex flex-wrap items-center gap-2">
            <x-badge tone="neutral">{{ ucfirst($project->category) }}</x-badge>

            @if ($project->program && strcasecmp($project->program->title, $project->category) !== 0)
                <span class="text-xs font-semibold text-muted">{{ $project->program->title }}</span>
            @endif
        </div>

        <h3 class="mt-3 font-display text-xl font-semibold leading-snug text-ink">
            <a
                href="{{ url('/impact#project-'.$project->slug) }}"
                class="rounded-sm transition-colors hover:text-brand-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
            >
                {{ $project->title }}
            </a>
        </h3>

        @if ($project->summary)
            <p class="mt-2 flex-1 text-sm leading-relaxed text-muted">{{ $project->summary }}</p>
        @endif

        <a
            href="{{ url('/impact#project-'.$project->slug) }}"
            class="mt-5 inline-flex min-h-11 items-center gap-1.5 rounded-sm text-sm font-semibold text-brand-teal transition-colors hover:text-brand-teal-dark focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
        >
            View project
            <x-icon name="arrow-right" class="size-4" />
        </a>
    </div>
</article>
