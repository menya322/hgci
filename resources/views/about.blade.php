@extends('layouts.app')

@php
    $vision = $settings['about.vision'] ?? 'Reach to the Poor of the Poorest.';
    $mission = $settings['about.mission'] ?? "Transform children's lives living in poverty in Uganda communities.";
    $whoWeAre = $settings['about.who_we_are'] ?? null;
    $approach = $settings['about.approach'] ?? 'HGCI employs a community-based approach in achieving its objectives by promoting active participation of community members in fighting poverty.';
    $strategicGoal = $settings['about.strategic_goal'] ?? 'To ensure that all children get quality education and develop into responsible adult citizens of the country.';
    $coreValues = $settings['about.core_values'] ?? ['Love', 'Team work', 'Compassion', 'Transparency', 'Excellence'];
    $niches = $settings['about.niche'] ?? ['Health', 'Education', 'Livelihood'];

    $valueTones = [
        'bg-brand-teal text-white',
        'bg-brand-yellow text-ink',
        'bg-brand-green text-ink',
        'bg-brand-orange text-ink',
        'bg-brand-red text-white',
    ];

    $focusAreas = [
        [
            'title' => 'Child welfare and wellbeing',
            'description' => 'Food, basic necessities and the general welfare of every child, so no child faces hardship alone.',
        ],
        [
            'title' => 'Long-term development',
            'description' => 'Positive, lasting change for children growing up in poverty-stricken and underprivileged areas.',
        ],
        [
            'title' => 'Education and vocational skills',
            'description' => 'Quality, competitive education and vocational institutions that reduce illiteracy and improve welfare.',
        ],
        [
            'title' => 'Health, nutrition and sanitation',
            'description' => 'Awareness that creates a clean and healthy environment for children, families and communities.',
        ],
        [
            'title' => 'Discipline and responsibility',
            'description' => 'Guidance that helps children grow into responsible adults while discouraging violence and drug use.',
        ],
    ];
@endphp

@section('title', 'About HGCI')
@section('meta_description', 'Learn who Hope In God Child Initiatives (HGCI) is, our vision, mission, core values, strategic goal and community-based approach to caring for children in Uganda.')

