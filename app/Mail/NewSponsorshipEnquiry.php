<?php

namespace App\Mail;

use App\Models\SponsorshipEnquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewSponsorshipEnquiry extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public SponsorshipEnquiry $enquiry) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New sponsorship enquiry from '.$this->enquiry->full_name,
        );
    }

    public function content(): Content
    {
        return new Content(text: 'mail.sponsorship-enquiry');
    }
}
