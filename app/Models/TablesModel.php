<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TablesModel extends Model
{
    protected $table = "tables";
    protected $fillable = ["guest_number", "status", "location", "user_id"];
}
