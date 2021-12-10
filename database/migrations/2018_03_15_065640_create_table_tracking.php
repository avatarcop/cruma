<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTracking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('scrum_card_no',10)->nullable();
            $table->integer('analyst_id')->nullable();
            $table->integer('developer_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->datetime('assign_time')->nullable();
            $table->integer('assign_total')->nullable();
            $table->datetime('finish_time')->nullable();
            $table->integer('finish_total')->nullable();
            $table->datetime('qc_time')->nullable();
            $table->integer('qc_total')->nullable();
            $table->datetime('closed_time')->nullable();
            $table->integer('closed_total')->nullable();
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
        Schema::dropIfExists('trackings');
    }
}
