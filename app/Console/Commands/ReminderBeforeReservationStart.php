<?php

namespace App\Console\Commands;

use App\Jobs\SendReviewEmailJob;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReminderBeforeReservationStart extends Command
{
    protected $signature = 'app:send-reminder';
    protected $description = 'This command check reservation and send email to user one hour before start to remind them to be on time here.';

    public function handle(): void
    {
    $reservations = Reservation::whereNull("reminder_sent_at")
            ->where("start_date", "<=", \Illuminate\Support\now()->addHour())
            ->where("is_active", true)
            ->get();

        foreach ($reservations as $reservation)
        {
            $reservation->update(["reminder_sent_at" => Carbon::now()]);
            dispatch(new SendReviewEmailJob($reservation));
        }
    }
}
