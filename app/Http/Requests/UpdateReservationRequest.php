<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "table_id" => "sometimes|integer|min:1|max:23|exists:tables_info_list,id",
            "guest_number" => "sometimes|integer|min:1|max:9",
            "special_request" => "sometimes|string|min:3",
            "start_date" => "sometimes|date"
        ];
    }
}
