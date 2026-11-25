@extends('admin.layouts.app')

@section('title', 'Edit post')

@section('content')
    <div class="max-w-3xl">
        <a href="{{ route('admin.posts.index') }}" class="inline-flex min-h-11 items-center gap-1.5 text-sm font-semibold text-brand-teal underline-offset-4 hover:underline">
            <x-icon name="arrow-right" class="size-4 rotate-180" />
            Back to posts
        </a>

        <div class="mt-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-3xl font-semibold text-ink">Edit post</h1>
                <p class="mt-1 text-sm leading-relaxed text-muted">{{ $post->title }}</p>
            </div>

            @if ($post->published_at && ! $post->published_at->isFuture())
                <x-button href="{{ url('/news/'.$post->slug) }}" variant="outline" size="sm">View on site</x-button>
            @endif
        </div>

        <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" class="mt-6 rounded-lg border border-line bg-surface p-5 shadow-card sm:p-7">
            @csrf
            @method('PUT')

            @include('admin.posts._form', ['post' => $post])

            <div class="mt-7 flex flex-wrap gap-3 border-t border-line pt-6">
                <x-button type="submit">Save changes</x-button>
                <x-button href="{{ route('admin.posts.index') }}" variant="outline">Cancel</x-button>
            </div>
        </form>
    </div>
@endsection
