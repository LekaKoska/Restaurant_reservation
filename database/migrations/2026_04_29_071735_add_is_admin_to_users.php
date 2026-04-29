<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table(User::TABLE, function (Blueprint $table) {
            $table->boolean("is_admin")->default(false)->after("password");
        });
    }

    public function down(): void
    {
        Schema::table(User::TABLE, function (Blueprint $table) {
            $table->dropColumn("is_admin");
        });
    }
};
