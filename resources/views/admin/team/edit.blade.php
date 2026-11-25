@extends('admin.layouts.app')

@section('title', 'Edit team member')

@section('content')
    <div class="max-w-3xl">
        <a href="{{ route('admin.team.index') }}" class="inline-flex min-h-11 items-center gap-1.5 text-sm font-semibold text-brand-teal underline-offset-4 hover:underline">
            <x-icon name="arrow-right" class="size-4 rotate-180" />
            Back to team
        </a>

        <div class="mt-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-3xl font-semibold text-ink">Edit team member</h1>
                <p class="mt-1 text-sm leading-relaxed text-muted">{{ $member->name }}</p>
            </div>

            @if ($member->is_published)
                <x-button href="{{ url('/about#team') }}" variant="outline" size="sm">View on site</x-button>
            @endif
        </div>

        <form method="POST" action="{{ route('admin.team.update', $member) }}" enctype="multipart/form-data" class="mt-6 rounded-lg border border-line bg-surface p-5 shadow-card sm:p-7">
            @csrf
            @method('PUT')

            @include('admin.team._form', ['member' => $member])

            <div class="mt-7 flex flex-wrap gap-3 border-t border-line pt-6">
                <x-button type="submit">Save changes</x-button>
                <x-button href="{{ route('admin.team.index') }}" variant="outline">Cancel</x-button>
            </div>
        </form>
    </div>
@endsection
