<?php

use App\Models\Reservation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(table: Reservation::TABLE,callback:  function (Blueprint $table) {
            $table->boolean(column: "review_sent")->default(value: false);
        });
    }

    public function down(): void
    {
        Schema::table(table: Reservation::TABLE,callback:  function (Blueprint $table) {
            $table->dropColumn("review_sent");
        });
    }
};
