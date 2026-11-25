@extends('admin.layouts.app')

@section('title', 'Edit event')

@section('content')
    <div class="max-w-3xl">
        <a href="{{ route('admin.events.index') }}" class="inline-flex min-h-11 items-center gap-1.5 text-sm font-semibold text-brand-teal underline-offset-4 hover:underline">
            <x-icon name="arrow-right" class="size-4 rotate-180" />
            Back to events
        </a>

        <div class="mt-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-3xl font-semibold text-ink">Edit event</h1>
                <p class="mt-1 text-sm leading-relaxed text-muted">{{ $event->title }}</p>
            </div>

            @if ($event->is_published)
                <x-button href="{{ url('/events/'.$event->slug) }}" variant="outline" size="sm">View on site</x-button>
            @endif
        </div>

        <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data" class="mt-6 rounded-lg border border-line bg-surface p-5 shadow-card sm:p-7">
            @csrf
            @method('PUT')

            @include('admin.events._form', ['event' => $event])

            <div class="mt-7 flex flex-wrap gap-3 border-t border-line pt-6">
                <x-button type="submit">Save changes</x-button>
                <x-button href="{{ route('admin.events.index') }}" variant="outline">Cancel</x-button>
            </div>
        </form>
    </div>
@endsection
