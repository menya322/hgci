@php
    $categoryOptions = [
        'sponsorship' => 'Sponsorship',
        'donations' => 'Donations',
        'volunteering' => 'Volunteering',
        'general' => 'General',
    ];
@endphp

<div class="space-y-5">
    <x-form.field label="Question" name="question" required>
        <x-form.input name="question" :value="$faq->question" required />
    </x-form.field>

    <x-form.field label="Answer" name="answer" required>
        <x-form.textarea name="answer" rows="6" :value="$faq->answer" required />
    </x-form.field>

    <div class="grid gap-5 sm:grid-cols-3">
        <x-form.field label="Category" name="category">
            <x-form.select name="category" :options="$categoryOptions" placeholder="No category" :selected="$faq->category" />
        </x-form.field>

        <x-form.field label="Display order" name="sort_order" hint="Lower numbers appear first.">
            <x-form.input name="sort_order" type="number" min="0" max="999" :value="$faq->sort_order ?? 0" />
        </x-form.field>

        <div class="sm:flex sm:items-end">
            <div class="w-full rounded-lg border border-line bg-surface-warm p-4">
                <x-form.checkbox name="is_published" :checked="$faq->is_published">
                    Publish this FAQ
                </x-form.checkbox>
            </div>
        </div>
    </div>
</div>
