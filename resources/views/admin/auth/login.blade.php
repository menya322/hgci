<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>Admin sign in | {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col bg-surface-warm text-ink">
    <main id="main-content" class="flex flex-1 items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="rounded-lg border border-line bg-surface shadow-card">
                <div class="border-b border-line bg-brand-teal px-6 py-7 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-white/90">Hope In God Child Initiatives</p>
                    <h1 class="mt-1 font-display text-2xl font-semibold">Admin sign in</h1>
                    <p class="mt-2 text-sm leading-relaxed text-white/90">Use your administrator account to manage content.</p>
                </div>

                <div class="p-6 sm:p-7">
                    @if (session('status'))
                        <div role="status" class="mb-5 rounded-lg border border-brand-green bg-surface-warm px-4 py-3 text-sm font-medium text-ink">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div role="alert" class="mb-5 rounded-lg border border-brand-red bg-surface px-4 py-3">
                            <p class="text-sm font-semibold text-brand-red">We could not sign you in.</p>
                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm leading-relaxed text-ink">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
                        @csrf

                        <x-form.field label="Email address" name="email" required>
                            <x-form.input name="email" type="email" autocomplete="email" autofocus required />
                        </x-form.field>

                        <x-form.field label="Password" name="password" required>
                            <x-form.input name="password" type="password" autocomplete="current-password" required />
                        </x-form.field>

                        <x-form.checkbox name="remember">Keep me signed in on this device</x-form.checkbox>

                        <x-button type="submit" class="w-full" size="lg">Sign in</x-button>
                    </form>
                </div>
            </div>

            <p class="mt-6 text-center text-sm text-muted">
                <a href="{{ url('/') }}" class="font-semibold text-brand-teal underline-offset-4 hover:underline">Return to the public site</a>
            </p>
        </div>
    </main>
</body>
</html>
