<?php

namespace Database\Factories;

use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Program>
 */
class ProgramFactory extends Factory
{
    protected $model = Program::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [
            'title' => $title,
            'icon' => fake()->randomElement(['book-open', 'health', 'briefcase', 'bowl', 'heart']),
            'excerpt' => fake()->sentence(14),
            'description' => fake()->paragraphs(3, true),
            'image' => null,
            'image_alt' => null,
            'is_published' => true,
            'sort_order' => fake()->numberBetween(0, 10),
            'meta_title' => null,
            'meta_description' => null,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}
