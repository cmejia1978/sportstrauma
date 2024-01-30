<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('doctor_id')->unsigned()->index();
            $table->integer('patient_id')->unsigned()->index();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->char('first_notified', 1)->index();
            $table->char('second_notified', 1)->index();
            $table->char('tomorrow_notified', 1)->index();
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
        Schema::drop('appointments');
    }
}
