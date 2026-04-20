<?php

namespace App\Models;

use Database\Factories\TablesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function userReservation(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
