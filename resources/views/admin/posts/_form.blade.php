@php
    $publishedValue = $post->published_at?->format('Y-m-d\TH:i');
@endphp

<div class="space-y-5">
    <x-form.field label="Title" name="title" required>
        <x-form.input name="title" :value="$post->title" required />
    </x-form.field>

    <div class="grid gap-5 sm:grid-cols-2">
        <x-form.field label="Category" name="category" hint="For example: news, story or update.">
            <x-form.input name="category" :value="$post->category" />
        </x-form.field>

        <x-form.field label="Publication date" name="published_at" hint="Leave blank to keep this post as a draft.">
            <x-form.input name="published_at" type="datetime-local" :value="$publishedValue" />
        </x-form.field>
    </div>

    <x-form.field label="Short summary" name="excerpt" hint="Shown on the news list and in search results. Around 1–2 sentences.">
        <x-form.textarea name="excerpt" rows="3" :value="$post->excerpt" />
    </x-form.field>

    <x-form.field label="Story" name="body" hint="Plain text. Separate paragraphs with a blank line.">
        <x-form.textarea name="body" rows="12" :value="$post->body" />
    </x-form.field>

    <div class="grid gap-5 sm:grid-cols-2">
        <x-form.field label="Featured image" name="featured_image" hint="JPG, PNG or WebP, up to 2 MB.">
            @if ($post->featured_image)
                <div class="mb-3 overflow-hidden rounded-lg border border-line bg-surface-warm">
                    <img
                        src="{{ Storage::disk('public')->url($post->featured_image) }}"
                        alt="{{ $post->image_alt ?? $post->title }}"
                        class="h-32 w-full object-cover"
                    >
                </div>
            @endif

            <input
                id="featured_image"
                name="featured_image"
                type="file"
                accept="image/jpeg,image/png,image/webp"
                @if ($errors->has('featured_image')) aria-invalid="true" aria-describedby="featured_image-error" @endif
                class="block w-full rounded-lg border border-line bg-surface px-3.5 py-2.5 text-sm text-ink file:mr-3 file:rounded-md file:border-0 file:bg-brand-teal file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal"
            >
        </x-form.field>

        <x-form.field label="Image description" name="image_alt" hint="Describe the photo for screen readers.">
            <x-form.input name="image_alt" :value="$post->image_alt" />
        </x-form.field>
    </div>

    <div class="rounded-lg border border-line bg-surface-warm p-4">
        <x-form.checkbox name="is_featured" :checked="$post->is_featured">
            Feature this post on the home page
        </x-form.checkbox>
    </div>
</div>
