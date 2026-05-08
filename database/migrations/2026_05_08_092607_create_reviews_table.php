<?php

use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create(table: Review::TABLE, callback:  function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: "reservation_id")->constrained(table: Reservation::TABLE);
            $table->foreignId(column: "user_id")->constrained(table: User::TABLE);
            $table->smallInteger(column: "rating")->unsigned();
            $table->text(column: "comment")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: Review::TABLE);
    }
};
