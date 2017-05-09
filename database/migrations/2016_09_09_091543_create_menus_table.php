<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('menu_id');
            $table->integer('parent_id');
            $table->char('menu_name', 255);
            $table->char('menu_page', 255);
            $table->char('icon', 255);
            $table->enum('admin_access', ['YES','NO'])->default('YES');
            $table->enum('superuser_access', ['YES','NO'])->default('NO');
            $table->enum('user_access', ['YES','NO'])->default('NO');
            $table->enum('agency_access', ['YES','NO'])->default('NO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menus');
        
    }
}
