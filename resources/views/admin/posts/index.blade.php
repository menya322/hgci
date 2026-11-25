@extends('admin.layouts.app')

@section('title', 'Posts')

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-ink">Posts</h1>
            <p class="mt-1 text-sm leading-relaxed text-muted">News and stories shown on the public site once published.</p>
        </div>

        <x-button href="{{ route('admin.posts.create') }}" size="sm">New post</x-button>
    </div>

    <div class="mt-8 overflow-hidden rounded-lg border border-line bg-surface shadow-card">
        @if ($posts->isEmpty())
            <div class="px-5 py-10 text-center">
                <p class="font-display text-lg font-semibold text-ink">No posts yet</p>
                <p class="mt-2 text-sm text-muted">Create a post to share an update or story.</p>
                <div class="mt-5">
                    <x-button href="{{ route('admin.posts.create') }}">Create the first post</x-button>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[44rem] text-left text-sm">
                    <thead class="bg-surface-warm text-xs uppercase tracking-[0.12em] text-muted">
                        <tr>
                            <th scope="col" class="px-5 py-3 font-semibold">Title</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Category</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Status</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Author</th>
                            <th scope="col" class="px-5 py-3 font-semibold"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($posts as $post)
                            <tr>
                                <td class="px-5 py-3">
                                    <p class="font-semibold text-ink">{{ $post->title }}</p>
                                    <p class="mt-0.5 text-xs text-muted">/{{ $post->slug }}</p>
                                </td>
                                <td class="px-5 py-3 text-muted">{{ $post->category ?: '—' }}</td>
                                <td class="px-5 py-3">
                                    @if ($post->published_at && ! $post->published_at->isFuture())
                                        <span class="inline-flex rounded-md bg-brand-green/15 px-2 py-1 text-xs font-semibold text-ink">Published</span>
                                    @else
                                        <span class="inline-flex rounded-md bg-line px-2 py-1 text-xs font-semibold text-ink">Draft</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-muted">{{ $post->author?->name ?? '—' }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="font-semibold text-brand-teal underline-offset-4 hover:underline">Edit</a>

                                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Move this post to the trash?');">
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
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection
