<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNowMatchNumberToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->renameColumn('number_of_games', 'number_of_match');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedSmallInteger('now_match_number')->after('number_of_match');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('now_match_number');
            $table->renameColumn('number_of_match', 'number_of_games');
        });
    }
}
