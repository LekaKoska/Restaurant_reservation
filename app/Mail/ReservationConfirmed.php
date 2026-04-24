<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Reservation $reservation)
    {}


    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address("restaurant@leka.com"),
            subject: "Reservation confirmed",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.reserved_info',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
