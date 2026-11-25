@extends('admin.layouts.app')

@section('title', 'Projects')

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-ink">Projects</h1>
            <p class="mt-1 text-sm leading-relaxed text-muted">Livelihood, relief and care projects shown on the impact page.</p>
        </div>

        <x-button href="{{ route('admin.projects.create') }}" size="sm">New project</x-button>
    </div>

    <div class="mt-8 overflow-hidden rounded-lg border border-line bg-surface shadow-card">
        @if ($projects->isEmpty())
            <div class="px-5 py-10 text-center">
                <p class="font-display text-lg font-semibold text-ink">No projects yet</p>
                <p class="mt-2 text-sm text-muted">Add a project to show it on the public impact page.</p>
                <div class="mt-5">
                    <x-button href="{{ route('admin.projects.create') }}">Create the first project</x-button>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[46rem] text-left text-sm">
                    <thead class="bg-surface-warm text-xs uppercase tracking-[0.12em] text-muted">
                        <tr>
                            <th scope="col" class="px-5 py-3 font-semibold">Project</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Program</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Category</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Order</th>
                            <th scope="col" class="px-5 py-3 font-semibold">Status</th>
                            <th scope="col" class="px-5 py-3 font-semibold"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($projects as $project)
                            <tr>
                                <td class="px-5 py-3">
                                    <p class="font-semibold text-ink">{{ $project->title }}</p>
                                    <p class="mt-0.5 text-xs text-muted">/{{ $project->slug }}</p>
                                </td>
                                <td class="px-5 py-3 text-muted">{{ $project->program?->title ?? '—' }}</td>
                                <td class="px-5 py-3 text-muted">{{ ucfirst($project->category) }}</td>
                                <td class="px-5 py-3 text-muted">{{ $project->sort_order }}</td>
                                <td class="px-5 py-3">
                                    @if ($project->is_published)
                                        <span class="inline-flex rounded-md bg-brand-green/15 px-2 py-1 text-xs font-semibold text-ink">Published</span>
                                    @else
                                        <span class="inline-flex rounded-md bg-line px-2 py-1 text-xs font-semibold text-ink">Hidden</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.projects.edit', $project) }}" class="font-semibold text-brand-teal underline-offset-4 hover:underline">Edit</a>

                                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Move this project to the trash?');">
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
                {{ $projects->links() }}
            </div>
        @endif
    </div>
@endsection
