<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullableUserIdPostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //外部キー制約を一旦無効化
        Schema::disableForeignKeyConstraints();
        Schema::table('post_comments', function (Blueprint $table) {
            $table->bigInteger('user_id')->nullable(true)->change();
        });
        //外部キー制約を有効化
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //外部キー制約を一旦無効化
        Schema::disableForeignKeyConstraints();
        Schema::table('post_comments', function (Blueprint $table) {
            $table->bigInteger('user_id')->nullable(false)->change();
        });
        //外部キー制約を有効化
        Schema::enableForeignKeyConstraints();
    }
}
