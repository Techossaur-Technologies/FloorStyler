<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentValueRawPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('raw_plans', function (Blueprint $table) {
            DB::statement("ALTER TABLE raw_plans MODIFY type ENUM('SKETCH', 'DRAWING', 'COMMENT'), algorithm=copy");
            //
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
            //
        });
    }
}
