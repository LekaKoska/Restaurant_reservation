<?php
namespace App\Repository;

use App\Models\TablesModel;

class UserReservationRepository
{
    private $tablesModel;

    public function  __construct()
    {
        $this->tablesModel = new TablesModel();
    }

    public function findUserReservation($user)
    {
        return $this->tablesModel->firstWhere("user_id", $user->id);
    }

    public function creatingReservation($user, $request)
    {
      return $this->tablesModel->create([
            "user_id" => $user->id,
            "guest_number" => $request->get("guest_number"),
            "table_id" => $request->get("table_id")
        ]);
    }

}

