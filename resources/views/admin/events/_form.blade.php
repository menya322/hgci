@php
    $startsValue = $event->starts_at?->format('Y-m-d\TH:i');
    $endsValue = $event->ends_at?->format('Y-m-d\TH:i');
@endphp

<div class="space-y-5">
    <x-form.field label="Title" name="title" required>
        <x-form.input name="title" :value="$event->title" required />
    </x-form.field>

    <div class="grid gap-5 sm:grid-cols-2">
        <x-form.field label="Starts at" name="starts_at" required>
            <x-form.input name="starts_at" type="datetime-local" :value="$startsValue" required />
        </x-form.field>

        <x-form.field label="Ends at" name="ends_at" hint="Optional. Must be after the start time.">
            <x-form.input name="ends_at" type="datetime-local" :value="$endsValue" />
        </x-form.field>
    </div>

    <x-form.field label="Location" name="location">
        <x-form.input name="location" :value="$event->location" />
    </x-form.field>

    <x-form.field label="Short summary" name="excerpt" hint="Shown on event cards. Around 1–2 sentences.">
        <x-form.textarea name="excerpt" rows="3" :value="$event->excerpt" />
    </x-form.field>

    <x-form.field label="Description" name="description" hint="Plain text. Separate paragraphs with a blank line.">
        <x-form.textarea name="description" rows="8" :value="$event->description" />
    </x-form.field>

    <div class="grid gap-5 sm:grid-cols-2">
        <x-admin.image-input name="image" label="Event image" :current="$event->image" :alt="$event->image_alt ?? $event->title" />

        <x-form.field label="Image description" name="image_alt" hint="Describe the photo for screen readers.">
            <x-form.input name="image_alt" :value="$event->image_alt" />
        </x-form.field>
    </div>

    <div class="rounded-lg border border-line bg-surface-warm p-4">
        <x-form.checkbox name="is_published" :checked="$event->is_published">
            Publish this event on the public site
        </x-form.checkbox>
    </div>
</div>
