<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use App\Policies\ReservationPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[UsePolicy(ReservationPolicy::class)]
class Reservation extends Model
{
    const TABLE = "reservations";
    protected $table = self::TABLE;
    protected $fillable = [
        "table_id", "user_id", "guest_number",
        "start_date", "end_date", "special_request",
        "is_active", "review_sent", "reminder_sent_at"
        ];

        protected $casts = [
            "start_date" => "datetime",
            "end_date" => "datetime"
        ];

        public function user(): BelongsTo
        {
            return $this->belongsTo(related: User::class, foreignKey: "user_id", ownerKey: "id");
        }
}
