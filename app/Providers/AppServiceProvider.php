<?php

namespace App\Providers;

use App\DRDSB\Patient\Appointment;
use App\DRDSB\Patient\Patient;
use App\DRDSB\User\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.app', function($view)
        {
            $patients = Patient::where('customer_id', 0)->where('doctor_id', Auth::user()->id)->get();
            $todays_appointments = Appointment::where('start', '=', date('Y-m-d'))->get();

            $doctors = User::select('users.*')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('roles.slug', 'doctor')
                ->whereIn('users.id', [2, 3])
                ->get();

            $view->with(['app_patients' => $patients, 'todays_appointments' => $todays_appointments, 'app_doctors' => $doctors]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
