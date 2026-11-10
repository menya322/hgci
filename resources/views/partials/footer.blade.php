@php
    $quickLinks = [
        ['label' => 'About HGCI', 'url' => url('/about')],
        ['label' => 'Our Programs', 'url' => url('/programs')],
        ['label' => 'Impact & Achievements', 'url' => url('/impact')],
        ['label' => 'News & Stories', 'url' => url('/news')],
        ['label' => 'Events', 'url' => url('/events')],
    ];

    $involvedLinks = [
        ['label' => 'Sponsor a child', 'url' => url('/sponsor')],
        ['label' => 'Donate', 'url' => url('/donate')],
        ['label' => 'Volunteer', 'url' => url('/get-involved#volunteer')],
        ['label' => 'Partner with us', 'url' => url('/get-involved#partner')],
        ['label' => 'Contact us', 'url' => url('/contact')],
    ];

    $socialLinks = [
        ['label' => 'Facebook', 'icon' => 'facebook'],
        ['label' => 'Instagram', 'icon' => 'instagram'],
        ['label' => 'X', 'icon' => 'x-twitter'],
        ['label' => 'YouTube', 'icon' => 'youtube'],
    ];
@endphp

<footer class="bg-brand-teal-dark text-white">
    <div class="container-page py-14 lg:py-16">
        <div class="grid gap-10 lg:grid-cols-12 lg:gap-8">
            <div class="lg:col-span-4">
                <x-logo variant="dark" />

                <p class="mt-5 max-w-sm text-sm leading-relaxed text-white/85">
                    Hope In God Child Initiatives (HGCI) is a child sponsorship and Christian humanitarian aid
                    organization transforming the lives of orphans and vulnerable children in Uganda.
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    @foreach ($socialLinks as $social)
                        <a
                            href="#"
                            title="[ADD: {{ $social['label'] }} link]"
                            aria-label="HGCI on {{ $social['label'] }} (link to be added)"
                            class="inline-flex size-11 items-center justify-center rounded-lg border border-white/30 text-white transition-colors hover:border-white hover:bg-white hover:text-brand-teal-dark focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                        >
                            <x-icon :name="$social['icon']" class="size-5" />
                        </a>
                    @endforeach
                </div>
            </div>

            <nav class="lg:col-span-2" aria-label="Footer quick links">
                <h2 class="flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.16em] text-white">
                    <span class="h-1.5 w-5 rounded-full bg-brand-yellow" aria-hidden="true"></span>
                    Quick links
                </h2>
                <ul class="mt-4 space-y-1">
                    @foreach ($quickLinks as $link)
                        <li>
                            <a
                                href="{{ $link['url'] }}"
                                class="inline-flex min-h-9 items-center rounded-sm text-sm text-white/85 transition-colors hover:text-white hover:underline hover:decoration-brand-yellow hover:decoration-2 hover:underline-offset-4 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                            >{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <nav class="lg:col-span-2" aria-label="Footer get involved links">
                <h2 class="flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.16em] text-white">
                    <span class="h-1.5 w-5 rounded-full bg-brand-yellow" aria-hidden="true"></span>
                    Get involved
                </h2>
                <ul class="mt-4 space-y-1">
                    @foreach ($involvedLinks as $link)
                        <li>
                            <a
                                href="{{ $link['url'] }}"
                                class="inline-flex min-h-9 items-center rounded-sm text-sm text-white/85 transition-colors hover:text-white hover:underline hover:decoration-brand-yellow hover:decoration-2 hover:underline-offset-4 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                            >{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="lg:col-span-4">
                <h2 class="flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.16em] text-white">
                    <span class="h-1.5 w-5 rounded-full bg-brand-yellow" aria-hidden="true"></span>
                    Head office
                </h2>

                <ul class="mt-4 space-y-3 text-sm text-white/85">
                    <li class="flex gap-3">
                        <x-icon name="map-pin" class="mt-0.5 size-5 shrink-0 text-brand-yellow" />
                        <span>[ADD: physical address]<br>[ADD: city and district], Uganda</span>
                    </li>
                    <li class="flex gap-3">
                        <x-icon name="phone" class="mt-0.5 size-5 shrink-0 text-brand-yellow" />
                        <span>[ADD: phone number]</span>
                    </li>
                    <li class="flex gap-3">
                        <x-icon name="envelope" class="mt-0.5 size-5 shrink-0 text-brand-yellow" />
                        <span>[ADD: email address]</span>
                    </li>
                    <li class="flex gap-3">
                        <x-icon name="clock" class="mt-0.5 size-5 shrink-0 text-brand-yellow" />
                        <span>[ADD: office hours]</span>
                    </li>
                </ul>

                <x-button href="{{ url('/contact') }}" variant="outline-light" size="sm" class="mt-6">
                    Contact HGCI
                    <x-icon name="arrow-right" class="size-4" />
                </x-button>
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-4 border-t border-white/20 pt-6 text-sm text-white/80 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ date('Y') }} Hope In God Child Initiatives. All rights reserved.</p>

            <div class="flex flex-wrap gap-x-6 gap-y-2">
                <a href="{{ url('/privacy') }}" class="rounded-sm transition-colors hover:text-white hover:underline hover:decoration-brand-yellow hover:decoration-2 hover:underline-offset-4 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Privacy Policy</a>
                <a href="{{ url('/terms') }}" class="rounded-sm transition-colors hover:text-white hover:underline hover:decoration-brand-yellow hover:decoration-2 hover:underline-offset-4 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Terms of Use</a>
            </div>
        </div>
    </div>
</footer>

