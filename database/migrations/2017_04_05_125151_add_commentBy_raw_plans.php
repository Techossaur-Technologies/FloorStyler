<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentByRawPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('raw_plans', function (Blueprint $table) {
            $table->integer('commentBy');
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
            $table->dropColumn('commentBy');
        });
    }
}
