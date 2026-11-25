<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Post;
use App\Support\ContentImages;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SocialMetaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_every_public_page_has_a_description_canonical_and_social_card(): void
    {
        $paths = ['/', '/about', '/programs', '/programs/livelihood', '/impact', '/sponsor', '/donate', '/get-involved', '/news', '/events', '/gallery', '/contact'];

        foreach ($paths as $path) {
            $response = $this->get($path);

            $response->assertOk();

            $html = $response->getContent();

            $this->assertMatchesRegularExpression('/<title>[^<]+<\/title>/', $html, "Missing title on {$path}");
            $this->assertStringContainsString('<meta name="description" content="', $html, "Missing description on {$path}");
            $this->assertStringContainsString('<link rel="canonical" href="'.url($path).'">', $html, "Missing canonical on {$path}");
            $this->assertStringContainsString('property="og:image" content="'.asset('images/og/og-default.jpg').'"', $html, "Missing og:image on {$path}");
            $this->assertStringContainsString('name="twitter:image" content="'.asset('images/og/og-default.jpg').'"', $html, "Missing twitter:image on {$path}");
            $this->assertStringContainsString('<meta name="twitter:card" content="summary_large_image">', $html, "Missing twitter card on {$path}");
        }
    }

    public function test_default_social_card_file_exists_and_is_the_expected_size(): void
    {
        $path = public_path('images/og/og-default.jpg');

        $this->assertFileExists($path);

        $size = getimagesize($path);

        $this->assertSame(1200, $size[0]);
        $this->assertSame(630, $size[1]);
        $this->assertLessThanOrEqual(400 * 1024, filesize($path), 'Default social card should stay under 400 KB.');
    }

    public function test_story_page_uses_its_own_photo_as_the_social_preview(): void
    {
        $response = $this->get('/news/add-story-education-update');

        $response->assertOk()
            ->assertSee('property="og:image" content="'.asset('images/posts/featured-story.jpg').'"', false)
            ->assertSee('name="twitter:image" content="'.asset('images/posts/featured-story.jpg').'"', false)
            ->assertSee('property="og:type" content="article"', false)
            ->assertSee('property="og:image:width" content="1200"', false)
            ->assertSee('property="og:image:height" content="900"', false)
            ->assertSee('An HGCI staff member handing clothing to students in a school compound.');
    }

    public function test_event_page_uses_its_own_photo_as_the_social_preview(): void
    {
        $this->get('/events/add-event-community-outreach')
            ->assertOk()
            ->assertSee('property="og:image" content="'.asset('images/gallery/community-care/sitting-with-family.jpeg').'"', false)
            ->assertSee('property="og:image:width" content="1080"', false)
            ->assertSee('property="og:image:height" content="810"', false);
    }

    public function test_a_story_without_a_photo_falls_back_to_the_default_card(): void
    {
        Post::factory()->create([
            'title' => 'A story with no photograph',
            'slug' => 'a-story-with-no-photograph',
            'category' => 'announcement',
            'featured_image' => null,
            'published_at' => now()->subDay(),
        ]);

        $this->get('/news/a-story-with-no-photograph')
            ->assertOk()
            ->assertSee('property="og:image" content="'.asset('images/og/og-default.jpg').'"', false)
            ->assertDontSee('property="og:image" content="'.asset('images/posts/featured-story.jpg').'"', false);
    }

    public function test_an_event_without_a_photo_falls_back_to_the_default_card(): void
    {
        Event::factory()->create([
            'title' => 'An event with no photograph',
            'slug' => 'an-event-with-no-photograph',
            'image' => null,
            'starts_at' => now()->addWeek(),
        ]);

        $this->get('/events/an-event-with-no-photograph')
            ->assertOk()
            ->assertSee('property="og:image" content="'.asset('images/og/og-default.jpg').'"', false);
    }

    public function test_share_image_reads_real_dimensions_and_skips_placeholders(): void
    {
        $post = Post::query()->where('slug', 'add-story-education-update')->firstOrFail();

        $share = ContentImages::shareImage(ContentImages::post($post));

        $this->assertNotNull($share);
        $this->assertSame(asset('images/posts/featured-story.jpg'), $share['url']);
        $this->assertSame(1200, $share['width']);
        $this->assertSame(900, $share['height']);
        $this->assertNotSame('', $share['alt']);

        $empty = ContentImages::shareImage([
            'src' => null,
            'alt' => 'Photo of something to be added.',
            'asset' => false,
        ]);

        $this->assertNull($empty);
    }

    public function test_no_rendered_page_contains_an_image_without_alt_text(): void
    {
        $paths = ['/', '/about', '/programs', '/programs/livelihood', '/impact', '/sponsor', '/get-involved', '/news', '/events', '/gallery', '/gallery/community-care', '/contact'];

        foreach ($paths as $path) {
            $html = $this->get($path)->assertOk()->getContent();

            preg_match_all('#<img\b[^>]*>#is', $html, $matches);

            foreach ($matches[0] as $tag) {
                $this->assertMatchesRegularExpression(
                    '#\balt\s*=\s*"[^"]+"#i',
                    $tag,
                    "Image without descriptive alt text on {$path}: {$tag}",
                );
            }
        }
    }
}
