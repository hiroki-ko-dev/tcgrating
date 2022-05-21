<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResumeInfoToGameUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_users', function (Blueprint $table) {
            $table->string('experience',200)->nullable()->after('rate');
            $table->string('area',200)->nullable()->after('experience');
            $table->string('preference',200)->nullable()->after('area');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_users', function (Blueprint $table) {
            $table->dropColumn('experience');
            $table->dropColumn('area');
            $table->dropColumn('preference');
        });
    }
}
