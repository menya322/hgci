<?php

namespace Database\Factories;

use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GalleryImage>
 */
class GalleryImageFactory extends Factory
{
    protected $model = GalleryImage::class;

    public function definition(): array
    {
        return [
            'gallery_album_id' => GalleryAlbum::factory(),
            'image' => 'gallery/'.fake()->uuid().'.jpg',
            'caption' => fake()->sentence(6),
            'alt_text' => fake()->sentence(10),
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
