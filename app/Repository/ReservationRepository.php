<?php
namespace App\Repository;

use App\Models\Reservation;
use App\Services\ResponseServices;
use Symfony\Component\HttpFoundation\Response;

class ReservationRepository
{


    public function  __construct(protected Reservation $reservationModel)
    {}


    public function findUserReservation($reservation)
    {
        return Reservation::firstWhere("table_id", $reservation->id);
    }

    public function creatingReservation(array $data)
    {
        $takenTable = Reservation::where("table_id", $data["table_id"])->where(function($query) use ($data)
        {
            $query->where("end_date", ">=", $data["start_date"]);
            $query->where("start_date", "<=", $data["end_date"]);
        })->exists();

        if($takenTable)
            {
                throw new \Exception(message: "Table is taken in this period!", code: Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            return Reservation::create($data);
    }

     public function allUserReservations($user)
    {
        return $this->reservationModel->with("userReservations")->where("user_id", $user->id)->get();
    }

}

