@extends('admin.layouts.app')

@section('title', 'Edit FAQ')

@section('content')
    <div class="max-w-3xl">
        <a href="{{ route('admin.faqs.index') }}" class="inline-flex min-h-11 items-center gap-1.5 text-sm font-semibold text-brand-teal underline-offset-4 hover:underline">
            <x-icon name="arrow-right" class="size-4 rotate-180" />
            Back to FAQs
        </a>

        <div class="mt-3">
            <h1 class="font-display text-3xl font-semibold text-ink">Edit FAQ</h1>
            <p class="mt-1 text-sm leading-relaxed text-muted">{{ $faq->question }}</p>
        </div>

        <form method="POST" action="{{ route('admin.faqs.update', $faq) }}" class="mt-6 rounded-lg border border-line bg-surface p-5 shadow-card sm:p-7">
            @csrf
            @method('PUT')

            @include('admin.faqs._form', ['faq' => $faq])

            <div class="mt-7 flex flex-wrap gap-3 border-t border-line pt-6">
                <x-button type="submit">Save changes</x-button>
                <x-button href="{{ route('admin.faqs.index') }}" variant="outline">Cancel</x-button>
            </div>
        </form>
    </div>
@endsection
