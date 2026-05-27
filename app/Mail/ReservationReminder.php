<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationReminder extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Reservation $reservation)
    {}
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(address: "restaurant@leka.com"),
            subject: 'Reservation Reminder',
        );
    }
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.reservation_reminder',
        );
    }
    public function attachments(): array
    {
        return [];
    }
}
