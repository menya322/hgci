@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-ink">Dashboard</h1>
            <p class="mt-1 text-sm leading-relaxed text-muted">A quick look at the content and enquiries on the HGCI website.</p>
        </div>

        <div class="flex flex-wrap gap-2">
            <x-button href="{{ route('admin.posts.create') }}" size="sm">New post</x-button>
            <x-button href="{{ route('admin.programs.create') }}" size="sm" variant="outline">New program</x-button>
        </div>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $cards = [
                ['label' => 'Unread messages', 'value' => $stats['unreadMessages'], 'note' => 'Contact form', 'tone' => 'bg-brand-yellow text-ink'],
                ['label' => 'New enquiries', 'value' => $stats['newEnquiries'], 'note' => 'Awaiting first reply', 'tone' => 'bg-brand-green text-ink'],
                ['label' => 'Pending pledges', 'value' => $stats['pendingPledges'], 'note' => 'Follow-up needed', 'tone' => 'bg-brand-red text-white'],
                ['label' => 'Upcoming events', 'value' => $stats['upcomingEvents'], 'note' => 'Scheduled from now', 'tone' => 'bg-brand-orange text-ink'],
                ['label' => 'Posts', 'value' => $stats['posts'], 'note' => $stats['publishedPosts'].' published', 'tone' => 'bg-brand-teal text-white'],
                ['label' => 'Programs', 'value' => $stats['programs'], 'note' => 'Public programs', 'tone' => 'bg-brand-teal text-white'],
                ['label' => 'Volunteer applications', 'value' => $stats['newApplications'], 'note' => 'New and unread', 'tone' => 'bg-brand-green text-ink'],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="rounded-lg border border-line bg-surface p-5 shadow-card">
                <span class="inline-flex size-9 items-center justify-center rounded-md {{ $card['tone'] }}">
                    <x-icon name="sparkles" class="size-5" />
                </span>
                <p class="mt-4 font-display text-3xl font-semibold text-ink">{{ $card['value'] }}</p>
                <p class="mt-1 text-sm font-semibold text-ink">{{ $card['label'] }}</p>
                <p class="mt-0.5 text-xs text-muted">{{ $card['note'] }}</p>
            </div>
        @endforeach
    </div>

    <section class="mt-10 overflow-hidden rounded-lg border border-line bg-surface shadow-card" aria-labelledby="recent-posts-heading">
        <div class="flex items-center justify-between gap-4 border-b border-line px-5 py-4">
            <h2 id="recent-posts-heading" class="font-display text-lg font-semibold text-ink">Recent posts</h2>
            <a href="{{ route('admin.posts.index') }}" class="text-sm font-semibold text-brand-teal underline-offset-4 hover:underline">View all posts</a>
        </div>

        @if ($recentPosts->isEmpty())
            <p class="px-5 py-8 text-sm text-muted">No posts yet. Create your first story to share on the public site.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[36rem] text-left text-sm">
                    <thead class="bg-surface-warm text-xs uppercase tracking-[0.12em] text-muted">
                        <tr>
                            <th scope="col" class="px-5 py-3 font-semibold">Title</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Status</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Published</th>
                            <th scope="col" class="px-5 py-3 font-semibold"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($recentPosts as $post)
                            <tr>
                                <td class="px-5 py-3 font-semibold text-ink">{{ $post->title }}</td>
                                <td class="px-5 py-3">
                                    @if ($post->published_at && ! $post->published_at->isFuture())
                                        <span class="inline-flex rounded-md bg-brand-green/15 px-2 py-1 text-xs font-semibold text-ink">Published</span>
                                    @else
                                        <span class="inline-flex rounded-md bg-line px-2 py-1 text-xs font-semibold text-ink">Draft</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-muted">{{ $post->published_at?->format('j M Y, H:i') ?? 'Not set' }}</td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="font-semibold text-brand-teal underline-offset-4 hover:underline">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
