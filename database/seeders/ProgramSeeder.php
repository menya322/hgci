<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            [
                'slug' => 'education',
                'title' => 'Education',
                'icon' => 'book-open',
                'excerpt' => 'Quality learning and vocational pathways that prepare children for responsible adulthood.',
                'description' => 'HGCI works to ensure that all children get quality education and develop into responsible adult citizens of Uganda. We support learning, work towards establishing quality and competitive education and vocational institutions, and help reduce illiteracy among children and the wider community.',
                'sort_order' => 1,
            ],
            [
                'slug' => 'health-nutrition',
                'title' => 'Health & Nutrition',
                'icon' => 'health',
                'excerpt' => 'Health awareness, nutrition and sanitation for cleaner, healthier homes and communities.',
                'description' => 'HGCI creates awareness on health, nutrition and sanitation so that children grow up in a clean and healthy environment. Our community-based approach promotes healthy habits among children, families and local leaders.',
                'sort_order' => 2,
            ],
            [
                'slug' => 'livelihood',
                'title' => 'Livelihood',
                'icon' => 'briefcase',
                'excerpt' => 'Piggery, cow rearing and goat rearing projects that strengthen household incomes.',
                'description' => 'Through piggery, cow rearing and goat rearing, HGCI supports households to build sustainable incomes and food security. Community members take an active part in projects that fight poverty at the household level.',
                'sort_order' => 3,
            ],
            [
                'slug' => 'food-relief',
                'title' => 'Food Relief',
                'icon' => 'bowl',
                'excerpt' => 'Food and basic necessities for orphans and vulnerable families during times of greatest need.',
                'description' => 'HGCI provides food and other basic necessities to orphans and vulnerable groups of people. Relief support helps families meet immediate needs while longer-term livelihood projects take root.',
                'sort_order' => 4,
            ],
            [
                'slug' => 'child-sponsorship',
                'title' => 'Child Sponsorship',
                'icon' => 'heart',
                'excerpt' => 'Consistent, personal support that walks with a child through school and into a hopeful future.',
                'description' => "Child sponsorship connects a sponsor with a child's education and wellbeing. Sponsorship helps provide food, quality education, healthcare and the basic necessities a child needs to thrive.",
                'sort_order' => 5,
            ],
        ];

        foreach ($programs as $program) {
            Program::updateOrCreate(
                ['slug' => $program['slug']],
                [
                    'title' => $program['title'],
                    'icon' => $program['icon'],
                    'excerpt' => $program['excerpt'],
                    'description' => $program['description'],
                    'is_published' => true,
                    'sort_order' => $program['sort_order'],
                ],
            );
        }
    }
}
