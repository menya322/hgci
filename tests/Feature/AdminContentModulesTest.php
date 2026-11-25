<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Faq;
use App\Models\Project;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminContentModulesTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_all_new_admin_index_pages_load(): void
    {
        $this->actingAs($this->admin);

        $this->get('/admin/projects')->assertOk()->assertSee('Projects');
        $this->get('/admin/events')->assertOk()->assertSee('Events');
        $this->get('/admin/team')->assertOk()->assertSee('Team members');
        $this->get('/admin/testimonials')->assertOk()->assertSee('Testimonials');
        $this->get('/admin/faqs')->assertOk()->assertSee('FAQs');

        $this->get('/admin/projects/create')->assertOk();
        $this->get('/admin/events/create')->assertOk();
        $this->get('/admin/team/create')->assertOk();
        $this->get('/admin/testimonials/create')->assertOk();
        $this->get('/admin/faqs/create')->assertOk();
    }

    public function test_an_admin_can_create_a_project_that_appears_on_the_impact_page(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->post('/admin/projects', [
            'title' => 'Admin Created Project',
            'summary' => 'A project summary written in the admin panel.',
            'description' => 'A project description written in the admin panel.',
            'category' => 'livelihood',
            'beneficiaries_count' => 120,
            'sort_order' => 2,
            'is_published' => '1',
            'image' => UploadedFile::fake()->image('project.jpg', 800, 600),
        ]);

        $response->assertRedirect();

        $project = Project::where('slug', 'admin-created-project')->firstOrFail();

        $this->assertSame('admin-created-project', $project->slug);
        $this->assertSame(120, $project->beneficiaries_count);
        $this->assertNotNull($project->image);
        Storage::disk('public')->assertExists($project->image);

        $this->get('/impact')
            ->assertOk()
            ->assertSee('Admin Created Project');
    }

    public function test_an_admin_can_update_a_project_and_hide_it_from_the_public_site(): void
    {
        $project = Project::factory()->create(['is_published' => true]);

        $this->actingAs($this->admin)->put('/admin/projects/'.$project->slug, [
            'title' => $project->title,
            'category' => $project->category,
            'sort_order' => $project->sort_order,
        ])->assertRedirect();

        $project->refresh();

        $this->assertFalse($project->is_published);
        $this->get('/impact')->assertDontSee($project->title);
    }

    public function test_an_admin_can_create_an_event_that_appears_on_the_events_page(): void
    {
        $startsAt = now()->addWeek()->setTime(10, 0);

        $response = $this->actingAs($this->admin)->post('/admin/events', [
            'title' => 'Admin Created Event',
            'excerpt' => 'An event summary written in the admin panel.',
            'description' => 'An event description written in the admin panel.',
            'location' => 'Kampala',
            'starts_at' => $startsAt->format('Y-m-d\TH:i'),
            'ends_at' => $startsAt->copy()->addHours(2)->format('Y-m-d\TH:i'),
            'is_published' => '1',
        ]);

        $response->assertRedirect();

        $event = Event::where('slug', 'admin-created-event')->firstOrFail();

        $this->assertSame('Kampala', $event->location);
        $this->assertTrue($event->is_published);

        $this->get('/events')
            ->assertOk()
            ->assertSee('Admin Created Event');

        $this->get('/events/'.$event->slug)
            ->assertOk()
            ->assertSee('Admin Created Event')
            ->assertSee('An event description written in the admin panel.');
    }

    public function test_an_admin_can_create_a_team_member_that_appears_on_the_about_page(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/team', [
            'name' => 'Admin Created Member',
            'role' => 'Programme Officer',
            'bio' => 'A short biography written in the admin panel.',
            'sort_order' => 3,
            'is_published' => '1',
        ]);

        $response->assertRedirect();

        $member = TeamMember::where('slug', 'admin-created-member')->firstOrFail();
        $this->assertSame('Programme Officer', $member->role);

        $this->get('/about')
            ->assertOk()
            ->assertSee('Admin Created Member')
            ->assertSee('Programme Officer');
    }

    public function test_an_admin_can_create_a_testimonial(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/testimonials', [
            'name' => 'Admin Created Testimonial',
            'role' => 'Sponsor',
            'quote' => 'A quote written in the admin panel.',
            'sort_order' => 4,
            'is_published' => '1',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('testimonials', [
            'name' => 'Admin Created Testimonial',
            'role' => 'Sponsor',
            'is_published' => true,
            'sort_order' => 4,
        ]);

        $this->get('/admin/testimonials')
            ->assertOk()
            ->assertSee('Admin Created Testimonial');
    }

    public function test_an_admin_can_create_an_faq_that_appears_on_the_sponsor_page(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/faqs', [
            'question' => 'Admin created sponsorship question?',
            'answer' => 'An answer written in the admin panel.',
            'category' => 'sponsorship',
            'sort_order' => 5,
            'is_published' => '1',
        ]);

        $response->assertRedirect();

        $faq = Faq::where('question', 'Admin created sponsorship question?')->firstOrFail();
        $this->assertSame('sponsorship', $faq->category);

        $this->get('/sponsor')
            ->assertOk()
            ->assertSee('Admin created sponsorship question?')
            ->assertSee('An answer written in the admin panel.');
    }

    public function test_an_admin_can_delete_a_team_member(): void
    {
        $member = TeamMember::factory()->create();

        $this->actingAs($this->admin)
            ->delete('/admin/team/'.$member->slug)
            ->assertRedirect('/admin/team');

        $this->assertSoftDeleted('team_members', ['id' => $member->id]);
    }

    public function test_validation_rejects_invalid_entries_for_every_module(): void
    {
        $this->actingAs($this->admin);

        $this->from('/admin/projects/create')->post('/admin/projects', [
            'title' => '',
            'program_id' => 9999,
            'category' => 'not-a-category',
            'beneficiaries_count' => -5,
        ])->assertSessionHasErrors(['title', 'program_id', 'category', 'beneficiaries_count']);

        $this->from('/admin/events/create')->post('/admin/events', [
            'title' => '',
            'starts_at' => '',
            'ends_at' => 'not-a-date',
        ])->assertSessionHasErrors(['title', 'starts_at', 'ends_at']);

        $this->from('/admin/team/create')->post('/admin/team', [
            'name' => '',
            'sort_order' => 1000,
        ])->assertSessionHasErrors(['name', 'sort_order']);

        $this->from('/admin/testimonials/create')->post('/admin/testimonials', [
            'name' => '',
            'quote' => '',
        ])->assertSessionHasErrors(['name', 'quote']);

        $this->from('/admin/faqs/create')->post('/admin/faqs', [
            'question' => '',
            'answer' => '',
            'category' => 'not-a-category',
        ])->assertSessionHasErrors(['question', 'answer', 'category']);

        $this->assertDatabaseMissing('projects', ['title' => '']);
        $this->assertDatabaseMissing('events', ['title' => '']);
        $this->assertDatabaseMissing('team_members', ['name' => '']);
        $this->assertDatabaseMissing('testimonials', ['name' => '']);
        $this->assertDatabaseMissing('faqs', ['question' => '']);
    }

    public function test_image_uploads_reject_invalid_files_and_oversized_images(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin)->from('/admin/projects/create')
            ->post('/admin/projects', [
                'title' => 'Invalid upload project',
                'category' => 'livelihood',
                'image' => UploadedFile::fake()->create('notes.pdf', 100, 'application/pdf'),
            ])
            ->assertSessionHasErrors('image');

        $this->actingAs($this->admin)->from('/admin/projects/create')
            ->post('/admin/projects', [
                'title' => 'Oversized upload project',
                'category' => 'livelihood',
                'image' => UploadedFile::fake()->image('huge.jpg')->size(3000),
            ])
            ->assertSessionHasErrors('image');

        $this->assertDatabaseMissing('projects', ['title' => 'Invalid upload project']);
        $this->assertDatabaseMissing('projects', ['title' => 'Oversized upload project']);
    }

    public function test_non_admin_users_cannot_reach_the_new_modules(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get('/admin/projects')->assertForbidden();
        $this->actingAs($user)->get('/admin/events')->assertForbidden();
        $this->actingAs($user)->get('/admin/team')->assertForbidden();
        $this->actingAs($user)->get('/admin/testimonials')->assertForbidden();
        $this->actingAs($user)->get('/admin/faqs')->assertForbidden();
    }
}
