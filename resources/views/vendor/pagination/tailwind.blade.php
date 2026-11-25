@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex flex-col gap-4 border-t border-line pt-6 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-muted">
            Showing
            <span class="font-semibold text-ink">{{ $paginator->firstItem() }}</span>
            to
            <span class="font-semibold text-ink">{{ $paginator->lastItem() }}</span>
            of
            <span class="font-semibold text-ink">{{ $paginator->total() }}</span>
        </p>

        <ul class="flex flex-wrap items-center gap-2">
            <li>
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" class="inline-flex min-h-11 items-center justify-center rounded-lg border border-line bg-surface-warm px-3 text-sm font-semibold text-muted">
                        Previous
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex min-h-11 items-center justify-center rounded-lg border border-line bg-surface px-3 text-sm font-semibold text-ink transition-colors hover:border-brand-teal hover:text-brand-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal">
                        Previous
                    </a>
                @endif
            </li>

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span aria-hidden="true" class="inline-flex size-11 items-center justify-center text-sm font-semibold text-muted">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" class="inline-flex size-11 items-center justify-center rounded-lg border border-brand-teal bg-brand-teal text-sm font-semibold text-white">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" aria-label="Go to page {{ $page }}" class="inline-flex size-11 items-center justify-center rounded-lg border border-line bg-surface text-sm font-semibold text-ink transition-colors hover:border-brand-teal hover:text-brand-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal">
                                    {{ $page }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach

            <li>
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex min-h-11 items-center justify-center rounded-lg border border-line bg-surface px-3 text-sm font-semibold text-ink transition-colors hover:border-brand-teal hover:text-brand-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal">
                        Next
                    </a>
                @else
                    <span aria-disabled="true" class="inline-flex min-h-11 items-center justify-center rounded-lg border border-line bg-surface-warm px-3 text-sm font-semibold text-muted">
                        Next
                    </span>
                @endif
            </li>
        </ul>
    </nav>
@endif
