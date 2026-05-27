<?php

namespace App\Jobs;

use App\Mail\ReviewEmail;
use App\Models\Reservation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendReviewEmailJob implements ShouldQueue
{
    use Queueable;
    public function __construct(public Reservation $reservation)
    {}

    public function handle(): void
    {
        Mail::to($this->reservation->user->email)->send(mailable: new ReviewEmail($this->reservation));
        $this->reservation->update(['review_sent' => true]);
    }
}
