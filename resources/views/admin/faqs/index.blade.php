@extends('admin.layouts.app')

@section('title', 'FAQs')

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-ink">FAQs</h1>
            <p class="mt-1 text-sm leading-relaxed text-muted">Questions and answers shown on the sponsor page and other public pages.</p>
        </div>

        <x-button href="{{ route('admin.faqs.create') }}" size="sm">New FAQ</x-button>
    </div>

    <div class="mt-8 overflow-hidden rounded-lg border border-line bg-surface shadow-card">
        @if ($faqs->isEmpty())
            <div class="px-5 py-10 text-center">
                <p class="font-display text-lg font-semibold text-ink">No FAQs yet</p>
                <p class="mt-2 text-sm text-muted">Add a question to help visitors understand sponsorship and giving.</p>
                <div class="mt-5">
                    <x-button href="{{ route('admin.faqs.create') }}">Add the first FAQ</x-button>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[42rem] text-left text-sm">
                    <thead class="bg-surface-warm text-xs uppercase tracking-[0.12em] text-muted">
                        <tr>
                            <th scope="col" class="px-5 py-3 font-semibold">Question</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Category</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Order</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Status</th>
                            <th scope="col" class="px-5 py-3 font-semibold"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($faqs as $faq)
                            <tr>
                                <td class="px-5 py-3">
                                    <p class="font-semibold text-ink">{{ $faq->question }}</p>
                                </td>
                                <td class="px-5 py-3 text-muted">{{ $faq->category ? ucfirst($faq->category) : '—' }}</td>
                                <td class="px-5 py-3 text-muted">{{ $faq->sort_order }}</td>
                                <td class="px-5 py-3">
                                    @if ($faq->is_published)
                                        <span class="inline-flex rounded-md bg-brand-green/15 px-2 py-1 text-xs font-semibold text-ink">Published</span>
                                    @else
                                        <span class="inline-flex rounded-md bg-line px-2 py-1 text-xs font-semibold text-ink">Hidden</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="font-semibold text-brand-teal underline-offset-4 hover:underline">Edit</a>

                                        <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('Move this FAQ to the trash?');">
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
                {{ $faqs->links() }}
            </div>
        @endif
    </div>
@endsection
