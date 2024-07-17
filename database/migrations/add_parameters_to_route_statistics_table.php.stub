<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('route_statistics', function (Blueprint $table) {
            $table->json('parameters')->after('route')->nullable();
        });
    }

    public function down()
    {
        Schema::table('route_statistics', function (Blueprint $table) {
            $table->dropColumn('parameters');
        });
    }
};
