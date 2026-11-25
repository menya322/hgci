@extends('admin.layouts.app')

@section('title', 'New event')

@section('content')
    <div class="max-w-3xl">
        <a href="{{ route('admin.events.index') }}" class="inline-flex min-h-11 items-center gap-1.5 text-sm font-semibold text-brand-teal underline-offset-4 hover:underline">
            <x-icon name="arrow-right" class="size-4 rotate-180" />
            Back to events
        </a>

        <h1 class="mt-3 font-display text-3xl font-semibold text-ink">New event</h1>
        <p class="mt-1 text-sm leading-relaxed text-muted">Upcoming events appear on the events page and home page.</p>

        <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" class="mt-6 rounded-lg border border-line bg-surface p-5 shadow-card sm:p-7">
            @csrf

            @include('admin.events._form', ['event' => $event])

            <div class="mt-7 flex flex-wrap gap-3 border-t border-line pt-6">
                <x-button type="submit">Save event</x-button>
                <x-button href="{{ route('admin.events.index') }}" variant="outline">Cancel</x-button>
            </div>
        </form>
    </div>
@endsection
