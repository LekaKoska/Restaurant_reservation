<?php

use App\Models\Reservation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(table: Reservation::TABLE,callback: function (Blueprint $table) {
           $table->timestamp(column: "reminder_sent_at")->nullable()->after(column: "review_sent");
        });
    }

    public function down(): void
    {
        Schema::table(table: Reservation::TABLE,callback: function (Blueprint $table) {
            $table->dropColumn(columns: "reminder_sent_at");
        });
    }
};
