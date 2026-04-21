<?php

namespace App\Models;

use Database\Factories\TablesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TablesModel extends Model
{
    use HasFactory;
    protected $table = "tables";

    protected $fillable = ["guest_number",  "table_id", "user_id"];

    public function tableInfo()
    {
        return $this->hasOne(TablesInfoListModel::class, "id", "table_id");
    }

    public static function newFactory()
    {
        return TablesFactory::new();
    }

    public function userTimeReservation(): HasOne
    {
        return $this->hasOne(ReservationTimeModel::class, "table_id", "table_id");
    }

}
