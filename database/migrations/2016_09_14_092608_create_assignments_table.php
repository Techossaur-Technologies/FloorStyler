<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->integer('user_id')->unsigned();
            $table->integer('organization_id')->unsigned();
            $table->integer('agency_id')->unsigned();
            $table->enum('status', ['PENDING', 'PROCESSING', 'COMPLETED'])->default('PENDING');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('agency_id')->references('id')->on('agencies');

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
        Schema::drop('assignments');
    }
}
