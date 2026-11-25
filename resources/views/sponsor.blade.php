@extends('layouts.app')

@php
    $steps = [
        [
            'title' => 'Send an enquiry',
            'copy' => 'Complete the short form below and tell us a little about the child you would like to sponsor.',
        ],
        [
            'title' => 'We contact you',
            'copy' => 'Our team answers your questions and explains the next steps in the sponsorship process.',
        ],
        [
            'title' => 'Meet your child',
            'copy' => 'We match you with a child and share their story with you. [ADD: matching and onboarding details.]',
        ],
        [
            'title' => 'Walk together',
            'copy' => 'Your regular gift helps provide food, education, healthcare and basic necessities.',
        ],
    ];

    $gifts = [
        [
            'icon' => 'bowl',
            'tone' => 'bg-brand-orange text-ink',
            'title' => 'Food and basic necessities',
            'copy' => 'Regular meals and the everyday essentials a child needs to grow and learn.',
        ],
        [
            'icon' => 'academic-cap',
            'tone' => 'bg-brand-yellow text-ink',
            'title' => 'Quality education',
            'copy' => 'School support and learning opportunities that prepare children for responsible adulthood.',
        ],
        [
            'icon' => 'health',
            'tone' => 'bg-brand-teal text-white',
            'title' => 'Healthcare and wellbeing',
            'copy' => 'Support for a child\'s health, nutrition and general wellbeing.',
        ],
        [
            'icon' => 'shield-check',
            'tone' => 'bg-brand-green text-ink',
            'title' => 'A safe, nurturing environment',
            'copy' => 'Care that helps a child grow up in a safe and supportive community.',
        ],
    ];
@endphp

@section('title', 'Sponsor a Child')
@section('meta_description', 'Sponsor a child in Uganda through Hope In God Child Initiatives. Your sponsorship helps provide food, quality education, healthcare and basic necessities.')

