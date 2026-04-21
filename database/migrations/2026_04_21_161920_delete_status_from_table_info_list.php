<?php

use App\Models\TablesInfoListModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(TablesInfoListModel::TABLE, function (Blueprint $table) {
            $table->dropColumn("status");
        });
    }

    public function down(): void
    {
        Schema::table(TablesInfoListModel::TABLE, function (Blueprint $table) {
            //
        });
    }
};
