<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuelResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duel_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('duel_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->unsignedTinyInteger('number');
            $table->unsignedSmallInteger('ranking');
            $table->mediumInteger('rating');
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
        Schema::dropIfExists('duel_results');
    }
}
