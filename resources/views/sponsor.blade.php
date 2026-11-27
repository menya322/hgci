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
    <section id="how-it-works" class="py-16 lg:py-24">
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
                    <figcaption class="flex items-center gap-2 border-t border-line p-4 text-sm leading-relaxed text-muted">
                        <span class="size-1.5 shrink-0 rounded-full bg-brand-teal" aria-hidden="true"></span>
                        A child and an HGCI staff member during a community visit.
                    </figcaption>
                </figure>
            </div>

            <ol class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($steps as $step)
                    <li class="group relative flex h-full flex-col overflow-hidden rounded-lg border border-line bg-surface p-6 shadow-card transition duration-200 hover:-translate-y-1 hover:border-brand-teal hover:shadow-md">
                        <span class="absolute inset-x-0 top-0 h-1 {{ ['bg-brand-teal', 'bg-brand-yellow', 'bg-brand-orange', 'bg-brand-green'][$loop->index % 4] }}" aria-hidden="true"></span>

                        <div class="flex items-center justify-between gap-3">
                            <span class="inline-flex size-11 items-center justify-center rounded-lg bg-brand-teal font-display text-lg font-semibold text-white">
                                {{ $loop->iteration }}
                            </span>
                            <span class="text-xs font-bold uppercase tracking-[0.16em] text-muted">
                                Step {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        <h3 class="mt-5 font-display text-lg font-semibold text-ink">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $step['copy'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- What a gift provides. --}}
    @php
        $giftsImage = \App\Support\ImageSource::url('images/gallery/food-relief/family-receiving-food-parcel.jpeg', asset: true);
        $giftAccents = ['bg-brand-orange', 'bg-brand-yellow', 'bg-brand-teal', 'bg-brand-green'];
    @endphp

    <section class="relative isolate overflow-hidden bg-ink py-16 text-white lg:py-24">
        @if ($giftsImage)
            <img
                src="{{ $giftsImage }}"
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
                    eyebrow="What your gift provides"
                    title="Support that reaches the whole child"
                    description="Sponsorship is used where a child needs it most, alongside the wider work of HGCI in their community."
                    tone="dark"
                />

                <x-button href="#enquiry" variant="sponsor" class="shrink-0 md:mb-1">
                    Sponsor a child
                    <x-icon name="arrow-right" class="size-4" />
                </x-button>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($gifts as $gift)
                    <article class="group relative flex h-full flex-col overflow-hidden rounded-lg border border-line bg-surface p-6 text-ink shadow-card transition duration-200 hover:-translate-y-1 hover:shadow-md">
                        <span class="absolute inset-x-0 top-0 h-1 {{ $giftAccents[$loop->index % count($giftAccents)] }}" aria-hidden="true"></span>

                        <span class="inline-flex size-11 items-center justify-center rounded-lg {{ $gift['tone'] }}">
                            <x-icon :name="$gift['icon']" class="size-6" />
                        </span>
                        <h3 class="mt-4 font-display text-lg font-semibold text-ink">{{ $gift['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $gift['copy'] }}</p>
                    </article>
                @endforeach
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
                    <details class="group overflow-hidden rounded-lg border border-line bg-surface shadow-card transition-colors hover:border-brand-teal open:border-brand-teal">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 p-5 font-semibold text-ink [&::-webkit-details-marker]:hidden">
                            <span class="flex items-start gap-3">
                                <span class="mt-1.5 size-2 shrink-0 rounded-full bg-brand-teal" aria-hidden="true"></span>
                                <span>{{ $faq->question }}</span>
                            </span>
                            <span class="shrink-0 rounded-md p-1 text-brand-teal transition-transform group-open:rotate-180">
                                <x-icon name="chevron-down" class="size-5" />
                            </span>
                        </summary>
                        <div class="px-5 pb-5">
                            <p class="border-t border-line pt-3 text-sm leading-relaxed text-muted">{{ $faq->answer }}</p>
                        </div>
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
    @php
        $enquiryImage = \App\Support\ImageSource::url('images/gallery/community-care/encouraging-a-child.jpeg', asset: true);
    @endphp

    <section id="enquiry" class="relative isolate overflow-hidden bg-ink py-16 text-white lg:py-24">
        @if ($enquiryImage)
            <img
                src="{{ $enquiryImage }}"
                alt=""
                loading="lazy"
                decoding="async"
                class="absolute inset-0 h-full w-full object-cover"
            >
            <div aria-hidden="true" class="absolute inset-0 bg-ink/85"></div>
        @endif

        <div class="container-page relative z-10 grid gap-10 lg:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] lg:items-start lg:gap-16">
            <div>
                <x-section-heading
                    eyebrow="Sponsorship enquiry"
                    title="Tell us you would like to sponsor a child"
                    description="Complete the form and our team will contact you with the next steps. There is no payment on this page."
                    tone="dark"
                />

                <div class="mt-7 space-y-4 text-sm leading-relaxed text-white/90">
                    <p class="flex items-start gap-3">
                        <x-icon name="shield-check" class="mt-0.5 size-5 shrink-0 text-brand-yellow" />
                        <span>Your details are used only to respond to your enquiry.</span>
                    </p>
                    <p class="flex items-start gap-3">
                        <x-icon name="phone" class="mt-0.5 size-5 shrink-0 text-brand-yellow" />
                        <span>Prefer to talk? Call +256702556778 +256777782661</span>
                    </p>
                    <p class="flex items-start gap-3">
                        <x-icon name="envelope" class="mt-0.5 size-5 shrink-0 text-brand-yellow" />
                        <span>Email info@hopeingodci.org.</span>
                    </p>
                </div>
            </div>

            <div class="rounded-lg border border-line bg-surface p-6 text-ink shadow-card sm:p-8">
                <div class="mb-6 flex items-center gap-3 border-b border-line pb-5">
                    <span class="inline-flex size-10 shrink-0 items-center justify-center rounded-lg bg-brand-teal text-white">
                        <x-icon name="heart" class="size-5" />
                    </span>
                    <div>
                        <p class="font-display text-lg font-semibold leading-tight text-ink">Sponsorship enquiry</p>
                        <p class="text-sm text-muted">Takes about two minutes.</p>
                    </div>
                </div>

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
