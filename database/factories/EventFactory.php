<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $startsAt = fake()->dateTimeBetween('+1 day', '+3 months');

        return [
            'title' => fake()->unique()->sentence(4),
            'excerpt' => fake()->sentence(16),
            'description' => fake()->paragraphs(3, true),
            'location' => fake()->city(),
            'starts_at' => $startsAt,
            'ends_at' => (clone $startsAt)->modify('+2 hours'),
            'image' => null,
            'image_alt' => null,
            'is_published' => true,
        ];
    }

    public function past(): static
    {
        return $this->state(function (array $attributes) {
            $startsAt = fake()->dateTimeBetween('-3 months', '-1 day');

            return [
                'starts_at' => $startsAt,
                'ends_at' => (clone $startsAt)->modify('+2 hours'),
            ];
        });
    }
}
