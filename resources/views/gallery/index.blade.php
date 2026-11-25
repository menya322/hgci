@extends('layouts.app')

@section('title', 'Gallery')
@section('meta_description', 'View photos from Hope In God Child Initiatives (HGCI) showing school support, food relief, health and hygiene, clothing distributions and community care in Uganda.')

@section('content')
    <x-page-hero
        eyebrow="Gallery"
        title="Moments of hope"
        description="A window into the work of HGCI: children, families and communities walking together with dignity and care."
        image="images/gallery/education-school-support/students-with-hygiene-supplies.jpeg"
        image-alt="Students holding packs of sanitary supplies after an HGCI distribution at their school"
        :breadcrumbs="[['label' => 'Gallery']]"
    >
        <div class="flex flex-col gap-3 sm:flex-row">
            <x-button href="{{ url('/sponsor') }}" size="lg">
                <x-icon name="heart" class="size-5" />
                Sponsor a child
            </x-button>
            <x-button href="{{ url('/get-involved') }}" variant="outline-light" size="lg">
                Get involved
                <x-icon name="arrow-right" class="size-4" />
            </x-button>
        </div>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="container-page">
            <x-section-heading
                eyebrow="Photo albums"
                title="Life at HGCI"
                description="Browse moments from our programmes and community visits. Every photo is shared with consent and respect for the children and families pictured."
            />

            @if ($albums->isEmpty())
                <div class="mt-10 rounded-lg border border-dashed border-line bg-surface-warm p-8 text-center sm:p-12">
                    <span class="inline-flex size-14 items-center justify-center rounded-lg bg-brand-teal text-white">
                        <x-icon name="photo" class="size-7" />
                    </span>
                    <h2 class="mt-5 font-display text-2xl font-semibold text-ink">Photos are being prepared</h2>
                    <p class="mx-auto mt-3 max-w-xl leading-relaxed text-muted">
                        [ADD: gallery albums and photos.] In the meantime, explore our programmes or contact us to learn
                        more about the work of HGCI.
                    </p>
                    <div class="mt-7 flex flex-col justify-center gap-3 sm:flex-row">
                        <x-button href="{{ url('/programs') }}">Explore our programs</x-button>
                        <x-button href="{{ url('/contact') }}" variant="outline">Contact us</x-button>
                    </div>
                </div>
            @else
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($albums as $album)
                        <x-album-card :album="$album" :count="$album->images_count" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    @if ($previewImages->isNotEmpty())
        <section class="border-y border-line bg-surface-warm py-16 lg:py-24">
            <div class="container-page">
                <x-section-heading
                    eyebrow="Recent moments"
                    title="A glimpse of the work"
                    description="Select any photo to view it larger. You can move between photos with the arrow keys and close the viewer with Escape."
                />

                <div class="mt-10">
                    <x-gallery-grid :images="$previewImages" />
                </div>
            </div>
        </section>
    @endif

    <x-cta-band
        tone="teal"
        eyebrow="See something you can support?"
        title="Help us write the next photo story"
        description="Your gift or your time helps children stay in school, eat well and grow up in a safe and caring community."
        primary-label="Donate today"
        :primary-href="url('/donate')"
        secondary-label="Sponsor a child"
        :secondary-href="url('/sponsor')"
    />
@endsection
