<?php

use App\Models\Reservation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(Reservation::TABLE, function (Blueprint $table) {
            $table->boolean("is_active")->default(true)->after("special_request");
        });
    }

    public function down(): void
    {
        Schema::table(Reservation::TABLE, function (Blueprint $table) {
            $table->dropColumn("is_active");
        });
    }
};
