<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TablesInfoListModel extends Model
{
    protected $table = "tables_info_list";
    protected $fillable = ['table_num', "location", "status"];
    const LOCATION = ['north', 'east', 'west', 'south'];
}
