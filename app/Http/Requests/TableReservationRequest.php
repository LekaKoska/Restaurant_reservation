<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableReservationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "user_id" => "exists:users,id",
            "guest_number" => "required|integer|min:1|max:9",
            "table_id" => "required|integer|min:1|max:23|exists:tables_info_list,id",
            "start_date" => "required|date",
        ];
    }
}
