<?php

namespace Tests\Feature;

use App\Models\DonationPledge;
use App\Models\SponsorshipEnquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminExportsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_an_admin_can_export_sponsorship_enquiries_as_csv(): void
    {
        SponsorshipEnquiry::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'phone' => '+256 700 111222',
            'country' => 'Uganda',
            'preferred_child_age' => '6-10',
            'message' => 'I would like to sponsor a child.',
            'consent' => true,
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/inbox/enquiries/export');

        $response->assertOk()
            ->assertDownload('sponsorship-enquiries-'.now()->format('Y-m-d').'.csv');

        $this->assertStringContainsString('text/csv', (string) $response->headers->get('content-type'));

        $csv = $response->streamedContent();

        $this->assertStringContainsString('First name', $csv);
        $this->assertStringContainsString('Preferred child age', $csv);
        $this->assertStringContainsString('Jane', $csv);
        $this->assertStringContainsString('jane@example.com', $csv);
        $this->assertStringContainsString('Uganda', $csv);
        $this->assertStringContainsString('I would like to sponsor a child.', $csv);
    }

    public function test_the_enquiry_export_respects_the_current_filters(): void
    {
        SponsorshipEnquiry::factory()->create(['first_name' => 'Wanted', 'last_name' => 'Person']);
        SponsorshipEnquiry::factory()->create(['first_name' => 'Other', 'last_name' => 'Person']);

        $response = $this->actingAs($this->admin)->get('/admin/inbox/enquiries/export?q=Wanted');

        $response->assertOk();

        $csv = $response->streamedContent();

        $this->assertStringContainsString('Wanted', $csv);
        $this->assertStringNotContainsString('Other', $csv);
    }

    public function test_an_admin_can_export_donation_pledges_as_csv(): void
    {
        DonationPledge::factory()->create([
            'name' => 'Carol Pledge',
            'email' => 'carol@example.com',
            'amount' => 75000,
            'currency' => 'UGX',
            'frequency' => 'monthly',
            'method' => 'mobile_money',
            'message' => 'Please use this for school fees.',
            'consent' => true,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/inbox/pledges/export');

        $response->assertOk()
            ->assertDownload('donation-pledges-'.now()->format('Y-m-d').'.csv');

        $this->assertStringContainsString('text/csv', (string) $response->headers->get('content-type'));

        $csv = $response->streamedContent();

        $this->assertStringContainsString('Payment method', $csv);
        $this->assertStringContainsString('Carol Pledge', $csv);
        $this->assertStringContainsString('carol@example.com', $csv);
        $this->assertStringContainsString('75000.00', $csv);
        $this->assertStringContainsString('Monthly', $csv);
        $this->assertStringContainsString('Mobile Money', $csv);
        $this->assertStringContainsString('Please use this for school fees.', $csv);
    }

    public function test_only_the_enquiry_and_pledge_inboxes_show_an_export_link(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/inbox/enquiries')
            ->assertOk()
            ->assertSee('Export CSV');

        $this->actingAs($this->admin)
            ->get('/admin/inbox/pledges')
            ->assertOk()
            ->assertSee('Export CSV');

        $this->actingAs($this->admin)
            ->get('/admin/inbox/messages')
            ->assertOk()
            ->assertDontSee('Export CSV');

        $this->actingAs($this->admin)
            ->get('/admin/inbox/applications')
            ->assertOk()
            ->assertDontSee('Export CSV');
    }

    public function test_non_admin_users_cannot_export_records(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get('/admin/inbox/enquiries/export')->assertForbidden();
        $this->actingAs($user)->get('/admin/inbox/pledges/export')->assertForbidden();
    }
}
