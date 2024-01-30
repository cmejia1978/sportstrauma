<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('doctor_id')->unsigned()->index();
            $table->integer('customer_id')->unsigned()->index();
            $table->string('full_name');
            $table->string('email');
            $table->string('marital_status', 20);
            $table->string('religion');
            $table->string('referred_by');
            $table->string('birth_location');
            $table->date('birth_date');
            $table->tinyInteger('age');
            $table->string('sex', 9);
            $table->string('address');
            $table->string('pref_phone_num');
            $table->string('alt_phone_num');
            $table->string('occupation');
            $table->string('employer');
            $table->char('seen_other_provider', 1);
            $table->string('other_provider_country');
            $table->char('x_rays', 1);
            $table->date('x_ray_date');
            $table->char('operated', 1);
            $table->string('operated_info');
            $table->string('medical_inquiry_reason');
            $table->string('medical_problem_time');
            $table->char('medical_problem_coup', 1);
            $table->string('medical_problem_coup_info');
            $table->char('sport_practice', 1);
            $table->string('sport_practice_info');
            $table->char('exercise', 1);
            $table->string('exercise_info');
            $table->char('alcohol', 1);
            $table->string('alcohol_usage');
            $table->char('smokes', 1);
            $table->string('smokes_per_day');
            $table->string('smokes_years');
            $table->string('allergies');
            $table->string('allergies_cause');
            $table->string('allergies_reaction');
            $table->string('tutor_name');
            $table->string('children_info');
            $table->char('mental_services', 1);
            $table->string('mental_services_info');
            $table->char('medicines_usage', 1);
            $table->string('medicines_usage_info');
            $table->char('associated', 'Y');
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
        Schema::drop('patients');
    }
}
