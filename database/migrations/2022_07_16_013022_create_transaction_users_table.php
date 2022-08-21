<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('email',200);
            $table->string('first_name',200);
            $table->string('last_name',200);
            $table->unsignedBigInteger('tel');
            $table->unsignedInteger('post_code');
            $table->unsignedSmallInteger('prefecture_id');
            $table->string('address1',200);
            $table->string('address2',200);
            $table->string('address3',200)->nullable();
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
        Schema::dropIfExists('transaction_users');
    }
}
