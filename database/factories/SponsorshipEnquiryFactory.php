<?php

namespace Database\Factories;

use App\Models\SponsorshipEnquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SponsorshipEnquiry>
 */
class SponsorshipEnquiryFactory extends Factory
{
    protected $model = SponsorshipEnquiry::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'country' => fake()->country(),
            'preferred_child_age' => fake()->randomElement(['0-5', '6-10', '11-15', '16-18', 'No preference']),
            'message' => fake()->paragraph(),
            'consent' => true,
            'status' => 'new',
            'read_at' => null,
        ];
    }
}
