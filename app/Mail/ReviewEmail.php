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
use Illuminate\Support\Facades\URL;

class ReviewEmail extends Mailable
{
    use Queueable, SerializesModels;

    public array $ratingLinks = [];
    public function __construct(public Reservation $reservation)
    {
        for ($rating = 1; $rating <= 5; $rating++) {
            $this->ratingLinks[$rating] = URL::temporarySignedRoute(
                name: 'review-email.store',
                expiration: now()->addDays(7),
                parameters:[
                    'reservation_id' => $this->reservation->id,
                    'rating' => $rating,
                ]
            );
        }
    }
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
            with: ['ratingLinks' => $this->ratingLinks]
        );
    }
    public function attachments(): array
    {
        return [];
    }
}
