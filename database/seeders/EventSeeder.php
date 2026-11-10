<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'slug' => 'add-event-community-outreach',
                'title' => '[ADD: event title – community outreach day]',
                'location' => '[ADD: event location]',
                'starts_at' => now()->addDays(21)->setTime(10, 0),
                'ends_at' => now()->addDays(21)->setTime(14, 0),
                'excerpt' => '[ADD: short event summary for the events card.]',
                'description' => '[ADD: event details, programme and who is invited.]',
            ],
            [
                'slug' => 'add-event-sponsor-family-visit',
                'title' => '[ADD: event title – sponsor and family visit]',
                'location' => '[ADD: event location]',
                'starts_at' => now()->addDays(42)->setTime(9, 30),
                'ends_at' => now()->addDays(42)->setTime(15, 0),
                'excerpt' => '[ADD: short event summary for the events card.]',
                'description' => '[ADD: event details, programme and who is invited.]',
            ],
        ];

        foreach ($events as $event) {
            Event::updateOrCreate(
                ['slug' => $event['slug']],
                [
                    'title' => $event['title'],
                    'location' => $event['location'],
                    'starts_at' => $event['starts_at'],
                    'ends_at' => $event['ends_at'],
                    'excerpt' => $event['excerpt'],
                    'description' => $event['description'],
                    'is_published' => true,
                ],
            );
        }
    }
}
