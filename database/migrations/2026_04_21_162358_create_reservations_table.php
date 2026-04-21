<?php

use App\Models\Reservation;
use App\Models\TablesInfoListModel;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(Reservation::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId("table_id")->constrained(TablesInfoListModel::TABLE);
            $table->foreignId("user_id")->constrained(User::TABLE);
            $table->tinyInteger("guest_number");
            $table->dateTime("start_date");
            $table->dateTime("end_date")->nullable();
            $table->string("special_request")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(Reservation::TABLE);
    }
};
