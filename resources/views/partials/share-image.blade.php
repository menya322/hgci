{{--
    Publishes a page's featured photograph as its social preview.

    Expects `shareImage` from ContentImages::shareImage(), which is null while
    the slot is still a placeholder. Setting nothing is deliberate: the SEO
    partial then uses the bundled default card.

    Every value is cast to a string because Blade's `@section('x', null)`
    treats a null second argument as the start of a section block, which would
    open an output buffer that is never closed.
--}}

@if (! empty($shareImage))
    @section('og_image', (string) $shareImage['url'])
    @section('og_image_alt', (string) $shareImage['alt'])

    @if (! empty($shareImage['width']) && ! empty($shareImage['height']))
        @section('og_image_width', (string) $shareImage['width'])
        @section('og_image_height', (string) $shareImage['height'])
    @endif
@endif
