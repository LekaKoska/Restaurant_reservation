<?php
namespace App\Repository;

use App\Models\Reservation;


class ReservationRepository
{
    public function  __construct(protected Reservation $reservationModel)
    {}

    public function findUserReservation($reservation): Reservation
    {
        return Reservation::firstWhere("table_id", $reservation->id);
    }

    public function creatingReservation(array $data): Reservation
    {
            return Reservation::create($data);
    }
}

