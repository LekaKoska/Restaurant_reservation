<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationTimeModel extends Model
{
    protected $table = "reservation";
    protected $fillable = ['user_id', 'table_id', 'reservation_date'];

    protected $hidden = ['id', 'created_at', 'updated_at'];

    public function reservetionTime()
    {
        return $this->hasMany(TablesModel::class);
    }

}
