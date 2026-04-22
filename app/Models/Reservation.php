<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    const TABLE = "reservations";
    protected $table = self::TABLE;
    protected $fillable = [
        "table_id", "user_id", "guest_number",
        "start_date", "end_time", "special_request"
        ];
}
