@extends('layouts.app')

@section('title', 'Events')
@section('meta_description', 'See upcoming events, community days and sponsor visits with Hope In God Child Initiatives (HGCI) in Uganda.')

@section('content')
    <x-page-hero
        eyebrow="Coming up"
        title="Events and community days"
        description="Join us in person, or keep the children and families we serve in your prayers."
        image="images/gallery/health-hygiene/sanitary-pads-in-classroom.jpeg"
        image-alt="Students in a classroom with packs of sanitary supplies during an HGCI school visit"
        :breadcrumbs="[['label' => 'Events']]"
    >
        <div class="flex flex-col gap-3 sm:flex-row">
            <x-button href="{{ url('/get-involved') }}" size="lg">
                <x-icon name="users" class="size-5" />
                Get involved
            </x-button>
            <x-button href="{{ url('/contact') }}" variant="outline-light" size="lg">
                Ask about an event
                <x-icon name="arrow-right" class="size-4" />
            </x-button>
        </div>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="container-page">
            <x-section-heading
                eyebrow="Upcoming"
                title="Save the date"
                description="These are the events currently planned. Details are confirmed by our team before each event."
            />

            <div class="mt-10">
                @if ($upcoming->isEmpty())
                    <div class="rounded-lg border border-dashed border-line bg-surface-warm p-8 text-center sm:p-12">
                        <span class="inline-flex size-14 items-center justify-center rounded-lg bg-brand-teal text-white">
                            <x-icon name="calendar" class="size-7" />
                        </span>
                        <h2 class="mt-5 font-display text-2xl font-semibold text-ink">No events are scheduled yet</h2>
                        <p class="mx-auto mt-3 max-w-xl leading-relaxed text-muted">
                            [ADD: upcoming events.] Check back soon, or contact us to find out how you can serve
                            alongside HGCI.
                        </p>
                        <div class="mt-7 flex flex-col justify-center gap-3 sm:flex-row">
                            <x-button href="{{ url('/get-involved') }}">Get involved</x-button>
                            <x-button href="{{ url('/contact') }}" variant="outline">Contact us</x-button>
                        </div>
                    </div>
                @else
                    <div class="grid gap-5 md:grid-cols-2">
                        @foreach ($upcoming as $event)
                            <x-event-card :event="$event" />
                        @endforeach
                    </div>

                    <div class="mt-12">
                        {{ $upcoming->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if ($past->isNotEmpty())
        <section class="border-y border-line bg-surface-warm py-16 lg:py-24">
            <div class="container-page">
                <x-section-heading
                    eyebrow="Past events"
                    title="Moments we shared"
                    description="A look back at recent community days and gatherings."
                />

                <div class="mt-10 grid gap-5 md:grid-cols-2">
                    @foreach ($past as $event)
                        <x-event-card :event="$event" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-cta-band
        tone="yellow"
        eyebrow="Serve together"
        title="Bring your time and skills"
        description="Volunteers, partners and prayerful supporters all help HGCI reach more children and families."
        primary-label="Get involved"
        :primary-href="url('/get-involved')"
        secondary-label="Donate"
        :secondary-href="url('/donate')"
    />
@endsection
