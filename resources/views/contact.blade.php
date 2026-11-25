@extends('layouts.app')

@php
    $phone = $settings['contact.phone'] ?? '[ADD: phone number]';
    $email = $settings['contact.email'] ?? '[ADD: email address]';
    $addressLine1 = $settings['contact.address_line1'] ?? '[ADD: physical address]';
    $addressLine2 = $settings['contact.address_line2'] ?? '[ADD: city and district]';
    $country = $settings['contact.country'] ?? 'Uganda';
    $officeHours = $settings['contact.office_hours'] ?? '[ADD: office hours]';

    $isPlaceholder = fn ($value) => ! $value || str_starts_with((string) $value, '[ADD');

    $phoneHref = $isPlaceholder($phone) ? null : 'tel:'.preg_replace('/[^0-9+]/', '', $phone);
    $emailHref = $isPlaceholder($email) ? null : 'mailto:'.$email;

    $socialLinks = [
        ['label' => 'Facebook', 'icon' => 'facebook', 'key' => 'social.facebook'],
        ['label' => 'Instagram', 'icon' => 'instagram', 'key' => 'social.instagram'],
        ['label' => 'X', 'icon' => 'x-twitter', 'key' => 'social.x'],
        ['label' => 'YouTube', 'icon' => 'youtube', 'key' => 'social.youtube'],
    ];
@endphp

@section('title', 'Contact Us')
@section('meta_description', 'Contact Hope In God Child Initiatives (HGCI) in Uganda about child sponsorship, donations, volunteering, partnerships or prayer requests.')

