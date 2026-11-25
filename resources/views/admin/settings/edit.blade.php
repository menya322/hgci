@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
    <div class="max-w-5xl">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="font-display text-3xl font-semibold text-ink">Settings</h1>
                <p class="mt-1 text-sm leading-relaxed text-muted">
                    Contact details, social profiles, giving information, hero copy and impact counters used across the public site.
                </p>
            </div>
        </div>

        <div class="mt-6 rounded-lg border border-line bg-surface-warm p-4">
            <p class="text-sm leading-relaxed text-ink">
                Keep the <span class="font-semibold">[ADD: ...]</span> placeholders until HGCI confirms the real details.
                They are shown on the public site exactly as written, so nothing is invented.
            </p>
        </div>

        @if ($errors->any())
            <div role="alert" class="mt-6 rounded-lg border border-brand-red bg-surface px-4 py-3">
                <p class="text-sm font-semibold text-brand-red">Some settings could not be saved.</p>
                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm leading-relaxed text-ink">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.settings.update') }}" class="mt-8 space-y-6">
            @csrf
            @method('PUT')

            @foreach ($groups as $groupKey => $group)
                <section class="rounded-lg border border-line bg-surface p-5 shadow-card sm:p-7" aria-labelledby="settings-{{ $groupKey }}-heading">
                    <h2 id="settings-{{ $groupKey }}-heading" class="font-display text-xl font-semibold text-ink">
                        {{ $group['title'] }}
                    </h2>
                    <p class="mt-1 max-w-2xl text-sm leading-relaxed text-muted">{{ $group['description'] }}</p>

                    <div class="mt-6 grid gap-5 sm:grid-cols-2">
                        @foreach ($group['fields'] as $settingKey => $field)
                            <div class="{{ $field['type'] === 'textarea' ? 'sm:col-span-2' : '' }}">
                                <x-form.field
                                    :label="$field['label']"
                                    :name="$field['name']"
                                    :hint="$field['hint'] ?? null"
                                    :required="$field['required'] ?? false"
                                >
                                    @if ($field['type'] === 'textarea')
                                        <x-form.textarea
                                            :name="$field['name']"
                                            :value="$settings[$settingKey] ?? ''"
                                            rows="4"
                                        />
                                    @else
                                        <x-form.input
                                            :name="$field['name']"
                                            :value="$settings[$settingKey] ?? ''"
                                        />
                                    @endif
                                </x-form.field>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach

            <div class="flex flex-wrap items-center gap-3 rounded-lg border border-line bg-surface px-5 py-4 shadow-card">
                <x-button type="submit">Save settings</x-button>
                <x-button href="{{ route('admin.dashboard') }}" variant="outline">Cancel</x-button>
                <p class="text-xs leading-relaxed text-muted">Changes appear on the public site immediately.</p>
            </div>
        </form>
    </div>
@endsection
