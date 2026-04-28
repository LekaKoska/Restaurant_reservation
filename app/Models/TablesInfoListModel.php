<?php

namespace App\Models;

use Database\Factories\TableInfoListFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TableStatus;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TablesInfoListModel extends Model
{
    use HasFactory;

    const TABLE = "tables_info_list";

    protected $table = self::TABLE;
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = ["table_num", "location"];
    protected $casts = ["status" => TableStatus::class];
    const LOCATION = ['north', 'east', 'west', 'south'];

    const STATUS_TAKEN = "taken";
    const STATUS_AVAILABLE = "available";

    public static function newFactory()
    {
        return TableInfoListFactory::new();
    }
    public function takenSlots(): HasMany
    {
        return $this->hasMany(Reservation::class, "table_id", "id");
    }

}
