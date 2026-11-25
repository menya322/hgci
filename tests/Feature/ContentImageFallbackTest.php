<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\Project;
use App\Models\User;
use App\Support\ContentImages;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Content photography on the programs and impact pages.
 *
 * The rule under test: an image uploaded through the admin panel always wins,
 * a bundled photo under public/images is the fallback, and when neither exists
 * the page shows the "[ADD: photo]" placeholder rather than a broken frame.
 */
class ContentImageFallbackTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_program_cards_on_the_index_page_use_the_bundled_photo(): void
    {
        $response = $this->get('/programs');

        $response->assertOk()
            ->assertSee(asset('images/programs/education.jpg'), false)
            ->assertSee(asset('images/programs/health-nutrition.jpg'), false)
            ->assertSee(asset('images/programs/food-relief.jpg'), false)
            ->assertSee(asset('images/programs/child-sponsorship.jpg'), false);
    }

    public function test_program_detail_page_shows_the_bundled_photo(): void
    {
        $this->get('/programs/education')
            ->assertOk()
            ->assertSee(asset('images/programs/education.jpg'), false);
    }

    public function test_uploaded_program_image_replaces_the_bundled_photo(): void
    {
        Storage::fake('public');

        $program = Program::query()->where('slug', 'education')->firstOrFail();
        $program->update([
            'image' => 'programs/uploaded-education.jpg',
            'image_alt' => 'An uploaded education photo.',
        ]);

        Storage::disk('public')->put('programs/uploaded-education.jpg', 'fake-image');

        $response = $this->get('/programs');

        $response->assertOk()
            ->assertSee(Storage::disk('public')->url('programs/uploaded-education.jpg'), false)
            ->assertSee('An uploaded education photo.')
            ->assertDontSee(asset('images/programs/education.jpg'), false);
    }

    public function test_program_without_a_photo_falls_back_to_the_placeholder(): void
    {
        $program = Program::factory()->create([
            'title' => 'Clean Water',
            'slug' => 'clean-water',
            'image' => null,
            'sort_order' => 50,
        ]);

        $response = $this->get('/programs');

        $response->assertOk()
            ->assertSee('[ADD: clean water photo]')
            ->assertSee('Photo of Clean Water to be added.');
    }

    public function test_project_features_on_the_impact_page_render_their_photos(): void
    {
        $response = $this->get('/impact');

        $response->assertOk()
            ->assertSee(asset('images/projects/food-relief.jpg'), false)
            ->assertSee('id="project-piggery"', false)
            ->assertSee('id="project-cow-rearing"', false)
            ->assertSee('id="project-goat-rearing"', false);
    }

    public function test_impact_page_keeps_a_placeholder_for_projects_without_photos(): void
    {
        $response = $this->get('/impact');

        $response->assertOk()
            ->assertSee('[ADD: piggery photo]')
            ->assertSee('[ADD: cow rearing photo]')
            ->assertSee('[ADD: goat rearing photo]')
            ->assertSee('Photo of Piggery to be added.')
            ->assertSee('[ADD: project photo]');
    }

    public function test_uploaded_project_image_replaces_the_bundled_photo(): void
    {
        Storage::fake('public');

        $project = Project::query()->where('slug', 'food-relief-project')->firstOrFail();
        $project->update([
            'image' => 'projects/uploaded-food-relief.jpg',
            'image_alt' => 'An uploaded food relief photo.',
        ]);

        Storage::disk('public')->put('projects/uploaded-food-relief.jpg', 'fake-image');

        $this->get('/impact')
            ->assertOk()
            ->assertSee(Storage::disk('public')->url('projects/uploaded-food-relief.jpg'), false)
            ->assertSee('An uploaded food relief photo.');
    }

    public function test_admin_upload_flow_stores_a_program_photo_that_then_renders(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $program = Program::query()->where('slug', 'education')->firstOrFail();

        $this->actingAs($admin)
            ->put('/admin/programs/'.$program->slug, [
                'title' => $program->title,
                'icon' => $program->icon,
                'image' => UploadedFile::fake()->image('education.jpg', 800, 500),
                'image_alt' => 'A brand new education photo from the admin panel.',
                'is_published' => '1',
                'sort_order' => 1,
            ])
            ->assertRedirect();

        $program->refresh();
        $this->assertNotNull($program->image);

        $this->get('/programs')
            ->assertOk()
            ->assertSee('A brand new education photo from the admin panel.');
    }

    public function test_content_images_helper_returns_an_empty_slot_for_an_unknown_slug(): void
    {
        $program = Program::factory()->create([
            'title' => 'Unlisted Programme',
            'slug' => 'unlisted-programme',
            'image' => null,
        ]);

        $image = ContentImages::program($program);

        $this->assertNull($image['src']);
        $this->assertSame('[ADD: unlisted programme photo]', $image['label']);
        $this->assertSame('Photo of Unlisted Programme to be added.', $image['alt']);
    }
}
