<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryImageMoveRequest;
use App\Http\Requests\Admin\GalleryImageUpdateRequest;
use App\Http\Requests\Admin\GalleryImageUploadRequest;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GalleryImageController extends Controller
{
    public function index(GalleryAlbum $album): View
    {
        return view('admin.gallery.images', [
            'album' => $album,
            'images' => $album->images()->get(),
        ]);
    }

    public function store(GalleryImageUploadRequest $request, GalleryAlbum $album): RedirectResponse
    {
        $directory = public_path('images/gallery/uploads/'.$album->id);
        File::ensureDirectoryExists($directory);

        $nextOrder = (int) ($album->images()->max('sort_order') ?? 0) + 1;
        $count = 0;
        $firstPath = null;

        foreach ($request->file('images') as $file) {
            $base = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $name = ($base !== '' ? $base : 'photo').'-'.Str::lower(Str::random(8)).'.'.Str::lower($file->extension());

            $file->move($directory, $name);

            $path = 'images/gallery/uploads/'.$album->id.'/'.$name;

            $album->images()->create([
                'image' => $path,
                'sort_order' => $nextOrder++,
            ]);

            $firstPath ??= $path;
            $count++;
        }

        if (! $album->cover_image && $firstPath) {
            $album->forceFill(['cover_image' => $firstPath])->save();
        }

        return redirect()
            ->route('admin.gallery.images.index', $album)
            ->with('status', $count.' '.Str::plural('photo', $count).' uploaded.');
    }

    public function update(GalleryImageUpdateRequest $request, GalleryAlbum $album, GalleryImage $image): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $image->update($data);

        return redirect()
            ->route('admin.gallery.images.index', $album)
            ->with('status', 'Photo details updated.');
    }

    public function cover(GalleryAlbum $album, GalleryImage $image): RedirectResponse
    {
        $album->forceFill(['cover_image' => $image->image])->save();

        return redirect()
            ->route('admin.gallery.images.index', $album)
            ->with('status', 'Album cover updated.');
    }

    public function move(GalleryImageMoveRequest $request, GalleryAlbum $album, GalleryImage $image): RedirectResponse
    {
        $images = $album->images()->get()->values();
        $index = $images->search(fn (GalleryImage $item) => $item->is($image));

        if ($index === false) {
            return redirect()
                ->route('admin.gallery.images.index', $album)
                ->with('status', 'That photo could not be found in this album.');
        }

        $target = $request->string('direction')->toString() === 'up' ? $index - 1 : $index + 1;

        if ($target < 0 || $target >= $images->count()) {
            return redirect()
                ->route('admin.gallery.images.index', $album)
                ->with('status', 'That photo is already at the edge of the album.');
        }

        $ordered = $images->all();
        [$ordered[$index], $ordered[$target]] = [$ordered[$target], $ordered[$index]];

        foreach ($ordered as $position => $item) {
            $item->forceFill(['sort_order' => $position + 1])->save();
        }

        return redirect()
            ->route('admin.gallery.images.index', $album)
            ->with('status', 'Photo order updated.');
    }

    public function destroy(GalleryAlbum $album, GalleryImage $image): RedirectResponse
    {
        if (str_starts_with((string) $image->image, 'images/gallery/uploads/')) {
            File::delete(public_path($image->image));
        }

        $image->delete();

        if ($album->cover_image === $image->image) {
            $next = $album->images()->first();
            $album->forceFill(['cover_image' => $next?->image])->save();
        }

        return redirect()
            ->route('admin.gallery.images.index', $album)
            ->with('status', 'Photo deleted.');
    }
}
