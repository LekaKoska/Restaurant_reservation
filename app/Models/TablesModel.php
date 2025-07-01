<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TablesModel extends Model
{
    protected $table = "tables";

    protected $fillable = ["guest_number",  "table_id", "user_id"];


}
