<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('duel_category_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedSmallInteger('number_of_games');
            $table->unsignedSmallInteger('max_member');
            $table->mediumInteger('room_id');
            $table->mediumInteger('watching_id')->nullable();
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
        Schema::dropIfExists('duels');
    }
}
