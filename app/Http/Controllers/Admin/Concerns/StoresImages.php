<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

trait StoresImages
{
    /**
     * Store an uploaded image on the public disk and remove the replaced file.
     */
    protected function storeImage(
        FormRequest $request,
        string $field,
        string $directory,
        ?string $existing = null,
    ): ?string {
        if (! $request->hasFile($field)) {
            return $existing;
        }

        $path = $request->file($field)->store($directory, 'public');

        if ($existing) {
            Storage::disk('public')->delete($existing);
        }

        return $path;
    }
}
