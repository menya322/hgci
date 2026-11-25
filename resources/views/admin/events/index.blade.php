@extends('admin.layouts.app')

@section('title', 'Events')

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-ink">Events</h1>
            <p class="mt-1 text-sm leading-relaxed text-muted">Upcoming and past events shown on the public events page.</p>
        </div>

        <x-button href="{{ route('admin.events.create') }}" size="sm">New event</x-button>
    </div>

    <div class="mt-8 overflow-hidden rounded-lg border border-line bg-surface shadow-card">
        @if ($events->isEmpty())
            <div class="px-5 py-10 text-center">
                <p class="font-display text-lg font-semibold text-ink">No events yet</p>
                <p class="mt-2 text-sm text-muted">Add an event to show it on the public events page.</p>
                <div class="mt-5">
                    <x-button href="{{ route('admin.events.create') }}">Create the first event</x-button>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[44rem] text-left text-sm">
                    <thead class="bg-surface-warm text-xs uppercase tracking-[0.12em] text-muted">
                        <tr>
                            <th scope="col" class="px-5 py-3 font-semibold">Event</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Starts</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Location</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Status</th>
                            <th scope="col" class="px-5 py-3 font-semibold"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($events as $event)
                            <tr>
                                <td class="px-5 py-3">
                                    <p class="font-semibold text-ink">{{ $event->title }}</p>
                                    <p class="mt-0.5 text-xs text-muted">/{{ $event->slug }}</p>
                                </td>
                                <td class="px-5 py-3 text-muted">{{ $event->starts_at?->format('j M Y, H:i') ?? '—' }}</td>
                                <td class="px-5 py-3 text-muted">{{ $event->location ?: '—' }}</td>
                                <td class="px-5 py-3">
                                    @if ($event->is_published)
                                        <span class="inline-flex rounded-md bg-brand-green/15 px-2 py-1 text-xs font-semibold text-ink">Published</span>
                                    @else
                                        <span class="inline-flex rounded-md bg-line px-2 py-1 text-xs font-semibold text-ink">Hidden</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.events.edit', $event) }}" class="font-semibold text-brand-teal underline-offset-4 hover:underline">Edit</a>

                                        <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Move this event to the trash?');">
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
                {{ $events->links() }}
            </div>
        @endif
    </div>
@endsection
