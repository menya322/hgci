@php
    $iconOptions = [
        'book-open' => 'Book (education)',
        'health' => 'Heart with pulse (health)',
        'briefcase' => 'Briefcase (livelihood)',
        'bowl' => 'Bowl (food relief)',
        'heart' => 'Heart (sponsorship)',
        'academic-cap' => 'Academic cap',
        'users' => 'People',
        'sparkles' => 'Sparkles',
    ];
@endphp

<div class="space-y-5">
    <div class="grid gap-5 sm:grid-cols-[2fr_1fr]">
        <x-form.field label="Title" name="title" required>
            <x-form.input name="title" :value="$program->title" required />
        </x-form.field>

        <x-form.field label="Icon" name="icon">
            <x-form.select name="icon" :options="$iconOptions" placeholder="Choose an icon" :selected="$program->icon" />
        </x-form.field>
    </div>

    <x-form.field label="Short summary" name="excerpt" hint="Shown on the programs grid. Around 1–2 sentences.">
        <x-form.textarea name="excerpt" rows="3" :value="$program->excerpt" />
    </x-form.field>

    <x-form.field label="Description" name="description" hint="Plain text. Separate paragraphs with a blank line.">
        <x-form.textarea name="description" rows="8" :value="$program->description" />
    </x-form.field>

    <div class="grid gap-5 sm:grid-cols-2">
        <x-form.field label="Programme image" name="image" hint="JPG, PNG or WebP, up to 2 MB.">
            @if ($program->image)
                <div class="mb-3 overflow-hidden rounded-lg border border-line bg-surface-warm">
                    <img
                        src="{{ Storage::disk('public')->url($program->image) }}"
                        alt="{{ $program->image_alt ?? $program->title }}"
                        class="h-32 w-full object-cover"
                    >
                </div>
            @endif

            <input
                id="image"
                name="image"
                type="file"
                accept="image/jpeg,image/png,image/webp"
                @if ($errors->has('image')) aria-invalid="true" aria-describedby="image-error" @endif
                class="block w-full rounded-lg border border-line bg-surface px-3.5 py-2.5 text-sm text-ink file:mr-3 file:rounded-md file:border-0 file:bg-brand-teal file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
            >
        </x-form.field>

        <x-form.field label="Image description" name="image_alt" hint="Describe the photo for screen readers.">
            <x-form.input name="image_alt" :value="$program->image_alt" />
        </x-form.field>
    </div>

    <div class="grid gap-5 sm:grid-cols-3">
        <x-form.field label="Display order" name="sort_order" hint="Lower numbers appear first.">
            <x-form.input name="sort_order" type="number" min="0" max="999" :value="$program->sort_order ?? 0" />
        </x-form.field>

        <div class="sm:col-span-2 sm:flex sm:items-end">
            <div class="w-full rounded-lg border border-line bg-surface-warm p-4">
                <x-form.checkbox name="is_published" :checked="$program->is_published">
                    Publish this program on the public site
                </x-form.checkbox>
            </div>
        </div>
    </div>

    <fieldset class="rounded-lg border border-line bg-surface-warm p-4">
        <legend class="px-1 text-sm font-semibold text-ink">Search engine details</legend>
        <p class="mt-1 text-xs leading-relaxed text-muted">Optional. Leave blank to use the program title and summary.</p>

        <div class="mt-4 space-y-4">
            <x-form.field label="Meta title" name="meta_title">
                <x-form.input name="meta_title" :value="$program->meta_title" />
            </x-form.field>

            <x-form.field label="Meta description" name="meta_description">
                <x-form.textarea name="meta_description" rows="2" :value="$program->meta_description" />
            </x-form.field>
        </div>
    </fieldset>
</div>
