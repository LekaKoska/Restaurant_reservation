<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableReservationRequest;
use App\Models\TablesInfoListModel;
use App\Repository\TableInfoRepostory;
use App\Repository\UserReservationRepository;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{

    public function __construct(protected UserReservationRepository $userReservationRepo, protected TableInfoRepostory $tableInfoRepo)
    {}
    public function index(TableReservationRequest $request)
    {
        $user = Auth::user();

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

        $tables = $this->tableInfoRepo->allTablesInfo();
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
