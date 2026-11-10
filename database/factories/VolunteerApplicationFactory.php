<?php

namespace Database\Factories;

use App\Models\VolunteerApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VolunteerApplication>
 */
class VolunteerApplicationFactory extends Factory
{
    protected $model = VolunteerApplication::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'location' => fake()->city(),
            'skills' => fake()->sentence(12),
            'availability' => fake()->randomElement(['Weekdays', 'Weekends', 'Evenings', 'Flexible']),
            'motivation' => fake()->paragraph(),
            'consent' => true,
            'status' => 'new',
            'read_at' => null,
        ];
    }
}
