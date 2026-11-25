@extends('layouts.app')

@php
    $givingCards = [
        [
            'icon' => 'phone',
            'tone' => 'bg-brand-teal text-white',
            'title' => 'Mobile money',
            'rows' => [
                'Provider' => $settings['giving.mobile_money_provider'] ?? null,
                'Account name' => $settings['giving.mobile_money_account_name'] ?? null,
                'Number' => $settings['giving.mobile_money_number'] ?? null,
            ],
        ],
        [
            'icon' => 'briefcase',
            'tone' => 'bg-brand-yellow text-ink',
            'title' => 'Bank transfer',
            'rows' => [
                'Bank' => $settings['giving.bank_name'] ?? null,
                'Account name' => $settings['giving.bank_account_name'] ?? null,
                'Account number' => $settings['giving.bank_account_number'] ?? null,
                'Branch' => $settings['giving.bank_branch'] ?? null,
                'SWIFT' => $settings['giving.bank_swift'] ?? null,
            ],
        ],
        [
            'icon' => 'heart',
            'tone' => 'bg-brand-green text-ink',
            'title' => 'Other ways to give',
            'rows' => [
                'Instructions' => $settings['giving.instructions'] ?? null,
            ],
        ],
    ];

    $uses = [
        [
            'title' => 'Education',
            'copy' => 'School support and learning opportunities that prepare children for responsible adulthood.',
            'icon' => 'academic-cap',
            'tone' => 'bg-brand-teal text-white',
        ],
        [
            'title' => 'Health and nutrition',
            'copy' => 'Health, nutrition and sanitation support so children can grow up strong and well.',
            'icon' => 'health',
            'tone' => 'bg-brand-red text-white',
        ],
        [
            'title' => 'Livelihood',
            'copy' => 'Community projects such as piggery, cow rearing and goat rearing that strengthen families.',
            'icon' => 'briefcase',
            'tone' => 'bg-brand-green text-ink',
        ],
    ];
@endphp

@section('title', 'Donate')
@section('meta_description', 'Give to Hope In God Child Initiatives (HGCI) and help provide food, quality education, healthcare and basic necessities for orphans and vulnerable children in Uganda.')

