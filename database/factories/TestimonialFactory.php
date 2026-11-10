<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'role' => fake()->randomElement(['Sponsor', 'Volunteer', 'Community member', 'Parent']),
            'quote' => fake()->paragraphs(2, true),
            'photo' => null,
            'is_published' => true,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
