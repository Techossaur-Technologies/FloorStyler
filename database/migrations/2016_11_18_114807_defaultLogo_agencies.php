<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DefaultLogoAgencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agencies', function (Blueprint $table) {
            
        });
        \DB::statement('UPDATE agencies SET logo_path = "storage/logo/blank_logo.jpg"');

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agencies', function (Blueprint $table) {
        });
    }
}
