<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableReservationRequest;
use App\Models\TablesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index(TableReservationRequest $request)
    {
        $user = Auth::user();
        if(!$user)
        {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Only auth user's have permission to be there"
                ], 401);
        }
       $userExist = TablesModel::firstWhere("user_id", $user->id);

        if($userExist)
        {
            return response()->json([
                "status" => false,
                "message" => "You already have reservation"
            ], 403);
        }

       $tableReservation = TablesModel::create([
            "user_id" => $user->id,
            "guest_number" => $request->get("guest_number"),
            "location" => $request->get("location")
        ]);

        return response()->json([
            "status" => true,
            "data" => $tableReservation
        ]);


    }
}
