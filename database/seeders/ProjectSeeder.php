<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $livelihood = Program::query()->where('slug', 'livelihood')->firstOrFail();
        $foodRelief = Program::query()->where('slug', 'food-relief')->firstOrFail();

        $projects = [
            [
                'slug' => 'piggery',
                'title' => 'Piggery',
                'program_id' => $livelihood->id,
                'category' => 'livelihood',
                'summary' => 'A household livelihood project supported through HGCI\'s community-based approach.',
                'description' => 'The piggery project is one of the livelihood initiatives through which HGCI promotes active participation of community members in fighting poverty. [ADD: project details, location and outcomes]',
                'sort_order' => 1,
            ],
            [
                'slug' => 'cow-rearing',
                'title' => 'Cow Rearing',
                'program_id' => $livelihood->id,
                'category' => 'livelihood',
                'summary' => 'A livestock project that supports family income and food security.',
                'description' => 'Cow rearing is part of HGCI\'s livelihood work with communities in Uganda. [ADD: project details, location and outcomes]',
                'sort_order' => 2,
            ],
            [
                'slug' => 'goat-rearing',
                'title' => 'Goat Rearing',
                'program_id' => $livelihood->id,
                'category' => 'livelihood',
                'summary' => 'A community livelihood project that helps families build sustainable incomes.',
                'description' => 'Goat rearing is one of the livelihood and relief projects supported by HGCI. [ADD: project details, location and outcomes]',
                'sort_order' => 3,
            ],
            [
                'slug' => 'food-relief-project',
                'title' => 'Food Relief',
                'program_id' => $foodRelief->id,
                'category' => 'relief',
                'summary' => 'Food and basic necessities for orphans and vulnerable groups of people.',
                'description' => 'HGCI provides food and other basic necessities to orphans and vulnerable groups of people. [ADD: project details, location and outcomes]',
                'sort_order' => 4,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['slug' => $project['slug']],
                [
                    'program_id' => $project['program_id'],
                    'title' => $project['title'],
                    'summary' => $project['summary'],
                    'description' => $project['description'],
                    'category' => $project['category'],
                    'beneficiaries_count' => null,
                    'is_published' => true,
                    'sort_order' => $project['sort_order'],
                ],
            );
        }
    }
}
