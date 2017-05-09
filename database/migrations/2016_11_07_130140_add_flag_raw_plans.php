<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFlagRawPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('raw_plans', function (Blueprint $table) {
            $table->integer('flag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('raw_plans', function (Blueprint $table) {
            $table->dropColumn('flag');
            
        });
    }
}
