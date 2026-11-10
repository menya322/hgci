@extends('layouts.app')

@php
    $heroEyebrow = $settings['hero.eyebrow'] ?? 'Child sponsorship in Uganda';
    $heroTitle = $settings['hero.title'] ?? 'Every child deserves hope.';
    $heroDescription = $settings['hero.description'] ?? 'Hope In God Child Initiatives is a child sponsorship and Christian humanitarian aid organization transforming the lives of orphans and vulnerable children in Uganda.';
    $vision = $settings['about.vision'] ?? 'Reach to the Poor of the Poorest.';
    $mission = $settings['about.mission'] ?? "Transform children's lives living in poverty in Uganda communities.";
    $niches = $settings['about.niche'] ?? ['Health', 'Education', 'Livelihood'];
    $coreValues = $settings['about.core_values'] ?? ['Love', 'Team work', 'Compassion', 'Transparency', 'Excellence'];

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

    $programTones = ['teal', 'red', 'green', 'orange', 'yellow'];

    $impactStats = [
        ['label' => 'Children reached', 'value' => $settings['impact.children_reached'] ?? null],
        ['label' => 'Projects supported', 'value' => $settings['impact.projects_supported'] ?? null],
        ['label' => 'Communities served', 'value' => $settings['impact.communities_served'] ?? null],
    ];
@endphp

@section('title', 'Child sponsorship and Christian humanitarian aid in Uganda')
@section('meta_description', 'Hope In God Child Initiatives (HGCI) transforms the lives of orphans and vulnerable children in Uganda through child sponsorship, education, health, livelihood and food relief.')

