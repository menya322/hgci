@php
    $categoryOptions = [
        'livelihood' => 'Livelihood',
        'education' => 'Education',
        'health' => 'Health',
        'relief' => 'Relief',
        'sponsorship' => 'Sponsorship',
    ];
@endphp

<div class="space-y-5">
    <x-form.field label="Title" name="title" required>
        <x-form.input name="title" :value="$project->title" required />
    </x-form.field>

    <div class="grid gap-5 sm:grid-cols-2">
        <x-form.field label="Program" name="program_id" hint="Optional. Links this project to a program.">
            <x-form.select name="program_id" :options="$programs" placeholder="No program" :selected="$project->program_id" />
        </x-form.field>

        <x-form.field label="Category" name="category">
            <x-form.select name="category" :options="$categoryOptions" :selected="$project->category" />
        </x-form.field>
    </div>

    <x-form.field label="Short summary" name="summary" hint="Shown on project cards. Around 1–2 sentences.">
        <x-form.textarea name="summary" rows="3" :value="$project->summary" />
    </x-form.field>

    <x-form.field label="Description" name="description" hint="Plain text. Separate paragraphs with a blank line.">
        <x-form.textarea name="description" rows="8" :value="$project->description" />
    </x-form.field>

    <div class="grid gap-5 sm:grid-cols-2">
        <x-admin.image-input name="image" label="Project image" :current="$project->image" :alt="$project->image_alt ?? $project->title" />

        <x-form.field label="Image description" name="image_alt" hint="Describe the photo for screen readers.">
            <x-form.input name="image_alt" :value="$project->image_alt" />
        </x-form.field>
    </div>

    <div class="grid gap-5 sm:grid-cols-3">
        <x-form.field label="Beneficiaries" name="beneficiaries_count" hint="Optional. Number of people reached.">
            <x-form.input name="beneficiaries_count" type="number" min="0" max="1000000" :value="$project->beneficiaries_count" />
        </x-form.field>

        <x-form.field label="Display order" name="sort_order" hint="Lower numbers appear first.">
            <x-form.input name="sort_order" type="number" min="0" max="999" :value="$project->sort_order ?? 0" />
        </x-form.field>

        <div class="sm:flex sm:items-end">
            <div class="w-full rounded-lg border border-line bg-surface-warm p-4">
                <x-form.checkbox name="is_published" :checked="$project->is_published">
                    Publish this project
                </x-form.checkbox>
            </div>
        </div>
    </div>
</div>
