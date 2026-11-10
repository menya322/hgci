<?php

namespace Tests\Feature;

use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_home_page_loads_with_seeded_content(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Every child deserves hope.')
            ->assertSee('Reach to the Poor of the Poorest.')
            ->assertSee('Programs that meet children where they are')
            ->assertSee('Education')
            ->assertSee('Piggery')
            ->assertSee('Life at HGCI')
            ->assertSee('Events and community days');
    }

    public function test_home_page_hides_unpublished_programs(): void
    {
        Program::factory()->unpublished()->create([
            'title' => 'Hidden Programme',
            'slug' => 'hidden-programme',
            'sort_order' => 99,
        ]);

        $response = $this->get('/');

        $response->assertOk()
            ->assertDontSee('Hidden Programme');
    }

    public function test_home_page_renders_when_no_programs_exist(): void
    {
        Program::query()->forceDelete();

        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Every child deserves hope.');
    }
}
