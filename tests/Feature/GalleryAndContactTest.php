<?php

namespace Tests\Feature;

use App\Models\GalleryAlbum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryAndContactTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_gallery_index_lists_seeded_albums(): void
    {
        $response = $this->get('/gallery');

        $response->assertOk()
            ->assertSee('Life at HGCI')
            ->assertSee('Education & school support')
            ->assertSee('Health & hygiene')
            ->assertSee('Food relief')
            ->assertSee('Clothing & essentials')
            ->assertSee('Community care');
    }

    public function test_gallery_album_page_loads_with_photos_and_lightbox(): void
    {
        $response = $this->get('/gallery/health-hygiene');

        $response->assertOk()
            ->assertSee('Sanitary supplies prepared for students.')
            ->assertSee('4 photos')
            ->assertSee('Photo viewer')
            ->assertSee('sanitary-pads-in-classroom.jpeg');
    }

    public function test_gallery_grid_is_responsive_and_lazy_loads_every_thumbnail(): void
    {
        $response = $this->get('/gallery/health-hygiene');

        $html = $response->getContent();

        // One column on mobile, two at sm, three at lg.
        $this->assertStringContainsString('grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3', $html);

        // Every gallery thumbnail reserves its own space and loads lazily.
        $this->assertGreaterThanOrEqual(4, substr_count($html, 'aspect-[4/3] w-full object-cover'));
        $this->assertGreaterThanOrEqual(4, substr_count($html, 'loading="lazy"'));
        $this->assertGreaterThanOrEqual(4, substr_count($html, 'width="1200"'));
        $this->assertGreaterThanOrEqual(4, substr_count($html, 'height="900"'));
    }

    public function test_gallery_captions_are_visible_without_hovering(): void
    {
        $html = $this->get('/gallery/health-hygiene')->getContent();

        // The caption sits in the card body, not in a hover-only overlay.
        $this->assertStringContainsString('border-t border-line px-4 py-3', $html);

        foreach ([
            'Sanitary supplies prepared for students.',
            'Unloading hygiene supplies for a school distribution.',
            'Students with sanitary supplies in class.',
            'Children beside a local water point.',
        ] as $caption) {
            $this->assertStringContainsString($caption, $html);
        }
    }

    public function test_gallery_album_counts_only_photos_whose_file_exists(): void
    {
        $album = GalleryAlbum::query()->where('slug', 'health-hygiene')->firstOrFail();

        $album->images()->create([
            'image' => 'images/gallery/health-hygiene/missing-file.jpg',
            'caption' => 'A photo whose file was removed.',
            'sort_order' => 99,
        ]);

        $response = $this->get('/gallery/health-hygiene');

        $response->assertOk()
            ->assertSee('4 photos')
            ->assertDontSee('missing-file.jpg')
            ->assertDontSee('A photo whose file was removed.');
    }

    public function test_unpublished_gallery_album_returns_404(): void
    {
        GalleryAlbum::factory()->create([
            'title' => 'Hidden album',
            'slug' => 'hidden-album',
            'is_published' => false,
        ]);

        $this->get('/gallery/hidden-album')->assertNotFound();
    }

    public function test_unknown_gallery_album_returns_404(): void
    {
        $this->get('/gallery/not-an-album')->assertNotFound();
    }

    public function test_contact_page_loads_with_form_and_details(): void
    {
        $response = $this->get('/contact');

        $response->assertOk()
            ->assertSee('We would love to hear from you')
            ->assertSee('Send a message')
            ->assertSee('Prayer requests')
            ->assertSee('[ADD: map and exact location]')
            ->assertSee('community-home-visit.jpeg');
    }

    public function test_contact_form_stores_a_message(): void
    {
        $response = $this->from('/contact')->post('/contact', [
            'name' => 'Test Supporter',
            'email' => 'supporter@example.com',
            'phone' => '+256 700 000000',
            'subject' => 'sponsorship',
            'message' => 'I would like to sponsor a child.',
            'consent' => '1',
        ]);

        $response->assertRedirect('/contact')
            ->assertSessionHas('status');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Test Supporter',
            'email' => 'supporter@example.com',
            'subject' => 'sponsorship',
            'status' => 'new',
        ]);
    }

    public function test_contact_form_rejects_invalid_submissions(): void
    {
        $response = $this->from('/contact')->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'subject' => 'unknown-subject',
            'message' => '',
        ]);

        $response->assertRedirect('/contact')
            ->assertSessionHasErrors(['name', 'email', 'subject', 'message', 'consent']);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_contact_form_rejects_honeypot_submissions(): void
    {
        $response = $this->from('/contact')->post('/contact', [
            'name' => 'Spam Bot',
            'email' => 'spam@example.com',
            'subject' => 'general',
            'message' => 'This should not be stored.',
            'consent' => '1',
            'website' => 'https://spam.example.com',
        ]);

        $response->assertRedirect('/contact')
            ->assertSessionHasErrors('website');

        $this->assertDatabaseCount('contact_messages', 0);
    }
}
