<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileDropTransactionInfoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->string('profile_image_path', 500)
                ->nullable()
                ->after('body');
            $table->date('birthday')->nullable()->after('profile_image_path');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('tel');
            $table->dropColumn('post_code');
            $table->dropColumn('prefecture_id');
            $table->dropColumn('address1');
            $table->dropColumn('address2');
            $table->dropColumn('address3');
            $table->dropColumn('rate_yugioh_links');
            $table->dropColumn([
                'stripe_id',
                'pm_type',
                'pm_last_four',
                'trial_ends_at',
            ]);
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
            $table->string('image', 255)->nullable()->after('body');
            $table->dropColumn('profile_image_path');
            $table->dropColumn('birthday');
            $table->string('first_name', 200)->nullable()->after('name');
            $table->string('last_name', 200)->nullable()->after('first_name');
            $table->unsignedBigInteger('tel')->nullable()->after('remember_token');
            $table->unsignedInteger('post_code')->nullable()->after('tel');
            $table->unsignedSmallInteger('prefecture_id')->nullable()->after('post_code');
            $table->string('address1', 200)->nullable()->after('prefecture_id');
            $table->string('address2', 200)->nullable()->after('address1');
            $table->string('address3', 200)->nullable()->after('address2');
            $table->string('stripe_id')->nullable()->index();
            $table->string('pm_type')->nullable();
            $table->string('pm_last_four', 4)->nullable();
            $table->integer('rate_yugioh_links')->default(0)->after('twitter_simple_image_url');
            $table->timestamp('trial_ends_at')->nullable();
        });
    }
}
