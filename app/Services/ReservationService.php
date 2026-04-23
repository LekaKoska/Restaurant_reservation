<?php

namespace App\Services;

use App\Repository\ReservationRepository;
use Carbon\Carbon;

class ReservationService
{
    public function __construct(protected ReservationRepository $reservationRepo)
    {}

    public function endTimeReservation(array $data)
    {
        if(array_key_exists("end_date", $data))
            {
                return $data;
            }
        $endDate = Carbon::parse($data["start_date"])->addHours(2);
        $data["end_date"] = $endDate;
        return $data;
    }
}
