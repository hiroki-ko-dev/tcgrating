<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupIdToEventUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_users', function (Blueprint $table) {
            $table->unsignedTinyInteger('group_id')->nullable()->after('user_id');
            $table->mediumInteger('rating')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_users', function (Blueprint $table) {
            $table->dropColumn('group_id');
            $table->dropColumn('rating');
        });
    }
}
