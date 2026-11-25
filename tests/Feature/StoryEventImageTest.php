<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Post;
use App\Models\TeamMember;
use App\Models\User;
use App\Support\ContentImages;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Photography on stories, events, the team section and the supporting pages.
 *
 * The rule under test is the same one used for programs and projects: an
 * uploaded image wins, a bundled photo is the fallback, and a placeholder
 * appears when neither exists — never a broken frame and never alt text that
 * describes a photo that is not there.
 */
class StoryEventImageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_story_cards_use_the_bundled_photo_for_their_category(): void
    {
        $response = $this->get('/news');

        $response->assertOk()
            ->assertSee(asset('images/posts/featured-story.jpg'), false)
            ->assertSee(asset('images/gallery/health-hygiene/students-with-sanitary-supplies.jpeg'), false)
            ->assertSee(asset('images/programs/livelihood.jpg'), false);
    }

    public function test_story_article_shows_the_bundled_photo(): void
    {
        $this->get('/news/add-story-education-update')
            ->assertOk()
            ->assertSee(asset('images/posts/featured-story.jpg'), false);
    }

    public function test_a_story_without_a_matching_photo_gets_a_labelled_placeholder(): void
    {
        Post::factory()->create([
            'title' => 'A brand new story',
            'slug' => 'a-brand-new-story',
            'category' => 'announcement',
            'featured_image' => null,
            'published_at' => now()->subDay(),
        ]);

        $this->get('/news')
            ->assertOk()
            ->assertSee('[ADD: story photo]')
            ->assertSee('Photo of A brand new story to be added.');
    }

    public function test_uploaded_story_image_replaces_the_bundled_photo(): void
    {
        Storage::fake('public');

        $post = Post::query()->where('slug', 'add-story-education-update')->firstOrFail();
        $post->update([
            'featured_image' => 'posts/uploaded-story.jpg',
            'image_alt' => 'An uploaded story photo.',
        ]);

        Storage::disk('public')->put('posts/uploaded-story.jpg', 'fake-image');

        $this->get('/news')
            ->assertOk()
            ->assertSee(Storage::disk('public')->url('posts/uploaded-story.jpg'), false)
            ->assertSee('An uploaded story photo.');
    }

    public function test_event_cards_and_detail_pages_show_their_photos(): void
    {
        $this->get('/events')
            ->assertOk()
            ->assertSee(asset('images/gallery/community-care/sitting-with-family.jpeg'), false)
            ->assertSee(asset('images/programs/child-sponsorship.jpg'), false);

        $this->get('/events/add-event-community-outreach')
            ->assertOk()
            ->assertSee(asset('images/gallery/community-care/sitting-with-family.jpeg'), false);
    }

    public function test_an_event_without_a_bundled_photo_shows_a_labelled_placeholder(): void
    {
        Event::factory()->create([
            'title' => 'A brand new event',
            'slug' => 'a-brand-new-event',
            'image' => null,
        ]);

        $this->get('/events')
            ->assertOk()
            ->assertSee('[ADD: event photo]')
            ->assertSee('Photo of A brand new event to be added.');
    }

    public function test_uploaded_event_image_replaces_the_bundled_photo(): void
    {
        Storage::fake('public');

        $event = Event::query()->where('slug', 'add-event-community-outreach')->firstOrFail();
        $event->update([
            'image' => 'events/uploaded-event.jpg',
            'image_alt' => 'An uploaded event photo.',
        ]);

        Storage::disk('public')->put('events/uploaded-event.jpg', 'fake-image');

        $this->get('/events/add-event-community-outreach')
            ->assertOk()
            ->assertSee(Storage::disk('public')->url('events/uploaded-event.jpg'), false)
            ->assertSee('An uploaded event photo.');
    }

    public function test_team_members_render_their_photo_and_a_placeholder_without_one(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('team/leader.jpg', 'fake-image');

        TeamMember::factory()->create([
            'name' => 'Grace Namutebi',
            'photo' => 'team/leader.jpg',
            'sort_order' => 1,
        ]);

        TeamMember::factory()->create([
            'name' => 'Samuel Okello',
            'photo' => null,
            'sort_order' => 2,
        ]);

        $this->get('/about')
            ->assertOk()
            ->assertSee(Storage::disk('public')->url('team/leader.jpg'), false)
            ->assertSee('Grace Namutebi')
            ->assertSee('[ADD: team photo]')
            ->assertSee('Photo of Samuel Okello to be added.');
    }

    public function test_admin_uploads_for_stories_events_and_team_reach_the_public_pages(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $post = Post::query()->where('slug', 'add-story-education-update')->firstOrFail();
        $event = Event::query()->where('slug', 'add-event-community-outreach')->firstOrFail();

        $this->actingAs($admin)
            ->put('/admin/posts/'.$post->slug, [
                'title' => $post->title,
                'excerpt' => $post->excerpt,
                'body' => $post->body,
                'category' => $post->category,
                'featured_image' => UploadedFile::fake()->image('story.jpg', 800, 600),
                'image_alt' => 'A story photo uploaded by an administrator.',
                'published_at' => now()->subDay()->format('Y-m-d H:i:s'),
            ])
            ->assertRedirect();

        $this->actingAs($admin)
            ->put('/admin/events/'.$event->slug, [
                'title' => $event->title,
                'excerpt' => $event->excerpt,
                'description' => $event->description,
                'location' => $event->location,
                'starts_at' => $event->starts_at->format('Y-m-d H:i:s'),
                'ends_at' => $event->ends_at->format('Y-m-d H:i:s'),
                'image' => UploadedFile::fake()->image('event.jpg', 800, 600),
                'image_alt' => 'An event photo uploaded by an administrator.',
                'is_published' => '1',
            ])
            ->assertRedirect();

        $this->actingAs($admin)
            ->post('/admin/team', [
                'name' => 'Joy Atim',
                'role' => 'Programme coordinator',
                'photo' => UploadedFile::fake()->image('team.jpg', 800, 600),
                'is_published' => '1',
                'sort_order' => 1,
            ])
            ->assertRedirect();

        $this->get('/news')
            ->assertOk()
            ->assertSee('A story photo uploaded by an administrator.');

        $this->get('/events')
            ->assertOk()
            ->assertSee('An event photo uploaded by an administrator.');

        $this->get('/about')
            ->assertOk()
            ->assertSee('Joy Atim');
    }

    public function test_story_and_event_uploads_still_reject_invalid_files(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $post = Post::query()->where('slug', 'add-story-education-update')->firstOrFail();
        $event = Event::query()->where('slug', 'add-event-community-outreach')->firstOrFail();

        $this->actingAs($admin)
            ->put('/admin/posts/'.$post->slug, [
                'title' => $post->title,
                'featured_image' => UploadedFile::fake()->create('notes.pdf', 100, 'application/pdf'),
            ])
            ->assertSessionHasErrors('featured_image');

        $this->actingAs($admin)
            ->put('/admin/posts/'.$post->slug, [
                'title' => $post->title,
                'featured_image' => UploadedFile::fake()->image('huge.jpg')->size(3000),
            ])
            ->assertSessionHasErrors('featured_image');

        $this->actingAs($admin)
            ->put('/admin/events/'.$event->slug, [
                'title' => $event->title,
                'starts_at' => $event->starts_at->format('Y-m-d H:i:s'),
                'image' => UploadedFile::fake()->create('notes.pdf', 100, 'application/pdf'),
            ])
            ->assertSessionHasErrors('image');
    }

    public function test_the_helper_reports_an_empty_slot_for_an_unknown_event_slug(): void
    {
        $event = Event::factory()->create([
            'title' => 'Unlisted gathering',
            'slug' => 'unlisted-gathering',
            'image' => null,
        ]);

        $image = ContentImages::event($event);

        $this->assertNull($image['src']);
        $this->assertSame('[ADD: event photo]', $image['label']);
        $this->assertSame('Photo of Unlisted gathering to be added.', $image['alt']);
    }
}
