<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToolDuelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('duels', function (Blueprint $table) {
            $table->Integer('room_id')->nullable()->change();
            $table->unsignedSmallInteger('tool_id')->nullable()->after('watching_id');
            $table->string('tool_code',510)->nullable()->after('tool_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('duels', function (Blueprint $table) {
            $table->Integer('room_id')->nullable(false)->change();
            $table->dropColumn('tool_id');
            $table->dropColumn('tool_code');
        });
    }
}
