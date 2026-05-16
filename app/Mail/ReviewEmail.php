<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReviewEmail extends Mailable
{
    use Queueable, SerializesModels;

    public array $ratingLinks = [];
    public function __construct(public Reservation $reservation)
    {}
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Review Email',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.review',
        );
    }
    public function attachments(): array
    {
        return [];
    }
}
