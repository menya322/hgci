{{--
    Page title, meta description, canonical link and social sharing tags.

    Each page keeps one source of truth for its metadata: the `title` and
    `meta_description` sections. A page with a photograph of its own also sets
    the `og_image*` sections through partials/share-image.blade.php.

    og:image must always point at a file that exists, so a page only supplies
    `og_image` once ContentImages::shareImage() has resolved a real file. While
    a slot is still a placeholder the bundled default card is used instead of
    advertising an image that is not there.
--}}

@php
    $siteName = config('app.name');

    $defaultDescription = 'Hope In God Child Initiatives (HGCI) is a child sponsorship and Christian humanitarian aid organization transforming the lives of orphans and vulnerable children in Uganda.';

    // A 1200 x 630 crop of the hero photograph, used by pages without a
    // photograph of their own.
    $defaultImagePath = 'images/og/og-default.jpg';
    $defaultImageAlt = 'Students gathered outdoors with HGCI staff during a school support visit.';

    $pageTitle = trim((string) $__env->yieldContent('title'));
    $title = $pageTitle !== '' ? $pageTitle.' | '.$siteName : $siteName;

    $description = trim((string) $__env->yieldContent('meta_description')) ?: $defaultDescription;

    $canonical = url()->current();

    $ogType = trim((string) $__env->yieldContent('og_type')) ?: 'website';

    $ownImage = trim((string) $__env->yieldContent('og_image'));

    if ($ownImage !== '') {
        $ogImage = $ownImage;
        $ogImageAlt = trim((string) $__env->yieldContent('og_image_alt')) ?: $title;
        $ogImageWidth = (int) $__env->yieldContent('og_image_width');
        $ogImageHeight = (int) $__env->yieldContent('og_image_height');
    } else {
        $ogImage = asset($defaultImagePath);
        $ogImageAlt = $defaultImageAlt;

        $defaultDimensions = \App\Support\ImageSource::dimensions($defaultImagePath, true);
        $ogImageWidth = $defaultDimensions[0] ?? 0;
        $ogImageHeight = $defaultDimensions[1] ?? 0;
    }
@endphp

<title>{{ $title }}</title>

<meta name="description" content="{{ $description }}">

<link rel="canonical" href="{{ $canonical }}">

<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $ogImage }}">
@if ($ogImageWidth > 0 && $ogImageHeight > 0)
    <meta property="og:image:width" content="{{ $ogImageWidth }}">
    <meta property="og:image:height" content="{{ $ogImageHeight }}">
@endif
<meta property="og:image:alt" content="{{ $ogImageAlt }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $ogImage }}">
<meta name="twitter:image:alt" content="{{ $ogImageAlt }}">
