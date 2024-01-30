<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('appointment_id')->unsigned()->index();
            $table->string('person_responsible');
            $table->string('address');
            $table->string('pref_phone_num');
            $table->string('alt_phone_num');
            $table->string('employer');
            $table->string('employer_address');
            $table->string('employer_phone_num');
            $table->char('covered_by_insurance', 1);
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
        Schema::drop('payments');
    }
}
