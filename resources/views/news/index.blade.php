@extends('layouts.app')

@section('title', 'News & Stories')
@section('meta_description', 'Read news, stories and updates from Hope In God Child Initiatives (HGCI) about the children, families and communities we serve in Uganda.')

@section('content')
    <x-page-hero
        eyebrow="News & stories"
        title="Stories from the field"
        description="Updates from our programmes, the children we walk with and the communities we serve across Uganda."
        image="images/gallery/health-hygiene/unloading-hygiene-supplies.jpeg"
        image-alt="HGCI team unloading boxes of sanitary pads and supplies for a school distribution"
        :breadcrumbs="[['label' => 'News & Stories']]"
    >
        <div class="flex flex-col gap-3 sm:flex-row">
            <x-button href="{{ url('/sponsor') }}" size="lg">
                <x-icon name="heart" class="size-5" />
                Sponsor a child
            </x-button>
            <x-button href="{{ url('/events') }}" variant="outline-light" size="lg">
                See upcoming events
                <x-icon name="arrow-right" class="size-4" />
            </x-button>
        </div>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="container-page">
            @if ($posts->isEmpty())
                <div class="rounded-lg border border-dashed border-line bg-surface-warm p-8 text-center sm:p-12">
                    <span class="inline-flex size-14 items-center justify-center rounded-lg bg-brand-teal text-white">
                        <x-icon name="newspaper" class="size-7" />
                    </span>
                    <h2 class="mt-5 font-display text-2xl font-semibold text-ink">Our first stories are on the way</h2>
                    <p class="mx-auto mt-3 max-w-xl leading-relaxed text-muted">
                        [ADD: news and story content.] In the meantime, explore our programmes or get in touch to learn
                        more about the work of HGCI.
                    </p>
                    <div class="mt-7 flex flex-col justify-center gap-3 sm:flex-row">
                        <x-button href="{{ url('/programs') }}">Explore our programs</x-button>
                        <x-button href="{{ url('/contact') }}" variant="outline">Contact us</x-button>
                    </div>
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>

    <x-cta-band
        tone="yellow"
        eyebrow="Be part of the story"
        title="Every child deserves hope"
        description="Your gift helps a child stay in school, eat well and grow up in a safe and caring community."
        primary-label="Sponsor a child"
        :primary-href="url('/sponsor')"
        secondary-label="Donate today"
        :secondary-href="url('/donate')"
    />
@endsection