@section('content')
    {{-- Hero: mission-first statement with the vision and mission panel. --}}
    <section class="relative overflow-hidden bg-surface">
        <div class="container-page grid items-center gap-12 py-14 lg:grid-cols-2 lg:py-24">
            <div>
                <p class="inline-flex items-center gap-2 rounded-md border border-line bg-surface-warm px-3 py-1.5 text-xs font-bold uppercase tracking-[0.16em] text-brand-teal">
                    <span class="size-2 rounded-full bg-brand-red" aria-hidden="true"></span>
                    {{ $heroEyebrow }}
                </p>

                <h1 class="mt-6 max-w-xl font-display text-4xl font-semibold leading-[1.05] tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    {{ $heroTitle }}
                </h1>

                <p class="mt-6 max-w-xl text-lg leading-relaxed text-muted">
                    {{ $heroDescription }}
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <x-button href="{{ url('/sponsor') }}" size="lg">
                        <x-icon name="heart" class="size-5" />
                        Sponsor a child
                    </x-button>
                    <x-button href="{{ url('/donate') }}" variant="donate" size="lg">
                        Donate
                    </x-button>
                </div>

                <p class="mt-6 flex items-center gap-2 text-sm text-muted">
                    <x-icon name="shield-check" class="size-5 shrink-0 text-brand-teal" />
                    Community-based, transparent and accountable.
                </p>
            </div>

            <div class="relative overflow-hidden rounded-lg bg-brand-teal-dark p-8 text-white sm:p-10">
                <div aria-hidden="true" class="pointer-events-none absolute -right-10 -top-10 size-40 rounded-full bg-brand-teal/60"></div>
                <div aria-hidden="true" class="pointer-events-none absolute -bottom-14 -left-10 size-44 rounded-full bg-brand-teal/40"></div>

                <div class="relative">
                    <div class="flex items-center gap-3">
                        <span class="h-1 w-8 rounded-full bg-brand-yellow" aria-hidden="true"></span>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-white/90">Our vision</p>
                    </div>
                    <p class="mt-4 font-display text-3xl font-semibold leading-tight">
                        {{ $vision }}
                    </p>

                    <div class="my-6 h-px bg-white/20"></div>

                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-white/90">Our mission</p>
                    <p class="mt-2 text-lg leading-relaxed text-white/90">
                        {{ $mission }}
                    </p>

                    <div class="mt-8 flex flex-wrap gap-2">
                        @foreach ($niches as $niche)
                            <span class="rounded-md border border-white/25 bg-white/10 px-3 py-1.5 text-xs font-semibold text-white">
                                {{ $niche }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Quick links: the five main destinations. --}}
    <section class="border-y border-line bg-surface py-12 lg:py-16" aria-labelledby="quick-links-heading">
        <div class="container-page">
            <h2 id="quick-links-heading" class="sr-only">Explore Hope In God Child Initiatives</h2>

            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                <x-quick-link
                    href="{{ url('/about') }}"
                    title="About Us"
                    description="Who we are and what guides our work"
                    icon="users"
                    tone="teal"
                />
                <x-quick-link
                    href="{{ url('/programs') }}"
                    title="Our Programs"
                    description="Education, health and livelihood"
                    icon="academic-cap"
                    tone="yellow"
                />
                <x-quick-link
                    href="{{ url('/sponsor') }}"
                    title="Sponsor a Child"
                    description="Walk with a child through school"
                    icon="heart"
                    tone="red"
                />
                <x-quick-link
                    href="{{ url('/donate') }}"
                    title="Donate"
                    description="Give towards food, schooling and care"
                    icon="gift"
                    tone="orange"
                />
                <x-quick-link
                    href="{{ url('/contact') }}"
                    title="Contact"
                    description="Talk to our team in Uganda"
                    icon="envelope"
                    tone="green"
                />
            </div>
        </div>
    </section>

    {{-- Who we are + our niche. --}}
    <section class="bg-surface-warm py-16 lg:py-24">
        <div class="container-page grid gap-12 lg:grid-cols-2 lg:items-start">
            <div>
                <x-section-heading
                    eyebrow="Who we are"
                    title="A community-based approach to caring for children"
                    :description="$settings['about.who_we_are'] ?? null"
                />

                <p class="mt-5 max-w-xl leading-relaxed text-muted">
                    {{ $settings['about.approach'] ?? 'HGCI employs a community-based approach in achieving its objectives by promoting active participation of community members in fighting poverty.' }}
                </p>

                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach ($coreValues as $value)
                        <x-badge tone="neutral">{{ $value }}</x-badge>
                    @endforeach
                </div>

                <x-button href="{{ url('/about') }}" variant="outline" class="mt-8">
                    Learn about HGCI
                    <x-icon name="arrow-right" class="size-4" />
                </x-button>
            </div>

            <div class="rounded-lg border border-line bg-surface p-6 shadow-card sm:p-8">
                <h3 class="font-display text-xl font-semibold text-ink">Our niche</h3>

                <ul class="mt-6 space-y-5">
                    @foreach ($niches as $niche)
                        @php
                            $detail = $nicheDetails[$niche] ?? [
                                'icon' => 'sparkles',
                                'tone' => 'bg-brand-orange text-ink',
                                'copy' => null,
                            ];
                        @endphp

                        <li class="flex gap-4">
                            <span class="inline-flex size-11 shrink-0 items-center justify-center rounded-lg {{ $detail['tone'] }}">
                                <x-icon :name="$detail['icon']" class="size-6" />
                            </span>
                            <div>
                                <p class="font-semibold text-ink">{{ $niche }}</p>
                                @if ($detail['copy'])
                                    <p class="mt-0.5 text-sm leading-relaxed text-muted">{{ $detail['copy'] }}</p>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-6 rounded-md border border-line bg-surface-warm p-4 text-sm leading-relaxed text-ink">
                    <span class="font-semibold">Strategic goal:</span>
                    {{ $settings['about.strategic_goal'] ?? 'To ensure that all children get quality education and develop into responsible adult citizens of the country.' }}
                </div>
            </div>
        </div>
    </section>

    {{-- Featured story / current project. --}}
    @if ($featuredPost)
        <section class="py-16 lg:py-24" aria-labelledby="featured-story-heading">
            <div class="container-page grid gap-10 lg:grid-cols-2 lg:items-center">
                <div class="overflow-hidden rounded-lg border border-line bg-surface shadow-card">
                    <x-media
                        :src="$featuredPost->featured_image"
                        :alt="$featuredPost->image_alt ?? $featuredPost->title"
                        ratio="aspect-[4/3]"
                    />
                </div>

                <div>
                    <x-section-heading
                        eyebrow="Featured story"
                        title="{{ $featuredPost->title }}"
                        :description="$featuredPost->excerpt"
                    />

                    <p class="mt-5 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-muted">
                        @if ($featuredPost->category)
                            <span class="font-semibold text-brand-teal">{{ ucfirst($featuredPost->category) }}</span>
                            <span aria-hidden="true" class="size-1 rounded-full bg-line"></span>
                        @endif
                        <time datetime="{{ $featuredPost->published_at?->toDateString() }}">
                            {{ $featuredPost->published_at?->format('j M Y') }}
                        </time>
                    </p>

                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        <x-button href="{{ url('/news/'.$featuredPost->slug) }}" size="lg">
                            Read the story
                            <x-icon name="arrow-right" class="size-4" />
                        </x-button>
                        <x-button href="{{ url('/news') }}" variant="outline" size="lg">
                            All news
                        </x-button>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Programs grid, driven by the programs table. --}}
    <section class="border-y border-line bg-surface-warm py-16 lg:py-24">
        <div class="container-page">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <x-section-heading
                    eyebrow="What we do"
                    title="Programs that meet children where they are"
                    description="From education to food relief, our work is designed around the whole child and the community around them."
                />

                <x-button href="{{ url('/programs') }}" variant="outline" class="shrink-0">
                    View all programs
                    <x-icon name="arrow-right" class="size-4" />
                </x-button>
            </div>

            @if ($programs->isNotEmpty())
                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($programs as $program)
                        <x-program-card
                            :href="url('/programs/'.$program->slug)"
                            :title="$program->title"
                            :description="$program->excerpt"
                            :icon="$program->icon ?? 'sparkles'"
                            :tone="$programTones[$loop->index % count($programTones)]"
                        />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Impact / achievements strip. --}}
    <section class="bg-brand-teal-dark py-16 text-white lg:py-20" aria-labelledby="impact-heading">
        <div class="container-page">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <x-section-heading
                    eyebrow="Our impact"
                    title="Practical projects, lasting change"
                    description="Our livelihood and relief work is community-led, so families help shape the support they receive."
                    tone="dark"
                />

                <x-button href="{{ url('/impact') }}" variant="outline-light" class="shrink-0">
                    See our impact
                    <x-icon name="arrow-right" class="size-4" />
                </x-button>
            </div>

            <dl class="mt-10 grid gap-4 sm:grid-cols-3">
                @foreach ($impactStats as $stat)
                    <div class="rounded-lg border border-white/20 bg-white/5 p-6">
                        <dt class="text-sm font-semibold text-white/90">{{ $stat['label'] }}</dt>
                        <dd class="mt-2 font-display text-2xl font-semibold text-white">
                            @if ($stat['value'] && ! str_starts_with((string) $stat['value'], '[ADD'))
                                {{ $stat['value'] }}
                            @else
                                <span title="{{ $stat['value'] ?? '[ADD: verified figure]' }}">[ADD]</span>
                                <span class="mt-1 block text-xs font-normal text-white/80">Verified figure to be published</span>
                            @endif
                        </dd>
                    </div>
                @endforeach
            </dl>

            <div class="mt-8 flex flex-wrap items-center gap-2">
                @foreach ($projects as $project)
                    <a
                        href="{{ url('/impact') }}"
                        class="inline-flex min-h-11 items-center rounded-md border border-white/25 bg-white/5 px-3 py-1.5 text-sm font-semibold text-white transition-colors hover:bg-white hover:text-brand-teal-dark focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                    >
                        {{ $project->title }}
                    </a>
                @endforeach
                <span class="inline-flex min-h-11 items-center rounded-md border border-dashed border-white/40 px-3 py-1.5 text-sm font-semibold text-white">
                    [ADD: fourth project]
                </span>
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
        secondary-label="How sponsorship works"
        :secondary-href="url('/sponsor#how-it-works')"
    />

    {{-- Upcoming events. --}}
    @if ($upcomingEvents->isNotEmpty())
        <section class="py-16 lg:py-24" aria-labelledby="events-heading">
            <div class="container-page grid gap-10 lg:grid-cols-[minmax(0,1fr)_minmax(0,2fr)] lg:items-start">
                <div>
                    <x-section-heading
                        eyebrow="Coming up"
                        title="Events and community days"
                        description="Join us in person, or keep us in prayer as we serve children and families."
                    />

                    <x-button href="{{ url('/events') }}" variant="outline" class="mt-7">
                        All events
                        <x-icon name="arrow-right" class="size-4" />
                    </x-button>
                </div>

                <div class="grid gap-4">
                    @foreach ($upcomingEvents as $event)
                        <x-event-card :event="$event" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Latest news and stories. --}}
    @if ($latestPosts->isNotEmpty())
        <section class="border-y border-line bg-surface-warm py-16 lg:py-24" aria-labelledby="news-heading">
            <div class="container-page">
                <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                    <x-section-heading
                        eyebrow="News and stories"
                        title="Life at HGCI"
                        description="Updates from our programmes, the children we walk with and the communities we serve."
                    />

                    <x-button href="{{ url('/news') }}" variant="outline" class="shrink-0">
                        All news
                        <x-icon name="arrow-right" class="size-4" />
                    </x-button>
                </div>

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($latestPosts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Get involved link grid. --}}
    <section class="py-16 lg:py-20">
        <div class="container-page">
            <x-section-heading
                align="center"
                eyebrow="Get involved"
                title="There is a place for you in this work"
                description="Sponsor a child, give, volunteer your skills, partner with us or join us in prayer."
            />

            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <x-button href="{{ url('/sponsor') }}" variant="outline">Sponsor a child</x-button>
                <x-button href="{{ url('/get-involved#volunteer') }}" variant="outline">Volunteer</x-button>
                <x-button href="{{ url('/donate') }}" variant="donate">Donate</x-button>
                <x-button href="{{ url('/contact') }}" variant="outline">Contact us</x-button>
                <x-button href="{{ url('/contact#prayer') }}" variant="ghost">Prayer request</x-button>
            </div>
        </div>
    </section>

    {{-- Sponsor CTA repeated before the footer. --}}
    <x-cta-band
        tone="teal"
        eyebrow="Partner with us"
        title="A little goes a long way"
        description="Every gift helps a child stay in school, eat well and grow up in a safe and caring community."
        primary-label="Donate today"
        :primary-href="url('/donate')"
        secondary-label="Sponsor a child"
        :secondary-href="url('/sponsor')"
    />
@endsection
