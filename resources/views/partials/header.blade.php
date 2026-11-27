@php
    $navigation = [
        [
            'label' => 'About',
            'active' => request()->is('about*'),
            'items' => [
                ['label' => 'Who We Are', 'url' => url('/about'), 'description' => 'Our story, vision and values'],
                ['label' => 'Vision & Values', 'url' => url('/about#vision'), 'description' => 'What guides our work'],
                ['label' => 'Our Approach', 'url' => url('/about#approach'), 'description' => 'Community-based change'],
                ['label' => 'Team', 'url' => url('/about#team'), 'description' => 'The people behind HGCI'],
            ],
        ],
        [
            'label' => 'What We Do',
            'active' => request()->is('programs*') || request()->is('impact*'),
            'items' => [
                ['label' => 'Our Programs', 'url' => url('/programs'), 'description' => 'Education, health and livelihood'],
                ['label' => 'Education', 'url' => url('/programs/education'), 'description' => 'Learning for a brighter future'],
                ['label' => 'Health & Nutrition', 'url' => url('/programs/health-nutrition'), 'description' => 'Healthier homes and communities'],
                ['label' => 'Livelihood', 'url' => url('/programs/livelihood'), 'description' => 'Piggery, cow and goat rearing'],
                ['label' => 'Food Relief', 'url' => url('/programs/food-relief'), 'description' => 'Food and basic necessities'],
            ],
        ],
        [
            'label' => 'Get Involved',
            'active' => request()->is('sponsor*') || request()->is('get-involved*'),
            'items' => [
                ['label' => 'Sponsor a Child', 'url' => url('/sponsor'), 'description' => 'Walk with a child through school'],
                ['label' => 'Volunteer', 'url' => url('/get-involved#volunteer'), 'description' => 'Give your time and skills'],
                ['label' => 'Partner With Us', 'url' => url('/get-involved#partner'), 'description' => 'Work with HGCI in the community'],
                ['label' => 'Prayer Request', 'url' => url('/contact#prayer'), 'description' => 'Let us pray with you'],
            ],
        ],
        [
            'label' => 'News & Events',
            'active' => request()->is('news*') || request()->is('events*'),
            'items' => [
                ['label' => 'News & Stories', 'url' => url('/news'), 'description' => 'Updates from the field'],
                ['label' => 'Events', 'url' => url('/events'), 'description' => 'Coming up in our community'],
            ],
        ],
    ];
@endphp

<div class="bg-brand-teal-dark pt-[env(safe-area-inset-top)] text-white">
    <div class="container-page flex min-h-10 flex-wrap items-center justify-between gap-x-6 gap-y-1 py-2 text-xs sm:text-sm">
        <div class="flex flex-wrap items-center gap-x-5 gap-y-1">
            <a href="{{ url('/contact') }}" class="inline-flex items-center gap-1.5 rounded-sm transition-colors hover:text-white hover:underline hover:decoration-brand-yellow hover:decoration-2 hover:underline-offset-4 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                <x-icon name="phone" class="size-4 shrink-0 text-brand-yellow" />
                <span>+256702556778   +256777782661</span>
            </a>
            <a href="{{ url('/contact') }}" class="inline-flex items-center gap-1.5 rounded-sm transition-colors hover:text-white hover:underline hover:decoration-brand-yellow hover:decoration-2 hover:underline-offset-4 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                <x-icon name="envelope" class="size-4 shrink-0 text-brand-yellow" />
                <span> info@hopeingodci.org</span>
            </a>
        </div>

        <p class="hidden text-white/90 md:block">Child sponsorship &amp; Christian humanitarian aid in Uganda</p>
    </div>
</div>

<header
    x-data="{ mobileOpen: false }"
    x-effect="document.body.classList.toggle('overflow-hidden', mobileOpen)"
    @resize.window="if (window.innerWidth >= 1280) mobileOpen = false"
    @keydown.escape.window="mobileOpen = false"
    class="sticky top-0 z-50 border-b border-line bg-surface shadow-card"
