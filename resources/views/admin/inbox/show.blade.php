@extends('admin.layouts.app')

@section('title', $name)

@section('content')
    <div class="max-w-4xl">
        <a href="{{ route($indexRoute) }}" class="inline-flex min-h-11 items-center gap-1.5 text-sm font-semibold text-brand-teal underline-offset-4 hover:underline">
            <x-icon name="arrow-right" class="size-4 rotate-180" />
            Back to {{ \Illuminate\Support\Str::lower($heading) }}
        </a>

        <div class="mt-3 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="font-display text-3xl font-semibold text-ink">{{ $name }}</h1>

                    @if ($record->read_at === null)
                        <span class="inline-flex items-center gap-1.5 rounded-md bg-brand-yellow px-2 py-1 text-xs font-semibold text-ink">
                            <span class="inline-flex size-1.5 rounded-full bg-brand-red" aria-hidden="true"></span>
                            Unread
                        </span>
                    @else
                        <span class="inline-flex rounded-md bg-brand-green/15 px-2 py-1 text-xs font-semibold text-ink">Read</span>
                    @endif
                </div>

                <p class="mt-1 text-sm leading-relaxed text-muted">
                    Received {{ $record->created_at?->format('j M Y, H:i') }}
                    @if ($record->read_at)
                        &middot; marked read {{ $record->read_at->format('j M Y, H:i') }}
                    @endif
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                @if ($record->read_at === null)
                    <form method="POST" action="{{ route($readRoute, $record) }}">
                        @csrf
                        <x-button type="submit" size="sm">Mark as read</x-button>
                    </form>
                @endif

                <form method="POST" action="{{ route($destroyRoute, $record) }}" onsubmit="return confirm('Delete this record permanently?');">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="inline-flex min-h-11 items-center justify-center rounded-lg border border-brand-red px-4 text-sm font-semibold text-brand-red transition-colors hover:bg-brand-red hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-red"
                    >
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-lg border border-line bg-surface shadow-card">
            <dl class="divide-y divide-line">
                @foreach ($fields as $field)
                    @if ($field['block'] ?? false)
                        <div class="px-5 py-4 sm:px-6">
                            <dt class="text-xs font-semibold uppercase tracking-[0.12em] text-muted">{{ $field['label'] }}</dt>
                            <dd class="mt-1.5 whitespace-pre-line text-base leading-relaxed text-ink">
                                @if (filled($field['value']))
                                    {{ $field['value'] }}
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </dd>
                        </div>
                    @else
                        <div class="grid gap-1 px-5 py-4 sm:grid-cols-[12rem_1fr] sm:items-baseline sm:gap-4 sm:px-6">
                            <dt class="text-xs font-semibold uppercase tracking-[0.12em] text-muted">{{ $field['label'] }}</dt>
                            <dd class="text-base leading-relaxed text-ink">
                                @if (filled($field['value']))
                                    @if (! empty($field['href']))
                                        <a href="{{ $field['href'] }}" class="font-medium text-brand-teal underline-offset-4 hover:underline">{{ $field['value'] }}</a>
                                    @else
                                        {{ $field['value'] }}
                                    @endif
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </dd>
                        </div>
                    @endif
                @endforeach
            </dl>
        </div>
    </div>
@endsection
