<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\DonationPledge;
use App\Models\Event;
use App\Models\SponsorshipEnquiry;
use App\Models\User;
use App\Models\VolunteerApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_dashboard_shows_the_operational_counts(): void
    {
        $admin = User::factory()->admin()->create();

        ContactMessage::factory()->count(3)->create(['read_at' => null]);
        ContactMessage::factory()->create(['read_at' => now()]);

        SponsorshipEnquiry::factory()->count(2)->create(['status' => 'new']);
        SponsorshipEnquiry::factory()->create(['status' => 'contacted']);

        DonationPledge::factory()->count(3)->create(['status' => 'pending']);
        DonationPledge::factory()->create(['status' => 'completed']);

        Event::factory()->count(2)->create();
        Event::factory()->past()->create();

        VolunteerApplication::factory()->count(2)->create(['status' => 'new']);
        VolunteerApplication::factory()->create(['status' => 'reviewed']);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk()
            ->assertSee('Unread messages')
            ->assertSee('New enquiries')
            ->assertSee('Pending pledges')
            ->assertSee('Upcoming events');

        $stats = $response->viewData('stats');

        $this->assertSame(3, $stats['unreadMessages']);
        $this->assertSame(2, $stats['newEnquiries']);
        $this->assertSame(3, $stats['pendingPledges']);
        $this->assertSame(2, $stats['upcomingEvents']);
        $this->assertSame(2, $stats['newApplications']);
    }
}
