<?php

namespace App\Jobs;

use App\Models\Reservation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendReservationReminder implements ShouldQueue
{
    use Queueable;
    public function __construct(public Reservation $reservation)
    {}

    public function handle(): void
    {
        Mail::to($this->reservation->user->email);
    }
}
