<div class="space-y-5">
    <div class="grid gap-5 sm:grid-cols-2">
        <x-form.field label="Name" name="name" required>
            <x-form.input name="name" :value="$testimonial->name" required />
        </x-form.field>

        <x-form.field label="Role" name="role" hint="For example: Sponsor, Volunteer, Parent.">
            <x-form.input name="role" :value="$testimonial->role" />
        </x-form.field>
    </div>

    <x-form.field label="Quote" name="quote" required>
        <x-form.textarea name="quote" rows="5" :value="$testimonial->quote" required />
    </x-form.field>

    <x-admin.image-input name="photo" label="Photo" :current="$testimonial->photo" :alt="$testimonial->name" />

    <div class="grid gap-5 sm:grid-cols-3">
        <x-form.field label="Display order" name="sort_order" hint="Lower numbers appear first.">
            <x-form.input name="sort_order" type="number" min="0" max="999" :value="$testimonial->sort_order ?? 0" />
        </x-form.field>

        <div class="sm:col-span-2 sm:flex sm:items-end">
            <div class="w-full rounded-lg border border-line bg-surface-warm p-4">
                <x-form.checkbox name="is_published" :checked="$testimonial->is_published">
                    Publish this testimonial
                </x-form.checkbox>
            </div>
        </div>
    </div>
</div>
