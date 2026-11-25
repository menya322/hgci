<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryAlbumRequest;
use App\Models\GalleryAlbum;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class GalleryAlbumController extends Controller
{
    public function index(): View
    {
        return view('admin.gallery.index', [
            'albums' => GalleryAlbum::query()->withCount('images')->ordered()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery.create', [
            'album' => new GalleryAlbum(['is_published' => true, 'sort_order' => 0]),
        ]);
    }

    public function store(GalleryAlbumRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $album = GalleryAlbum::create($data);

        return redirect()
            ->route('admin.gallery.images.index', $album)
            ->with('status', 'Album created. Upload the first photos below.');
    }

    public function edit(GalleryAlbum $album): View
    {
        $album->loadCount('images');

        return view('admin.gallery.edit', [
            'album' => $album,
        ]);
    }

    public function update(GalleryAlbumRequest $request, GalleryAlbum $album): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $album->update($data);

        return redirect()
            ->route('admin.gallery.edit', $album)
            ->with('status', 'Album updated.');
    }

    public function destroy(GalleryAlbum $album): RedirectResponse
    {
        $album->images()->delete();
        $album->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('status', 'Album moved to the trash.');
    }
}
