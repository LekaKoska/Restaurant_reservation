<?php

namespace App\Http\Controllers;


use App\Http\Requests\TableReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use App\Models\TablesInfoListModel;
use App\Models\User;
use App\Repository\ReservationRepository;
use App\Repository\TableInfoRepository;
use App\Services\ReservationService;
use App\Services\ResponseServices;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends Controller
{

    public function __construct(protected ReservationRepository $reservationRepo, protected TableInfoRepository $tableRepo)
    {}

    public function store(TableReservationRequest $request,  ReservationService $reservationService): JsonResponse
    {
        $newReservation = $reservationService->endTimeReservation($request->validated());

        try {
        $reservationService->takenTable($newReservation);
            $reservation =  $this->reservationRepo->creatingReservation($newReservation);
        } catch(Exception $e)
        {
            return ResponseServices::errorResponse(message: $e->getMessage());
        }
            return ResponseServices::successResponse(message: "Your reservation has been created", data: $reservation);
    }

    public function info(): JsonResponse
    {
        $tables = $this->tableRepo->allTablesInfo();
        return ResponseServices::successResponse(data: $tables, code: Response::HTTP_OK);
    }
    public function show(Reservation $reservation): JsonResponse
    {
        Gate::authorize("update", $reservation);
        return ResponseServices::successResponse(data: $reservation);
    }
    public function update(UpdateReservationRequest $request, Reservation $reservation, ReservationService $reservationService): JsonResponse
    {
        Gate::authorize("update", $reservation);
        $updatedReservation = $reservationService->endTimeReservation($request->validated(), $reservation);

        try{
            $reservationService->takenTable($updatedReservation, $reservation->id);
        } catch(Exception $e)
        {
            return ResponseServices::errorResponse(message: $e->getMessage());
        }
        $reservation->update($updatedReservation);
        return ResponseServices::successResponse(message: "Your reservation is updated successfully", data: $reservation);
    }

    public function delete(Reservation $reservation): JsonResponse
    {
        Gate::authorize("delete", $reservation);
        try {
         $reservation->delete();
        } catch(Exception $e)
        {
        return ResponseServices::errorResponse(message: $e->getMessage());
        }
         return ResponseServices::successResponse(message: "Your reservation is deleted", code: Response::HTTP_OK);
    }

    public function reservationHistory(User $user): JsonResponse
    {
        Gate::authorize("view", $user);
        return ResponseServices::successResponse(data: $user->reservations);
    }
    public function takenSlots(TablesInfoListModel $table, ReservationService $reservationService): JsonResponse
    {
      $takenSlots = $reservationService->takenSlots($table);
      return ResponseServices::successResponse(data: $takenSlots, code: Response::HTTP_OK);
    }
}

