<?php

namespace Database\Factories;

use App\Models\DonationPledge;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DonationPledge>
 */
class DonationPledgeFactory extends Factory
{
    protected $model = DonationPledge::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'amount' => fake()->randomFloat(2, 10000, 1000000),
            'currency' => 'UGX',
            'frequency' => fake()->randomElement(['one_time', 'monthly']),
            'method' => fake()->randomElement(['mobile_money', 'bank_transfer']),
            'message' => fake()->optional()->sentence(),
            'consent' => true,
            'status' => 'pending',
            'read_at' => null,
        ];
    }
}
