@extends('layouts.app')

@php
    $nicheDetails = [
        'Health' => [
            'icon' => 'health',
            'tone' => 'bg-brand-teal text-white',
            'copy' => 'Awareness on health, nutrition and sanitation for clean, healthy homes.',
        ],
        'Education' => [
            'icon' => 'academic-cap',
            'tone' => 'bg-brand-yellow text-ink',
            'copy' => 'Quality, competitive learning that reduces illiteracy among children.',
        ],
        'Livelihood' => [
            'icon' => 'briefcase',
            'tone' => 'bg-brand-green text-ink',
            'copy' => 'Piggery, cow rearing and goat rearing projects that strengthen families.',
        ],
    ];

    $programTones = [
        'education' => 'teal',
        'health-nutrition' => 'red',
        'livelihood' => 'green',
        'food-relief' => 'orange',
        'child-sponsorship' => 'yellow',
    ];
@endphp

@section('title', 'Our Programs')
@section('meta_description', 'Explore HGCI programs in Uganda: education, health and nutrition, livelihood projects, food relief and child sponsorship.')

@section('content')
    <x-page-hero
        eyebrow="What we do"
        title="Programs that meet children where they are"
        description="From education to food relief, our work is designed around the whole child and the community around them."
        image="images/gallery/education-school-support/school-support-gathering.jpeg"
        image-alt="Children holding hygiene supplies at an HGCI school support gathering"
        :breadcrumbs="[['label' => 'Our Programs']]"
    >
        <div class="flex flex-col gap-3 sm:flex-row">
            <x-button href="{{ url('/sponsor') }}" size="lg">
                <x-icon name="heart" class="size-5" />
                Sponsor a child
            </x-button>
            <x-button href="{{ url('/impact') }}" variant="outline-light" size="lg">
                See our impact
                <x-icon name="arrow-right" class="size-4" />
            </x-button>
        </div>
    </x-page-hero>

    {{-- Our niche. --}}
    <section class="border-b border-line bg-surface py-12 lg:py-16" aria-labelledby="niche-heading">
        <div class="container-page">
            <h2 id="niche-heading" class="font-display text-xl font-semibold text-ink">Our niche</h2>
            <p class="mt-1 text-sm leading-relaxed text-muted">
                Health, education and livelihood sit at the centre of everything we do.
            </p>

            <ul class="mt-6 grid gap-4 sm:grid-cols-3">
                @foreach ($nicheDetails as $niche => $detail)
                    <li class="flex gap-4 rounded-lg border border-line bg-surface p-5 shadow-card">
                        <span class="inline-flex size-11 shrink-0 items-center justify-center rounded-lg {{ $detail['tone'] }}">
                            <x-icon :name="$detail['icon']" class="size-6" />
                        </span>
                        <div>
                            <p class="font-semibold text-ink">{{ $niche }}</p>
                            <p class="mt-0.5 text-sm leading-relaxed text-muted">{{ $detail['copy'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- Programs grid. --}}
    <section class="bg-surface-warm py-16 lg:py-24">
        <div class="container-page">
            <x-section-heading
                eyebrow="Our programs"
                title="Practical support for the whole child"
                description="Each programme responds to a different part of a child's life, and together they help children grow up safe, healthy and educated."
            />

            @if ($programs->isNotEmpty())
                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($programs as $program)
                        <x-program-card
                            :href="route('programs.show', $program)"
                            :title="$program->title"
                            :description="$program->excerpt"
                            :icon="$program->icon ?? 'sparkles'"
                            :tone="$programTones[$program->slug] ?? 'teal'"
                            :image="\App\Support\ContentImages::program($program)"
                        />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Livelihood and relief projects. --}}
    @if ($projects->isNotEmpty())
        @php
            $projectsImage = \App\Support\ImageSource::url('images/programs/livelihood.jpg', asset: true);
        @endphp

        <section class="relative isolate overflow-hidden bg-ink py-16 text-white lg:py-20" aria-label="Livelihood and relief projects">
            @if ($projectsImage)
                <img
                    src="{{ $projectsImage }}"
                    alt=""
                    loading="lazy"
                    decoding="async"
                    class="absolute inset-0 h-full w-full object-cover"
                >
                <div aria-hidden="true" class="absolute inset-0 bg-ink/85"></div>
            @endif

            <div class="container-page relative z-10">
                <div class="flex flex-col gap-8 md:flex-row md:items-end md:justify-between">
                    <x-section-heading
                        eyebrow="Livelihood and relief"
                        title="Projects that strengthen families"
                        description="Our community-led projects support families to grow their own food, build income and meet immediate needs."
                        tone="dark"
                    />

                    <x-button href="{{ url('/impact') }}" variant="outline-light" class="shrink-0 md:mb-1">
                        Explore our impact
                        <x-icon name="arrow-right" class="size-4" />
                    </x-button>
                </div>

                <div class="mt-10 rounded-lg border border-white/20 bg-white/10 p-6 sm:p-8">
                    <ul class="flex flex-wrap gap-2">
                        @foreach ($projects as $project)
                            <li>
                                <a
                                    href="{{ url('/impact#project-'.$project->slug) }}"
                                    class="inline-flex min-h-11 items-center rounded-md border border-line bg-surface px-3 py-1.5 text-sm font-semibold text-ink transition-colors hover:border-brand-teal hover:text-brand-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-yellow"
                                >
                                    {{ $project->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <p class="mt-4 text-sm leading-relaxed text-white/80">
                        Piggery, cow rearing, goat rearing and food relief are part of HGCI's wider livelihood and
                        relief work.
                    </p>
                </div>
            </div>
        </section>
    @endif

    {{-- Sponsor CTA band. --}}
    <x-cta-band
        tone="teal"
        eyebrow="Partner with us"
        title="Help a child stay in school"
        description="Sponsorship provides food, education, healthcare and basic necessities for a child in Uganda."
        primary-label="Sponsor a child"
        :primary-href="url('/sponsor')"
        secondary-label="Donate"
        :secondary-href="url('/donate')"
    />
@endsection
