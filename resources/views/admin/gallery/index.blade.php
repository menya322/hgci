@extends('admin.layouts.app')

@section('title', 'Gallery')

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-ink">Gallery albums</h1>
            <p class="mt-1 text-sm leading-relaxed text-muted">Albums and photos shown on the public gallery page.</p>
        </div>

        <x-button href="{{ route('admin.gallery.create') }}" size="sm">New album</x-button>
    </div>

    <div class="mt-8 overflow-hidden rounded-lg border border-line bg-surface shadow-card">
        @if ($albums->isEmpty())
            <div class="px-5 py-10 text-center">
                <p class="font-display text-lg font-semibold text-ink">No albums yet</p>
                <p class="mt-2 text-sm text-muted">Create an album, then upload photos into it.</p>
                <div class="mt-5">
                    <x-button href="{{ route('admin.gallery.create') }}">Create the first album</x-button>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[46rem] text-left text-sm">
                    <thead class="bg-surface-warm text-xs uppercase tracking-[0.12em] text-muted">
                        <tr>
                            <th scope="col" class="px-5 py-3 font-semibold">Album</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Photos</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Order</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Status</th>
                            <th scope="col" class="px-5 py-3 font-semibold"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($albums as $album)
                            <tr>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        @if ($album->cover_image)
                                            <img
                                                src="{{ asset($album->cover_image) }}"
                                                alt=""
                                                class="size-12 shrink-0 rounded-md border border-line object-cover"
                                            >
                                        @else
                                            <span class="inline-flex size-12 shrink-0 items-center justify-center rounded-md border border-dashed border-line bg-surface-warm text-muted">
                                                <x-icon name="photo" class="size-5" />
                                            </span>
                                        @endif

                                        <div>
                                            <p class="font-semibold text-ink">{{ $album->title }}</p>
                                            <p class="mt-0.5 text-xs text-muted">/{{ $album->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-muted">{{ $album->images_count }}</td>
                                <td class="px-5 py-3 text-muted">{{ $album->sort_order }}</td>
                                <td class="px-5 py-3">
                                    @if ($album->is_published)
                                        <span class="inline-flex rounded-md bg-brand-green/15 px-2 py-1 text-xs font-semibold text-ink">Published</span>
                                    @else
                                        <span class="inline-flex rounded-md bg-line px-2 py-1 text-xs font-semibold text-ink">Hidden</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.gallery.images.index', $album) }}" class="font-semibold text-brand-teal underline-offset-4 hover:underline">Photos</a>
                                        <a href="{{ route('admin.gallery.edit', $album) }}" class="font-semibold text-brand-teal underline-offset-4 hover:underline">Edit</a>

                                        <form method="POST" action="{{ route('admin.gallery.destroy', $album) }}" onsubmit="return confirm('Move this album and its photos to the trash?');">
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
                {{ $albums->links() }}
            </div>
        @endif
    </div>
@endsection
