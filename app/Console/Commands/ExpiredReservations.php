<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpiredReservations extends Command
{
    protected $signature = 'app:expired-reservations';

    protected $description = 'This command checks all reservations with an expired date and changes their status to false.';

    public function handle()
    {
        Reservation::where("end_date", "<=", Carbon::now())->update(["is_active" => false]);
    }
}
