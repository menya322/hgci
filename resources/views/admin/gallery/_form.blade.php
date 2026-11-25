<div class="space-y-5">
    <x-form.field label="Album title" name="title" required>
        <x-form.input name="title" :value="$album->title" required />
    </x-form.field>

    <x-form.field label="Description" name="description" hint="A short introduction shown at the top of the album.">
        <x-form.textarea name="description" rows="4" :value="$album->description" />
    </x-form.field>

    @if ($album->cover_image)
        <div class="grid gap-5 sm:grid-cols-[12rem_1fr] sm:items-center">
            <img
                src="{{ asset($album->cover_image) }}"
                alt=""
                class="h-28 w-full rounded-lg border border-line object-cover"
            >

            <div>
                <p class="text-sm font-semibold text-ink">Current cover photo</p>
                <p class="mt-1 text-sm leading-relaxed text-muted">
                    Choose a different cover from the photos in this album.
                </p>
                <a href="{{ route('admin.gallery.images.index', $album) }}" class="mt-2 inline-flex min-h-11 items-center text-sm font-semibold text-brand-teal underline-offset-4 hover:underline">
                    Manage photos
                </a>
            </div>
        </div>
    @endif

    <div class="grid gap-5 sm:grid-cols-2">
        <x-form.field label="Display order" name="sort_order" hint="Lower numbers appear first.">
            <x-form.input name="sort_order" type="number" min="0" max="999" :value="$album->sort_order ?? 0" />
        </x-form.field>

        <div class="sm:flex sm:items-end">
            <div class="w-full rounded-lg border border-line bg-surface-warm p-4">
                <x-form.checkbox name="is_published" :checked="$album->is_published">
                    Publish this album on the gallery page
                </x-form.checkbox>
            </div>
        </div>
    </div>
</div>
