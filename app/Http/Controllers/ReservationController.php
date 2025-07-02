<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableReservationRequest;
use App\Models\TablesInfoListModel;
use App\Models\TablesModel;
use App\Repository\TableInfoRepostory;
use App\Repository\UserReservationRepository;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    private $userReservationRepo;
    private $tableInfoRepo;


    public function __construct()
    {
        $this->userReservationRepo = new UserReservationRepository();
        $this->tableInfoRepo = new TableInfoRepostory();
    }
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
       $userExist = $this->userReservationRepo->findUserReservation($user);

        if($userExist)
        {
            return response()->json([
                "status" => false,
                "message" => "You already have reservation"
            ], 403);
        }

        $table = $this->tableInfoRepo->checkStatus($request);

        if ($table->status === TablesInfoListModel::STATUS_TAKEN) {

            return response()->json([
                "status" => false,
                "message" => "This table is already taken!"
            ], 403);
        }


       $tableReservation = $this->userReservationRepo->creatingReservation($user, $request);

        $table->status = TablesInfoListModel::STATUS_TAKEN;
        $table->save();



        return response()->json([
            "status" => true,
            "data" => $tableReservation
        ]);


    }

    public function info()
    {

        $tables = TablesInfoListModel::all();
        $data = [];
        foreach ($tables as $table)
        {
           $data[] =  [
                        "table_id" => $table['table_num'],
                        "location" => $table['location'],
                        "status" => $table['status']
                    ];

        }
        return response()->json(
            [
                "status" => true,
                "data" => $data
            ], 200);




    }
}
