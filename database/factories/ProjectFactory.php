<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'program_id' => Program::factory(),
            'title' => fake()->unique()->sentence(3),
            'summary' => fake()->sentence(14),
            'description' => fake()->paragraphs(3, true),
            'image' => null,
            'image_alt' => null,
            'category' => fake()->randomElement(['livelihood', 'relief', 'education', 'health']),
            'beneficiaries_count' => fake()->numberBetween(10, 500),
            'is_published' => true,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
