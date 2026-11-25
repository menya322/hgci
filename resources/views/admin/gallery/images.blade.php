@extends('admin.layouts.app')

@section('title', 'Photos · '.$album->title)

@section('content')
    <a href="{{ route('admin.gallery.index') }}" class="inline-flex min-h-11 items-center gap-1.5 text-sm font-semibold text-brand-teal underline-offset-4 hover:underline">
        <x-icon name="arrow-right" class="size-4 rotate-180" />
        Back to gallery
    </a>

    <div class="mt-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-ink">{{ $album->title }}</h1>
            <p class="mt-1 text-sm leading-relaxed text-muted">
                {{ $images->count() }} {{ \Illuminate\Support\Str::plural('photo', $images->count()) }} in this album.
                Use the order field or the move buttons to arrange them.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <x-button href="{{ route('admin.gallery.edit', $album) }}" variant="outline" size="sm">Edit album</x-button>

            @if ($album->is_published)
                <x-button href="{{ route('gallery.show', $album) }}" variant="outline" size="sm">View on site</x-button>
            @endif
        </div>
    </div>

    @if ($errors->any())
        <div role="alert" class="mt-6 rounded-lg border border-brand-red bg-surface px-4 py-3">
            <p class="text-sm font-semibold text-brand-red">Please check the highlighted fields.</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm leading-relaxed text-ink">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="mt-8 rounded-lg border border-line bg-surface p-5 shadow-card sm:p-6" aria-labelledby="upload-photos-heading">
        <h2 id="upload-photos-heading" class="font-display text-lg font-semibold text-ink">Add photos</h2>
        <p id="images-hint" class="mt-1 text-xs leading-relaxed text-muted">
            JPG, PNG or WebP. Up to 20 photos at a time, 2 MB each. The first photo becomes the cover if the album has none.
        </p>

        <form method="POST" action="{{ route('admin.gallery.images.store', $album) }}" enctype="multipart/form-data" class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-end">
            @csrf

            <div class="flex-1">
                <label for="images" class="block text-sm font-semibold text-ink">Choose photos<span class="ml-1 text-brand-red" aria-hidden="true">*</span></label>
                <input
                    id="images"
                    name="images[]"
                    type="file"
                    multiple
                    accept="image/jpeg,image/png,image/webp"
                    aria-describedby="images-hint"
                    required
                    class="mt-1.5 block w-full rounded-lg border border-line bg-surface px-3.5 py-2.5 text-sm text-ink file:mr-3 file:rounded-md file:border-0 file:bg-brand-teal file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
                >
            </div>

            <x-button type="submit">Upload photos</x-button>
        </form>
    </section>

    <section class="mt-8" aria-labelledby="album-photos-heading">
        <h2 id="album-photos-heading" class="font-display text-lg font-semibold text-ink">Album photos</h2>

        @if ($images->isEmpty())
            <div class="mt-4 rounded-lg border border-dashed border-line bg-surface-warm p-8 text-center">
                <p class="font-display text-lg font-semibold text-ink">No photos in this album yet</p>
                <p class="mt-2 text-sm text-muted">Use the upload form above to add the first photos.</p>
            </div>
        @else
            <div class="mt-4 grid gap-5 lg:grid-cols-2">
                @foreach ($images as $image)
                    <article class="overflow-hidden rounded-lg border border-line bg-surface shadow-card">
                        <div class="relative border-b border-line bg-surface-warm">
                            <img
                                src="{{ asset($image->image) }}"
                                alt="{{ $image->alt_text ?: $image->caption ?: 'Album photo' }}"
                                loading="lazy"
                                class="h-52 w-full object-cover"
                            >

                            @if ($album->cover_image === $image->image)
                                <span class="absolute left-3 top-3 inline-flex items-center gap-1 rounded-md bg-brand-yellow px-2 py-1 text-xs font-semibold text-ink">
                                    <x-icon name="check" class="size-3.5" />
                                    Cover photo
                                </span>
                            @endif
                        </div>

                        <div class="p-4">
                            <form method="POST" action="{{ route('admin.gallery.images.update', [$album, $image]) }}" class="space-y-3">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label for="caption-{{ $image->id }}" class="block text-sm font-semibold text-ink">Caption</label>
                                    <input
                                        id="caption-{{ $image->id }}"
                                        name="caption"
                                        type="text"
                                        maxlength="255"
                                        value="{{ $image->caption }}"
                                        class="mt-1.5 block min-h-11 w-full rounded-lg border border-line bg-surface px-3.5 py-2.5 text-base text-ink focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
                                    >
                                </div>

                                <div>
                                    <label for="alt-{{ $image->id }}" class="block text-sm font-semibold text-ink">Image description</label>
                                    <input
                                        id="alt-{{ $image->id }}"
                                        name="alt_text"
                                        type="text"
                                        maxlength="255"
                                        value="{{ $image->alt_text }}"
                                        class="mt-1.5 block min-h-11 w-full rounded-lg border border-line bg-surface px-3.5 py-2.5 text-base text-ink focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
                                    >
                                </div>

                                <div class="flex flex-wrap items-end gap-3">
                                    <div class="w-32">
                                        <label for="order-{{ $image->id }}" class="block text-sm font-semibold text-ink">Order</label>
                                        <input
                                            id="order-{{ $image->id }}"
                                            name="sort_order"
                                            type="number"
                                            min="0"
                                            max="999"
                                            value="{{ $image->sort_order }}"
                                            class="mt-1.5 block min-h-11 w-full rounded-lg border border-line bg-surface px-3.5 py-2.5 text-base text-ink focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
                                        >
                                    </div>

                                    <x-button type="submit" size="sm" variant="outline">Save details</x-button>
                                </div>
                            </form>

                            <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-line pt-4">
                                @if ($album->cover_image !== $image->image)
                                    <form method="POST" action="{{ route('admin.gallery.images.cover', [$album, $image]) }}">
                                        @csrf
                                        <x-button type="submit" size="sm">Set as cover</x-button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('admin.gallery.images.move', [$album, $image]) }}">
                                    @csrf
                                    <input type="hidden" name="direction" value="up">
                                    <x-button type="submit" size="sm" variant="outline">Move up</x-button>
                                </form>

                                <form method="POST" action="{{ route('admin.gallery.images.move', [$album, $image]) }}">
                                    @csrf
                                    <input type="hidden" name="direction" value="down">
                                    <x-button type="submit" size="sm" variant="outline">Move down</x-button>
                                </form>

                                <form method="POST" action="{{ route('admin.gallery.images.destroy', [$album, $image]) }}" onsubmit="return confirm('Delete this photo from the album?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex min-h-11 items-center rounded-lg px-3 text-sm font-semibold text-brand-red underline-offset-4 hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-red">
                                        Delete photo
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection
