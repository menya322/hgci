<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\DonationPledge;
use App\Models\SponsorshipEnquiry;
use App\Models\User;
use App\Models\VolunteerApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminInboxTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_the_inbox_hub_and_all_record_pages_load(): void
    {
        $message = ContactMessage::factory()->create([
            'name' => 'Alice Contact',
            'email' => 'alice@example.com',
            'subject' => 'Sponsorship question',
            'message' => 'I would like to know more about the sponsorship programme.',
        ]);

        $enquiry = SponsorshipEnquiry::factory()->create([
            'first_name' => 'Bob',
            'last_name' => 'Sponsor',
            'email' => 'bob@example.com',
            'country' => 'Uganda',
        ]);

        $pledge = DonationPledge::factory()->create([
            'name' => 'Carol Pledge',
            'email' => 'carol@example.com',
            'amount' => 50000,
            'currency' => 'UGX',
        ]);

        $application = VolunteerApplication::factory()->create([
            'first_name' => 'Dan',
            'last_name' => 'Volunteer',
            'email' => 'dan@example.com',
            'location' => 'Kampala',
        ]);

        $this->actingAs($this->admin)
            ->get('/admin/inbox')
            ->assertOk()
            ->assertSee('Inbox')
            ->assertSee('Contact messages')
            ->assertSee('Sponsorship enquiries')
            ->assertSee('Donation pledges')
            ->assertSee('Volunteer applications')
            ->assertSee('4 unread');

        $this->actingAs($this->admin)
            ->get('/admin/inbox/messages')
            ->assertOk()
            ->assertSee('Alice Contact')
            ->assertSee('Sponsorship question');

        $this->actingAs($this->admin)
            ->get('/admin/inbox/messages/'.$message->id)
            ->assertOk()
            ->assertSee('Alice Contact')
            ->assertSee('alice@example.com')
            ->assertSee('I would like to know more about the sponsorship programme.');

        $this->actingAs($this->admin)
            ->get('/admin/inbox/enquiries')
            ->assertOk()
            ->assertSee('Bob Sponsor');

        $this->actingAs($this->admin)
            ->get('/admin/inbox/enquiries/'.$enquiry->id)
            ->assertOk()
            ->assertSee('bob@example.com')
            ->assertSee('Uganda');

        $this->actingAs($this->admin)
            ->get('/admin/inbox/pledges')
            ->assertOk()
            ->assertSee('Carol Pledge');

        $this->actingAs($this->admin)
            ->get('/admin/inbox/pledges/'.$pledge->id)
            ->assertOk()
            ->assertSee('50,000.00 UGX');

        $this->actingAs($this->admin)
            ->get('/admin/inbox/applications')
            ->assertOk()
            ->assertSee('Dan Volunteer');

        $this->actingAs($this->admin)
            ->get('/admin/inbox/applications/'.$application->id)
            ->assertOk()
            ->assertSee('dan@example.com')
            ->assertSee('Kampala');
    }

    public function test_marking_a_record_as_read_sets_the_read_time_and_keeps_the_status(): void
    {
        $cases = [
            [
                'record' => ContactMessage::factory()->create(['status' => 'new']),
                'path' => '/admin/inbox/messages',
                'table' => 'contact_messages',
            ],
            [
                'record' => SponsorshipEnquiry::factory()->create(['status' => 'new']),
                'path' => '/admin/inbox/enquiries',
                'table' => 'sponsorship_enquiries',
            ],
            [
                'record' => DonationPledge::factory()->create(['status' => 'pending']),
                'path' => '/admin/inbox/pledges',
                'table' => 'donation_pledges',
            ],
            [
                'record' => VolunteerApplication::factory()->create(['status' => 'new']),
                'path' => '/admin/inbox/applications',
                'table' => 'volunteer_applications',
            ],
        ];

        foreach ($cases as $case) {
            $record = $case['record'];
            $status = $record->status;
            $table = $case['table'];

            $this->actingAs($this->admin)
                ->post($case['path'].'/'.$record->id.'/read')
                ->assertRedirect($case['path'].'/'.$record->id)
                ->assertSessionHas('status', 'Marked as read.');

            $record->refresh();

            $this->assertNotNull($record->read_at, "Expected {$table} record to be marked as read.");
            $this->assertSame($status, $record->status, "Expected the status of {$table} to stay unchanged.");
        }
    }

    public function test_an_admin_can_delete_records_from_every_inbox(): void
    {
        $cases = [
            [
                'record' => ContactMessage::factory()->create(),
                'path' => '/admin/inbox/messages',
                'table' => 'contact_messages',
            ],
            [
                'record' => SponsorshipEnquiry::factory()->create(),
                'path' => '/admin/inbox/enquiries',
                'table' => 'sponsorship_enquiries',
            ],
            [
                'record' => DonationPledge::factory()->create(),
                'path' => '/admin/inbox/pledges',
                'table' => 'donation_pledges',
            ],
            [
                'record' => VolunteerApplication::factory()->create(),
                'path' => '/admin/inbox/applications',
                'table' => 'volunteer_applications',
            ],
        ];

        foreach ($cases as $case) {
            $id = $case['record']->id;

            $this->actingAs($this->admin)
                ->delete($case['path'].'/'.$id)
                ->assertRedirect($case['path'])
                ->assertSessionHas('status', 'Record deleted.');

            $this->assertDatabaseMissing($case['table'], ['id' => $id]);
        }
    }

    public function test_the_inbox_search_and_unread_filter_work(): void
    {
        ContactMessage::factory()->create([
            'name' => 'Findable Person',
            'email' => 'findable@example.com',
            'read_at' => null,
        ]);

        ContactMessage::factory()->create([
            'name' => 'Hidden Person',
            'email' => 'hidden@example.com',
            'read_at' => now(),
        ]);

        $this->actingAs($this->admin)
            ->get('/admin/inbox/messages?q=Findable')
            ->assertOk()
            ->assertSee('Findable Person')
            ->assertDontSee('Hidden Person');

        $this->actingAs($this->admin)
            ->get('/admin/inbox/messages?unread=1')
            ->assertOk()
            ->assertSee('Findable Person')
            ->assertDontSee('Hidden Person');
    }

    public function test_non_admin_users_cannot_access_the_inbox(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $message = ContactMessage::factory()->create();

        $this->actingAs($user)->get('/admin/inbox')->assertForbidden();
        $this->actingAs($user)->get('/admin/inbox/messages')->assertForbidden();
        $this->actingAs($user)->get('/admin/inbox/messages/'.$message->id)->assertForbidden();
        $this->actingAs($user)->post('/admin/inbox/messages/'.$message->id.'/read')->assertForbidden();
        $this->actingAs($user)->delete('/admin/inbox/messages/'.$message->id)->assertForbidden();
    }
}