@section('content')
    <x-page-hero
        eyebrow="Contact us"
        title="We would love to hear from you"
        description="Whether you have a question, would like to sponsor a child or want to partner with HGCI, our team is ready to listen."
        image="images/gallery/community-care/sitting-with-family.jpeg"
        image-alt="HGCI staff sitting on a mat with a mother and her child during a home visit"
        :breadcrumbs="[['label' => 'Contact']]"
    >
        <div class="flex flex-col gap-3 sm:flex-row">
            <x-button href="#contact-form" size="lg">
                <x-icon name="envelope" class="size-5" />
                Send a message
            </x-button>
            <x-button href="#prayer" variant="outline-light" size="lg">
                <x-icon name="heart" class="size-5" />
                Prayer request
            </x-button>
        </div>
    </x-page-hero>

    <section id="contact-form" class="scroll-mt-28 py-16 lg:py-24">
        <div class="container-page grid gap-10 lg:grid-cols-[minmax(0,3fr)_minmax(0,2fr)] lg:items-start">
            <div class="rounded-lg border border-line bg-surface p-6 shadow-card sm:p-8">
                <x-section-heading
                    eyebrow="Send a message"
                    title="How can we help?"
                    description="Complete the form and our team will get back to you as soon as possible."
                />

                <form method="POST" action="{{ route('contact.store') }}" class="mt-8 space-y-5">
                    @csrf
                    <x-form.honeypot />
                    <x-form.errors />

                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-form.field label="Full name" name="name" required>
                            <x-form.input name="name" autocomplete="name" required />
                        </x-form.field>

                        <x-form.field label="Email address" name="email" required>
                            <x-form.input name="email" type="email" autocomplete="email" required />
                        </x-form.field>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-form.field label="Phone number" name="phone">
                            <x-form.input name="phone" type="tel" autocomplete="tel" />
                        </x-form.field>

                        <x-form.field label="What is your message about?" name="subject" required>
                            <x-form.select
                                name="subject"
                                placeholder="Choose a subject"
                                :options="[
                                    'general' => 'General enquiry',
                                    'sponsorship' => 'Child sponsorship',
                                    'donation' => 'Donations and giving',
                                    'volunteering' => 'Volunteering or partnership',
                                    'prayer' => 'Prayer request',
                                    'media' => 'Media or speaking request',
                                ]"
                            />
                        </x-form.field>
                    </div>

                    <x-form.field
                        label="Your message"
                        name="message"
                        hint="Please do not include sensitive personal or financial information."
                        required
                    >
                        <x-form.textarea name="message" rows="6" required />
                    </x-form.field>

                    <x-form.checkbox name="consent">
                        I agree that HGCI may use my details to respond to this message.
                    </x-form.checkbox>

                    <x-button type="submit" size="lg" class="w-full">
                        Send message
                        <x-icon name="arrow-right" class="size-4" />
                    </x-button>
                </form>
            </div>

            <aside class="space-y-6" aria-label="Contact details">
                <div class="rounded-lg border border-line bg-surface-warm p-6">
                    <h2 class="font-display text-xl font-semibold text-ink">Contact details</h2>

                    <dl class="mt-5 space-y-5 text-sm">
                        <div class="flex gap-3">
                            <dt class="shrink-0 text-brand-teal">
                                <span class="sr-only">Address</span>
                                <x-icon name="map-pin" class="size-5" />
                            </dt>
                            <dd class="leading-relaxed text-ink">
                                {{ $addressLine1 }}<br>
                                {{ $addressLine2 }}<br>
                                {{ $country }}
                            </dd>
                        </div>

                        <div class="flex gap-3">
                            <dt class="shrink-0 text-brand-teal">
                                <span class="sr-only">Phone</span>
                                <x-icon name="phone" class="size-5" />
                            </dt>
                            <dd>
                                @if ($phoneHref)
                                    <a href="{{ $phoneHref }}" class="font-medium text-ink underline decoration-2 underline-offset-4 hover:text-brand-teal">{{ $phone }}</a>
                                @else
                                    <span class="text-muted">{{ $phone }}</span>
                                @endif
                            </dd>
                        </div>

                        <div class="flex gap-3">
                            <dt class="shrink-0 text-brand-teal">
                                <span class="sr-only">Email</span>
                                <x-icon name="envelope" class="size-5" />
                            </dt>
                            <dd class="min-w-0 break-words">
                                @if ($emailHref)
                                    <a href="{{ $emailHref }}" class="font-medium text-ink underline decoration-2 underline-offset-4 hover:text-brand-teal">{{ $email }}</a>
                                @else
                                    <span class="text-muted">{{ $email }}</span>
                                @endif
                            </dd>
                        </div>

                        <div class="flex gap-3">
                            <dt class="shrink-0 text-brand-teal">
                                <span class="sr-only">Office hours</span>
                                <x-icon name="clock" class="size-5" />
                            </dt>
                            <dd class="text-muted">{{ $officeHours }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 border-t border-line pt-5">
                        <h3 class="text-sm font-semibold text-ink">Follow HGCI</h3>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($socialLinks as $social)
                                @php
                                    $url = $settings[$social['key']] ?? null;
                                    $hasUrl = ! $isPlaceholder($url);
                                @endphp

                                @if ($hasUrl)
                                    <a
                                        href="{{ $url }}"
                                        class="inline-flex size-11 items-center justify-center rounded-lg border border-line bg-surface text-ink transition-colors hover:border-brand-teal hover:text-brand-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
                                        aria-label="HGCI on {{ $social['label'] }}"
                                    >
                                        <x-icon :name="$social['icon']" class="size-5" />
                                    </a>
                                @else
                                    <span
                                        class="inline-flex size-11 items-center justify-center rounded-lg border border-dashed border-line bg-surface text-muted"
                                        title="[ADD: {{ $social['label'] }} link]"
                                    >
                                        <x-icon :name="$social['icon']" class="size-5" />
                                        <span class="sr-only">HGCI on {{ $social['label'] }} (link to be added)</span>
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div id="prayer" class="scroll-mt-28 rounded-lg border border-brand-yellow-dark/30 bg-brand-yellow p-6 text-ink">
                    <span class="inline-flex size-11 items-center justify-center rounded-lg bg-white text-brand-red">
                        <x-icon name="heart" class="size-6" />
                    </span>
                    <h2 class="mt-4 font-display text-xl font-semibold">Prayer requests</h2>
                    <p class="mt-2 text-sm leading-relaxed">
                        We would be honoured to pray with you. Choose <strong>Prayer request</strong> as the subject in
                        the form, and share as much or as little as you feel comfortable.
                    </p>
                    <a
                        href="#contact-form"
                        class="mt-4 inline-flex min-h-11 items-center gap-1.5 rounded-sm text-sm font-semibold underline decoration-2 underline-offset-4 hover:text-brand-red focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ink"
                    >
                        Send a prayer request
                        <x-icon name="arrow-right" class="size-4" />
                    </a>
                </div>
            </aside>
        </div>
    </section>

    <section id="visit" class="scroll-mt-28 border-y border-line bg-surface-warm py-16 lg:py-24">
        <div class="container-page grid gap-10 lg:grid-cols-2 lg:items-center">
            <div>
                <x-section-heading
                    eyebrow="Visit us"
                    title="Find HGCI in Uganda"
                    description="Our team works alongside children, families and community members. Get in touch before visiting so we can welcome you well."
                />

                <div class="mt-8 overflow-hidden rounded-lg border border-line bg-surface">
                    <div class="relative flex aspect-[16/9] items-center justify-center bg-surface-warm p-6">
                        <div class="text-center">
                            <span class="inline-flex size-14 items-center justify-center rounded-lg border border-dashed border-brand-teal/50 bg-surface text-brand-teal">
                                <x-icon name="map-pin" class="size-7" />
                            </span>
                            <p class="mt-4 text-sm font-semibold text-ink">[ADD: map and exact location]</p>
                            <p class="mt-1 text-xs leading-relaxed text-muted">
                                A map will be added once the physical address is confirmed.
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-line p-6">
                        <p class="text-sm leading-relaxed text-ink">
                            {{ $addressLine1 }}<br>
                            {{ $addressLine2 }}<br>
                            {{ $country }}
                        </p>
                        <p class="mt-3 text-sm text-muted">{{ $officeHours }}</p>
                    </div>
                </div>
            </div>

            <figure class="overflow-hidden rounded-lg border border-line bg-surface shadow-card">
                <x-responsive-image
                    src="images/gallery/community-care/community-home-visit.jpeg"
                    asset
                    alt="HGCI staff and community members sitting together during a home visit."
                    :width="1080"
                    :height="810"
                    ratio="4/3"
                />
                <figcaption class="border-t border-line p-5 text-sm leading-relaxed text-muted">
                    HGCI staff and community members during a home visit. [ADD: photo credit and consent details.]
                </figcaption>
            </figure>
        </div>
    </section>

    <x-cta-band
        tone="teal"
        eyebrow="Take the next step"
        title="Sponsor a child or give today"
        description="Every gift helps provide food, quality education, healthcare and basic necessities for a child in Uganda."
        primary-label="Sponsor a child"
        :primary-href="url('/sponsor')"
        secondary-label="Donate"
        :secondary-href="url('/donate')"
    />
@endsection
