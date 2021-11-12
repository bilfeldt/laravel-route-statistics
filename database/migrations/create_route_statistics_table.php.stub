<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('route_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('team_id')->nullable(); // Can be changed to the following if your application uses teams: $table->foreignId('team_id')->nullable()->constrained();
            $table->string('method')->nullable();
            $table->string('route')->nullable();
            $table->integer('status')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->dateTime('date');
            $table->unsignedInteger('counter');

            $table->index('date');
            $table->index(['user_id', 'date', 'route', 'method']);
            $table->index(['team_id', 'date', 'route', 'method']);
            $table->index(['route', 'method', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('route_statistics');
    }
};
