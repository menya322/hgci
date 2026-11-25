@extends('admin.layouts.app')

@section('title', 'Inbox')

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-ink">Inbox</h1>
            <p class="mt-1 text-sm leading-relaxed text-muted">
                Messages and requests sent through the public forms.
            </p>
        </div>

        @if ($unreadTotal > 0)
            <span class="inline-flex min-h-11 items-center gap-2 self-start rounded-lg bg-brand-yellow px-4 text-sm font-semibold text-ink sm:self-auto">
                <span class="inline-flex size-2.5 rounded-full bg-brand-red" aria-hidden="true"></span>
                {{ $unreadTotal }} unread
            </span>
        @else
            <span class="inline-flex min-h-11 items-center gap-2 self-start rounded-lg bg-brand-green/15 px-4 text-sm font-semibold text-ink sm:self-auto">
                <x-icon name="check" class="size-4" />
                All caught up
            </span>
        @endif
    </div>

    <div class="mt-8 grid gap-5 sm:grid-cols-2">
        @foreach ($items as $item)
            <article class="flex flex-col rounded-lg border border-line bg-surface p-5 shadow-card">
                <div class="flex items-start justify-between gap-4">
                    <span class="inline-flex size-11 items-center justify-center rounded-lg bg-brand-teal text-white">
                        <x-icon name="{{ $item['icon'] }}" class="size-5" />
                    </span>

                    @if ($item['unread'] > 0)
                        <span class="inline-flex items-center gap-1.5 rounded-md bg-brand-yellow px-2 py-1 text-xs font-semibold text-ink">
                            {{ $item['unread'] }} unread
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-md bg-line px-2 py-1 text-xs font-semibold text-ink">
                            Read
                        </span>
                    @endif
                </div>

                <h2 class="mt-4 font-display text-xl font-semibold text-ink">{{ $item['label'] }}</h2>
                <p class="mt-1 flex-1 text-sm leading-relaxed text-muted">{{ $item['description'] }}</p>

                <div class="mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-line pt-4">
                    <p class="text-sm text-muted">
                        <span class="font-display text-2xl font-semibold text-ink">{{ $item['total'] }}</span>
                        {{ \Illuminate\Support\Str::plural('record', $item['total']) }}
                    </p>

                    <a
                        href="{{ route($item['route']) }}"
                        class="inline-flex min-h-11 items-center gap-1.5 rounded-lg px-3 text-sm font-semibold text-brand-teal underline-offset-4 hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
                    >
                        Open inbox
                        <x-icon name="arrow-right" class="size-4" />
                    </a>
                </div>
            </article>
        @endforeach
    </div>
@endsection
