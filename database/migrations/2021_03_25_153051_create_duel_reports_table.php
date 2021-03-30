<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuelReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duel_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('duel_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->unsignedTinyInteger('number');
            $table->unsignedTinyInteger('report');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('duel_reports');
    }
}
