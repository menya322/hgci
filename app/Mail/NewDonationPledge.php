<?php

namespace App\Mail;

use App\Models\DonationPledge;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewDonationPledge extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public DonationPledge $pledge) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New donation pledge from '.$this->pledge->name,
        );
    }

    public function content(): Content
    {
        return new Content(text: 'mail.donation-pledge');
    }
}
