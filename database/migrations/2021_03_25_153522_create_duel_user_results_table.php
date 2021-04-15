<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuelUserResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duel_user_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('duel_user_id')->constrained();
            $table->unsignedTinyInteger('games_number');
            $table->unsignedSmallInteger('result')->default(0);
            $table->unsignedSmallInteger('ranking')->default(0);
            $table->mediumInteger('rating')->default(0);
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
        Schema::dropIfExists('duel_user_results');
    }
}
