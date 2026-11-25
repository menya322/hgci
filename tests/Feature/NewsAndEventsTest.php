<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsAndEventsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_news_index_lists_published_posts(): void
    {
        $response = $this->get('/news');

        $response->assertOk()
            ->assertSee('Stories from the field')
            ->assertSee('education update')
            ->assertSee('health and nutrition update')
            ->assertSee('community livelihood update');
    }

    public function test_news_index_hides_draft_and_future_posts(): void
    {
        Post::factory()->draft()->create([
            'title' => 'Draft story',
            'slug' => 'draft-story',
        ]);

        Post::factory()->create([
            'title' => 'Scheduled story',
            'slug' => 'scheduled-story',
            'published_at' => now()->addDay(),
        ]);

        $response = $this->get('/news');

        $response->assertOk()
            ->assertDontSee('Draft story')
            ->assertDontSee('Scheduled story');
    }

    public function test_news_show_loads_a_published_story(): void
    {
        $response = $this->get('/news/add-story-education-update');

        $response->assertOk()
            ->assertSee('Back to all stories')
            ->assertSee('Sponsor a child')
            ->assertSee('[ADD: full story content about the education programme.]');
    }

    public function test_news_show_returns_404_for_draft_and_future_posts(): void
    {
        Post::factory()->draft()->create([
            'slug' => 'draft-story',
        ]);

        Post::factory()->create([
            'slug' => 'scheduled-story',
            'published_at' => now()->addDay(),
        ]);

        $this->get('/news/draft-story')->assertNotFound();
        $this->get('/news/scheduled-story')->assertNotFound();
    }

    public function test_news_show_returns_404_for_unknown_slug(): void
    {
        $this->get('/news/not-a-story')->assertNotFound();
    }

    public function test_news_index_pagination_renders_when_there_are_many_posts(): void
    {
        Post::factory()->count(10)->create([
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get('/news');

        $response->assertOk()
            ->assertSee('Next')
            ->assertSee('Go to page 2');
    }

    public function test_events_index_lists_upcoming_events(): void
    {
        $response = $this->get('/events');

        $response->assertOk()
            ->assertSee('Save the date')
            ->assertSee('community outreach')
            ->assertSee('sponsor and family visit');
    }

    public function test_events_index_shows_past_events_separately(): void
    {
        Event::factory()->past()->create([
            'title' => 'A recent community day',
            'slug' => 'recent-community-day',
        ]);

        $response = $this->get('/events');

        $response->assertOk()
            ->assertSee('Past events')
            ->assertSee('A recent community day');
    }

    public function test_event_show_loads_with_details(): void
    {
        $response = $this->get('/events/add-event-community-outreach');

        $response->assertSee('Event details')
            ->assertSee('[ADD: event location]')
            ->assertSee('Back to all events')
            ->assertOk();
    }

    public function test_unpublished_event_returns_404(): void
    {
        Event::factory()->create([
            'title' => 'Hidden event',
            'slug' => 'hidden-event',
            'is_published' => false,
        ]);

        $this->get('/events/hidden-event')->assertNotFound();
    }
}
