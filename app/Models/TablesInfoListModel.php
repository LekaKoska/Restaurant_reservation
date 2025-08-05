<?php

namespace App\Models;

use Database\Factories\TableInfoListFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablesInfoListModel extends Model
{
    use HasFactory;

    protected $table = "tables_info_list";
    protected $hidden = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['table_num', "location", "status"];
    const LOCATION = ['north', 'east', 'west', 'south'];

    const STATUS_TAKEN = "taken";
    const STATUS_AVAILABLE = "available";

    public function resInfo()
    {
        return $this->hasOne(TablesModel::class, "table_id", "id");
    }

    public static function newFactory()
    {
        return TableInfoListFactory::new();
    }

}
