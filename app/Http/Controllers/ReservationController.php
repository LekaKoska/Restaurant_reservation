<?php

namespace App\Http\Controllers;


use App\Http\Requests\TableReservationRequest;
use App\Http\Requests\TimeReservationRequest;
use App\Models\TablesInfoListModel;
use App\Models\User;
use App\Repository\ReservationTimeRepository;
use App\Repository\TableInfoRepostory;
use App\Repository\UserReservationRepository;
use App\Services\ResponseServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{

    public function __construct(protected UserReservationRepository $userReservationRepo,
                                protected TableInfoRepostory $tableInfoRepo,
                                protected ReservationTimeRepository $timeReservationRepo)
    {}
    public function index(TableReservationRequest $request): JsonResponse
    {
        $user = Auth::user();

       $userExist = $this->userReservationRepo->findUserReservation($user);

        if($userExist)
        {
            return ResponseServices::errorResponse(message: "You already have reservation");

        }

        $table = $this->tableInfoRepo->checkStatus($request);

        if ($table->status === TablesInfoListModel::STATUS_TAKEN) {

            return ResponseServices::errorResponse(message: "This table is already taken!");

        }

        $url = \url("api/reservation/time/{$user->id}");
        $tableReservation = $this->userReservationRepo->creatingReservation($user, $request);

        $table->status = TablesInfoListModel::STATUS_TAKEN;
        $table->save();



        return ResponseServices::successResponse(data: $tableReservation, message: "Your reservation was created, please set your time by clicking on $url");

    }

    public function info(): JsonResponse
    {

        $tables = $this->tableInfoRepo->allTablesInfo();
        $tables->toArray();

        foreach ($tables as $table)
        {
           $data[] =  [
                        "table_id" => $table['table_num'],
                        "location" => $table['location'],
                        "status" => $table['status']
                    ];

        }
        return ResponseServices::successResponse(data: $data);


    }

    public function time(TimeReservationRequest $request, User $name): JsonResponse
    {


        if (!$name->reservedTable)
        {
            return ResponseServices::errorResponse(message: "You dont have reservation!");
        }

       if($name->reservedTime)
       {
           return ResponseServices::errorResponse(message: "You have already set a time for your reservation!");
       }

        $time = $this->timeReservationRepo->addingTime($name, $request);

            $this->timeReservationRepo->mail($name, $time);


            return ResponseServices::successResponse(data: $time, message: "Order accepted, check your mail for reservation info");



    }
}
