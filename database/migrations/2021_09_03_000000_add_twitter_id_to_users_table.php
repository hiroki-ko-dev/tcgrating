<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTwitterIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('twitter_id')->nullable()->after('id');
            $table->string('twitter_nickname')->nullable()->after('image');
            $table->string('twitter_image_url')->nullable()->after('twitter_nickname');
            $table->string('twitter_simple_image_url')->nullable()->after('twitter_image_url');
            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('twitter_id');
            $table->dropColumn('twitter_nickname');
            $table->dropColumn('twitter_image_url');
            $table->dropColumn('twitter_simple_image_url');
            $table->string('email')->nullable(false)->change();
        });
    }
}
