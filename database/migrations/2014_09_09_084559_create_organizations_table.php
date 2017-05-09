<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->enum('status', ['ALIVE', 'IDLE', 'DEAD'])->default('IDLE');
            $table->timestamps();
        });
        \DB::statement('INSERT INTO organizations (id, name, status) VALUES ("1", "None", "ALIVE")');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('organizations');
    }
}
