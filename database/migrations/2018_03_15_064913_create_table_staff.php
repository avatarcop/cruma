<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStaff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('staffs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('staff_code', 10)->nullable();
            $table->string('staff_name',50)->nullable(); 
            $table->string('email', 50)->nullable();
            $table->string('password',100)->nullable();
            $table->integer('role_id')->nullable();
        
            $table->integer('division_id')->nullable();
            $table->text('avatar')->nullable();
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
        Schema::dropIfExists('staffs');
    }
}
