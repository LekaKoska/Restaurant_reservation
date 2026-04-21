<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimeReservationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "reservation_date" => "required|date"
        ];
    }
}
