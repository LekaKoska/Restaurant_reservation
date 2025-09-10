<?php
    namespace App\Repository;

use App\Mail\ReservationConfirmed;
use App\Models\ReservationTimeModel;
use Illuminate\Support\Facades\Mail;

class ReservationTimeRepository
{
    public function __construct(protected ReservationTimeModel $time)
    {}
    public function addingTime($name, $request): ReservationTimeModel
    {
        return ReservationTimeModel::create(
            [
                "user_id" => $name->id,
                'table_id' => $name->reservedTable->table_id,
                "reservation_date" => $request->get("reservation_date"),
            ]);
    }

    public function mail($name, $time)
    {
        return  Mail::to($name->email)->send(new ReservationConfirmed([
            'name' => $name->name,
            'table_id' => $name->reservedTable->table_id,
            'guest_number' => $name->reservedTable->guest_number,
            'reservation_date' => $time['reservation_date']]));
    }
}
