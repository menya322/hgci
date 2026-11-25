@extends('admin.layouts.app')

@section('title', $heading)

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <a href="{{ route('admin.inbox.index') }}" class="inline-flex min-h-11 items-center gap-1.5 text-sm font-semibold text-brand-teal underline-offset-4 hover:underline">
                <x-icon name="arrow-right" class="size-4 rotate-180" />
                Back to inbox
            </a>

            <h1 class="mt-2 font-display text-3xl font-semibold text-ink">{{ $heading }}</h1>
            <p class="mt-1 text-sm leading-relaxed text-muted">{{ $description }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2 text-sm">
            @if ($exportRoute)
                <x-button
                    href="{{ route($exportRoute, array_filter(['q' => $search, 'unread' => $unreadOnly ? 1 : null])) }}"
                    variant="outline"
                    size="sm"
                >
                    <x-icon name="arrow-right" class="size-4 rotate-90" />
                    Export CSV
                </x-button>
            @endif

            <span class="inline-flex min-h-11 items-center rounded-lg border border-line bg-surface px-4 text-ink">
                <span class="font-semibold">{{ $totalCount }}</span>&nbsp;total
            </span>
            <span class="inline-flex min-h-11 items-center rounded-lg bg-brand-yellow px-4 font-semibold text-ink">
                {{ $unreadCount }} unread
            </span>
        </div>
    </div>

    <form method="GET" action="{{ route($indexRoute) }}" class="mt-8 rounded-lg border border-line bg-surface p-4 shadow-card">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end">
            <div class="flex-1">
                <label for="q" class="block text-sm font-semibold text-ink">Search</label>
                <input
                    id="q"
                    name="q"
                    type="search"
                    value="{{ $search }}"
                    placeholder="Search by name, email or message"
                    class="mt-1.5 block min-h-11 w-full rounded-lg border border-line bg-surface px-3.5 py-2.5 text-base text-ink transition-colors placeholder:text-muted/70 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
                >
            </div>

            <div class="sm:pb-2.5">
                <x-form.checkbox name="unread" :checked="$unreadOnly">Only unread</x-form.checkbox>
            </div>

            <div class="flex flex-wrap gap-2">
                <x-button type="submit">Apply</x-button>

                @if ($search !== '' || $unreadOnly)
                    <x-button href="{{ route($indexRoute) }}" variant="outline">Clear</x-button>
                @endif
            </div>
        </div>
    </form>

    <div class="mt-6 overflow-hidden rounded-lg border border-line bg-surface shadow-card">
        @if ($rows->isEmpty())
            <div class="px-5 py-10 text-center">
                @if ($totalCount === 0)
                    <p class="font-display text-lg font-semibold text-ink">{{ $emptyMessage }}</p>
                    <p class="mt-2 text-sm text-muted">New submissions from the public site will appear here.</p>
                @else
                    <p class="font-display text-lg font-semibold text-ink">No records match your filters</p>
                    <p class="mt-2 text-sm text-muted">Try a different search term, or clear the filters to see everything.</p>
                    <div class="mt-5">
                        <x-button href="{{ route($indexRoute) }}" variant="outline">Clear filters</x-button>
                    </div>
                @endif
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[48rem] text-left text-sm">
                    <thead class="bg-surface-warm text-xs uppercase tracking-[0.12em] text-muted">
                        <tr>
                            <th scope="col" class="px-5 py-3 font-semibold">Sender</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Details</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Received</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Status</th>
                            <th scope="col" class="px-5 py-3 font-semibold"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($rows as $row)
                            <tr>
                                <td class="px-5 py-4">
                                    <p class="font-semibold text-ink">{{ $row['name'] }}</p>
                                    <a href="mailto:{{ $row['email'] }}" class="mt-0.5 inline-block text-xs text-brand-teal underline-offset-4 hover:underline">{{ $row['email'] }}</a>
                                </td>
                                <td class="max-w-md px-5 py-4 text-muted">
                                    <p class="line-clamp-2" title="{{ $row['summary'] }}">{{ $row['summary'] }}</p>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-muted">
                                    <p>{{ $row['received_at']->format('j M Y') }}</p>
                                    <p class="mt-0.5 text-xs">{{ $row['received_at']->format('H:i') }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    @if ($row['read_at'] === null)
                                        <span class="inline-flex items-center gap-1.5 rounded-md bg-brand-yellow px-2 py-1 text-xs font-semibold text-ink">
                                            <span class="inline-flex size-1.5 rounded-full bg-brand-red" aria-hidden="true"></span>
                                            Unread
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-md bg-brand-green/15 px-2 py-1 text-xs font-semibold text-ink">Read</span>
                                        <p class="mt-1 text-xs text-muted">{{ $row['read_at']->format('j M Y') }}</p>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ $row['show_url'] }}" class="font-semibold text-brand-teal underline-offset-4 hover:underline">View</a>

                                        <form method="POST" action="{{ $row['delete_url'] }}" onsubmit="return confirm('Delete this record permanently?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-semibold text-brand-red underline-offset-4 hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-line px-5 py-4">
                {{ $records->links() }}
            </div>
        @endif
    </div>
@endsection
