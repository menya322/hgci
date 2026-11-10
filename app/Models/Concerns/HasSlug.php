<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::saving(function (self $model): void {
            $source = $model->slugSource();

            if (blank($model->slug) && filled($model->{$source})) {
                $model->slug = $model->makeUniqueSlug($model->{$source});
            }
        });
    }

    protected function slugSource(): string
    {
        return 'title';
    }

    protected function makeUniqueSlug(string $value): string
    {
        $base = Str::slug($value);

        if ($base === '') {
            $base = Str::lower(Str::random(8));
        }

        $slug = $base;
        $suffix = 2;

        while ($this->slugExists($slug)) {
            $slug = $base.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }

    protected function slugExists(string $slug): bool
    {
        $query = static::withTrashed()->where('slug', $slug);

        if ($this->exists) {
            $query->whereKeyNot($this->getKey());
        }

        return $query->exists();
    }
}
