@extends('layouts.app')

@php
    $ways = [
        [
            'icon' => 'users',
            'tone' => 'bg-brand-teal text-white',
            'title' => 'Volunteer your time',
            'copy' => 'Share your skills and time with children and families in Uganda.',
            'link' => '#volunteer',
            'link-label' => 'Apply to volunteer',
        ],
        [
            'icon' => 'briefcase',
            'tone' => 'bg-brand-yellow text-ink',
            'title' => 'Partner with us',
            'copy' => 'Churches, schools, businesses and organisations can partner with HGCI.',
            'link' => url('/contact'),
            'link-label' => 'Start a conversation',
            'id' => 'partner',
        ],
        [
            'icon' => 'gift',
            'tone' => 'bg-brand-green text-ink',
            'title' => 'Give in kind',
            'copy' => 'Donate food, scholastic materials or other basic necessities.',
            'link' => url('/contact'),
            'link-label' => 'Ask what is needed',
        ],
        [
            'icon' => 'heart',
            'tone' => 'bg-brand-orange text-ink',
            'title' => 'Join us in prayer',
            'copy' => 'Keep the children, families and communities we serve in your prayers.',
            'link' => url('/contact#prayer'),
            'link-label' => 'Send a prayer request',
        ],
    ];

    $steps = [
        [
            'title' => 'Send your application',
            'copy' => 'Tell us a little about yourself, your skills and when you are available.',
        ],
        [
            'title' => 'Talk with our team',
            'copy' => 'We will contact you to learn more and explain where your help is most useful.',
        ],
        [
            'title' => 'Serve together',
            'copy' => 'Join the work alongside HGCI staff and community volunteers.',
        ],
    ];

    $phone = $settings['contact.phone'] ?? '[ADD: phone number]';
    $email = $settings['contact.email'] ?? '[ADD: email address]';
@endphp

@section('title', 'Get Involved')
@section('meta_description', 'Volunteer, partner, give in kind or pray with Hope In God Child Initiatives (HGCI) and help transform the lives of children and communities in Uganda.')

