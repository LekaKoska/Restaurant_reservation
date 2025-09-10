<?php
namespace App\Repository;

use App\Models\TablesModel;
use App\Models\User;

class UserReservationRepository
{


    public function  __construct(protected TablesModel $tablesModel)
    {}

    public function findUserReservation($user): ?User
    {
        return $this->tablesModel->firstWhere("user_id", $user->id);
    }

    public function creatingReservation($user, $request): TablesModel
    {
      return $this->tablesModel->create([
            "user_id" => $user->id,
            "guest_number" => $request->get("guest_number"),
            "table_id" => $request->get("table_id")
        ]);
    }

}

