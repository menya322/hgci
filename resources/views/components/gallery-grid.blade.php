{{--
    Photo grid with an inline lightbox.

    - Thumbnails lazy-load and sit in a 4:3 frame, so the grid never shifts.
    - Every photo shows its caption in the card, not only on hover, so the
      caption is readable on touch devices and by screen readers.
    - Selecting a photo opens an Alpine lightbox with arrow-key navigation,
      Escape to close and focus returned to the thumbnail that was opened.
--}}

@props(['images'])

@php
    // Only photos whose file is on disk reach the grid and the lightbox, so a
    // removed upload can never leave a broken thumbnail or blank slide behind.
    $visible = $images
        ->filter(fn ($image) => filled($image->image) && file_exists(public_path($image->image)))
        ->values();

    $photos = $visible
        ->map(fn ($image) => [
            'src' => asset($image->image),
            'alt' => $image->alt_text ?: ($image->caption ?: 'HGCI gallery photo'),
            'caption' => $image->caption,
        ])
        ->values();
@endphp

@if ($photos->isEmpty())
    <div class="rounded-lg border border-dashed border-line bg-surface-warm p-8 text-center">
        <span class="inline-flex size-12 items-center justify-center rounded-lg bg-brand-teal text-white">
            <x-icon name="photo" class="size-6" />
        </span>
        <p class="mt-4 font-display text-lg font-semibold text-ink">Photos are being added</p>
        <p class="mt-2 text-sm leading-relaxed text-muted">[ADD: photos for this album.] Please check back soon.</p>
    </div>
@else
    <div
    x-data="{
        open: false,
        active: 0,
        lastFocused: null,
        images: @js($photos),
        show(index) {
            this.lastFocused = document.activeElement;
            this.active = index;
            this.open = true;
            this.$nextTick(() => this.$refs.close.focus());
        },
        close() {
            this.open = false;
            this.$nextTick(() => this.lastFocused?.focus());
        },
        next() {
            this.active = (this.active + 1) % this.images.length;
        },
        prev() {
            this.active = (this.active - 1 + this.images.length) % this.images.length;
        },
    }"
    @keydown.escape.window="if (open) close()"
    @keydown.arrow-right.window="if (open) next()"
    @keydown.arrow-left.window="if (open) prev()"
    x-effect="document.body.classList.toggle('overflow-hidden', open)"
>
        <ul class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($visible as $image)
                @php
                    $caption = $image->caption;
                    $alt = $image->alt_text ?: ($caption ?: 'HGCI gallery photo');
                @endphp

                <li>
                    <button
                        type="button"
                        @click="show({{ $loop->index }})"
                        class="group flex h-full w-full flex-col overflow-hidden rounded-lg border border-line bg-surface text-left shadow-card transition-colors hover:border-brand-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
                        aria-label="View larger photo{{ $caption ? ': '.$caption : '' }}"
                    >
                        <span class="relative block w-full overflow-hidden bg-surface-warm">
                            <img
                                src="{{ asset($image->image) }}"
                                alt="{{ $alt }}"
                                loading="lazy"
                                decoding="async"
                                width="1200"
                                height="900"
                                class="aspect-[4/3] w-full object-cover transition-transform duration-300 group-hover:scale-[1.02]"
                            >
                        </span>

                        <span class="flex w-full flex-1 items-start gap-2 border-t border-line px-4 py-3">
                            <x-icon name="photo" class="mt-0.5 size-4 shrink-0 text-brand-teal" />

                            <span class="text-xs leading-relaxed text-muted">
                                {{ $caption ?: '[ADD: photo caption]' }}
                            </span>
                        </span>
                    </button>
                </li>
            @endforeach
        </ul>

        {{-- Lightbox. --}}
        <div
            x-show="open"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-[100] flex flex-col bg-ink/95 p-4 sm:p-6"
            role="dialog"
            aria-modal="true"
            aria-label="Photo viewer"
            @click.self="close()"
        >
            <div class="flex items-center justify-between gap-4">
                <p class="text-sm font-semibold text-white" x-text="`${active + 1} of ${images.length}`"></p>

                <button
                    type="button"
                    x-ref="close"
                    @click="close()"
                    class="inline-flex size-11 items-center justify-center rounded-lg border border-white/40 text-white transition-colors hover:bg-white hover:text-ink focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                    aria-label="Close photo viewer"
                >
                    <x-icon name="close" class="size-6" />
                </button>
            </div>

            <div class="relative flex flex-1 items-center justify-center gap-3 sm:gap-6">
                <button
                    type="button"
                    @click="prev()"
                    class="inline-flex size-11 shrink-0 items-center justify-center rounded-lg border border-white/40 text-white transition-colors hover:bg-white hover:text-ink focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                    aria-label="Previous photo"
                >
                    <x-icon name="arrow-right" class="size-5 rotate-180" />
                </button>

                <figure class="min-w-0 max-w-5xl text-center">
                    <img
                        :src="images[active].src"
                        :alt="images[active].alt"
                        class="mx-auto max-h-[70vh] w-auto rounded-lg object-contain"
                    >
                    <figcaption class="mt-3 text-sm leading-relaxed text-white" x-text="images[active].caption"></figcaption>
                </figure>

                <button
                    type="button"
                    @click="next()"
                    class="inline-flex size-11 shrink-0 items-center justify-center rounded-lg border border-white/40 text-white transition-colors hover:bg-white hover:text-ink focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                    aria-label="Next photo"
                >
                    <x-icon name="arrow-right" class="size-5" />
                </button>
            </div>

            <p class="mt-3 text-center text-xs text-white/70">Use the arrow keys to move between photos, or press Escape to close.</p>
        </div>
    </div>
@endif
