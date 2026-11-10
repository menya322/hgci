<?php

namespace Database\Factories;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TeamMember>
 */
class TeamMemberFactory extends Factory
{
    protected $model = TeamMember::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
            'role' => fake()->jobTitle(),
            'bio' => fake()->paragraphs(2, true),
            'photo' => null,
            'is_published' => true,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
