<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "reservation_id" => "required|exists:reservations,id",
            "rating" => "required|integer|min:1|max:5",
            "comment" => "nullable|string|max:255"
        ];
    }
}
