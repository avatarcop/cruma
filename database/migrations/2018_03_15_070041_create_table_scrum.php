<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableScrum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrums', function (Blueprint $table) {
            $table->increments('id');

            //$table->string('scrum_card_code');
            $table->string('scrum_card_no',20)->nullable();
           

            //$table->string('project_code');
            $table->integer('project_id')->nullable();
            //$table->string('scrum_type_code');
            $table->integer('scrum_type_id')->nullable();

            $table->integer('urgency_id')->nullable();
           

            $table->integer('estimate_id')->nullable();
        

            $table->datetime('deadline')->nullable();

            $table->integer('analyst_id')->nullable();

            $table->integer('status_id')->nullable();

            $table->string('subject',50)->nullable();

            $table->text('scrum_desc')->nullable();
            $table->text('notes')->nullable();
            $table->text('image')->nullable();

            $table->datetime('assign_time')->nullable();
            $table->datetime('finish_time')->nullable();
            $table->datetime('qc_time')->nullable();
            $table->datetime('closed_time')->nullable();

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
        Schema::dropIfExists('scrums');
    }
}
