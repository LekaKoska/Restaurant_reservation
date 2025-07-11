<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\TableReservationRequest;
use App\Http\Requests\TimeReservationRequest;
use App\Mail\ReservationConfirmed;
use App\Models\ReservationTimeModel;
use App\Models\TablesInfoListModel;
use App\Models\User;
use App\Repository\TableInfoRepostory;
use App\Repository\UserReservationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{

    public function __construct(protected UserReservationRepository $userReservationRepo, protected TableInfoRepostory $tableInfoRepo)
    {}
    public function index(TableReservationRequest $request): JsonResponse
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

        $url = \url("api/reservation/time/{$user->id}");
        $tableReservation = $this->userReservationRepo->creatingReservation($user, $request);

        $table->status = TablesInfoListModel::STATUS_TAKEN;
        $table->save();



        return ApiResponse::successResponse(data: $tableReservation, message: "Your reservation was created, please set your time by clicking on $url");

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
        return ApiResponse::successResponse(data: $data);


    }

    public function time(TimeReservationRequest $request, User $name): JsonResponse
    {


        if (!$name->reservedTable)
        {
            return ApiResponse::errorResponse(message: "You dont have reservation!");
        }

       if($name->reservedTime)
       {
           return ApiResponse::errorResponse(message: "You have already set a time for your reservation!");
       }

        $time = ReservationTimeModel::create(
            [
                "user_id" => $name->id,
                'table_id' => $name->reservedTable->table_id,
                "reservation_date" => $request->get("reservation_date")
            ]);

            Mail::to($name->email)->send(new ReservationConfirmed([
            'name' => $name->name,
            'table_id' => $name->reservedTable->table_id,
            'guest_number' => $name->reservedTable->guest_number,
            'reservation_date' => $time['reservation_date']]));

        return response()->json([
            "status" => true,
            "data" => $time,
            "message" => "Order accepted, check your mail for reservation info"
        ], 201);


    }
}
