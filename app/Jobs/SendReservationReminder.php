<?php

namespace App\Jobs;

use App\Mail\ReservationReminder;
use App\Models\Reservation;
use Carbon\Carbon;
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
        if($this->reservation->user) {
            Mail::to($this->reservation->user->email)->send(mailable: new ReservationReminder($this->reservation));
        }
    }
}
