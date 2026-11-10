<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'author_id' => User::factory(),
            'title' => fake()->unique()->sentence(4),
            'excerpt' => fake()->sentence(18),
            'body' => fake()->paragraphs(6, true),
            'featured_image' => null,
            'image_alt' => null,
            'category' => fake()->randomElement(['news', 'story', 'update']),
            'is_featured' => false,
            'published_at' => fake()->dateTimeBetween('-2 months', 'now'),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => null,
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}
