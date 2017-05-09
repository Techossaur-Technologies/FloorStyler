<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBoligAppIDAssignments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->integer('boligAppID');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn('boligAppID');
            
        });
    }
}
