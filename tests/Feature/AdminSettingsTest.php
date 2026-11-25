<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSettingsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_the_settings_page_loads_with_the_seeded_values(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/settings')
            ->assertOk()
            ->assertSee('Settings')
            ->assertSee('Hero text')
            ->assertSee('Impact counters')
            ->assertSee('Contact information')
            ->assertSee('Social profiles')
            ->assertSee('Donation details')
            ->assertSee('Every child deserves hope.')
            ->assertSee('[ADD: phone number]');
    }

    public function test_an_admin_can_update_settings(): void
    {
        $this->actingAs($this->admin)
            ->put('/admin/settings', [
                'hero_title' => 'Hope for every child',
                'hero_description' => 'An updated introduction for the home page hero.',
                'contact_phone' => '+256 700 000000',
                'contact_notification_email' => 'updates@example.com',
                'social_facebook' => 'https://www.facebook.com/example',
                'giving_bank_name' => 'Example Bank',
                'impact_children_reached' => '150',
            ])
            ->assertRedirect('/admin/settings')
            ->assertSessionHas('status', 'Settings saved.');

        $this->assertSame('Hope for every child', Setting::get('hero.title'));
        $this->assertSame('An updated introduction for the home page hero.', Setting::get('hero.description'));
        $this->assertSame('+256 700 000000', Setting::get('contact.phone'));
        $this->assertSame('updates@example.com', Setting::get('contact.notification_email'));
        $this->assertSame('https://www.facebook.com/example', Setting::get('social.facebook'));
        $this->assertSame('Example Bank', Setting::get('giving.bank_name'));
        $this->assertSame('150', Setting::get('impact.children_reached'));
    }

    public function test_the_placeholder_email_addresses_are_accepted(): void
    {
        $this->actingAs($this->admin)
            ->put('/admin/settings', [
                'hero_title' => 'Every child deserves hope.',
                'hero_description' => 'Keeping the existing introduction.',
                'contact_email' => '[ADD: email address]',
                'contact_notification_email' => '[ADD: notification email address]',
            ])
            ->assertRedirect('/admin/settings')
            ->assertSessionHasNoErrors();

        $this->assertSame('[ADD: email address]', Setting::get('contact.email'));
        $this->assertSame('[ADD: notification email address]', Setting::get('contact.notification_email'));
    }

    public function test_invalid_email_addresses_and_missing_hero_copy_are_rejected(): void
    {
        $this->actingAs($this->admin)
            ->from('/admin/settings')
            ->put('/admin/settings', [
                'hero_title' => '',
                'hero_description' => 'A description is present.',
                'contact_notification_email' => 'not-an-email',
            ])
            ->assertRedirect('/admin/settings')
            ->assertSessionHasErrors(['hero_title', 'contact_notification_email']);

        $this->assertSame('[ADD: notification email address]', Setting::get('contact.notification_email'));
    }

    public function test_non_admin_users_cannot_manage_settings(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get('/admin/settings')->assertForbidden();

        $this->actingAs($user)
            ->put('/admin/settings', [
                'hero_title' => 'Nope',
                'hero_description' => 'Nope',
            ])
            ->assertForbidden();
    }
}
