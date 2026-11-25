@if (session('status'))
    <div role="status" class="border-b border-brand-green bg-surface-warm">
        <div class="container-page flex items-start gap-3 py-4">
            <span class="inline-flex size-8 shrink-0 items-center justify-center rounded-md bg-brand-green text-ink">
                <x-icon name="check" class="size-5" />
            </span>
            <p class="text-sm font-medium leading-relaxed text-ink">{{ session('status') }}</p>
        </div>
    </div>
@endif