@section('content')
    <x-page-hero
    eyebrow="About HGCI"
    title="Hope for every child, rooted in community"
    description="Hope In God Child Initiatives is a child sponsorship and Christian humanitarian aid organisation serving orphans and vulnerable children in Uganda."
    :breadcrumbs="[['label' => 'About']]"
    image="images/gallery/community-care/community-home-visit.jpeg"
    image-alt="HGCI staff sitting with a family outside their home during a community visit"
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

    {{-- Who we are + at a glance. --}}
    <section class="py-16 lg:py-24">
        <div class="container-page grid gap-12 lg:grid-cols-[minmax(0,3fr)_minmax(0,2fr)] lg:items-start">
            <div>
                <x-section-heading
                    eyebrow="Who we are"
                    title="A community-based approach to caring for children"
                />

                @if ($whoWeAre)
                    <p class="mt-5 max-w-2xl leading-relaxed text-muted">{{ $whoWeAre }}</p>
                @endif

                <p class="mt-4 max-w-2xl leading-relaxed text-muted">{{ $approach }}</p>

                <div class="mt-8 max-w-2xl overflow-hidden rounded-lg border border-line bg-surface shadow-card">
                    <x-responsive-image
                        src="images/about/hgci-profile.jpeg"
                        asset
                        alt="Two-page spread from the HGCI organisational profile covering our vision, mission, core values and strategic areas of focus."
                        :width="1080"
                        :height="764"
                        ratio="4/3"
                    />
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <x-button href="{{ url('/programs') }}" variant="outline">
                        Explore our programs
                        <x-icon name="arrow-right" class="size-4" />
                    </x-button>
                    <x-button href="{{ url('/impact') }}" variant="ghost">
                        See our impact
                    </x-button>
                </div>
            </div>

            <aside class="rounded-lg border border-line bg-surface-warm p-6 shadow-card sm:p-8" aria-label="HGCI at a glance">
                <h2 class="font-display text-xl font-semibold text-ink">At a glance</h2>

                <dl class="mt-6 space-y-5">
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-[0.16em] text-brand-teal">Vision</dt>
                        <dd class="mt-1 leading-relaxed text-ink">{{ $vision }}</dd>
                    </div>
                    <div class="h-px bg-line" aria-hidden="true"></div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-[0.16em] text-brand-teal">Mission</dt>
                        <dd class="mt-1 leading-relaxed text-ink">{{ $mission }}</dd>
                    </div>
                    <div class="h-px bg-line" aria-hidden="true"></div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-[0.16em] text-brand-teal">Strategic goal</dt>
                        <dd class="mt-1 leading-relaxed text-ink">{{ $strategicGoal }}</dd>
                    </div>
                </dl>

                <div class="mt-6 rounded-md border border-line bg-surface p-4">
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand-teal">Our niche</p>
                    <ul class="mt-2 flex flex-wrap gap-2">
                        @foreach ($niches as $niche)
                            <li>
                                <x-badge tone="teal">{{ $niche }}</x-badge>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
        </div>
    </section>

    {{-- Vision, mission and core values. --}}
    <section id="vision" class="border-y border-line bg-surface-warm py-16 lg:py-24">
        <div class="container-page">
            <x-section-heading
                align="center"
                eyebrow="Vision and values"
                title="What guides our work"
                description="Our vision, mission and core values shape every decision we make for children and communities."
            />

            <div class="mt-12 grid gap-6 lg:grid-cols-2">
                <article class="rounded-lg border border-brand-teal-dark bg-brand-teal-dark p-8 text-white sm:p-10">
                    <div class="flex items-center gap-3">
                        <span class="h-1 w-8 rounded-full bg-brand-yellow" aria-hidden="true"></span>
                        <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-white">Our vision</h3>
                    </div>
                    <p class="mt-5 font-display text-3xl font-semibold leading-tight sm:text-4xl">{{ $vision }}</p>
                </article>

                <article class="rounded-lg border border-line bg-surface p-8 shadow-card sm:p-10">
                    <div class="flex items-center gap-3">
                        <span class="h-1 w-8 rounded-full bg-brand-red" aria-hidden="true"></span>
                        <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-brand-teal">Our mission</h3>
                    </div>
                    <p class="mt-5 font-display text-2xl font-semibold leading-tight text-ink sm:text-3xl">{{ $mission }}</p>
                </article>
            </div>

            <div class="mt-10">
                <h3 class="font-display text-xl font-semibold text-ink">Our core values</h3>

                <ul class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    @foreach ($coreValues as $value)
                        <li class="flex items-center gap-3 rounded-lg border border-line bg-surface p-4 shadow-card">
                            <span class="inline-flex size-9 shrink-0 items-center justify-center rounded-md {{ $valueTones[$loop->index % count($valueTones)] }}">
                                <x-icon name="check" class="size-5" />
                            </span>
                            <span class="font-semibold text-ink">{{ $value }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- Strategic areas of focus. --}}
    <section class="py-16 lg:py-24">
        <div class="container-page">
            <x-section-heading
                eyebrow="Strategic focus"
                title="Where we put our energy"
                description="Five strategic areas guide how HGCI serves children and communities in Uganda."
            />

            <ol class="mt-12 grid gap-x-10 gap-y-8 md:grid-cols-2">
                @foreach ($focusAreas as $area)
                    <li class="flex gap-5">
                        <span class="inline-flex size-11 shrink-0 items-center justify-center rounded-lg bg-brand-teal font-display text-lg font-semibold text-white">
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </span>
                        <div>
                            <h3 class="font-display text-lg font-semibold text-ink">{{ $area['title'] }}</h3>
                            <p class="mt-1 text-sm leading-relaxed text-muted">{{ $area['description'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>

            <div class="mt-12 rounded-lg border border-line bg-surface-warm p-6 sm:p-8">
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand-teal">Our strategic goal</p>
                <p class="mt-2 font-display text-2xl font-semibold leading-tight text-ink">{{ $strategicGoal }}</p>
            </div>
        </div>
    </section>

    {{-- Our approach. --}}
    <section id="approach" class="border-y border-brand-teal-dark bg-brand-teal-dark py-16 text-white lg:py-24">
        <div class="container-page grid gap-10 lg:grid-cols-2 lg:items-center">
            <x-section-heading
                eyebrow="Our approach"
                title="Community at the centre"
                description="We promote the active participation of community members in fighting poverty, because lasting change is built together."
                tone="dark"
            />

            <div class="rounded-lg border border-white/25 bg-white/5 p-6 sm:p-8">
                <p class="leading-relaxed text-white">{{ $approach }}</p>

                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach ($niches as $niche)
                        <span class="rounded-md border border-white/25 bg-white/10 px-3 py-1.5 text-xs font-semibold text-white">
                            {{ $niche }}
                        </span>
                    @endforeach
                </div>

                <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                    <x-button href="{{ url('/programs') }}" variant="sponsor">
                        Our programs
                    </x-button>
                    <x-button href="{{ url('/contact') }}" variant="outline-light">
                        Talk to our team
                    </x-button>
                </div>
            </div>
        </div>
    </section>

    {{-- Team. --}}
    <section id="team" class="py-16 lg:py-24">
        <div class="container-page">
            <x-section-heading
                eyebrow="Our team"
                title="The people behind HGCI"
                description="Meet the people serving children and families through HGCI."
            />

            @if ($teamMembers->isNotEmpty())
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($teamMembers as $member)
                        @php $memberImage = \App\Support\ContentImages::teamMember($member, '4/3'); @endphp

                        <article class="overflow-hidden rounded-lg border border-line bg-surface shadow-card">
                            <x-responsive-image
                                :src="$memberImage['src'] ?? null"
                                :alt="$memberImage['alt'] ?? $member->name"
                                :width="$memberImage['width'] ?? 800"
                                :height="$memberImage['height'] ?? 600"
                                ratio="4/3"
                                :focus="$memberImage['focus'] ?? 'upper'"
                                :asset="$memberImage['asset'] ?? false"
                                :label="$memberImage['label'] ?? '[ADD: team photo]'"
                                class="border-b border-line"
                            />

                            <div class="p-6">
                                <h3 class="font-display text-lg font-semibold text-ink">{{ $member->name }}</h3>

                                @if ($member->role)
                                    <p class="mt-0.5 text-sm font-semibold text-brand-teal">{{ $member->role }}</p>
                                @endif

                                @if ($member->bio)
                                    <p class="mt-3 text-sm leading-relaxed text-muted">{{ $member->bio }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="mt-10 grid gap-6 lg:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] lg:items-center">
                    <div class="overflow-hidden rounded-lg border border-line bg-surface shadow-card">
                        <x-responsive-image
                            src="images/gallery/community-care/hgci-team-in-community.jpeg"
                            asset
                            alt="HGCI team members standing together with a community member outdoors."
                            :width="810"
                            :height="1080"
                            ratio="4/3"
                            focus="upper"
                        />
                    </div>

                    <div class="rounded-lg border border-dashed border-line bg-surface-warm p-8 sm:p-10">
                        <p class="font-display text-xl font-semibold text-ink">Team profiles are being prepared</p>
                        <p class="mt-2 max-w-2xl leading-relaxed text-muted">
                            [ADD: names, roles and biographies of HGCI leadership and staff.] Once supplied, each team
                            member will appear here with their photo and role.
                        </p>
                        <x-button href="{{ url('/contact') }}" variant="outline" class="mt-6">
                            Contact HGCI
                            <x-icon name="arrow-right" class="size-4" />
                        </x-button>
                    </div>
                </div>
            @endif
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
@endsection
