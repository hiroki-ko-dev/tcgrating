<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_category_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('duel_id')->nullable()->constrained();
            $table->foreignId('team_id')->nullable()->constrained();
            $table->foreignId('event_id')->nullable()->constrained();
            $table->string('title',200);
            $table->string('body',2000);
            $table->boolean('is_personal')->default(0);
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
        Schema::dropIfExists('posts');
    }
}
