@extends('layouts.app')

@section('title', $album->title.' – Gallery')
@section('meta_description', $album->description ?: 'A photo album from Hope In God Child Initiatives (HGCI) in Uganda.')

@php
    // Only photos whose file is actually on disk are shown, so the headline
    // count always matches the grid instead of promising missing images.
    $visibleImages = $images
        ->filter(fn ($image) => filled($image->image) && file_exists(public_path($image->image)))
        ->values();
@endphp

@section('content')
    <x-page-hero
        eyebrow="Photo album"
        :title="$album->title"
        :description="$album->description"
        :breadcrumbs="[
            ['label' => 'Gallery', 'url' => url('/gallery')],
            ['label' => $album->title],
        ]"
    >
        <div class="flex flex-wrap items-center gap-4">
            <p class="inline-flex items-center gap-2 text-sm font-semibold text-brand-teal">
                <x-icon name="photo" class="size-4" />
                {{ $visibleImages->count() }} {{ \Illuminate\Support\Str::plural('photo', $visibleImages->count()) }}
            </p>

            <x-button href="{{ url('/gallery') }}" variant="outline" size="sm">
                All albums
                <x-icon name="arrow-right" class="size-4" />
            </x-button>
        </div>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="container-page">
            <x-gallery-grid :images="$images" />
        </div>
    </section>

    @if ($otherAlbums->isNotEmpty())
        <section class="border-y border-line bg-surface-warm py-16 lg:py-24">
            <div class="container-page">
                <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                    <x-section-heading
                        eyebrow="Keep exploring"
                        title="More photo albums"
                        description="See more moments from our programmes and community visits."
                    />

                    <x-button href="{{ url('/gallery') }}" variant="outline" class="shrink-0">
                        All albums
                        <x-icon name="arrow-right" class="size-4" />
                    </x-button>
                </div>

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($otherAlbums as $otherAlbum)
                        <x-album-card :album="$otherAlbum" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-cta-band
        tone="yellow"
        eyebrow="Be part of the story"
        title="Every child deserves hope"
        description="Your gift helps a child stay in school, eat well and grow up in a safe and caring community."
        primary-label="Donate today"
        :primary-href="url('/donate')"
        secondary-label="Sponsor a child"
        :secondary-href="url('/sponsor')"
    />
@endsection
