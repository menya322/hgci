<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_guests_are_redirected_to_the_admin_login_page(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/posts')->assertRedirect('/admin/login');
        $this->get('/admin/programs')->assertRedirect('/admin/login');
    }

    public function test_non_admin_users_cannot_access_the_admin_area(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get('/admin')->assertForbidden();
        $this->actingAs($user)->get('/admin/posts')->assertForbidden();
    }

    public function test_an_admin_can_sign_in_and_reach_the_dashboard(): void
    {
        $admin = User::factory()->admin()->create(['password' => 'secret-password']);

        $response = $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'secret-password',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin);

        $this->get('/admin')
            ->assertOk()
            ->assertSee('Dashboard');
    }

    public function test_a_non_admin_account_is_not_allowed_to_sign_in(): void
    {
        $user = User::factory()->create(['is_admin' => false, 'password' => 'secret-password']);

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email' => $user->email,
            'password' => 'secret-password',
        ]);

        $response->assertRedirect('/admin/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        $admin = User::factory()->admin()->create();

        $this->from('/admin/login')->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_an_admin_can_create_a_post_and_see_it_on_the_public_site(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post('/admin/posts', [
            'title' => 'Admin Created Story',
            'excerpt' => 'A short summary written in the admin panel.',
            'body' => 'The full story body written in the admin panel.',
            'category' => 'story',
            'is_featured' => '1',
            'published_at' => now()->format('Y-m-d\TH:i'),
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('posts', [
            'title' => 'Admin Created Story',
            'slug' => 'admin-created-story',
            'author_id' => $admin->id,
            'is_featured' => true,
        ]);

        $post = Post::where('slug', 'admin-created-story')->firstOrFail();

        $this->get('/news')
            ->assertOk()
            ->assertSee('Admin Created Story');

        $this->get('/news/'.$post->slug)
            ->assertOk()
            ->assertSee('Admin Created Story')
            ->assertSee('The full story body written in the admin panel.');

        $this->get('/')
            ->assertOk()
            ->assertSee('Admin Created Story');
    }

    public function test_an_admin_can_create_a_program_and_see_it_on_the_public_site(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post('/admin/programs', [
            'title' => 'Admin Created Program',
            'icon' => 'sparkles',
            'excerpt' => 'A short program summary written in the admin panel.',
            'description' => 'The full program description written in the admin panel.',
            'sort_order' => 3,
            'is_published' => '1',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('programs', [
            'title' => 'Admin Created Program',
            'slug' => 'admin-created-program',
            'is_published' => true,
            'sort_order' => 3,
        ]);

        $program = Program::where('slug', 'admin-created-program')->firstOrFail();

        $this->get('/programs')
            ->assertOk()
            ->assertSee('Admin Created Program');

        $this->get('/programs/'.$program->slug)
            ->assertOk()
            ->assertSee('Admin Created Program')
            ->assertSee('The full program description written in the admin panel.');
    }

    public function test_admin_forms_reject_invalid_submissions(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->from('/admin/posts/create')
            ->post('/admin/posts', ['title' => '', 'published_at' => 'not-a-date'])
            ->assertSessionHasErrors(['title', 'published_at']);

        $this->actingAs($admin)->from('/admin/programs/create')
            ->post('/admin/programs', ['title' => '', 'icon' => 'not-an-icon', 'sort_order' => -1])
            ->assertSessionHasErrors(['title', 'icon', 'sort_order']);

        $this->assertDatabaseMissing('posts', ['title' => '']);
        $this->assertDatabaseMissing('programs', ['title' => '']);
    }

    public function test_an_admin_can_sign_out(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('/admin/logout')
            ->assertRedirect('/admin/login');

        $this->assertGuest();
    }
}
