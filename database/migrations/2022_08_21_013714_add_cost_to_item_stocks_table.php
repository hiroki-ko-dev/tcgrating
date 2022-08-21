<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCostToItemStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_stocks', function (Blueprint $table) {
            $table->smallInteger('quantity')->change();
            $table->unsignedInteger('cost')->default(0)->after('quantity');
            $table->string('remarks',500)->nullable()->after('cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_stocks', function (Blueprint $table) {
            $table->unsignedSmallInteger('quantity')->change();
            $table->dropColumn('cost');
            $table->dropColumn('remarks');
        });
    }
}
