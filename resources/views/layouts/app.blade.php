<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title')@yield('title') | @endif{{ config('app.name') }}</title>

    <meta name="description" content="@yield('meta_description', 'Hope In God Child Initiatives (HGCI) is a child sponsorship and Christian humanitarian aid organization transforming the lives of orphans and vulnerable children in Uganda.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="flex min-h-full flex-col bg-surface text-ink">
    <a
        href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[100] focus:inline-flex focus:min-h-11 focus:items-center focus:rounded-lg focus:bg-brand-teal focus:px-5 focus:py-3 focus:text-sm focus:font-semibold focus:text-white focus:shadow-card"
    >Skip to content</a>

    @include('partials.header')

    <main id="main-content" tabindex="-1" class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
