<?php

namespace App\Services;

use App\Models\Reservation;
use App\Repository\ReservationRepository;
use Carbon\Carbon;
use Illuminate\Http\Response;

class ReservationService
{
    public function __construct(protected ReservationRepository $reservationRepo)
    {}

    public function endTimeReservation(array $data, ?Reservation $reservation = null)
    {
        if(array_key_exists("end_date", $data))
            {
                return $data;
            }
        $startDate = $data["start_date"] ?? $reservation->start_date;
        $endDate = Carbon::parse($startDate)->addHours(2);
        $data["end_date"] = $endDate;
        $data["start_date"] = $startDate;
        return $data;
    }

    public function takenTable($data, $reservationId = null)
    {
         $takenTable = Reservation::where("table_id", $data["table_id"])->where(function($query) use ($data, $reservationId)
        {
            $query->where("end_date", ">=", $data["start_date"]);
            $query->where("start_date", "<=", $data["end_date"]);
            $query->where("id", "!=", $reservationId);
        })->exists();
        if($takenTable)
            {
                throw new \Exception(message: "Table is taken in this period!", code: Response::HTTP_UNPROCESSABLE_ENTITY);
            }

        return $takenTable;
    }
}
