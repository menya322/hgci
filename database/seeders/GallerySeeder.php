<?php

namespace Database\Seeders;

use App\Models\GalleryAlbum;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $albums = [
            [
                'slug' => 'life-at-hgci',
                'title' => 'Life at HGCI',
                'description' => 'Moments from our programmes and community projects. [ADD: album description]',
                'sort_order' => 1,
                'images' => 3,
            ],
            [
                'slug' => 'add-album-title',
                'title' => '[ADD: album title]',
                'description' => '[ADD: album description]',
                'sort_order' => 2,
                'images' => 2,
            ],
        ];

        foreach ($albums as $data) {
            $album = GalleryAlbum::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'is_published' => true,
                    'sort_order' => $data['sort_order'],
                ],
            );

            if ($album->images()->doesntExist()) {
                for ($i = 1; $i <= $data['images']; $i++) {
                    $album->images()->create([
                        'image' => null,
                        'caption' => '[ADD: photo caption]',
                        'alt_text' => '[ADD: photo description]',
                        'sort_order' => $i,
                    ]);
                }
            }
        }
    }
}
