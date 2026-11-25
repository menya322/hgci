@extends('admin.layouts.app')

@section('title', 'New team member')

@section('content')
    <div class="max-w-3xl">
        <a href="{{ route('admin.team.index') }}" class="inline-flex min-h-11 items-center gap-1.5 text-sm font-semibold text-brand-teal underline-offset-4 hover:underline">
            <x-icon name="arrow-right" class="size-4 rotate-180" />
            Back to team
        </a>

        <h1 class="mt-3 font-display text-3xl font-semibold text-ink">New team member</h1>
        <p class="mt-1 text-sm leading-relaxed text-muted">Published team members appear on the public about page in the order you set.</p>

        <form method="POST" action="{{ route('admin.team.store') }}" enctype="multipart/form-data" class="mt-6 rounded-lg border border-line bg-surface p-5 shadow-card sm:p-7">
            @csrf

            @include('admin.team._form', ['member' => $member])

            <div class="mt-7 flex flex-wrap gap-3 border-t border-line pt-6">
                <x-button type="submit">Save team member</x-button>
                <x-button href="{{ route('admin.team.index') }}" variant="outline">Cancel</x-button>
            </div>
        </form>
    </div>
@endsection
