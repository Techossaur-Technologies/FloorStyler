<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('logo');
            $table->string('logo_path');
            $table->integer('organization_id')->unsigned()->default('1');
            $table->enum('status', ['ALIVE', 'IDLE', 'DEAD'])->default('IDLE');
            $table->foreign('organization_id')->references('id')->on('organizations');
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
        Schema::drop('agencies');
    }
}
