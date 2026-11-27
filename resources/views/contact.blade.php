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

    <section id="contact-form" class="py-16 lg:py-24">
        <div class="container-page grid gap-8 lg:grid-cols-[minmax(0,3fr)_minmax(0,2fr)] lg:items-start lg:gap-12">
            <div class="overflow-hidden rounded-lg border border-line bg-surface shadow-card">
                <div class="flex items-center gap-4 border-b border-line bg-surface-warm p-6 sm:p-8">
                    <span class="inline-flex size-12 shrink-0 items-center justify-center rounded-lg bg-brand-teal text-white">
                        <x-icon name="envelope" class="size-6" />
                    </span>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-teal">Send a message</p>
                        <h2 class="mt-1 font-display text-2xl font-semibold leading-tight text-ink">How can we help?</h2>
                    </div>
                </div>

                <p class="px-6 pt-6 text-sm leading-relaxed text-muted sm:px-8 sm:pt-8">
                    Complete the form and our team will get back to you as soon as possible.
                </p>

                <form method="POST" action="{{ route('contact.store') }}" class="space-y-5 px-6 pb-6 pt-5 sm:px-8 sm:pb-8">
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
                <div class="overflow-hidden rounded-lg border border-line bg-surface-warm shadow-card">
                    <div class="border-b border-line px-6 py-5">
                        <h2 class="font-display text-xl font-semibold text-ink">Contact details</h2>
                        <p class="mt-1 text-sm text-muted">Reach our team directly.</p>
                    </div>

                    <dl class="divide-y divide-line text-sm">
                        <div class="px-6 py-4">
                            <dt class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.14em] text-muted">
                                <span class="inline-flex size-8 shrink-0 items-center justify-center rounded-md bg-brand-teal/10 text-brand-teal" aria-hidden="true">
                                    <x-icon name="map-pin" class="size-4" />
                                </span>
                                Address
                            </dt>
                            <dd class="mt-2 pl-10 leading-relaxed text-ink">
                                {{ $addressLine1 }}<br>
                                {{ $addressLine2 }}<br>
                                {{ $country }}
                            </dd>
                        </div>

                        <div class="px-6 py-4">
                            <dt class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.14em] text-muted">
                                <span class="inline-flex size-8 shrink-0 items-center justify-center rounded-md bg-brand-teal/10 text-brand-teal" aria-hidden="true">
                                    <x-icon name="phone" class="size-4" />
                                </span>
                                Phone
                            </dt>
                            <dd class="mt-2 break-words pl-10">
                                @if ($phoneHref)
                                    <a href="{{ $phoneHref }}" class="font-medium text-ink underline decoration-2 underline-offset-4 hover:text-brand-teal">{{ $phone }}</a>
                                @else
                                    <span class="text-muted">{{ $phone }}</span>
                                @endif
                            </dd>
                        </div>

                        <div class="px-6 py-4">
                            <dt class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.14em] text-muted">
                                <span class="inline-flex size-8 shrink-0 items-center justify-center rounded-md bg-brand-teal/10 text-brand-teal" aria-hidden="true">
                                    <x-icon name="envelope" class="size-4" />
                                </span>
                                Email
                            </dt>
                            <dd class="mt-2 break-words pl-10">
                                @if ($emailHref)
                                    <a href="{{ $emailHref }}" class="font-medium text-ink underline decoration-2 underline-offset-4 hover:text-brand-teal">{{ $email }}</a>
                                @else
                                    <span class="text-muted">{{ $email }}</span>
                                @endif
                            </dd>
                        </div>

                        <div class="px-6 py-4">
                            <dt class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.14em] text-muted">
                                <span class="inline-flex size-8 shrink-0 items-center justify-center rounded-md bg-brand-teal/10 text-brand-teal" aria-hidden="true">
                                    <x-icon name="clock" class="size-4" />
                                </span>
                                Office hours
                            </dt>
                            <dd class="mt-2 pl-10 text-muted">{{ $officeHours }}</dd>
                        </div>
                    </dl>

                    <div class="border-t border-line px-6 py-5">
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

                <div id="prayer" class="overflow-hidden rounded-lg border border-brand-yellow-dark/40 bg-brand-yellow p-6 text-ink shadow-card">
                    <div class="flex items-start gap-3">
                        <span class="inline-flex size-11 shrink-0 items-center justify-center rounded-lg bg-surface text-brand-red">
                            <x-icon name="heart" class="size-6" />
                        </span>
                        <div>
                            <h2 class="font-display text-xl font-semibold">Prayer requests</h2>
                            <p class="mt-1.5 text-sm leading-relaxed">
                                We would be honoured to pray with you. Choose <strong>Prayer request</strong> as the
                                subject in the form, and share as much or as little as you feel comfortable.
                            </p>
                        </div>
                    </div>
                    <a
                        href="#contact-form"
                        class="mt-5 inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-lg bg-ink px-4 text-sm font-semibold text-white transition-colors hover:bg-brand-teal-dark focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ink"
                    >
                        Send a prayer request
                        <x-icon name="arrow-right" class="size-4" />
                    </a>
                </div>
            </aside>
        </div>
    </section>

    {{-- Visit us. --}}
    @php
        $visitImage = \App\Support\ImageSource::url('images/gallery/community-care/community-home-visit.jpeg', asset: true);
    @endphp

    <section id="visit" class="relative isolate overflow-hidden bg-ink py-16 text-white lg:py-24">
        @if ($visitImage)
            <img
                src="{{ $visitImage }}"
                alt=""
                loading="lazy"
                decoding="async"
                class="absolute inset-0 h-full w-full object-cover"
            >
            <div aria-hidden="true" class="absolute inset-0 bg-ink/85"></div>
        @endif

        <div class="container-page relative z-10 grid gap-10 lg:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] lg:items-center lg:gap-16">
            <div>
                <x-section-heading
                    eyebrow="Visit us"
                    title="Find HGCI in Uganda"
                    description="Our team works alongside children, families and community members. Get in touch before visiting so we can welcome you well."
                    tone="dark"
                />

                <div class="mt-8 space-y-4 text-sm leading-relaxed text-white/90">
                    <p class="flex items-start gap-3">
                        <x-icon name="map-pin" class="mt-0.5 size-5 shrink-0 text-brand-yellow" />
                        <span>{{ $addressLine1 }}, {{ $addressLine2 }}, {{ $country }}</span>
                    </p>
                    <p class="flex items-start gap-3">
                        <x-icon name="clock" class="mt-0.5 size-5 shrink-0 text-brand-yellow" />
                        <span>{{ $officeHours }}</span>
                    </p>
                </div>

                <x-button href="#contact-form" variant="outline-light" class="mt-8">
                    Send us a message
                    <x-icon name="arrow-right" class="size-4" />
                </x-button>
            </div>

            <div class="overflow-hidden rounded-lg border border-line bg-surface text-ink shadow-card">
                <div class="relative flex aspect-[16/9] items-center justify-center bg-surface-warm p-6">
                    <div class="text-center">
                        <span class="inline-flex size-14 items-center justify-center rounded-lg border border-dashed border-brand-teal/50 bg-surface text-brand-teal">
                            <x-icon name="map-pin" class="size-7" />
                        </span>
                        <p class="mt-4 text-sm font-semibold text-ink"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15958.77742635328!2d32.60169254724417!3d0.4516578427025737!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x177db3ef41731c2d%3A0xf724f1d9aa11575b!2sGayaza!5e0!3m2!1sen!2sug!4v1795805076584!5m2!1sen!2sug" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe></p>
                        <p class="mt-1 text-xs leading-relaxed text-muted">
                            A map will be added once the physical address is confirmed.
                        </p>
                    </div>
                </div>
            </div>
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
