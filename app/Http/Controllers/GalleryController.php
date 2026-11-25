<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GalleryController extends Controller
{
    public function index(): View
    {
        $albums = GalleryAlbum::query()
            ->published()
            ->ordered()
            ->withCount('images')
            ->get();

        $previewImages = $albums
            ->map(fn (GalleryAlbum $album) => $album->images()->skip(1)->first() ?? $album->images()->first())
            ->filter()
            ->values();

        return view('gallery.index', [
            'albums' => $albums,
            'previewImages' => $previewImages,
        ]);
    }

    public function show(GalleryAlbum $album): View
    {
        if (! $album->is_published) {
            throw new NotFoundHttpException;
        }

        $images = $album->images()->get();

        $otherAlbums = GalleryAlbum::query()
            ->published()
            ->ordered()
            ->whereKeyNot($album->getKey())
            ->limit(3)
            ->get();

        return view('gallery.show', [
            'album' => $album,
            'images' => $images,
            'otherAlbums' => $otherAlbums,
        ]);
    }
}
