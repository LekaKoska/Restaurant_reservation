<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    const TABLE = "reviews";
    protected $table = self::TABLE;
    protected $fillable = [
        'reservation_id', 'user_id', 'rating',
        'comment'
    ];

}
