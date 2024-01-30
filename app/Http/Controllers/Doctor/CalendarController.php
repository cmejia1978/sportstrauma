<?php

namespace App\Http\Controllers\Doctor;

use App\DRDSB\Patient\Appointment;
use App\Http\Controllers\Controller;
use App\DRDSB\User\User;
use App\DRDSB\Patient\Patient;
use Bican\Roles\Models\Role;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;

class CalendarController extends Controller
{

    protected $auth;

    public function __construct(Guard $guard)
    {
        $this->auth = $guard;
    }

    public function getPatientsData()
    {
        return Datatables::of(Patient::query())
            ->make(true);
    }

    public function getCalendar()
    {
        $appointments = Appointment::where('doctor_id', $this->auth->id())->get();
        return view('doctor.calendar.calendar', ['appointments' => $appointments]);
    }

}
