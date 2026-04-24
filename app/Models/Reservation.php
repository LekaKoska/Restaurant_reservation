<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    const TABLE = "reservations";
    protected $table = self::TABLE;
    protected $fillable = [
        "table_id", "user_id", "guest_number",
        "start_date", "end_date", "special_request"
        ];

        protected $casts = [
            "start_date" => "datetime",
            "end_date" => "datetime"
                            ];

        public function userReservations(): BelongsTo
        {
            return $this->belongsTo(User::class, "user_id", "id");
        }
}
