<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
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
            return ApiResponse::errorResponse(message: "You already have reservation");

        }

        $table = $this->tableInfoRepo->checkStatus($request);

        if ($table->status === TablesInfoListModel::STATUS_TAKEN) {

            return ApiResponse::errorResponse(message: "This table is already taken!");

        }


        $tableReservation = $this->userReservationRepo->creatingReservation($user, $request);

        $table->status = TablesInfoListModel::STATUS_TAKEN;
        $table->save();



        return ApiResponse::successResponse(message: "Your reservation has been created!", data: $tableReservation);


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
        return ApiResponse::successResponse(data: $data);





    }
}