@section('content')
    <x-page-hero
        eyebrow="Child sponsorship"
        title="Sponsor a child, change a life"
        description="Your sponsorship helps provide food, education, healthcare and a safe, nurturing environment for a child in Uganda."
        image="images/gallery/clothing-essentials/children-choosing-clothes.jpeg"
        image-alt="Children choosing donated clothes at an HGCI clothing distribution"
        :breadcrumbs="[['label' => 'Sponsor a Child']]"
    >
        <div class="flex flex-col gap-3 sm:flex-row">
            <x-button href="#enquiry" size="lg">
                <x-icon name="heart" class="size-5" />
                Start your enquiry
            </x-button>
            <x-button href="{{ url('/donate') }}" variant="donate" size="lg">
                Donate
            </x-button>
        </div>
    </x-page-hero>

    {{-- How sponsorship works. --}}
    <section id="how-it-works" class="scroll-mt-28 py-16 lg:py-24">
        <div class="container-page">
            <div class="grid gap-10 lg:grid-cols-[minmax(0,3fr)_minmax(0,2fr)] lg:items-center">
                <div>
                    <x-section-heading
                        eyebrow="How it works"
                        title="A simple, personal way to help"
                        description="Sponsorship connects you with a child and their community through a relationship built on care and trust."
                    />

                    <p class="mt-6 max-w-2xl text-sm leading-relaxed text-muted">
                        Sponsorship starts with a conversation. Nothing is charged on this page, and no child is
                        matched until our team has spoken with you.
                    </p>
                </div>

                <figure class="overflow-hidden rounded-lg border border-line bg-surface shadow-card">
                    <x-responsive-image
                        src="images/programs/child-sponsorship.jpg"
                        asset
                        alt="An HGCI staff member standing beside a smiling young girl outdoors."
                        :width="800"
                        :height="500"
                        ratio="4/3"
                        focus="upper"
                    />
                    <figcaption class="border-t border-line p-5 text-sm leading-relaxed text-muted">
                        A child and an HGCI staff member during a community visit.
                        [ADD: photo credit and consent details.]
                    </figcaption>
                </figure>
            </div>

            <ol class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($steps as $step)
                    <li class="rounded-lg border border-line bg-surface p-6 shadow-card">
                        <span class="inline-flex size-11 items-center justify-center rounded-lg bg-brand-teal font-display text-lg font-semibold text-white">
                            {{ $loop->iteration }}
                        </span>
                        <h3 class="mt-4 font-display text-lg font-semibold text-ink">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $step['copy'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- What a gift provides. --}}
    <section class="border-y border-line bg-surface-warm py-16 lg:py-24">
        <div class="container-page">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <x-section-heading
                    eyebrow="What your gift provides"
                    title="Support that reaches the whole child"
                    description="Sponsorship is used where a child needs it most, alongside the wider work of HGCI in their community."
                />

                <x-button href="#enquiry" class="shrink-0">
                    Sponsor a child
                    <x-icon name="arrow-right" class="size-4" />
                </x-button>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($gifts as $gift)
                    <article class="rounded-lg border border-line bg-surface p-6 shadow-card">
                        <span class="inline-flex size-11 items-center justify-center rounded-lg {{ $gift['tone'] }}">
                            <x-icon :name="$gift['icon']" class="size-6" />
                        </span>
                        <h3 class="mt-4 font-display text-lg font-semibold text-ink">{{ $gift['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $gift['copy'] }}</p>
                    </article>
                @endforeach
            </div>

            <div class="mt-8 rounded-lg border border-line bg-surface p-6 sm:p-8">
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand-teal">Sponsorship details</p>
                <p class="mt-2 max-w-3xl leading-relaxed text-ink">
                    [ADD: monthly sponsorship amount, payment options and what the sponsorship covers.]
                </p>
                <p class="mt-2 text-sm leading-relaxed text-muted">
                    HGCI does not display unverified amounts. The confirmed sponsorship details will be published here
                    once supplied.
                </p>
            </div>
        </div>
    </section>

    {{-- FAQ accordion. --}}
    <section id="faqs" class="py-16 lg:py-24">
        <div class="container-page grid gap-10 lg:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] lg:items-start">
            <div>
                <x-section-heading
                    eyebrow="Questions"
                    title="Sponsorship FAQs"
                    description="A few things sponsors often ask before they begin."
                />

                <x-button href="{{ url('/contact') }}" variant="outline" class="mt-7">
                    Ask another question
                    <x-icon name="arrow-right" class="size-4" />
                </x-button>
            </div>

            <div class="space-y-3">
                @forelse ($faqs as $faq)
                    <details class="group rounded-lg border border-line bg-surface p-5 shadow-card">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-ink [&::-webkit-details-marker]:hidden">
                            <span>{{ $faq->question }}</span>
                            <span class="shrink-0 text-brand-teal transition-transform group-open:rotate-180">
                                <x-icon name="chevron-down" class="size-5" />
                            </span>
                        </summary>
                        <p class="mt-3 text-sm leading-relaxed text-muted">{{ $faq->answer }}</p>
                    </details>
                @empty
                    <div class="rounded-lg border border-dashed border-line bg-surface-warm p-6">
                        <p class="font-semibold text-ink">FAQs are being prepared</p>
                        <p class="mt-2 text-sm leading-relaxed text-muted">
                            [ADD: sponsorship frequently asked questions.] Please contact us with any questions in the
                            meantime.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Sponsorship enquiry form. --}}
    <section id="enquiry" class="scroll-mt-28 border-y border-line bg-surface-warm py-16 lg:py-24">
        <div class="container-page grid gap-10 lg:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] lg:items-start">
            <div>
                <x-section-heading
                    eyebrow="Sponsorship enquiry"
                    title="Tell us you would like to sponsor a child"
                    description="Complete the form and our team will contact you with the next steps. There is no payment on this page."
                />

                <div class="mt-7 space-y-4 text-sm leading-relaxed text-muted">
                    <p class="flex items-start gap-3">
                        <x-icon name="shield-check" class="mt-0.5 size-5 shrink-0 text-brand-teal" />
                        <span>Your details are used only to respond to your enquiry.</span>
                    </p>
                    <p class="flex items-start gap-3">
                        <x-icon name="phone" class="mt-0.5 size-5 shrink-0 text-brand-teal" />
                        <span>Prefer to talk? Call [ADD: phone number].</span>
                    </p>
                    <p class="flex items-start gap-3">
                        <x-icon name="envelope" class="mt-0.5 size-5 shrink-0 text-brand-teal" />
                        <span>Email [ADD: email address].</span>
                    </p>
                </div>
            </div>

            <div class="rounded-lg border border-line bg-surface p-6 shadow-card sm:p-8">
                <form method="POST" action="{{ route('sponsor.enquiry') }}" class="space-y-5">
                    @csrf
                    <x-form.honeypot />
                    <x-form.errors />

                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-form.field label="First name" name="first_name" required>
                            <x-form.input name="first_name" autocomplete="given-name" required />
                        </x-form.field>

                        <x-form.field label="Last name" name="last_name" required>
                            <x-form.input name="last_name" autocomplete="family-name" required />
                        </x-form.field>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-form.field label="Email address" name="email" required>
                            <x-form.input name="email" type="email" autocomplete="email" required />
                        </x-form.field>

                        <x-form.field label="Phone number" name="phone">
                            <x-form.input name="phone" type="tel" autocomplete="tel" />
                        </x-form.field>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-form.field label="Country" name="country">
                            <x-form.input name="country" autocomplete="country-name" />
                        </x-form.field>

                        <x-form.field label="Preferred child age" name="preferred_child_age">
                            <x-form.select
                                name="preferred_child_age"
                                placeholder="No preference"
                                :options="[
                                    '0-5' => '0–5 years',
                                    '6-10' => '6–10 years',
                                    '11-15' => '11–15 years',
                                    '16-18' => '16–18 years',
                                    'No preference' => 'No preference',
                                ]"
                            />
                        </x-form.field>
                    </div>

                    <x-form.field label="Your message" name="message" hint="Optional. Tell us anything you would like us to know.">
                        <x-form.textarea name="message" rows="4" />
                    </x-form.field>

                    <x-form.checkbox name="consent">
                        I agree that HGCI may use my details to respond to this sponsorship enquiry.
                    </x-form.checkbox>

                    <x-button type="submit" size="lg" class="w-full">
                        Send sponsorship enquiry
                        <x-icon name="arrow-right" class="size-4" />
                    </x-button>
                </form>
            </div>
        </div>
    </section>

    <x-cta-band
        tone="teal"
        eyebrow="Another way to help"
        title="Not ready to sponsor? Give today"
        description="Every gift helps a child stay in school, eat well and grow up in a safe and caring community."
        primary-label="Donate today"
        :primary-href="url('/donate')"
        secondary-label="Get involved"
        :secondary-href="url('/get-involved')"
        :image="[
            'src' => 'images/home/sponsor.jpg',
            'alt' => 'Three smiling boys standing against a brick wall with new clothes in their arms.',
            'width' => 480,
            'height' => 640,
            'ratio' => '3/4',
            'asset' => true,
        ]"
    />
@endsection