@section('content')
    <x-page-hero
        eyebrow="Give today"
        title="Your gift gives a child hope"
        description="Every gift helps provide food, quality education, healthcare and basic necessities for a child in Uganda."
        image="images/gallery/education-school-support/clothing-support-at-school.jpeg"
        image-alt="An HGCI team member holding up a dress for students gathered around donated clothes in a school compound"
        :breadcrumbs="[['label' => 'Donate']]"
    >
        <div class="flex flex-col gap-3 sm:flex-row">
            <x-button href="#pledge" variant="donate" size="lg">
                <x-icon name="gift" class="size-5" />
                Make a pledge
            </x-button>
            <x-button href="{{ url('/sponsor') }}" size="lg">
                <x-icon name="heart" class="size-5" />
                Sponsor a child
            </x-button>
        </div>
    </x-page-hero>

    {{-- Where your gift goes. --}}
    <section class="py-16 lg:py-24">
        <div class="container-page">
            <x-section-heading
                eyebrow="Where your gift goes"
                title="Support that reaches the whole child"
                description="Your gift is used where it is needed most, alongside the wider work of HGCI in the child's community."
            />

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($uses as $use)
                    <article class="rounded-lg border border-line bg-surface p-6 shadow-card">
                        <span class="inline-flex size-11 items-center justify-center rounded-lg {{ $use['tone'] }}">
                            <x-icon :name="$use['icon']" class="size-6" />
                        </span>
                        <h3 class="mt-4 font-display text-lg font-semibold text-ink">{{ $use['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $use['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Ways to give. --}}
    <section id="ways-to-give" class="scroll-mt-28 border-y border-line bg-surface-warm py-16 lg:py-24">
        <div class="container-page">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <x-section-heading
                    eyebrow="Ways to give"
                    title="Choose the way that suits you"
                    description="Give through mobile money or a bank transfer. Our team can also help with other giving arrangements."
                />

                <x-button href="#pledge" variant="outline" class="shrink-0">
                    Record a pledge
                    <x-icon name="arrow-right" class="size-4" />
                </x-button>
            </div>

            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                @foreach ($givingCards as $card)
                    <article class="flex flex-col rounded-lg border border-line bg-surface p-6 shadow-card">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex size-11 shrink-0 items-center justify-center rounded-lg {{ $card['tone'] }}">
                                <x-icon :name="$card['icon']" class="size-6" />
                            </span>
                            <h3 class="font-display text-lg font-semibold text-ink">{{ $card['title'] }}</h3>
                        </div>

                        <dl class="mt-5 flex-1 divide-y divide-line border-t border-line">
                            @foreach ($card['rows'] as $label => $value)
                                <div class="flex items-start justify-between gap-4 py-3">
                                    <dt class="shrink-0 text-sm font-semibold text-muted">{{ $label }}</dt>
                                    <dd class="text-right text-sm font-medium text-ink">
                                        @if ($value && ! str_starts_with((string) $value, '[ADD'))
                                            {{ $value }}
                                        @else
                                            <span class="text-muted">{{ $value ?? '[ADD]' }}</span>
                                        @endif
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    </article>
                @endforeach
            </div>

            <div class="mt-8 rounded-lg border border-dashed border-line bg-surface p-5 sm:p-6">
                <p class="flex items-start gap-3 text-sm leading-relaxed text-muted">
                    <x-icon name="info" class="mt-0.5 size-5 shrink-0 text-brand-teal" />
                    <span>
                        Giving details are being confirmed. [ADD: mobile money and bank details will be published here
                        once supplied.] No payment is taken on this website.
                    </span>
                </p>
            </div>
        </div>
    </section>

    {{-- Donation pledge form. --}}
    <section id="pledge" class="scroll-mt-28 py-16 lg:py-24">
        <div class="container-page grid gap-10 lg:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] lg:items-start">
            <div>
                <x-section-heading
                    eyebrow="Donation pledge"
                    title="Tell us about your gift"
                    description="Record your pledge and our team will contact you with the confirmed payment details. There is no payment on this page."
                />

                <div class="mt-7 space-y-4 text-sm leading-relaxed text-muted">
                    <p class="flex items-start gap-3">
                        <x-icon name="shield-check" class="mt-0.5 size-5 shrink-0 text-brand-teal" />
                        <span>Your details are used only to follow up on your pledge.</span>
                    </p>
                    <p class="flex items-start gap-3">
                        <x-icon name="phone" class="mt-0.5 size-5 shrink-0 text-brand-teal" />
                        <span>Prefer to talk? Call +256702556778 +256777782661.</span>
                    </p>
                    <p class="flex items-start gap-3">
                        <x-icon name="envelope" class="mt-0.5 size-5 shrink-0 text-brand-teal" />
                        <span>Email info@hopeforchildren.org.</span>
                    </p>
                </div>
            </div>

            <div class="rounded-lg border border-line bg-surface p-6 shadow-card sm:p-8">
                <form method="POST" action="{{ route('donate.pledge') }}" class="space-y-5">
                    @csrf
                    <x-form.honeypot />
                    <x-form.errors />

                    <x-form.field label="Full name" name="name" required>
                        <x-form.input name="name" autocomplete="name" required />
                    </x-form.field>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-form.field label="Email address" name="email" required>
                            <x-form.input name="email" type="email" autocomplete="email" required />
                        </x-form.field>

                        <x-form.field label="Phone number" name="phone">
                            <x-form.input name="phone" type="tel" autocomplete="tel" />
                        </x-form.field>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-form.field label="Amount" name="amount" hint="Amount in Ugandan Shillings (UGX)." required>
                            <x-form.input name="amount" type="number" min="1" step="1" inputmode="numeric" required />
                        </x-form.field>

                        <x-form.field label="Giving frequency" name="frequency" required>
                            <x-form.select
                                name="frequency"
                                :options="[
                                    'one_time' => 'One-time gift',
                                    'monthly' => 'Monthly gift',
                                ]"
                                selected="one_time"
                            />
                        </x-form.field>
                    </div>

                    <x-form.field label="Preferred giving method" name="method">
                        <x-form.select
                            name="method"
                            placeholder="Choose a method"
                            :options="[
                                'mobile_money' => 'Mobile money',
                                'bank_transfer' => 'Bank transfer',
                                'other' => 'Other',
                            ]"
                        />
                    </x-form.field>

                    <x-form.field label="Your message" name="message" hint="Optional. Tell us anything you would like us to know.">
                        <x-form.textarea name="message" rows="4" />
                    </x-form.field>

                    <x-form.checkbox name="consent">
                        I agree that HGCI may use my details to follow up on this donation pledge.
                    </x-form.checkbox>

                    <x-button type="submit" variant="donate" size="lg" class="w-full">
                        Record my pledge
                        <x-icon name="arrow-right" class="size-4" />
                    </x-button>

                    <p class="text-center text-xs leading-relaxed text-muted">
                        This form records a pledge only. Our team will share the confirmed payment details with you.
                    </p>
                </form>
            </div>
        </div>
    </section>

    <x-cta-band
        tone="yellow"
        eyebrow="Another way to help"
        title="Sponsor a child, change a life"
        description="Sponsorship connects you with a child and their community through a relationship built on care and trust."
        primary-label="Sponsor a child"
        :primary-href="url('/sponsor')"
        secondary-label="Get involved"
        :secondary-href="url('/get-involved')"
    />
@endsection
