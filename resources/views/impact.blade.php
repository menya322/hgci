@extends('layouts.app')

@php
    $impactStats = [
        ['label' => 'Children reached', 'value' => $settings['impact.children_reached'] ?? null],
        ['label' => 'Projects supported', 'value' => $settings['impact.projects_supported'] ?? null],
        ['label' => 'Communities served', 'value' => $settings['impact.communities_served'] ?? null],
    ];

    $coreValues = $settings['about.core_values'] ?? ['Love', 'Team work', 'Compassion', 'Transparency', 'Excellence'];
@endphp

@section('title', 'Our Impact')
@section('meta_description', 'See the livelihood and relief projects HGCI supports in Uganda, including piggery, cow rearing, goat rearing and food relief, and learn how our impact is measured.')

@section('content')
    <x-page-hero
        eyebrow="Our impact"
        title="Practical projects, lasting change"
        description="HGCI works through community-based livelihood and relief projects that help families build food security, income and hope."
        :breadcrumbs="[['label' => 'Our Impact']]"
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

    {{-- Impact counters. --}}
    <section class="border-b border-line bg-surface py-14 lg:py-20" aria-labelledby="impact-figures-heading">
        <div class="container-page">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <x-section-heading
                    eyebrow="Impact at a glance"
                    title="The difference we are working towards"
                    description="These counters are managed in the HGCI admin panel. Verified figures will be published here once they are confirmed."
                />

                <x-button href="{{ url('/contact') }}" variant="outline" class="shrink-0">
                    Ask about our work
                    <x-icon name="arrow-right" class="size-4" />
                </x-button>
            </div>

            <dl class="mt-10 grid gap-4 sm:grid-cols-3">
                @foreach ($impactStats as $stat)
                    <div class="rounded-lg border border-line bg-surface-warm p-6">
                        <dt class="text-sm font-semibold text-muted">{{ $stat['label'] }}</dt>
                        <dd class="mt-2 font-display text-3xl font-semibold text-ink">
                            @if ($stat['value'] && ! str_starts_with((string) $stat['value'], '[ADD'))
                                {{ $stat['value'] }}
                            @else
                                <span title="{{ $stat['value'] ?? '[ADD: verified figure]' }}">[ADD]</span>
                                <span class="mt-1 block text-xs font-normal text-muted">Verified figure to be published</span>
                            @endif
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

    {{-- Achievements and projects. --}}
    <section class="bg-surface-warm py-16 lg:py-24">
        <div class="container-page">
            <x-section-heading
                eyebrow="Achievements"
                title="Livelihood and relief projects"
                description="Our community-led projects support families to grow their own food, build sustainable incomes and meet immediate needs."
            />

            @if ($projects->isNotEmpty())
                <div class="mt-12 space-y-14 lg:space-y-20">
                    @foreach ($projects as $project)
                        <x-project-feature :project="$project" :reverse="$loop->odd" />
                    @endforeach
                </div>
            @endif

            {{-- The fourth project was left blank in the HGCI brochure. --}}
            <div class="mt-14 rounded-lg border border-dashed border-line bg-surface p-6 sm:p-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <x-badge tone="yellow">[ADD: fourth project]</x-badge>
                        <p class="mt-3 font-display text-lg font-semibold text-ink">One more project to be confirmed</p>
                        <p class="mt-1 max-w-2xl text-sm leading-relaxed text-muted">
                            The HGCI brochure lists a fourth livelihood and relief project without a name. Its title,
                            photos and outcomes will be added here once HGCI supplies them.
                        </p>
                    </div>

                    <x-button href="{{ url('/contact') }}" variant="outline" class="shrink-0">
                        Contact HGCI
                    </x-button>
                </div>
            </div>
        </div>
    </section>

    {{-- How we work. --}}
    <section class="border-y border-brand-teal-dark bg-brand-teal-dark py-16 text-white lg:py-20">
        <div class="container-page grid gap-10 lg:grid-cols-2 lg:items-center">
            <x-section-heading
                eyebrow="How we work"
                title="Community-led, transparent and accountable"
                description="We promote the active participation of community members in fighting poverty, and we value transparency in everything we do."
                tone="dark"
            />

            <div class="rounded-lg border border-white/25 bg-white/5 p-6 sm:p-8">
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-white/90">Our core values</p>

                <ul class="mt-4 flex flex-wrap gap-2">
                    @foreach ($coreValues as $value)
                        <li class="rounded-md border border-white/25 bg-white/10 px-3 py-1.5 text-sm font-semibold text-white">
                            {{ $value }}
                        </li>
                    @endforeach
                </ul>

                <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                    <x-button href="{{ url('/about') }}" variant="sponsor">
                        About HGCI
                    </x-button>
                    <x-button href="{{ url('/programs') }}" variant="outline-light">
                        Our programs
                    </x-button>
                </div>
            </div>
        </div>
    </section>

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
