<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentNumberAndReferralNumberToPostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_comments', function (Blueprint $table) {
            $table->unsignedBigInteger('referral_id')->nullable()->after('id');
            $table->unsignedBigInteger('number')->default(2)->after('post_id');
            $table->string('image_url', 500)->after('body')->nullable();
            $table->unsignedTinyInteger('is_personal')->after('image_url')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_comments', function (Blueprint $table) {
            $table->dropColumn('referral_id');
            $table->dropColumn('number');
            $table->dropColumn('image_url');
            $table->dropColumn('is_personal');
        });
    }
}
