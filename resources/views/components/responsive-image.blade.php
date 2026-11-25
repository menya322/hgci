{{--
    Responsive content image with a reserved aspect-ratio frame.

    Usage:
        <x-responsive-image
            src="posts/example.jpg"
            alt="Children learning together"
            :width="1200"
            :height="750"
            ratio="16/10"
        />

    Required: alt, width, height.
    - Pass alt="" only for a purely decorative image.
    - width/height are the intrinsic pixels of the supplied file and reserve
      space before the image loads, preventing layout shift.
    - src is read from the public disk by default; add `asset` to resolve a
      file from public/ instead (e.g. gallery or static images).
    - A missing or empty src renders a flat placeholder, never a broken icon.
    - loading defaults to lazy; only the hero component should opt into eager.
    - focus nudges the crop so faces stay in frame: center, top, bottom,
      left, right, upper (25%) or lower (75%).
--}}

@props([
    'src' => null,
    'alt',
    'width',
    'height',
    'ratio' => '16/10',
    'label' => '[ADD: photo]',
    'asset' => false,
    'disk' => 'public',
    'srcset' => null,
    'sizes' => null,
    'loading' => 'lazy',
    'fetchpriority' => null,
    'focus' => 'center',
])

@php
    $ratios = [
        '16/9' => 'aspect-[16/9]',
        '16/10' => 'aspect-[16/10]',
        '3/2' => 'aspect-[3/2]',
        '4/3' => 'aspect-[4/3]',
        '1/1' => 'aspect-square',
        '4/5' => 'aspect-[4/5]',
        '3/4' => 'aspect-[3/4]',
        '21/9' => 'aspect-[21/9]',
    ];

    $normalisedRatio = str_replace(':', '/', (string) $ratio);
    $ratioClass = $ratios[$normalisedRatio] ?? $ratios['16/10'];

    $url = \App\Support\ImageSource::url($src, (bool) $asset, (string) $disk);
    $loading = in_array($loading, ['lazy', 'eager'], true) ? $loading : 'lazy';

    $focusClasses = [
        'center' => 'object-center',
        'top' => 'object-top',
        'bottom' => 'object-bottom',
        'left' => 'object-left',
        'right' => 'object-right',
        'upper' => 'object-[center_25%]',
        'lower' => 'object-[center_75%]',
    ];

    $focusClass = $focusClasses[$focus] ?? $focusClasses['center'];
@endphp

<div {{ $attributes->class(['relative overflow-hidden bg-surface-warm', $ratioClass]) }}>
    <span
        class="absolute inset-0 flex items-center justify-center p-4"
        @if ($url) aria-hidden="true" @else role="img" aria-label="{{ $alt }}" @endif
    >
        <span class="inline-flex items-center gap-2 rounded-md border border-dashed border-line bg-surface px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.15em] text-muted">
            <x-icon name="photo" class="size-4" />
            {{ $label }}
        </span>
    </span>

    @if ($url)
        <img
            src="{{ $url }}"
            alt="{{ $alt }}"
            width="{{ (int) $width }}"
            height="{{ (int) $height }}"
            loading="{{ $loading }}"
            decoding="async"
            @if ($fetchpriority) fetchpriority="{{ $fetchpriority }}" @endif
            @if ($srcset) srcset="{{ $srcset }}" @endif
            @if ($sizes) sizes="{{ $sizes }}" @endif
            class="absolute inset-0 h-full w-full object-cover {{ $focusClass }}"
            onerror="this.remove()"
        >
    @endif
</div>
