<?php

namespace Tests\Feature;

use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_about_page_loads(): void
    {
        $response = $this->get('/about');

        $response->assertOk()
            ->assertSee('Hope for every child, rooted in community')
            ->assertSee('Reach to the Poor of the Poorest.')
            ->assertSee('Our core values')
            ->assertSee('Love')
            ->assertSee('Team work')
            ->assertSee('Where we put our energy')
            ->assertSee('Team profiles are being prepared');
    }

    public function test_programs_index_lists_seeded_programs(): void
    {
        $response = $this->get('/programs');

        $response->assertOk()
            ->assertSee('Programs that meet children where they are')
            ->assertSee('Education')
            ->assertSee('Health &amp; Nutrition', false)
            ->assertSee('Livelihood')
            ->assertSee('Food Relief')
            ->assertSee('Child Sponsorship')
            ->assertSee('Piggery');
    }

    public function test_program_page_loads_with_related_projects(): void
    {
        $response = $this->get('/programs/livelihood');

        $response->assertOk()
            ->assertSee('How Livelihood supports children')
            ->assertSee('What this includes')
            ->assertSee('Piggery')
            ->assertSee('Cow Rearing')
            ->assertSee('Goat Rearing')
            ->assertSee('Other ways we serve children');
    }

    public function test_program_page_returns_404_for_unknown_slug(): void
    {
        $this->get('/programs/not-a-program')->assertNotFound();
    }

    public function test_unpublished_program_returns_404(): void
    {
        Program::factory()->unpublished()->create([
            'title' => 'Draft Programme',
            'slug' => 'draft-programme',
        ]);

        $this->get('/programs/draft-programme')->assertNotFound();
    }

    public function test_impact_page_loads_with_projects(): void
    {
        $response = $this->get('/impact');

        $response->assertOk()
            ->assertSee('Practical projects, lasting change')
            ->assertSee('Children reached')
            ->assertSee('Piggery')
            ->assertSee('Cow Rearing')
            ->assertSee('Goat Rearing')
            ->assertSee('Food Relief')
            ->assertSee('[ADD: fourth project]');
    }
}