@section('content')
    <x-page-hero
        eyebrow="Get involved"
        title="There is a place for you in this work"
        description="Whether you give your time, your skills, your resources or your prayers, you can be part of what HGCI is doing for children in Uganda."
        :breadcrumbs="[['label' => 'Get Involved']]"
    >
        <div class="flex flex-col gap-3 sm:flex-row">
            <x-button href="#volunteer" size="lg">
                <x-icon name="users" class="size-5" />
                Volunteer with us
            </x-button>
            <x-button href="{{ url('/donate') }}" variant="donate" size="lg">
                Donate
            </x-button>
        </div>
    </x-page-hero>

    {{-- Ways to get involved. --}}
    <section class="py-16 lg:py-24">
        <div class="container-page">
            <x-section-heading
                eyebrow="Ways to help"
                title="Choose how you would like to be involved"
                description="Every contribution matters, and there is more than one way to stand with children and families."
            />

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($ways as $way)
                    <article
                        @if (! empty($way['id'])) id="{{ $way['id'] }}" @endif
                        class="flex flex-col rounded-lg border border-line bg-surface p-6 shadow-card"
                    >
                        <span class="inline-flex size-11 items-center justify-center rounded-lg {{ $way['tone'] }}">
                            <x-icon :name="$way['icon']" class="size-6" />
                        </span>
                        <h3 class="mt-4 font-display text-lg font-semibold text-ink">{{ $way['title'] }}</h3>
                        <p class="mt-2 flex-1 text-sm leading-relaxed text-muted">{{ $way['copy'] }}</p>
                        <a
                            href="{{ $way['link'] }}"
                            class="mt-5 inline-flex min-h-11 items-center gap-1.5 rounded-sm text-sm font-semibold text-brand-teal transition-colors hover:text-brand-teal-dark focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
                        >
                            {{ $way['link-label'] }}
                            <x-icon name="arrow-right" class="size-4" />
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- How volunteering works. --}}
    <section class="border-y border-line bg-surface-warm py-16 lg:py-20">
        <div class="container-page">
            <div class="grid gap-10 lg:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] lg:items-start">
                <div>
                    <x-section-heading
                        eyebrow="Volunteering"
                        title="A simple way to start"
                        description="We would love to hear how you would like to serve. The process starts with a short application."
                    />

                    <figure class="mt-7 overflow-hidden rounded-lg border border-line bg-surface shadow-card">
                        <x-responsive-image
                            src="images/gallery/clothing-essentials/sorting-donated-clothes.jpeg"
                            asset
                            alt="HGCI staff and students sorting donated clothing on the grass outside a school."
                            :width="1080"
                            :height="720"
                            ratio="4/3"
                        />
                        <figcaption class="border-t border-line p-5 text-sm leading-relaxed text-muted">
                            Volunteers and HGCI staff sorting donations together.
                            [ADD: photo credit and consent details.]
                        </figcaption>
                    </figure>
                </div>

                <ol class="grid gap-4 sm:grid-cols-3">
                    @foreach ($steps as $step)
                        <li class="rounded-lg border border-line bg-surface p-5 shadow-card">
                            <span class="inline-flex size-9 items-center justify-center rounded-md bg-brand-teal font-display text-base font-semibold text-white">
                                {{ $loop->iteration }}
                            </span>
                            <h3 class="mt-3 font-display text-base font-semibold text-ink">{{ $step['title'] }}</h3>
                            <p class="mt-1.5 text-sm leading-relaxed text-muted">{{ $step['copy'] }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </section>

    {{-- Volunteer application form. --}}
    <section id="volunteer" class="py-16 lg:py-24">
        <div class="container-page grid gap-10 lg:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] lg:items-start">
            <div>
                <x-section-heading
                    eyebrow="Volunteer application"
                    title="Tell us about yourself"
                    description="Complete the form and our team will get in touch to talk about how you can help. There is no commitment at this stage."
                />

                <div class="mt-7 space-y-4 text-sm leading-relaxed text-muted">
                    <p class="flex items-start gap-3">
                        <x-icon name="shield-check" class="mt-0.5 size-5 shrink-0 text-brand-teal" />
                        <span>Your details are used only to respond to your application.</span>
                    </p>
                    <p class="flex items-start gap-3">
                        <x-icon name="phone" class="mt-0.5 size-5 shrink-0 text-brand-teal" />
                        <span>Prefer to talk? Call {{ $phone }}.</span>
                    </p>
                    <p class="flex items-start gap-3">
                        <x-icon name="envelope" class="mt-0.5 size-5 shrink-0 text-brand-teal" />
                        <span>Email {{ $email }}.</span>
                    </p>
                </div>

                <div class="mt-8 rounded-lg border border-line bg-surface-warm p-5">
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand-teal">Other ways to help</p>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li>
                            <a href="{{ url('/sponsor') }}" class="inline-flex min-h-11 items-center gap-1.5 font-semibold text-brand-teal hover:text-brand-teal-dark">
                                Sponsor a child
                                <x-icon name="arrow-right" class="size-4" />
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/donate') }}" class="inline-flex min-h-11 items-center gap-1.5 font-semibold text-brand-teal hover:text-brand-teal-dark">
                                Make a donation
                                <x-icon name="arrow-right" class="size-4" />
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/contact#prayer') }}" class="inline-flex min-h-11 items-center gap-1.5 font-semibold text-brand-teal hover:text-brand-teal-dark">
                                Send a prayer request
                                <x-icon name="arrow-right" class="size-4" />
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="rounded-lg border border-line bg-surface p-6 shadow-card sm:p-8">
                <form method="POST" action="{{ route('get-involved.volunteer') }}" class="space-y-5">
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
                        <x-form.field label="Where are you based?" name="location">
                            <x-form.input name="location" autocomplete="address-level2" />
                        </x-form.field>

                        <x-form.field label="When are you available?" name="availability">
                            <x-form.select
                                name="availability"
                                placeholder="Choose an option"
                                :options="[
                                    'Weekdays' => 'Weekdays',
                                    'Weekends' => 'Weekends',
                                    'Evenings' => 'Evenings',
                                    'Flexible' => 'Flexible',
                                ]"
                            />
                        </x-form.field>
                    </div>

                    <x-form.field label="Skills and experience" name="skills" hint="Optional. Tell us what you could help with.">
                        <x-form.textarea name="skills" rows="3" />
                    </x-form.field>

                    <x-form.field label="Why would you like to volunteer?" name="motivation" required>
                        <x-form.textarea name="motivation" rows="4" required />
                    </x-form.field>

                    <x-form.checkbox name="consent">
                        I agree that HGCI may use my details to respond to this volunteer application.
                    </x-form.checkbox>

                    <x-button type="submit" size="lg" class="w-full">
                        Send my application
                        <x-icon name="arrow-right" class="size-4" />
                    </x-button>
                </form>
            </div>
        </div>
    </section>

    <x-cta-band
        tone="teal"
        eyebrow="Give today"
        title="Your gift gives a child hope"
        description="Every gift helps provide food, quality education, healthcare and basic necessities for a child in Uganda."
        primary-label="Donate today"
        :primary-href="url('/donate')"
        secondary-label="Sponsor a child"
        :secondary-href="url('/sponsor')"
        :image="[
            'src' => 'images/gallery/community-care/community-home-visit.jpeg',
            'alt' => 'HGCI staff and community members sitting together during a home visit.',
            'width' => 1080,
            'height' => 810,
            'ratio' => '3/4',
            'focus' => 'upper',
            'asset' => true,
        ]"
    />
@endsection
