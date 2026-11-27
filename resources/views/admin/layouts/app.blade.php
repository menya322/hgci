<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>@hasSection('title')@yield('title') | @endif Admin | {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col bg-surface-warm text-ink">
    <a
        href="#admin-main"
        class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[100] focus:inline-flex focus:min-h-11 focus:items-center focus:rounded-lg focus:bg-brand-teal focus:px-5 focus:py-3 focus:text-sm focus:font-semibold focus:text-white"
    >Skip to content</a>

    <header class="border-b border-line bg-brand-teal-dark text-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                    <span class="inline-flex size-9 items-center justify-center rounded-md bg-brand-yellow text-sm font-bold text-ink">HG</span>
                    <span class="font-display text-base font-semibold leading-tight">HGCI Admin</span>
                </a>

                <form method="POST" action="{{ route('admin.logout') }}" class="lg:hidden">
                    @csrf
                    <button type="submit" class="inline-flex min-h-11 items-center rounded-lg border border-white/40 px-4 text-sm font-semibold text-white hover:bg-white hover:text-brand-teal-dark focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                        Sign out
                    </button>
                </form>
            </div>

            <nav aria-label="Admin" class="flex flex-wrap items-center gap-1">
                @php
                    $adminLinks = [
                        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => request()->routeIs('admin.dashboard')],
                        ['label' => 'Posts', 'route' => 'admin.posts.index', 'active' => request()->routeIs('admin.posts.*')],
                        ['label' => 'Programs', 'route' => 'admin.programs.index', 'active' => request()->routeIs('admin.programs.*')],
                        ['label' => 'Projects', 'route' => 'admin.projects.index', 'active' => request()->routeIs('admin.projects.*')],
                        ['label' => 'Events', 'route' => 'admin.events.index', 'active' => request()->routeIs('admin.events.*')],
                        ['label' => 'Team', 'route' => 'admin.team.index', 'active' => request()->routeIs('admin.team.*')],
                        ['label' => 'Testimonials', 'route' => 'admin.testimonials.index', 'active' => request()->routeIs('admin.testimonials.*')],
                        ['label' => 'FAQs', 'route' => 'admin.faqs.index', 'active' => request()->routeIs('admin.faqs.*')],
                        ['label' => 'Gallery', 'route' => 'admin.gallery.index', 'active' => request()->routeIs('admin.gallery.*')],
                        ['label' => 'Inbox', 'route' => 'admin.inbox.index', 'active' => request()->routeIs('admin.inbox.*') || request()->routeIs('admin.messages.*') || request()->routeIs('admin.enquiries.*') || request()->routeIs('admin.pledges.*') || request()->routeIs('admin.applications.*')],
                        ['label' => 'Settings', 'route' => 'admin.settings.edit', 'active' => request()->routeIs('admin.settings.*')],
                    ];
                @endphp

                @foreach ($adminLinks as $link)
                    <a
                        href="{{ route($link['route']) }}"
                        @if ($link['active']) aria-current="page" @endif
                        class="inline-flex min-h-11 items-center rounded-lg px-3 text-sm font-semibold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white {{ $link['active'] ? 'bg-white text-brand-teal-dark' : 'text-white hover:bg-brand-teal' }}"
                    >{{ $link['label'] }}</a>
                @endforeach

                <a
                    href="{{ url('/') }}"
                    class="inline-flex min-h-11 items-center rounded-lg px-3 text-sm font-semibold text-white transition-colors hover:bg-brand-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                >View site</a>

                <form method="POST" action="{{ route('admin.logout') }}" class="hidden lg:block">
                    @csrf
                    <button type="submit" class="inline-flex min-h-11 items-center rounded-lg border border-white/40 px-4 text-sm font-semibold text-white transition-colors hover:bg-white hover:text-brand-teal-dark focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                        Sign out
                    </button>
                </form>
            </nav>
        </div>
    </header>

    @if (session('status'))
        <div role="status" class="border-b border-brand-green bg-white">
            <div class="mx-auto flex max-w-7xl items-start gap-3 px-4 py-3 sm:px-6 lg:px-8">
                <span class="inline-flex size-7 shrink-0 items-center justify-center rounded-md bg-brand-green text-ink">
                    <x-icon name="check" class="size-4" />
                </span>
                <p class="text-sm font-medium leading-relaxed text-ink">{{ session('status') }}</p>
            </div>
        </div>
    @endif

    <main id="admin-main" tabindex="-1" class="flex-1">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
            @yield('content')
        </div>
    </main>

    <footer class="border-t border-line bg-surface py-5">
        <div class="mx-auto max-w-7xl px-4 text-sm text-muted sm:px-6 lg:px-8">
            Hope In God Child Initiatives &middot; Admin area
        </div>
    </footer>
</body>
</html>
