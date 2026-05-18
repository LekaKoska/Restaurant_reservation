<?php

namespace App\Console\Commands;

use App\Jobs\SendReviewEmailJob;
use App\Mail\ReviewEmail;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ExpiredReservations extends Command
{
    protected $signature = 'app:expired-reservations';

    protected $description = 'This command checks all reservations with an expired date, changes their status to false and send email to user to submit review';

    public function handle(): void
    {
       $expiredReservations = Reservation::where("end_date", "<=", Carbon::now())->where("review_sent", false)->get();

      foreach ($expiredReservations as $expired)
      {
          dispatch(job: new SendReviewEmailJob($expired));
          $expired->is_active = false;
          $expired->save();
      }
    }
}
