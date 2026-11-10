<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->where('is_admin', true)->first();

        $posts = [
            [
                'slug' => 'add-story-education-update',
                'title' => '[ADD: story title – education update]',
                'category' => 'education',
                'excerpt' => '[ADD: short story summary for the news card.]',
                'body' => "[ADD: full story content about the education programme.]\n\n[ADD: quote or detail from the community.]",
                'published_at' => now()->subDays(3),
                'is_featured' => true,
            ],
            [
                'slug' => 'add-story-health-nutrition-update',
                'title' => '[ADD: story title – health and nutrition update]',
                'category' => 'health',
                'excerpt' => '[ADD: short story summary for the news card.]',
                'body' => "[ADD: full story content about the health and nutrition programme.]\n\n[ADD: quote or detail from the community.]",
                'published_at' => now()->subDays(11),
                'is_featured' => false,
            ],
            [
                'slug' => 'add-story-livelihood-update',
                'title' => '[ADD: story title – community livelihood update]',
                'category' => 'livelihood',
                'excerpt' => '[ADD: short story summary for the news card.]',
                'body' => "[ADD: full story content about the livelihood projects.]\n\n[ADD: quote or detail from the community.]",
                'published_at' => now()->subDays(19),
                'is_featured' => false,
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(
                ['slug' => $post['slug']],
                [
                    'author_id' => $author?->id,
                    'title' => $post['title'],
                    'category' => $post['category'],
                    'excerpt' => $post['excerpt'],
                    'body' => $post['body'],
                    'is_featured' => $post['is_featured'],
                    'published_at' => $post['published_at'],
                ],
            );
        }
    }
}
