<?php

namespace Tests\Feature;

use App\Mail\NewContactMessage;
use App\Mail\NewDonationPledge;
use App\Mail\NewSponsorshipEnquiry;
use App\Mail\NewVolunteerApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class FormSubmissionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        Mail::fake();
    }

    public function test_contact_form_stores_a_message_and_sends_notification(): void
    {
        $response = $this->from('/contact')->post('/contact', [
            'name' => 'Contact Tester',
            'email' => 'contact@example.com',
            'phone' => '+256 700 111111',
            'subject' => 'general',
            'message' => 'I would like to know more about HGCI.',
            'consent' => '1',
        ]);

        $response->assertRedirect('/contact')->assertSessionHas('status');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'contact@example.com',
            'status' => 'new',
        ]);

        Mail::assertSent(NewContactMessage::class, function (NewContactMessage $mail) {
            return $mail->contactMessage->email === 'contact@example.com';
        });
    }

    public function test_contact_form_rejects_invalid_data_without_storing_or_mailing(): void
    {
        $response = $this->from('/contact')->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'subject' => 'invalid',
            'message' => '',
        ]);

        $response->assertRedirect('/contact')
            ->assertSessionHasErrors(['name', 'email', 'subject', 'message', 'consent']);

        $this->assertDatabaseCount('contact_messages', 0);
        Mail::assertNothingSent();
    }

    public function test_sponsorship_form_stores_an_enquiry_and_sends_notification(): void
    {
        $response = $this->from('/sponsor')->post('/sponsor/enquiry', [
            'first_name' => 'Sponsor',
            'last_name' => 'Tester',
            'email' => 'sponsor@example.com',
            'phone' => '+256 700 222222',
            'country' => 'Uganda',
            'preferred_child_age' => '6-10',
            'message' => 'I would like to sponsor a child.',
            'consent' => '1',
        ]);

        $response->assertRedirect('/sponsor')->assertSessionHas('status');

        $this->assertDatabaseHas('sponsorship_enquiries', [
            'email' => 'sponsor@example.com',
            'status' => 'new',
        ]);

        Mail::assertSent(NewSponsorshipEnquiry::class, function (NewSponsorshipEnquiry $mail) {
            return $mail->enquiry->email === 'sponsor@example.com';
        });
    }

    public function test_sponsorship_form_rejects_invalid_data_without_storing_or_mailing(): void
    {
        $response = $this->from('/sponsor')->post('/sponsor/enquiry', [
            'first_name' => '',
            'last_name' => '',
            'email' => 'not-an-email',
            'preferred_child_age' => 'not-an-age',
        ]);

        $response->assertRedirect('/sponsor')
            ->assertSessionHasErrors(['first_name', 'last_name', 'email', 'preferred_child_age', 'consent']);

        $this->assertDatabaseCount('sponsorship_enquiries', 0);
        Mail::assertNothingSent();
    }

    public function test_donation_form_stores_a_pledge_and_sends_notification(): void
    {
        $response = $this->from('/donate')->post('/donate/pledge', [
            'name' => 'Donor Tester',
            'email' => 'donor@example.com',
            'phone' => '+256 700 333333',
            'amount' => 100000,
            'frequency' => 'monthly',
            'method' => 'mobile_money',
            'message' => 'Please contact me with payment details.',
            'consent' => '1',
        ]);

        $response->assertRedirect('/donate')->assertSessionHas('status');

        $this->assertDatabaseHas('donation_pledges', [
            'email' => 'donor@example.com',
            'currency' => 'UGX',
            'status' => 'pending',
        ]);

        Mail::assertSent(NewDonationPledge::class, function (NewDonationPledge $mail) {
            return $mail->pledge->email === 'donor@example.com';
        });
    }

    public function test_donation_form_rejects_invalid_data_without_storing_or_mailing(): void
    {
        $response = $this->from('/donate')->post('/donate/pledge', [
            'name' => '',
            'email' => 'not-an-email',
            'amount' => 0,
            'frequency' => 'yearly',
            'method' => 'cheque',
        ]);

        $response->assertRedirect('/donate')
            ->assertSessionHasErrors(['name', 'email', 'amount', 'frequency', 'method', 'consent']);

        $this->assertDatabaseCount('donation_pledges', 0);
        Mail::assertNothingSent();
    }

    public function test_volunteer_form_stores_an_application_and_sends_notification(): void
    {
        $response = $this->from('/get-involved')->post('/get-involved/volunteer', [
            'first_name' => 'Volunteer',
            'last_name' => 'Tester',
            'email' => 'volunteer@example.com',
            'phone' => '+256 700 444444',
            'location' => 'Kampala',
            'skills' => 'Teaching and administration.',
            'availability' => 'Weekends',
            'motivation' => 'I want to support children in my community.',
            'consent' => '1',
        ]);

        $response->assertRedirect('/get-involved')->assertSessionHas('status');

        $this->assertDatabaseHas('volunteer_applications', [
            'email' => 'volunteer@example.com',
            'status' => 'new',
        ]);

        Mail::assertSent(NewVolunteerApplication::class, function (NewVolunteerApplication $mail) {
            return $mail->application->email === 'volunteer@example.com';
        });
    }

    public function test_volunteer_form_rejects_invalid_data_without_storing_or_mailing(): void
    {
        $response = $this->from('/get-involved')->post('/get-involved/volunteer', [
            'first_name' => '',
            'last_name' => '',
            'email' => 'not-an-email',
            'availability' => 'Whenever',
            'motivation' => '',
        ]);

        $response->assertRedirect('/get-involved')
            ->assertSessionHasErrors(['first_name', 'last_name', 'email', 'availability', 'motivation', 'consent']);

        $this->assertDatabaseCount('volunteer_applications', 0);
        Mail::assertNothingSent();
    }
}
