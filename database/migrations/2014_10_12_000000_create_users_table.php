<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->enum('user_type', ['ADMIN', 'SUPERUSER', 'USER', 'AGENT'])->default('USER');
            $table->string('user_image');
            $table->string('image_path');
            $table->integer('organization_id')->unsigned()->default('1');
            $table->enum('status', ['ALIVE', 'IDLE', 'DEAD'])->default('IDLE');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