>
    <div class="container-page flex h-20 items-center justify-between gap-4">
        <x-logo />

        <nav class="hidden items-center gap-0.5 xl:flex" aria-label="Main navigation">
            <x-nav-link :href="url('/')" :active="request()->is('/')">Home</x-nav-link>

            @foreach ($navigation as $group)
                <div
                    class="relative"
                    x-data="{ open: false }"
                    @mouseenter="open = true"
                    @mouseleave="open = false"
                    @focusin="open = true"
                    @focusout="if (! $el.contains($event.relatedTarget)) open = false"
                    @keydown.escape.window="open = false"
                >
                    <button
                        type="button"
                        @click="open = !open"
                        :aria-expanded="open.toString()"
                        aria-haspopup="true"
                        class="inline-flex min-h-11 items-center gap-1 whitespace-nowrap rounded-md px-3 text-sm font-semibold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal {{ $group['active'] ? 'bg-surface-warm text-brand-teal' : 'text-ink hover:bg-surface-warm hover:text-brand-teal' }}"
                    >
                        {{ $group['label'] }}
                        <span class="transition-transform" :class="open ? 'rotate-180' : ''">
                            <x-icon name="chevron-down" class="size-4" />
                        </span>
                    </button>

                    <div x-show="open" x-cloak class="absolute left-0 top-full z-50 pt-3">
                        <div class="w-72 rounded-lg border border-line bg-surface p-2 shadow-card">
                            @foreach ($group['items'] as $item)
                                <a
                                    href="{{ $item['url'] }}"
                                    class="block rounded-md px-3 py-2.5 transition-colors hover:bg-surface-warm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
                                >
                                    <span class="block text-sm font-semibold text-ink">{{ $item['label'] }}</span>
                                    <span class="mt-0.5 block text-xs leading-relaxed text-muted">{{ $item['description'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

            <x-nav-link :href="url('/gallery')" :active="request()->is('gallery*')">Gallery</x-nav-link>
            <x-nav-link :href="url('/contact')" :active="request()->is('contact*')">Contact</x-nav-link>
        </nav>

        <div class="flex shrink-0 items-center gap-2">
            {{-- Wrapper (not a class on the button) so the button's own
                 inline-flex cannot override `hidden` on small screens. --}}
            <div class="hidden sm:block">
                <x-button href="{{ url('/donate') }}" variant="donate" size="sm">
                    <x-icon name="heart" class="size-4" />
                    Donate
                </x-button>
            </div>

            <button
                type="button"
                @click="mobileOpen = !mobileOpen"
                :aria-expanded="mobileOpen.toString()"
                aria-controls="mobile-menu"
                aria-label="Toggle navigation menu"
                class="inline-flex size-11 items-center justify-center rounded-lg border border-line text-ink transition-colors hover:bg-surface-warm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal xl:hidden"
            >
                <span x-show="!mobileOpen"><x-icon name="menu" class="size-6" /></span>
                <span x-show="mobileOpen" x-cloak><x-icon name="close" class="size-6" /></span>
            </button>
        </div>
    </div>

    {{-- Mobile menu: overlays the page (does not push content) and keeps the
         Sponsor / Donate buttons pinned to the bottom of the panel so they are
         always reachable on small and short screens. --}}
    <div
        x-show="mobileOpen"
        x-cloak
        x-effect="if (mobileOpen) { $nextTick(() => { const top = $el.getBoundingClientRect().top; $el.style.maxHeight = Math.max(160, window.innerHeight - top) + 'px'; }); }"
        @resize.window="if (mobileOpen) { $nextTick(() => { const top = $el.getBoundingClientRect().top; $el.style.maxHeight = Math.max(160, window.innerHeight - top) + 'px'; }); }"
        id="mobile-menu"
        class="absolute inset-x-0 top-full flex max-h-[calc(100dvh-5rem)] flex-col overflow-hidden border-t border-line bg-surface shadow-card xl:hidden"
    >
        <nav class="container-page min-h-0 flex-1 overflow-y-auto overscroll-contain py-4" aria-label="Mobile navigation">
            <a
                href="{{ url('/') }}"
                @click="mobileOpen = false"
                class="flex min-h-11 items-center rounded-md px-3 text-sm font-semibold transition-colors {{ request()->is('/') ? 'bg-surface-warm text-brand-teal' : 'text-ink hover:bg-surface-warm hover:text-brand-teal' }}"
            >Home</a>

            @foreach ($navigation as $group)
                <p class="px-3 pb-1 pt-4 text-xs font-bold uppercase tracking-[0.18em] text-muted">{{ $group['label'] }}</p>

                @foreach ($group['items'] as $item)
                    <a
                        href="{{ $item['url'] }}"
                        @click="mobileOpen = false"
                        class="flex min-h-11 items-center rounded-md px-3 text-sm font-semibold text-ink transition-colors hover:bg-surface-warm hover:text-brand-teal"
                    >{{ $item['label'] }}</a>
                @endforeach
            @endforeach

            <p class="px-3 pb-1 pt-4 text-xs font-bold uppercase tracking-[0.18em] text-muted">Explore</p>
            <a href="{{ url('/gallery') }}" @click="mobileOpen = false" class="flex min-h-11 items-center rounded-md px-3 text-sm font-semibold text-ink transition-colors hover:bg-surface-warm hover:text-brand-teal">Gallery</a>
            <a href="{{ url('/contact') }}" @click="mobileOpen = false" class="flex min-h-11 items-center rounded-md px-3 text-sm font-semibold text-ink transition-colors hover:bg-surface-warm hover:text-brand-teal">Contact</a>
        </nav>

        <div class="shrink-0 border-t border-line bg-surface pb-[env(safe-area-inset-bottom)]">
            <div class="container-page grid gap-2 py-4 sm:grid-cols-2">
                <x-button href="{{ url('/sponsor') }}" variant="outline" class="w-full">Sponsor a child</x-button>
                <x-button href="{{ url('/donate') }}" variant="donate" class="w-full">
                    <x-icon name="heart" class="size-4" />
                    Donate
                </x-button>
            </div>
        </div>
    </div>
</header>

