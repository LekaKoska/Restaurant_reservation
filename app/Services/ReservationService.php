<?php

namespace App\Services;

use App\Ai\Agents\ReservationAssistent;
use App\Models\Reservation;
use App\Models\TablesInfoListModel;
use App\Repository\ReservationRepository;
use Carbon\Carbon;
use Illuminate\Http\Response;


class ReservationService
{
    public function __construct(protected ReservationRepository $reservationRepo) {}

    public function endTimeReservation(array $data, ?Reservation $reservation = null)
    {
        if (array_key_exists("special_request", $data)) {
            $response = ReservationAssistent::make()->prompt(json_encode($data));
            $specialRequest = json_decode($response->text);
            if ($specialRequest->end_date !== null) {
                $data['end_date'] = $specialRequest->end_date;
                return $data;
            }
        }
        if (array_key_exists("end_date", $data)) {
            return $data;
        }
        $startDate = $data["start_date"] ?? $reservation->start_date;
        $endDate = Carbon::parse($startDate)->addHours(2);
        $data["end_date"] = $endDate;
        $data["start_date"] = $startDate;
        return $data;
    }

    public function takenTable(array $data, mixed $reservationId = null)
    {
        $takenTable = Reservation::where("table_id", $data["table_id"])->where(function ($query) use ($data, $reservationId) {
            $query->where("end_date", ">=", $data["start_date"]);
            $query->where("start_date", "<=", $data["end_date"]);
            $query->where("id", "!=", $reservationId);
        })->exists();
        if ($takenTable) {
            throw new \Exception(message: "Table is taken in this period!", code: Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $takenTable;
    }

    public function takenSlots(TablesInfoListModel $table)
    {
        return $table->takenSlots->map(function ($reservation) {
            return [
                "start_date" => $reservation->start_date,
                "end_date" => $reservation->end_date
            ];
        });
    }
}
