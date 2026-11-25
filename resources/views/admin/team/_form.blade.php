<div class="space-y-5">
    <div class="grid gap-5 sm:grid-cols-2">
        <x-form.field label="Full name" name="name" required>
            <x-form.input name="name" :value="$member->name" required />
        </x-form.field>

        <x-form.field label="Role" name="role">
            <x-form.input name="role" :value="$member->role" />
        </x-form.field>
    </div>

    <x-form.field label="Short biography" name="bio" hint="Plain text. Separate paragraphs with a blank line.">
        <x-form.textarea name="bio" rows="6" :value="$member->bio" />
    </x-form.field>

    <x-admin.image-input name="photo" label="Photo" :current="$member->photo" :alt="$member->name" />

    <div class="grid gap-5 sm:grid-cols-3">
        <x-form.field label="Display order" name="sort_order" hint="Lower numbers appear first.">
            <x-form.input name="sort_order" type="number" min="0" max="999" :value="$member->sort_order ?? 0" />
        </x-form.field>

        <div class="sm:col-span-2 sm:flex sm:items-end">
            <div class="w-full rounded-lg border border-line bg-surface-warm p-4">
                <x-form.checkbox name="is_published" :checked="$member->is_published">
                    Publish this team member on the about page
                </x-form.checkbox>
            </div>
        </div>
    </div>
</div>
