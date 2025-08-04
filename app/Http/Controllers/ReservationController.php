<?php

namespace App\Http\Controllers;


use App\Http\Requests\TableReservationRequest;
use App\Http\Requests\TimeReservationRequest;
use App\Models\TablesInfoListModel;
use App\Models\TablesModel;
use App\Models\User;
use App\Repository\ReservationTimeRepository;
use App\Repository\TableInfoRepostory;
use App\Repository\UserReservationRepository;
use App\Services\ResponseServices;
use http\Env\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

class ReservationController extends Controller
{

    public function __construct(protected UserReservationRepository $userReservationRepo,
                                protected TableInfoRepostory $tableInfoRepo,
                                protected ReservationTimeRepository $timeReservationRepo)
    {}

    /**
     * @OA\Post(
     *     path="/api/reservation/",
     *     summary="Creating reservation",
     *     tags={"Tables"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *     @OA\JsonContent(
     *         required={"guest_number", "table_id"},
     *      @OA\Property(property="guest_number", type="number", example=1),
     *      @OA\Property(property="table_id", type="number", example=4)
     *     )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation has been created",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Your reservation is created successfully"),
     *          @OA\Property(property="data", type="object")
     *     )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="You already have reservation or table is taken",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="You already have reservation or this table is already taken")
     *     )
     *     ),
     *
     * )
     *
     */
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


        $tableReservation = $this->userReservationRepo->creatingReservation($user, $request);

        $url = \url("api/reservation/time/{$user->id}");
        $deleteUrl = \url("api/reservation/delete/{$table->resInfo->id}");


        $table->status = TablesInfoListModel::STATUS_TAKEN;
        $table->save();



        return ResponseServices::successResponse(data: $tableReservation, message: "Your reservation was created, please set your time by clicking on $url, if you want to cancel your reservation please click on $deleteUrl", code: 201);

    }

    /**
     * @OA\Get(
     *     path="/api/tables",
     *     summary="Returns all tables",
     *     tags={"Tables"},
     *     @OA\Response(
     *         response=200,
     *         description="All tables with information"
     *     )
     * )
     *
     *
     */

    public function info(): JsonResponse
    {

        $tables = $this->tableInfoRepo->allTablesInfo();


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

    /**
     * @OA\Post(
     *     path="/api/reservation/time/{name}",
     *     summary="Adding time on reservation",
     *     tags={"Tables"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="The ID of the user who has the reservation",
     *         required=true,
     *         @OA\Schema(
     *          type="integer",
     *          example=1
     *      )
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *     @OA\JsonContent(
     *         required={"reservation_date"},
     *     @OA\Property(property="reservation_date", type="string", format="date-time", example="2025-07-08 15:00:00")
     *     )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully added time",
     *     @OA\JsonContent(
     *         @OA\Property(
     *              property="message", type="string", example="Added time to your reservation")
     *     )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Your reservation already has a set time or you don't have reservation!",
     *       @OA\JsonContent(
     *           @OA\Property(property="message", type="string")
     *       )
     *     )
     * )
     *
     */

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

    /**
     * @OA\Delete(
     *     path="/api/reservation/delete/{id}",
     *     tags={"Tables"},
     *     summary="Deleting reservation by table ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Deleting reservation for user who has reservation",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *  @OA\Response(
     *    response=200,
     *    description="Successfully deleted reservation",
     *     @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Your reservation has been deleted")
     *          )
     *      )
     * )
     */

    public function delete($id)
    {

        $reservationDelete = TablesModel::findOrFail($id); // If you pass matching id put it into $reservationDelete in opposite throw an error
        if($reservationDelete->tableInfo)
        {
            $reservationDelete->tableInfo->status = TablesInfoListModel::STATUS_AVAILABLE;
            $reservationDelete->tableInfo->save();

        }

        $reservationDelete->delete();


        return ResponseServices::successResponse(message: "Your reservation has been canceled");
    }
}
