<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

final class ImageSource
{
    /**
     * Resolve a stored image path to a public URL.
     *
     * Returns null when the file is missing so callers can render a flat
     * placeholder instead of a browser's broken-image icon.
     */
    public static function url(?string $src, bool $asset = false, string $disk = 'public'): ?string
    {
        $src = $src === null ? '' : trim($src);

        if ($src === '') {
            return null;
        }

        if (str_starts_with($src, 'data:') || preg_match('#^(https?:)?//#i', $src) === 1) {
            return $src;
        }

        $path = ltrim($src, '/');

        if ($asset) {
            return file_exists(public_path($path)) ? asset($path) : null;
        }

        $storage = Storage::disk($disk);

        return $storage->exists($path) ? $storage->url($path) : null;
    }

    /**
     * Read the pixel dimensions of a stored image.
     *
     * Returns null for remote URLs and for files that are missing or are not
     * readable images, so callers can leave the corresponding meta tags out
     * rather than publish a size that does not match the file.
     *
     * @return array{0: int, 1: int}|null
     */
    public static function dimensions(?string $src, bool $asset = false, string $disk = 'public'): ?array
    {
        $src = $src === null ? '' : trim($src);

        if ($src === '' || str_starts_with($src, 'data:') || preg_match('#^(https?:)?//#i', $src) === 1) {
            return null;
        }

        $path = $asset
            ? public_path(ltrim($src, '/'))
            : Storage::disk($disk)->path(ltrim($src, '/'));

        if (! self::looksLikeImage($path)) {
            return null;
        }

        $size = getimagesize($path);

        if ($size === false || $size[0] < 1 || $size[1] < 1) {
            return null;
        }

        return [(int) $size[0], (int) $size[1]];
    }

    /**
     * Check the file header before handing the path to getimagesize().
     *
     * A record can point at a file that never finished uploading, so the bytes
     * may not be an image at all. Reading the signature first keeps a corrupt
     * upload from raising a PHP warning (and from breaking the page).
     */
    private static function looksLikeImage(string $path): bool
    {
        if (! is_file($path) || ! is_readable($path)) {
            return false;
        }

        $handle = fopen($path, 'rb');

        if ($handle === false) {
            return false;
        }

        try {
            $header = fread($handle, 12);
        } finally {
            fclose($handle);
        }

        if (! is_string($header) || strlen($header) < 12) {
            return false;
        }

        $signatures = [
            "\xFF\xD8\xFF",                 // JPEG
            "\x89PNG\r\n\x1A\n",            // PNG
            'GIF87a',                       // GIF
            'GIF89a',                       // GIF
            'BM',                           // BMP
        ];

        foreach ($signatures as $signature) {
            if (str_starts_with($header, $signature)) {
                return true;
            }
        }

        // WebP: "RIFF" + 4 size bytes + "WEBP".
        return str_starts_with($header, 'RIFF') && substr($header, 8, 4) === 'WEBP';
    }
}
