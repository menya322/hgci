@extends('layouts.app')

@php
    $focusPoints = [
        'education' => [
            'Quality learning and scholastic support for children',
            'Vocational pathways that prepare children for responsible adulthood',
            'Reducing illiteracy among children and the wider community',
        ],
        'health-nutrition' => [
            'Health awareness for children, families and community leaders',
            'Nutrition support that helps children grow and thrive',
            'Sanitation and healthy homes',
        ],
        'livelihood' => [
            'Piggery projects',
            'Cow rearing projects',
            'Goat rearing projects',
        ],
        'food-relief' => [
            'Food for orphans and vulnerable families',
            'Basic necessities during times of greatest need',
            'Relief that bridges the gap while longer-term projects take root',
        ],
        'child-sponsorship' => [
            'Food and basic necessities',
            'Quality education and scholastic support',
            'Healthcare and general wellbeing',
            'A consistent, personal relationship with a sponsor',
        ],
    ][$program->slug] ?? ['[ADD: programme activities and focus areas]'];

    $programTones = [
        'education' => 'teal',
        'health-nutrition' => 'red',
        'livelihood' => 'green',
        'food-relief' => 'orange',
        'child-sponsorship' => 'yellow',
    ];
@endphp

@section('title', $program->meta_title ?: $program->title)
@section('meta_description', $program->meta_description ?: $program->excerpt)

@section('content')
    <x-page-hero
        eyebrow="Our programs"
        :title="$program->title"
        :description="$program->excerpt"
        :breadcrumbs="[
            ['label' => 'Our Programs', 'url' => url('/programs')],
            ['label' => $program->title],
        ]"
    >
        <div class="flex flex-col gap-3 sm:flex-row">
            <x-button href="{{ url('/sponsor') }}" size="lg">
                <x-icon name="heart" class="size-5" />
                Sponsor a child
            </x-button>
            <x-button href="{{ url('/donate') }}" variant="donate" size="lg">
                Donate
            </x-button>
        </div>
    </x-page-hero>

    {{-- Programme overview. --}}
    <section class="py-16 lg:py-24">
        <div class="container-page grid gap-10 lg:grid-cols-2 lg:items-start lg:gap-12">
            <div class="overflow-hidden rounded-lg border border-line bg-surface shadow-card">
                @php $detailImage = \App\Support\ContentImages::program($program, '4/3'); @endphp

                <x-responsive-image
                    :src="$detailImage['src'] ?? null"
                    :alt="$detailImage['alt'] ?? $program->title"
                    :width="$detailImage['width'] ?? 1500"
                    :height="$detailImage['height'] ?? 1000"
                    ratio="4/3"
                    :focus="$detailImage['focus'] ?? 'center'"
                    :asset="$detailImage['asset'] ?? false"
                    :label="$detailImage['label'] ?? '[ADD: photo]'"
                />
            </div>

            <div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex size-11 items-center justify-center rounded-lg bg-brand-teal text-white">
                        <x-icon :name="$program->icon ?? 'sparkles'" class="size-6" />
                    </span>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-teal">About this programme</p>
                </div>

                <h2 class="mt-4 font-display text-2xl font-semibold leading-tight text-ink sm:text-3xl">
                    How {{ $program->title }} supports children
                </h2>

                <p class="mt-4 leading-relaxed text-muted">
                    {{ $program->description ?: $program->excerpt }}
                </p>

                <div class="mt-6 rounded-lg border border-line bg-surface-warm p-6">
                    <h3 class="font-display text-lg font-semibold text-ink">What this includes</h3>
                    <ul class="mt-4 space-y-3">
                        @foreach ($focusPoints as $point)
                            <li class="flex gap-3 text-sm leading-relaxed text-ink">
                                <x-icon name="check" class="mt-0.5 size-4 shrink-0 text-brand-teal" />
                                <span>{{ $point }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <x-button href="{{ url('/contact') }}" variant="outline">
                        Ask about this programme
                        <x-icon name="arrow-right" class="size-4" />
                    </x-button>
                    <x-button href="{{ url('/programs') }}" variant="ghost">
                        All programs
                    </x-button>
                </div>
            </div>
        </div>
    </section>

    {{-- Related projects. --}}
    @if ($projects->isNotEmpty())
        <section class="border-y border-line bg-surface-warm py-16 lg:py-20" aria-labelledby="related-projects-heading">
            <div class="container-page">
                <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                    <x-section-heading
                        eyebrow="Related projects"
                        title="On the ground with {{ $program->title }}"
                        description="These projects put the programme into action in Ugandan communities."
                    />

                    <x-button href="{{ url('/impact') }}" variant="outline" class="shrink-0">
                        See our impact
                        <x-icon name="arrow-right" class="size-4" />
                    </x-button>
                </div>

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($projects as $project)
                        <x-project-card :project="$project" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Other programmes. --}}
    @if ($otherPrograms->isNotEmpty())
        <section class="py-16 lg:py-20" aria-labelledby="other-programs-heading">
            <div class="container-page">
                <x-section-heading
                    eyebrow="Keep exploring"
                    title="Other ways we serve children"
                    description="Our programmes work together to support the whole child and the community around them."
                />

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($otherPrograms as $other)
                        <x-program-card
                            :href="route('programs.show', $other)"
                            :title="$other->title"
                            :description="$other->excerpt"
                            :icon="$other->icon ?? 'sparkles'"
                            :tone="$programTones[$other->slug] ?? 'teal'"
                            :image="\App\Support\ContentImages::program($other)"
                        />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Sponsor CTA band. --}}
    <x-cta-band
        tone="yellow"
        eyebrow="Sponsorship"
        title="Sponsor a child, change a life"
        description="Your sponsorship helps provide food, education, healthcare and a safe, nurturing environment for a child in Uganda."
        primary-label="Sponsor a child"
        :primary-href="url('/sponsor')"
        secondary-label="Donate today"
        :secondary-href="url('/donate')"
    />
@endsection
