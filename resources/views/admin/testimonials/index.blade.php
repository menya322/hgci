@extends('admin.layouts.app')

@section('title', 'Testimonials')

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-ink">Testimonials</h1>
            <p class="mt-1 text-sm leading-relaxed text-muted">Quotes from sponsors, volunteers and community members.</p>
        </div>

        <x-button href="{{ route('admin.testimonials.create') }}" size="sm">New testimonial</x-button>
    </div>

    <div class="mt-8 overflow-hidden rounded-lg border border-line bg-surface shadow-card">
        @if ($testimonials->isEmpty())
            <div class="px-5 py-10 text-center">
                <p class="font-display text-lg font-semibold text-ink">No testimonials yet</p>
                <p class="mt-2 text-sm text-muted">Add a testimonial to share a voice from the HGCI community.</p>
                <div class="mt-5">
                    <x-button href="{{ route('admin.testimonials.create') }}">Add the first testimonial</x-button>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[42rem] text-left text-sm">
                    <thead class="bg-surface-warm text-xs uppercase tracking-[0.12em] text-muted">
                        <tr>
                            <th scope="col" class="px-5 py-3 font-semibold">Name</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Role</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Order</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Status</th>
                            <th scope="col" class="px-5 py-3 font-semibold"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($testimonials as $testimonial)
                            <tr>
                                <td class="px-5 py-3">
                                    <p class="font-semibold text-ink">{{ $testimonial->name }}</p>
                                    <p class="mt-0.5 max-w-md truncate text-xs text-muted">{{ $testimonial->quote }}</p>
                                </td>
                                <td class="px-5 py-3 text-muted">{{ $testimonial->role ?: '—' }}</td>
                                <td class="px-5 py-3 text-muted">{{ $testimonial->sort_order }}</td>
                                <td class="px-5 py-3">
                                    @if ($testimonial->is_published)
                                        <span class="inline-flex rounded-md bg-brand-green/15 px-2 py-1 text-xs font-semibold text-ink">Published</span>
                                    @else
                                        <span class="inline-flex rounded-md bg-line px-2 py-1 text-xs font-semibold text-ink">Hidden</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="font-semibold text-brand-teal underline-offset-4 hover:underline">Edit</a>

                                        <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('Move this testimonial to the trash?');">
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
                {{ $testimonials->links() }}
            </div>
        @endif
    </div>
@endsection
