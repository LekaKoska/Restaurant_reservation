<?php

namespace App\Services;

use App\Models\Reservation;
use App\Repository\ReservationRepository;
use Carbon\Carbon;

class ReservationService
{
    public function __construct(protected ReservationRepository $reservationRepo)
    {}

    public function endTimeReservation(array $data, Reservation $reservation)
    {
        if(array_key_exists("end_date", $data))
            {
                return $data;
            }
            $startDate = $data["start_date"] ?? $reservation->start_date;
        $endDate = Carbon::parse($startDate)->addHours(2);
        $data["end_date"] = $endDate;
        return $data;
    }
}
