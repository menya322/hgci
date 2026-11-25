@extends('admin.layouts.app')

@section('title', 'Edit album')

@section('content')
    <div class="max-w-3xl">
        <a href="{{ route('admin.gallery.index') }}" class="inline-flex min-h-11 items-center gap-1.5 text-sm font-semibold text-brand-teal underline-offset-4 hover:underline">
            <x-icon name="arrow-right" class="size-4 rotate-180" />
            Back to gallery
        </a>

        <div class="mt-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-3xl font-semibold text-ink">Edit album</h1>
                <p class="mt-1 text-sm leading-relaxed text-muted">{{ $album->title }} &middot; {{ $album->images_count }} {{ \Illuminate\Support\Str::plural('photo', $album->images_count) }}</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <x-button href="{{ route('admin.gallery.images.index', $album) }}" size="sm">Manage photos</x-button>

                @if ($album->is_published)
                    <x-button href="{{ route('gallery.show', $album) }}" variant="outline" size="sm">View on site</x-button>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('admin.gallery.update', $album) }}" class="mt-6 rounded-lg border border-line bg-surface p-5 shadow-card sm:p-7">
            @csrf
            @method('PUT')

            @include('admin.gallery._form', ['album' => $album])

            <div class="mt-7 flex flex-wrap gap-3 border-t border-line pt-6">
                <x-button type="submit">Save changes</x-button>
                <x-button href="{{ route('admin.gallery.index') }}" variant="outline">Cancel</x-button>
            </div>
        </form>
    </div>
@endsection
